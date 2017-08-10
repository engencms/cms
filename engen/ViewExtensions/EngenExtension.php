<?php namespace Engen\ViewExtensions;

use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class EngenExtension implements ExtensionInterface
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
        'themeAsset',
        'adminAsset',
        'menu',
        'setting',
        'parse',
        'flash',
        'uriStart',
        'breadCrumbs',
    ];

    /**
     * @var array
     */
    protected $flash = [];


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

        // Register the admin views
        $engine->addFolder('admin', __DIR__ . '/../views');

        // Register the view methods
        foreach ($this->methods as $method) {
            $engine->registerFunction($method, [$this, $method]);
        }
    }


    /**
     * Append file modification timestamp for an asset
     *
     * @param  string $file
     * @return string
     */
    public function themeAsset($file)
    {
        if (!$this->app->path('public')) {
            return $file;
        }

        $theme = '';
        if (!defined('IS_BUILD')) {
            $viewPath = $this->app->config->get('views.path');
            $relative = substr($viewPath, strlen($this->app->path('public')));
            $theme    = "{$relative}/static";
        }

        $file   = $theme . '/' . ltrim($file, '/');
        $public = rtrim($this->app->path('public'), '/');
        $full   = $public . $file;

        if ($this->app->config->get('debug') !== true) {
            $path     = pathinfo($full, PATHINFO_DIRNAME);
            $filename = pathinfo($full, PATHINFO_FILENAME);
            $ext      = pathinfo($full, PATHINFO_EXTENSION);
            $minfile  = $path . '/' . $filename . '.min.' . $ext;
            $file     = is_file($minfile) ? substr($minfile, strlen($public)) : $file;
            $full     = $public . $file;
        }

        if (!is_file($full)) {
            return $file;
        }

        return $file . '?' . filemtime($full);
    }


    /**
     * Append file modification timestamp for an admin asset
     *
     * @param  string $file
     * @return string
     */
    public function adminAsset($file)
    {
        if (!$this->app->path('public')) {
            return $file;
        }

        $themesPath = substr(
            $this->app->config->get('themes.path'),
            strlen($this->app->path('public'))
        );

        $theme = $themesPath . '/_admin';

        $file   = $theme . '/' . ltrim($file, '/');
        $public = rtrim($this->app->path('public'), '/');
        $full   = $public . $file;

        if ($this->app->config->get('debug') !== true) {
            $path     = pathinfo($full, PATHINFO_DIRNAME);
            $filename = pathinfo($full, PATHINFO_FILENAME);
            $ext      = pathinfo($full, PATHINFO_EXTENSION);
            $minfile  = $path . '/' . $filename . '.min.' . $ext;
            $file     = is_file($minfile) ? substr($minfile, strlen($public)) : $file;
            $full     = $public . $file;
        }

        if (!is_file($full)) {
            return $file;
        }

        return $file . '?' . filemtime($full);
    }


    /**
     * Get a menu by key
     *
     * @param  string $key
     * @return Menu|null
     */
    public function menu($key)
    {
        return $this->app->menus->getMenuByKey($key);
    }

    /**
     * Get a setting value
     *
     * @param  string $key
     * @return mixed
     */
    public function setting($key, $fallback = null)
    {
        return $this->app->settings->getSetting($key, $fallback);
    }


    /**
     * Parse text
     *
     * @param  string $parser
     * @param  string $text
     * @return string
     */
    public function parse($parser, $text)
    {
        return $this->app->parsers->{$parser}($text);
    }


    /**
     * Get flash message
     *
     * @param  string $key
     * @return array
     */
    public function flash($key)
    {
        if (!array_key_exists($key, $this->flash)) {
            $this->flash[$key] = $this->app->session->getFlash($key);
        }

        return $this->flash[$key];
    }


    /**
     * Check if the current uri starts with a string
     *
     * @param  string $uri
     * @param  string $onMatch
     * @param  string $onMisMatch
     * @return mixed
     */
    public function uriStart($uri, $onMatch = true, $onMisMatch = false)
    {
        $current = trim($this->app->request->currentPath(), '/');
        $uri     = trim($uri, '/');

        if (empty($uri)) {
            return $onMisMatch;
        }

        return strpos($current, $uri) === 0 ? $onMatch : $onMisMatch;
    }


    /**
     * Get bread crumbs
     *
     * @param  string $key
     * @return array
     */
    public function breadCrumbs($key = null)
    {
        return $this->app->breadCrumbs->get($key ?? 'public');
    }
}
