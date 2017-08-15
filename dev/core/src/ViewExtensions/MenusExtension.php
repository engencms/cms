<?php namespace Engen\ViewExtensions;

use Closure;
use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class MenusExtension implements ExtensionInterface
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
        'menus',
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
     * Get all menus
     *
     * @return array
     */
    public function menus()
    {
        return $this->app->menus->getMenus();
    }
}
