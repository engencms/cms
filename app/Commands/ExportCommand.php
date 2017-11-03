<?php namespace App\Commands;

use Enstart\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends Command
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app     = $app;
        $app->container->make('Whoops\Run')->unregister();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('export')
            ->setDescription('Export all dynamic parts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exporter = $this->app->container->make('Engen\Services\Exporter');
        $filename = $exporter->export();
        if (!$filename) {
            $output->writeln('<error>Something went wrong. Make sure the folder data/export is writeable.</error>');
            return;
        }

        $output->writeln('Exported to: ' . $filename);
    }

}
