<?php namespace Engen\ViewExtensions;

use Closure;
use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class FilesExtension implements ExtensionInterface
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var RouterInterface
     */
    protected $app;

    /**
     * Methods to register
     * @var array
     */
    protected $methods = [
        'files',
        'fileUri',
        'imageDimensions',
    ];


    /**
     * @param Enstart\App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }


    /**
     * Register the extension
     *
     * @param  Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;

        // Register the view methods
        foreach ($this->methods as $method) {
            $engine->registerFunction($method, [$this, $method]);
        }
    }


    /**
     * Get all pages
     *
     * @return array
     */
    public function files()
    {
        $content = $this->app->files->getPathContent();
        return is_array($content) && isset($content['files'])
            ? $content['files']
            : [];
    }


    /**
     * Get the relative path for the file
     *
     * @param  string $filename
     * @return string
     */
    public function fileUri($filename)
    {
        return $this->app->config->get('uploads.uri') . "/{$filename}";
    }


    /**
     * Get the image dimensions of an uploaded file
     *
     * @param  string $filename
     * @return string
     */
    public function imageDimensions($filename)
    {
        $file = $this->app->config->get('uploads.path') . "/{$filename}";
        if (!is_file($file)) {
            return [];
        }

        $size = @getimagesize($file);
        return is_array($size) ? [$size[0], $size[1]] : [];
    }
}
