<?php

namespace Tests\Traits;

/**
 * Trait TestCleanupTrait
 *
 * Provides functionality to clean up the `translated` directory 
 * under the `tests/var` path, removing files and the directory itself.
 */
trait TestCleanupTrait
{
    /**
     * Cleans up the `translated` directory located at `tests/var`.
     *
     * This method will:
     * - Check if the directory exists.
     * - Remove all files inside the directory.
     * - Remove the directory itself once it's empty.
     *
     * @return void
     */
    protected function cleanupVar(): void
    {
        // Get the real path to the 'translated' directory under `tests/var`
        $varPath = realpath('./tests/var') . '/translated';

        // Ensure the directory exists before proceeding
        if (is_dir($varPath)) {
            // Get a list of all files in the directory
            $files = glob($varPath . '/*');
            
            // Loop through each file and delete it if it's a file
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Delete the file
                }
            }
            
            // Delete the directory after its content is removed
            rmdir($varPath);
        }

        // Note: If `$varPath` becomes `false` due to `realpath` not resolving correctly,
        // this function will silently do nothing. A validation for `false` could be added
        // if it's important to log or handle such cases explicitly.
    }
}