<?php namespace App\Commands;

use Enstart\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends Command
{
    protected $app;
    protected $builder;

    public function __construct(App $app)
    {
        define('IS_BUILD', true);

        $this->app     = $app;
        $this->builder = $app->container->make('Engen\Services\Builder');

        $app->container->make('Whoops\Run')->unregister();
        #$app->config->push('views.extensions', 'Engen\Extensions\BuildExtension');
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('build:site')
            ->setDescription('Generate static pages');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->builder->build() === false) {
            $output->writeln($this->builder->getError());
            return;
        }

        $output->writeln('All done!');
    }
}
