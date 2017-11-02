<?php namespace Engen\Services;

class Definitions
{
    /**
     * @var string
     */
    protected $definitionsPath;

    /**
     * Loaded definitions
     * @var array
     */
    protected $defs = [];

    /**
     * Block definitions list
     * @var array
     */
    protected $blockDefsLists;


    /**
     * @param string $templatePath
     */
    public function __construct($definitionsPath)
    {
        $this->definitionsPath = $definitionsPath;
    }


    /**
     * Get a page template definition
     *
     * @param  string $template
     * @return array
     */
    public function getPageDefinition($template)
    {
        return $this->loadDefinitionFile($template, 'templates');
    }


    /**
     * Get a block definition
     *
     * @param  string $template
     * @return array
     */
    public function getBlockDefinition($template)
    {
        return $this->loadDefinitionFile($template, 'blocks');
    }


    /**
     * Get block definitions
     *
     * @return array
     */
    public function getBlockDefinitions()
    {
        if (is_null($this->blockDefsLists)) {
            $this->blockDefsLists = [];

            $path = "{$this->definitionsPath}/blocks";

            if (is_dir($path)) {
                foreach (glob("{$path}/*.php") as $file) {
                    $this->blockDefsLists[] = basename($file, '.php');
                }
            }
        }

        return $this->blockDefsLists;
    }


    /**
     * Load a definition file
     *
     * @param  string $file
     * @param  string $type
     * @return array
     */
    protected function loadDefinitionFile($template, $type)
    {
        if (!array_key_exists($type, $this->defs)) {
            $this->defs[$type] = [];
        }

        $file = "{$this->definitionsPath}/{$type}/{$template}.php";

        if (!array_key_exists($file, $this->defs[$type])) {
            $this->defs[$type][$file] = is_file($file)
                ? include $file
                : [];
        }

        return $this->defs[$type][$file];
    }
}
