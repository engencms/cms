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
        $c->app->addPath([
            'engen_assets' => __DIR__ . '/assets',
            'engen'        => __DIR__,
        ]);

        require_once __DIR__ . '/helpers.php';

        $this->views($c);
        $this->database($c);
        $this->repos($c);
        $this->services($c);
        $this->parsers($c);
        $this->fields($c);
        $this->commands($c);

        $c->singleton('Engen\Validators\Validator');
        $c->alias('Engen\Validators\Validator', 'validator');

        $c->singleton('Engen\Libraries\Slugifier');
        $c->alias('Engen\Libraries\Slugifier', 'slugifier');
    }


    /**
     * Set up services
     *
     * @param  ContainerInterface $c
     */
    protected function services(ContainerInterface $c)
    {
        $c->singleton('Engen\Services\Templates', function ($c) {
            return new \Engen\Services\Templates($c->config->get('views.path') . '/templates');
        });
        $c->alias('Engen\Services\Templates', 'templates');

        $c->singleton('Engen\Services\Definitions', function ($c) {
            return new \Engen\Services\Definitions($c->config->get('views.path') . '/definitions');
        });
        $c->alias('Engen\Services\Definitions', 'definitions');

        $c->singleton('Enstart\Validator\ValidatorInterface', function ($c) {
            $v = new \Enstart\Validator\Validator();
            $v->addRuleset($c->make('Engen\Validators\EngenRules'));
            return $v;
        });

        $c->singleton('Engen\Repos\FilesInterface', function ($c) {
            return new \Engen\Repos\FilesLocalFS(
                $c->config->get('uploads.path')
            );
        });
        $c->alias('Engen\Repos\FilesInterface', 'files');

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

        $c->singleton('Engen\ViewExtensions\BreadCrumbs');
        $c->alias('Engen\ViewExtensions\BreadCrumbs', 'breadCrumbs');
    }


    /**
     * Set up database
     *
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
    }


    /**
     * @param  ContainerInterface $c
     */
    protected function repos(ContainerInterface $c)
    {
        // Pages
        $c->singleton('Engen\Repos\PagesInterface', function ($c) {
            return new \Engen\Repos\FileDB\Pages(
                $c->make('Maer\FileDB\FileDB'),
                $c->app->path('data') . '/pages'
            );
        });

        // Blocks
        $c->singleton('Engen\Repos\BlocksInterface', function ($c) {
            return new \Engen\Repos\FileDB\Blocks(
                $c->make('Maer\FileDB\FileDB'),
                $c->app->path('data') . '/blocks'
            );
        });
        $c->alias('Engen\Repos\BlocksInterface', 'blocks');

        // Menus
        $c->singleton('Engen\Repos\MenusInterface', 'Engen\Repos\FileDB\Menus');
        $c->alias('Engen\Repos\MenusInterface', 'menus');

        // Users
        $c->singleton('Engen\Repos\UsersInterface', 'Engen\Repos\FileDB\Users');
        $c->alias('Engen\Repos\UsersInterface', 'users');

        // Menus
        $c->singleton('Engen\Repos\SettingsInterface', 'Engen\Repos\FileDB\Settings');
        $c->alias('Engen\Repos\SettingsInterface', 'settings');

        // Content
        $c->singleton('Engen\Services\Pages');
        $c->alias('Engen\Services\Pages', 'pages');
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


    /**
     * @param  ContainerInterface $c
     */
    protected function fields(ContainerInterface $c)
    {
        $c->singleton('Engen\Services\FieldsCollection');
        $c->alias('Engen\Services\FieldsCollection', 'fields');

        $c->fields->register(new \Engen\Entities\Field([
            'name' => 'Markdown',
            'key'  => 'markdown',
            'view' => 'admin::fields/markdown',
        ]));

        $c->fields->register(new \Engen\Entities\Field([
            'name' => 'Repeater',
            'key'  => 'repeater',
            'view' => 'admin::fields/repeater',
        ]));

        $c->fields->register(new \Engen\Entities\Field([
            'name' => 'String',
            'key'  => 'string',
            'view' => 'admin::fields/string',
        ]));

        $c->fields->register(new \Engen\Entities\Field([
            'name' => 'Text area',
            'key'  => 'textarea',
            'view' => 'admin::fields/textarea',
        ]));

        $c->fields->register(new \Engen\Entities\Field([
            'name' => 'Image',
            'key'  => 'image',
            'view' => 'admin::fields/image',
        ]));
    }

    /**
     * @param  ContainerInterface $c
     */
    protected function commands(ContainerInterface $c)
    {
        $c->config->push('commands', 'Engen\Commands\BuildCommand');
        $c->config->push('commands', 'Engen\Commands\UsersCreateCommand');
        $c->config->push('commands', 'Engen\Commands\ExportCommand');
        $c->config->push('commands', 'Engen\Commands\ImportCommand');
    }
}
