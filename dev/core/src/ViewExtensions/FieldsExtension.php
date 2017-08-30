<?php namespace Engen\ViewExtensions;

use Closure;
use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class FieldsExtension implements ExtensionInterface
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
     * Field templates
     * @var array
     */
    protected $fieldTemplates = [];


    /**
     * Methods to register
     * @var array
     */
    protected $methods = [
        'fields',
        'addFieldTemplate',
        'fieldTemplates',
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
     * Get all registered fields
     *
     * @return array
     */
    public function fields($sort = false)
    {
        return $this->app->fields->getFields($sort);
    }


    /**
     * Add a field template
     *
     * @return array
     */
    public function addFieldTemplate($template, array $data = [])
    {
        return $this->fieldTemplates[] = [
            'template' => $template,
            'data'     => $data,
        ];
    }


    /**
     * Get all field templates
     *
     * @return array
     */
    public function fieldTemplates()
    {
        return $this->fieldTemplates;
    }
}
