<?php namespace Engen;

use Enstart\Container\ContainerInterface;
use Enstart\ServiceProvider\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the service provider
     *
     * @param  ContainerInterface $c
     */
    public function register(ContainerInterface $c)
    {
        $c->alias('Enstart\App', 'app');
        $c->app->addPath(['engen_assets' => __DIR__ . '/assets']);

        require_once __DIR__ . '/helpers.php';

        $this->views($c);
        $this->database($c);
        $this->parsers($c);

        $c->singleton('Engen\Services\Templates', function ($c) {
            return new \Engen\Services\Templates(
                $c->config->get('views.path')
            );
        });
        $c->alias('Engen\Services\Templates', 'templates');

        $c->singleton('Enstart\Validator\ValidatorInterface', function ($c) {
            $v = new \Enstart\Validator\Validator();
            $v->addRuleset($c->make('Engen\Validators\EngenRules'));
            return $v;
        });

        $c->singleton('Engen\Validators\Validator');
        $c->alias('Engen\Validators\Validator', 'validator');

        $c->singleton('Engen\ViewExtensions\BreadCrumbs');
        $c->alias('Engen\ViewExtensions\BreadCrumbs', 'breadCrumbs');

        $c->singleton('Engen\Repos\FilesInterface', function ($c) {
            return new \Engen\Repos\FilesLocalFS(
                $c->config->get('uploads.path')
            );
        });
        $c->alias('Engen\Repos\FilesInterface', 'files');

        $c->singleton('Engen\Libraries\Slugifier');
        $c->alias('Engen\Libraries\Slugifier', 'slugifier');

        // Auth
        $c->singleton('Engen\Services\Auth');
        $c->alias('Engen\Services\Auth', 'auth');
    }


    /**
     * Set up view pats etc.
     *
     * @param  ContainerInterface $c
     */
    protected function views(ContainerInterface $c)
    {
        // Set the correct theme path
        $views  = rtrim($c->config->get('themes.path'), '/');
        $views .= '/' . $c->config->get('themes.theme');
        $c->config->set('views.path', $views);
    }


    /**
     * @param  ContainerInterface $c
     */
    protected function database(ContainerInterface $c)
    {
        $c->singleton('Maer\FileDB\FileDB', function ($c) {
            $storage  = new \Maer\FileDB\Storage\FileSystem(
                $c->app->path('data') . '/meta',
                ['json_options' => JSON_PRETTY_PRINT]
            );

            return new \Maer\FileDB\FileDB($storage);
        });

        // Pages
        $c->singleton('Engen\Repos\PagesInterface', function ($c) {
            return new \Engen\Repos\PagesFileDB(
                $c->make('Maer\FileDB\FileDB'),
                $c->app->path('data') . '/pages'
            );
        });
        $c->alias('Engen\Repos\PagesInterface', 'pages');

        // Pages
        $c->singleton('Engen\Repos\BlocksInterface', function ($c) {
            return new \Engen\Repos\BlocksFileDB(
                $c->make('Maer\FileDB\FileDB'),
                $c->app->path('data') . '/blocks'
            );
        });
        $c->alias('Engen\Repos\BlocksInterface', 'blocks');

        // Menus
        $c->singleton('Engen\Repos\MenusInterface', 'Engen\Repos\MenusFileDB');
        $c->alias('Engen\Repos\MenusInterface', 'menus');

        // Users
        $c->singleton('Engen\Repos\UsersInterface', 'Engen\Repos\UsersFileDB');
        $c->alias('Engen\Repos\UsersInterface', 'users');

        // Menus
        $c->singleton('Engen\Repos\SettingsInterface', 'Engen\Repos\SettingsFileDB');
        $c->alias('Engen\Repos\SettingsInterface', 'settings');
    }


    /**
     * @param  ContainerInterface $c
     */
    protected function parsers(ContainerInterface $c)
    {
        $c->singleton('Engen\Services\Parsers', function ($c) {
            $parsers = new \Engen\Services\Parsers(
                $c->make('Engen\Repos\PagesInterface')
            );

            $parsers->registerParser('markdown', function ($text) {
                static $pd;

                if (is_null($pd)) {
                    $pd = new \Parsedown;
                }

                return $pd->text($text);
            });

            return $parsers;
        });
        $c->alias('Engen\Services\Parsers', 'parsers');
    }
}
