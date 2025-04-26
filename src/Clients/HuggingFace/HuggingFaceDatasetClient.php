<?php

namespace Partitech\PhpMistral\Clients\HuggingFace;

use CzProject\GitPhp\Git;
use CzProject\GitPhp\GitException;
use CzProject\GitPhp\GitRepository;
use FilesystemIterator;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\MistralClientException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use Throwable;

class HuggingFaceDatasetClient extends Client
{
    protected const string ENDPOINT_HUGGINGFACE = 'https://huggingface.co';
    protected const string ENDPOINT_DATASET_SERVER = 'https://datasets-server.huggingface.co';

    public const string REPOSITORY_TYPE_MODEL = 'model';
    public const string REPOSITORY_TYPE_DATASET = 'dataset';
    public const string REPOSITORY_TYPE_SPACE = 'space';

    public function __construct(?string $apiKey = null)
    {
        parent::__construct(apiKey: $apiKey, url: self::ENDPOINT_HUGGINGFACE);
    }

    /**
     * @throws MistralClientException
     */
    public function downloadDatasetFiles(string $dataset, string $revision = 'main', ?string $destination = null): string
    {
        $files = $this->listDatasetFiles($dataset, $revision);

        if (empty($files)) {
            throw new MistralClientException(message: "No files found for dataset {$dataset}@{$revision}", code: 404);
        }

        if (is_null($destination)) {
            $datasetFileName = str_replace('/', '__', $dataset);
            $destination = sys_get_temp_dir() . '/' . uniqid("hf_{$datasetFileName}_");
        }

        if (!is_dir($destination) && !mkdir($destination, 0755, true) && !is_dir($destination)) {
            throw new RuntimeException("Failed to create temp directory: $destination");
        }


        foreach ($files as $file) {
            $filename = $file['rfilename'];
            $endpoint = "/datasets/{$dataset}/resolve/{$revision}/{$filename}";
            $savePath = $destination . '/' . $filename;

            // Créer les répertoires si nécessaire
            $saveDir = dirname($savePath);
            if (!is_dir($saveDir)) {
                mkdir($saveDir, 0777, true);
            }

            $result = $this->downloadTo($endpoint, $savePath);
            if ($result === false) {
                throw new MistralClientException(message: "Failed to download file: {$endpoint}", code: 500);
            }
        }

        return $destination;
    }

    /**
     * @throws MistralClientException
     */
    public function listDatasetFiles(string $dataset, string $revision = 'main'): array
    {
        $this->url = self::ENDPOINT_HUGGINGFACE;
        $path = "/api/datasets/{$dataset}/revision/{$revision}";
        $response = $this->request('GET', $path);
        return $response['siblings'] ?? [];
    }

