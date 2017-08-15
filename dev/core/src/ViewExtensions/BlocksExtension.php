<?php namespace Engen\ViewExtensions;

use Closure;
use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class BlocksExtension implements ExtensionInterface
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
        'block',
        'blocks',
        'blockDefinition',
        'blockDefinitions',
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
     * Get a block by key
     *
     * @return array
     */
    public function block($blockKey, $key = null, $fallback = null)
    {
        $block = $this->app->blocks->getBlockByKey($blockKey);
        if (!$block || is_null($blockKey)) {
            return $block;
        }

        return $block->content($key, $fallback);
    }


    /**
     * Get all blocks
     *
     * @return array
     */
    public function blocks()
    {
        return $this->app->blocks->getBlocks();
    }


    /**
     * Get a block definition
     *
     * @param  string $template
     * @return array
     */
    public function blockDefinition($template)
    {
        return $this->app->definitions->getBlockDefinition($template);
    }


    /**
     * Get all block definitions
     *
     * @return array
     */
    public function blockDefinitions()
    {
        return $this->app->definitions->getBlockDefinitions();
    }
}
