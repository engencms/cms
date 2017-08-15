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
        $response = $this->makeJsonEntity();

        $builder = $this->container->make('Engen\Services\Builder');
        if (!$builder->build()) {
            $response->setError($builder->getError() ?: 'Unknown error occurred');
        }

        return $response;
    }
}
