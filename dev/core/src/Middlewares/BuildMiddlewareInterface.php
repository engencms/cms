<?php namespace Engen\Middlewares;

use Engen\App;

interface BuildMiddlewareInterface
{
    /**
     * @return boolean|null Set explicitly to false to stop the build
     */
    public function run(App $app);
}
