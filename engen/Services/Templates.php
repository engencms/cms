<?php namespace Engen\Services;

class Templates
{
    /**
     * @var string
     */
    protected $themePath;

    /**
     * @var string
     */
    protected $templatePath;

    /**
     * Already loaded definition files
     * @var array
     */
    protected $definitions = [];

    /**
     * All templates
     * @var null|array
     */
    protected $templates;


    /**
     * @param string $templatePath
     */
    public function __construct($themePath)
    {
        $this->themePath    = $themePath;
        $this->templatePath = $themePath . '/templates';
    }


    /**
     * Get a list of all templates
     *
     * @return array
     */
    public function getPageTemplates()
    {
        if (is_null($this->templates)) {
            $this->templates = [];

            foreach (glob($this->templatePath . '/*.php') as $file) {
                $this->templates[] = basename($file, '.php');
            }
        }

        return $this->templates;
    }


    /**
     * Get a template definition
     *
     * @param  string $template
     * @return array
     */
    public function getPageTemplateDefinition($template)
    {
        if (!array_key_exists($template, $this->definitions)) {
            $file = "{$this->templatePath}/definitions/{$template}.php";

            $this->definitions[$template] = is_file($file)
                ? include $file
                : [];
        }

        return $this->definitions[$template];
    }
}
