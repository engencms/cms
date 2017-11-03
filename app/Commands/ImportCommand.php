<?php namespace App\Commands;

use Enstart\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
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
        $this->setName('import')
            ->setDescription('Import a zip')
            ->addArgument('file', InputArgument::REQUIRED, 'filename');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file     = $input->getArgument('file');
        $filename = strpos($file, '/') === 0
            ? $file
            : $this->app->path('root') . '/' . $input->getArgument('file');

        if (!is_file($filename)) {
            $output->writeln('<error>The file ' . $filename . ' does not exist</error>');
            return;
        }

        if (strtolower(pathinfo($filename, PATHINFO_EXTENSION)) !== 'zip') {
            $output->writeln('<error>The file must be a zip file</error>');
            return;
        }

        $importer = $this->app->container->make('Engen\Services\Importer');
        if (!$importer->import($filename)) {
            $output->writeln('<error>Error importing the file</error>');
        }

        $output->writeln('Imported');
    }
}
