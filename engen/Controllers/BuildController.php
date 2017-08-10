<?php namespace Engen\Controllers;

class BuildController extends BaseController
{
    /**
     * Build static site
     *
     * @return string
     */
    public function build()
    {
        define('IS_BUILD', true);
        $builder = $this->container->make('Engen\Services\Builder');
        $builder->build();

        return $this->makeJsonEntity();
    }
}
