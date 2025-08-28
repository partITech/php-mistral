<?php

namespace Partitech\PhpMistral\Utils;

class File
{

    /**
     * Create a temporary file from either:
     *  - a base64-encoded payload (raw string or data URL), or
     *  - a raw (non-encoded) payload (e.g., SVG/JSON/plain text bytes).
     *
     * Behavior:
     * 1) If $data is a data URL, parse it:
     *    - If it has ";base64", decode base64.
     *    - Otherwise, treat as raw bytes (percent-decoded per RFC2397).
     * 2) If not a data URL:
     *    - If MIME looks textual (text/*, application/json, image/svg+xml, application/xml),
     *      treat $data as raw bytes.
     *    - Otherwise, try strict base64 decode after whitespace stripping.
     *      If decoding succeeds *and* round-trip check passes, use decoded bytes.
     *      If not, fall back to treating $data as raw bytes.
     * 3) Infer extension from MIME map; if unknown or generic, try finfo on bytes.
     * 4) Write to system temp directory and return the absolute path.
     *
     * @param string $mimeType Expected MIME type (hint; may be overridden by detection).
     * @param string $data     Base64 string, data URL, or raw bytes/text.
     *
     * @return string Absolute path to the created temp file.
     *
     * @throws \InvalidArgumentException If payload is empty.
     * @throws \RuntimeException If temp directory is not writable or file write fails.
     */
    public static function createTmpFile(string $mimeType, string $data): string
    {
        if ($data === '') {
            throw new \InvalidArgumentException('Empty payload.');
        }

        $originalMime = trim((string)$mimeType);
        $mimeType = $originalMime;
        $binary = null;

        // 0) Data URL support (with or without ";base64")
        //    Examples:
        //      data:image/png;base64,iVBORw0KGgo...
        //      data:text/plain,Hello%20world
        if (preg_match('#^data:([^;,]+)(;charset=[^;,]+)?(;(base64))?,(.*)$#is', $data, $m)) {
            $mimeType = $m[1] ?: $mimeType;
            $isBase64 = isset($m[4]) && strtolower($m[4]) === 'base64';
            $payload  = $m[5] ?? '';

            if ($isBase64) {
                // Strip whitespace which some senders insert
                $clean = preg_replace('/\s+/', '', $payload);
                $decoded = base64_decode($clean, true);
                if ($decoded !== false) {
                    $binary = $decoded;
                }
            } else {
                // Per RFC2397, non-base64 data is percent-encoded
                $binary = rawurldecode($payload);
            }
        }

        // 1) Not a data URL: decide whether to treat as raw or base64
        if ($binary === null) {
            $looksTextualByMime =
                str_starts_with(strtolower($mimeType), 'text/') ||
                in_array(strtolower($mimeType), [
                    'application/json',
                    'application/xml',
                    'image/svg+xml',
                    'application/javascript',
                    'application/x-ndjson',
                    'application/yaml',
                    'application/x-yaml',
                ], true);

            if ($looksTextualByMime) {
                // Trust MIME hint for textual types: treat as raw
                $binary = $data;
            } else {
                // Try strict base64 decode with whitespace stripped
                $clean = preg_replace('/\s+/', '', $data);
                $base64Alphabet = (bool)preg_match('/^[A-Za-z0-9+\/]*={0,2}$/', $clean);
                $lengthMod4Ok   = (strlen($clean) % 4) === 0;

                $decoded = ($base64Alphabet && $lengthMod4Ok) ? base64_decode($clean, true) : false;

                // Round-trip guard to avoid false positives on "base64-looking" text
                $isRoundTrip = $decoded !== false && base64_encode($decoded) === $clean;

                if ($isRoundTrip) {
                    $binary = $decoded;
                } else {
                    // Fallback: treat as raw bytes (already-decoded content)
                    $binary = $data;
                }
            }
        }

        // 2) Map common MIME types to extensions
        $mimeToExt = [
            // Images
            'image/jpeg'          => 'jpg',
            'image/pjpeg'         => 'jpg',
            'image/png'           => 'png',
            'image/gif'           => 'gif',
            'image/bmp'           => 'bmp',
            'image/x-ms-bmp'      => 'bmp',
            'image/webp'          => 'webp',
            'image/svg+xml'       => 'svg',
            'image/tiff'          => 'tiff',
            'image/x-icon'        => 'ico',
            'image/heif'          => 'heif',
            'image/heif-sequence' => 'heifs',
            'image/heic'          => 'heic',
            'image/heic-sequence' => 'heics',

            // Audio
            'audio/mpeg'          => 'mp3',
            'audio/mp4'           => 'm4a',
            'audio/x-wav'         => 'wav',
            'audio/wav'           => 'wav',
            'audio/aac'           => 'aac',
            'audio/ogg'           => 'ogg',
            'audio/flac'          => 'flac',
            'audio/webm'          => 'weba',
            'audio/amr'           => 'amr',
            'audio/midi'          => 'midi',
            'audio/x-midi'        => 'midi',

            // Video
            'video/mp4'           => 'mp4',
            'video/x-m4v'         => 'm4v',
            'video/mpeg'          => 'mpeg',
            'video/ogg'           => 'ogv',
            'video/webm'          => 'webm',
            'video/x-msvideo'     => 'avi',
            'video/quicktime'     => 'mov',
            'video/x-ms-wmv'      => 'wmv',
            'video/x-flv'         => 'flv',
            'video/3gpp'          => '3gp',
            'video/3gpp2'         => '3g2',
            'video/x-matroska'    => 'mkv',

            // Common documents & text
            'application/pdf'                 => 'pdf',
            'application/json'                => 'json',
            'application/xml'                 => 'xml',
            'text/xml'                        => 'xml',
            'image/svg+xml'                   => 'svg',
            'text/plain'                      => 'txt',
            'text/html'                       => 'html',
            'text/markdown'                   => 'md',
            'text/csv'                        => 'csv',
            'application/x-ndjson'            => 'ndjson',
            'application/javascript'          => 'js',
            'application/yaml'                => 'yaml',
            'application/x-yaml'              => 'yaml',
            'application/vnd.ms-excel'        => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/msword'              => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-powerpoint'   => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        ];

        $mimeType = trim((string)$mimeType);
        $extension = $mimeToExt[$mimeType] ?? null;

        // 3) If extension unknown or MIME empty/generic, try finfo detection on the *actual bytes*
        if ($extension === null || $mimeType === '' || strcasecmp($mimeType, 'application/octet-stream') === 0) {
            $fi = new \finfo(FILEINFO_MIME_TYPE);
            $detected = $fi->buffer($binary) ?: '';
            if ($detected !== '') {
                $mimeType = $detected;
                $extension = $mimeToExt[$detected] ?? null;
            }
        }

        // 4) As a last resort, derive from MIME subtype ("image/png" -> "png"), cleaning "svg+xml" -> "svgxml"
        if ($extension === null && str_contains($mimeType, '/')) {
            [$type, $sub] = explode('/', $mimeType, 2);
            $cleanSub = strtolower((string)preg_replace('/[^a-z0-9]+/i', '', $sub));
            $extension = $cleanSub !== '' ? $cleanSub : 'bin';
        }

        if ($extension === null) {
            $extension = 'bin';
        }

        // 5) Write file to temp dir
        $tmpDir = sys_get_temp_dir();
        if (!is_dir($tmpDir) || !is_writable($tmpDir)) {
            throw new \RuntimeException('The temporary directory is not writable.');
        }

        $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
        $fullPath = $tmpDir . DIRECTORY_SEPARATOR . $fileName;

        $bytes = @file_put_contents($fullPath, $binary, LOCK_EX);
        if ($bytes === false) {
            throw new \RuntimeException('Unable to write the temporary file.');
        }

        return $fullPath;
    }

}