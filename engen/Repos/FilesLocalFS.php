<?php namespace Engen\Repos;

use Engen\Entities\File;
use SplFileInfo;
use wapmorgan\FileTypeDetector\Detector;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FilesLocalFS implements FilesInterface
{
    /**
     * The upload folder
     * @var string
     */
    protected $base;

    /**
     * Upload error codes
     * @var array
     */
    protected $uploadErrors = [
        1 => 'The file is too large',
        2 => 'The file is too large',
        3 => 'The file wasn\'t fully uploaded',
        4 => 'No file was uploaded',
        6 => 'A configuration error on the server occurred',
        7 => 'A configuration error on the server occurred',
        8 => 'An internal server error occurred',
    ];

    public function __construct($base)
    {
        $this->base = $base;
    }

    public function getPathContent($path = null)
    {
        $path = $path ?: $this->base;

        $response = ['files'  => []];

        $fullPath = $path;

        if (strpos($fullPath, $this->base) !== 0) {
            return $response;
        }

        foreach (glob($fullPath . '/*') as $item) {
            if (is_dir($item)) {
                continue;
            }

            $f    = new SplFileInfo($item);
            $file = File::make([
                'name'     => $f->getBasename(),
                'path'     => $this->getRelativePath($f->getRealPath()),
                'size'     => $f->getSize(),
                'type'     => $f->getType(),
                'created'  => $f->getCTime(),
                'modified' => $f->getMtime(),
            ]);

            $file->typeInfo = Detector::detectByFilename($file->name);

            $response['files'][] = $file;
        }

        return $response;
    }

    public function getRealFilePath($path)
    {
        $full = realpath($this->base . '/' . trim($path, '/'));

        if (!$full || strpos($full, $this->base) !== 0 || !is_file($full)) {
            return null;
        }

        return [
            'path'     => $full,
            'filename' => basename($full),
            'size'     => filesize($full),
            'mime'     => mime_content_type($full),
        ];
    }

    public function deleteFile($file)
    {
        $filePath = realpath($this->base . "/{$file}");
        if (strpos($filePath, $this->base) !== 0) {
            return 'Invalid file path: ' . $filePath;
        }

        if (!is_file($filePath)) {
            return 'The file doesn\'t exist';
        }

        if (!is_writeable($filePath)) {
            return 'Insufficient file permissions';
        }

        unlink($filePath);
        return true;

    }

    /**
     * Upload file
     *
     * @param  UploadedFile $file
     * @return true|string
     */
    public function upload(UploadedFile $file)
    {
        $newName = $this->newName($file->getClientOriginalName());

        $error = $this->uploadErrors[$file->getError()] ?? null;

        if ($error) {
            return $response->setError($error);
        }

        try {
            $file->move($this->base, $newName);
        } catch (FileException $e) {
            return 'An error occurred';
        }

        return true;
    }


    protected function newName($name)
    {
        $base   = preg_replace('/^([\w\-\.])$/', '', $name);
        $ext    = strtolower(pathinfo($base, PATHINFO_EXTENSION));
        $base   = pathinfo($base, PATHINFO_FILENAME);

        $name = $base;
        $i    = 1;
        while (is_file("{$this->base}/{$name}.{$ext}")) {
            $name = "{$new}-{$i}";
            $i++;
        }

        return $name .= ".{$ext}";
    }

    protected function getRelativePath($path)
    {
        return substr($path, strlen($this->base));
    }
}