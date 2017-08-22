<?php

if (!function_exists('rrmdir')) {
    /**
     * Recursively remove a directory
     *     - Please be careful!
     *
     * @param  string $dir
     */
    function rrmdir($dir, $deleteTopFolder = true)
    {
        $dir = rtrim($dir, '/');

        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                rrmdir($file);
            } else {
                unlink($file);
            }
        }

        if ($deleteTopFolder) {
            rmdir($dir);
        }
    }
}

if (!function_exists('emptyDir')) {
    /**
     * Recursively remove all files and folders inside a directory
     *     - Please be careful!
     *
     * @param  string $dir
     */
    function emptyDir($dir)
    {
        rrmdir($dir, false);
    }
}

if (!function_exists('rcopy')) {
    /**
     * Recursively copy a folder and all it's content
     *     - Please be careful!
     *
     * @param  string $dir
     */
    function rcopy($source, $target)
    {
        $source  = realpath($source);
        $dirname = basename($source);

        if (!realpath($target) || !is_dir($target)) {
            mkdir($target, 0777, true);
        }

        foreach (glob($source . '/*') as $file) {
            $relative = substr($file, strlen($source));
            $dest     = $target . $relative;

            if (file_exists($dest)) {
                // File or folder already exists
                continue;
            }

            if (is_dir($file)) {
                mkdir($dest, 0777, true);
                rcopy($file, $dest);
            } else {
                copy($file, $dest);
            }
        }
    }
}

if (!function_exists('rchmod')) {
    function rchmod($dir, $dirPermissions, $filePermissions)
    {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file)) {
                chmod($file, $dirPermissions);
                rchmod($file, $dirPermissions, $filePermissions);
            } else {
                chmod($file, $filePermissions);
            }
        }
    }
}