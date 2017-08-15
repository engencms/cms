<?php namespace Engen\ViewExtensions;

class BreadCrumbs
{
    /**
     * Registered crumbs
     * @var array
     */
    protected $crumbs = [];


    /**
     * Register crumbs
     *
     * @param string|array  $label
     * @param string        $uri
     */
    public function add($key, $label, $uri = null)
    {
        if (!isset($this->crumbs[$key])) {
            $this->crumbs[$key] = [];
        }

        if (is_array($label)) {
            foreach ($label as $name => $crumb) {
                $this->crumbs[$key][] = ['label' => $name, 'uri' => $crumb];
            }
            return;
        }

        if (!is_string($uri)) {
            throw new \Exception('The uri must be a string');
        }

        $this->crumbs[$key][] = ['label' => $label, 'uri' => $uri];
    }


    /**
     * Get all registered crumbs
     * @return [type] [description]
     */
    public function get($key)
    {
        return $this->crumbs[$key] ?? [];
    }


    /**
     * Check if there are any crumbs
     *
     * @return boolean
     */
    public function hasCrumbs($key)
    {
        return !empty($this->crumbs[$key]);
    }
}
