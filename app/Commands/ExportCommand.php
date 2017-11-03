<?php namespace App\Commands;

use Enstart\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZipArchive;


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
        $zip      = new ZipArchive();
        $filename = $this->app->path('data') . '/exports/' . date('Y-m-d_His') . '.zip';

        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            $output->writeln('<error>Unable to create zip folder.</error>');
            return;
        }

        $paths = [
            '/data/blocks',
            '/data/meta',
            '/data/pages',
            '/public/uploads',
        ];

        foreach ($paths as $path) {
            $this->addFiles($zip, $this->app->path('root') . $path, $path);
        }

        $zip->close();
        $output->writeln('Exported to: ' . $filename);
    }

    protected function addFiles($zip, $source, $target)
    {
        $target = ltrim($target, '/');
        $zip->addEmptyDir($target);

        foreach (glob($source . '/*') as $file) {
            $zip->addFile($file, $target . '/' . basename($file));
        }
    }
}