    public function downloadTo(string $url, string $path): bool
    {
        $this->url = self::ENDPOINT_HUGGINGFACE;

        try {
            $response = $this->request('GET', $url, stream: true);

            $body = $response->getBody();
            $dir = dirname($path);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $fh = fopen($path, 'w');
            if (!$fh) {
                return false;
            }

            while (!$body->eof()) {
                fwrite($fh, $body->read(8192));
            }

            fclose($fh);
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * @throws MistralClientException
     */
    public function isValid(string $dataset): array
    {
        $this->url = self::ENDPOINT_DATASET_SERVER;
        return $this->request(method: 'GET', path: '/is-valid', parameters: ['query' => ['dataset' => $dataset]]);
    }

    /**
     * @throws MistralClientException
     */
    public function splits(string $dataset): array
    {
        $this->url = self::ENDPOINT_DATASET_SERVER;
        return $this->request(method: 'GET', path: '/splits', parameters: ['query' => ['dataset' => $dataset]]);
    }

    /**
     * @throws MistralClientException
     */
    public function firstRows(string $dataset, string $split, string $config): array
    {
        $this->url = self::ENDPOINT_DATASET_SERVER;
        return $this->request(method: 'GET', path: '/first-rows', parameters: ['query' => ['dataset' => $dataset, 'split' => $split, 'config' => $config,]]);
    }

    /**
     * @throws MistralClientException
     */
    public function rows(string $dataset, string $split, string $config, int $offset = 0, int $length = 10): array
    {
        $this->url = self::ENDPOINT_DATASET_SERVER;
        return $this->request(method: 'GET', path: '/rows', parameters: ['query' => ['dataset' => $dataset, 'split' => $split, 'config' => $config, 'length' => $length, 'offset' => $offset,]]);
    }

    /**
     * @throws MistralClientException
     */
    public function search(string $dataset, string $split, string $config, string $query): array
    {
        $this->url = self::ENDPOINT_DATASET_SERVER;
        return $this->request(method: 'GET', path: '/search', parameters: ['query' => ['dataset' => $dataset, 'split' => $split, 'config' => $config, 'query' => $query]]);
    }


    /**
     * @throws MistralClientException
     */
    public function statistics(string $dataset, string $split, string $config): array
    {
        $this->url = self::ENDPOINT_DATASET_SERVER;
        return $this->request(method: 'GET', path: '/statistics', parameters: ['query' => ['dataset' => $dataset, 'split' => $split, 'config' => $config]]);
    }


    /**
     * @throws MistralClientException
     */
    public function create(string $name, string $type, bool $private = false): array
    {
        $this->url = self::ENDPOINT_HUGGINGFACE;
        $parameters = [
            'name' => $name,
            'type' => $type,
            'private' => $private
        ];

        return $this->request('POST', 'api/repos/create'  , $parameters);
    }

    /**
     * @throws MistralClientException
     */
    public function delete(string $name, string $type): string
    {
        $this->url = self::ENDPOINT_HUGGINGFACE;
        $parameters = [
            'name' => $name,
            'type' => $type
        ];

        return $this->request('DELETE', 'api/repos/delete'  , $parameters);
    }


    /**
     * @throws MistralClientException
     */
    public function rename(string $from, string $to, string $type): string
    {
        $this->url = self::ENDPOINT_HUGGINGFACE;
        $parameters = [
            'fromRepo' => $from,
            'toRepo' => $to,
            'type' => $type
        ];

        return $this->request('POST', 'api/repos/move'  , $parameters);
    }

    /**
     * Commit files to a Hugging Face dataset repository using Git and Git LFS.
     *
     * @throws GitException
     */
    public function commit(string $repository, string $dir, array $files, string $summary, string $commitMessage = 'Add files', string $branch = 'main'): array
    {
        $localRepoDir = sys_get_temp_dir() . '/hf_dataset_' . md5($repository);
        $git = new Git();
        $repoUrl = "https://git:{$this->apiKey}@huggingface.co/datasets/{$repository}";

        // Clone the repository if it does not exist locally
        if (!is_dir($localRepoDir . '/.git')) {
            $repo = $git->cloneRepository($repoUrl, $localRepoDir);
        } else {
            $repo = new GitRepository($localRepoDir);
        }

        // Checkout the target branch (create it if it doesn't exist)
        try {
            $repo->checkout($branch);
        } catch (\Exception $e) {
            $repo->createBranch($branch);
            $repo->checkout($branch);
        }

        // install Git LFS and track all files
        $repo->execute('lfs', 'install');
        $repo->execute('lfs', 'track', '*.*');
        $repo->addFile('.gitattributes');

        // Copy the files and add them to the repository
        foreach ($files as $file) {
            $sourcePath = $dir . DIRECTORY_SEPARATOR . $file;
            $destPath = $localRepoDir . DIRECTORY_SEPARATOR . $file;

            if (!is_dir(dirname($destPath))) {
                mkdir(dirname($destPath), 0777, true);
            }

            copy($sourcePath, $destPath);
            $repo->addFile($file);
        }

        // Commit the changes if there are any
        $status = $repo->execute('status', '--porcelain');
        if (!empty($status)) {
            $repo->commit($commitMessage);
        }

        // Push the changes to the remote repository
        $output = $repo->push(null, ['--repo' => $repoUrl.'.git']);

        return [
            'repository' => $repository,
            'branch' => $branch,
            'commit_message' => $commitMessage,
            'files' => $files
        ];
    }

    /**
     * @throws MistralClientException
     */
    public function listDatasets(string $author, ?int $limit = null, ?string $search = null, ?string $sort = null, ?int $direction = null, bool $full = false): array
    {
        $this->url = self::ENDPOINT_HUGGINGFACE;
        $query = ['author' => $author];

        if ($limit !== null) {
            $query['limit'] = $limit;
        }
        if ($search !== null) {
            $query['search'] = $search;
        }
        if ($sort !== null) {
            $query['sort'] = $sort;
        }
        if ($direction !== null) {
            $query['direction'] = $direction;
        }
        if ($full) {
            $query['full'] = 'true';
        }

        return $this->request(method: 'GET', path: '/api/datasets', parameters: ['query' => $query]);
    }

    public function listFiles(string $dir): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
        );
        $files = [];
        $dir = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $fullPath = $fileInfo->getPathname();
                $relativePath = substr($fullPath, strlen($dir));
                $files[] = $relativePath;
            }
        }

        return $files;
    }
}
