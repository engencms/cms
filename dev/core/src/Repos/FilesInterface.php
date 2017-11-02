<?php namespace Engen\Repos;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FilesInterface
{
    /**
     * Get all files and folders in the upload path
     *
     * @param  string $path
     * @return array
     */
    public function getPathContent($path = null);


    /**
     * Get the absolute file path
     *
     * @param  string $path
     * @return array
     */
    public function getRealFilePath($path);


    /**
     * Delete a file
     *
     * @param  string $file
     * @return boolean|string True if success or error message on fail
     */
    public function deleteFile($file);


    /**
     * Upload file
     *
     * @param  UploadedFile $file
     * @return true|string
     */
    public function upload(UploadedFile $file);
}
