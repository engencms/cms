<?php namespace Engen\Services;

use Enstart\App;
use ZipArchive;

class Exporter
{
    /**
     * @var ZipArchive
     */
    protected $app;


    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Export data
     *
     * @return string
     */
    public function export()
    {
        $zip      = new ZipArchive();
        $filename = $this->app->path('data') . '/exports/' . date('Y-m-d_His') . '.zip';

        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            return false;
        }

        $paths = [
            '/data/blocks',
            '/data/meta',
            '/data/pages',
            '/public/uploads',
        ];

        foreach ($paths as $path) {
            $this->addFiles($zip, $this->app->path('root') . $path, $path);
        }

        $zip->close();

        return $filename;
    }

    /**
     * Add files in folder to the zip archive
     *
     * @param ZipArchive $zip
     * @param string     $source
     * @param string     $target
     */
    protected function addFiles($zip, $source, $target)
    {
        $target = ltrim($target, '/');
        $zip->addEmptyDir($target);

        foreach (glob($source . '/*') as $file) {
            $zip->addFile($file, $target . '/' . basename($file));
        }
    }
}
