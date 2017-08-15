<?php namespace Engen\Services;

use Enstart\App;
use App\Controllers\HomeController;
use Engen\Repos\PagesInterface;

class Builder
{
    protected $app;
    protected $target;
    protected $pages;
    protected $controller;
    protected $error;
    protected $mockRequest;
    protected $perms = [];


    /**
     * @param App $app
     */
    public function __construct(App $app, HomeController $controller, PagesInterface $pages)
    {
        $this->app        = $app;
        $this->pages      = $pages;
        $this->controller = $controller;
        $this->target     = realpath($app->config->get('build.path'));
        $this->perms      = [
            'dirs'  => $app->config->get('build.permissions.directories', 0775),
            'files' => $app->config->get('build.permissions.files', 0664),
        ];
    }


    /**
     * Build pages
     *
     * @return boolean
     */
    public function build()
    {
        $this->error = null;

        if (!$this->emptyBuild()) {
            return false;
        }

        foreach (array_reverse($this->pages->getPages()) as $page)  {
            if ($page->status != 'published') {
                continue;
            }

            $this->updateRequestParams($page->uri);
            $this->savePage($page->uri);
        }

        $this->copyAssets();
        // Set the file permissions on all the files
        // so they can be run through both CLI and the CMS
        rchmod($this->target, $this->perms['dirs'], $this->perms['files']);
        return true;
    }

    protected function updateRequestParams($uri)
    {
        if (is_null($this->mockRequest)) {
            $file = $this->app->path('engen_assets') . '/mock_request.php';
            $this->app->request->server()->replace(is_file($file) ? require $file : []);
            $this->mockRequest = true;
        }

        $this->app->request->server()->set('REDIRECT_URL', $uri);
        $this->app->request->server()->set('REQUEST_URI', $uri);

        $this->app->request->initialize(
            $this->app->request->get()->all(),
            $this->app->request->post()->all(),
            [],
            $this->app->request->cookies()->all(),
            $this->app->request->files()->all(),
            $this->app->request->server()->all(),
            null
        );

        // Update the view extension
        $this->app->container->make('Enstart\View\URI')
            ->updateUri($uri);
    }


    /**
     * Get any error that occurred, if any
     *
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * Copy template assets
     */
    protected function copyAssets()
    {
        $theme  = $this->app->config->get('views.path');
        $source = realpath("{$theme}/static");

        if (!$this->target || !$source) {
            return false;
        }

        rcopy($source, $this->target);
    }


    /**
     * Render and save a page
     *
     * @param  Object $page
     * @return boolean
     */
    protected function savePage($uri)
    {
        $content  = $this->controller->generate($uri);
        $path     = $this->target . '/' . trim($uri, '/');

        if (!is_dir($path)) {
            mkdir($path, $this->perms['dirs'], true);
        }

        if (file_put_contents($path . '/index.html', $content) > 0) {
            chmod($path . '/index.html', $this->perms['files']);
        }
    }


    /**
     * Emtpy the build folder
     *
     * @return boolean
     */
    protected function emptyBuild()
    {
        $root = realpath($this->app->path('root'));

        if (strpos($this->target, $root) !== 0 || $this->target === $root || !is_dir($this->target)) {
            // To make sure we don't accedently delete stuff outside of the application,
            // or the application itself, let's not delete anything that's outside of
            // the application root and not in a sub folder
            $this->error = "Invalid build path";
            return false;
        }

        if (!is_writable($this->target)) {
            $this->error = "Target is not writable";
            return false;
        }

        emptyDir($this->target);
        return true;
    }
}
