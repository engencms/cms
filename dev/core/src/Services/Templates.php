<?php namespace Engen\Services;

class Templates
{
    /**
     * @var string
     */
    protected $templatesPath;

    /**
     * All templates
     * @var null|array
     */
    protected $templates;


    /**
     * @param string $templatePath
     */
    public function __construct($templatesPath)
    {
        $this->templatesPath = $templatesPath;
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

            foreach (glob($this->templatesPath . '/*.php') as $file) {
                $this->templates[] = basename($file, '.php');
            }
        }

        return $this->templates;
    }
}
