<?php namespace Engen\ViewExtensions;

use Closure;
use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class PagesExtension implements ExtensionInterface
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
        'pages',
        'pageChildren',
        'pagesRecursive',
        'pageDefinition',
        'pageTemplates',
        'pageOptions',
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
    public function pages()
    {
        return $this->app->pages->getPages();
    }


    /**
     * Get all children for a page
     *
     * @param  string $id
     * @return array
     */
    public function pageChildren($id)
    {
        return $this->app->pages->getPageChildren($id);
    }


    /**
     * Recursivly get all pages
     *
     * @return array
     */
    public function pagesRecursive(Closure $callback, $parentId = 'root', $level = 0)
    {
        foreach ($this->pageChildren($parentId) as $item) {
            $lastParent = call_user_func_array($callback, [$item, $parentId, $level]);
            $this->pagesRecursive($callback, $item->id, $level + 1);
        }
    }


    /**
     * Get all get a page definition
     *
     * @param  string $template
     * @return array
     */
    public function pageDefinition($template)
    {
        return $this->app->definitions->getPageDefinition($template);
    }


    /**
     * Get all get all templates
     *
     * @return array
     */
    public function pageTemplates()
    {
        return $this->app->templates->getPageTemplates();
    }


    /**
     * Get options for pages
     *
     * @param  string  $currentId
     * @param  string  $currentParentId
     * @param  boolean $hideSelf
     * @param  string  $parentId
     */
    public function pageOptions($currentId, $currentParentId, $hideSelf = false, $parentId = 'root')
    {
        if ($children = $this->pageChildren($parentId)):
            foreach ($children as $item):
                if ($hideSelf && $item->id == $currentId) continue;
                $indent = str_repeat('&nbsp;', $item->level * 4);
        ?>

            <option value="<?= $item->id ?>" <?= $item->id == $currentParentId ? 'selected' : '' ?>>
                <?= $indent . htmlentities($item->title) ?>
            </option>

        <?php
            $this->pageOptions($currentId, $currentParentId, $hideSelf, $item->id);
            endforeach;
        endif;
    }
}
