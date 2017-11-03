<?php namespace Engen\Services;

use Enstart\App;
use ZipArchive;

class Importer
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
     * @param  string $filename
     * @return string
     */
    public function import($file)
    {
        $zip = new ZipArchive;
        if ($zip->open($file) === true) {
            $zip->extractTo($this->app->path('root'));
            $zip->close();
            return true;
        }

        $paths = [
            '/data/blocks',
            '/data/meta',
            '/data/pages',
            '/public/uploads',
        ];

        foreach ($paths as $path) {
            foreach (glob($path) as $file) {
                chmod($file, 0777);
            }
        }

        return false;
    }
}
