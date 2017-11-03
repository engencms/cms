<?php namespace Engen\Commands;

use Enstart\App;
use Engen\Entities\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class UsersCreateCommand extends Command
{
    protected $app;
    protected $in;
    protected $out;

    public function __construct(App $app)
    {
        $this->app     = $app;
        $app->container->make('Whoops\Run')->unregister();

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('users:create')
            ->setDescription('Create a new user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ask  = $this->getHelper('question');
        $user = new User;

        // Username
        // --------------------------------------------------------
        $question = (new Question('<fg=white;options=bold>Username: </>'))
            ->setValidator(function ($data) {
                return $this->validateUsername($data);
            });

        $user->username = $ask->ask($input, $output, $question);

        // Password
        // --------------------------------------------------------
        $question = (new Question('<fg=white;options=bold>Password: </>'))
            ->setHidden(true)
            ->setHiddenFallback(false)
            ->setValidator(function ($data) {
                return $this->validatePassword($data);
            });

        $user->password = $ask->ask($input, $output, $question);

        // Email
        // --------------------------------------------------------
        $question = (new Question('<fg=white;options=bold>Email: </>'))
            ->setValidator(function ($data) {
                return $this->validateEmail($data);
            });

        $user->email = $ask->ask($input, $output, $question);

        // First name
        // --------------------------------------------------------
        $question = (new Question('<fg=white;options=bold>First name: </>'))
            ->setValidator(function ($data) {
                return $this->validateName($data, 'first name');
            });

        $user->first_name = $ask->ask($input, $output, $question);

        // Last name
        // --------------------------------------------------------
        $question = (new Question('<fg=white;options=bold>Last name: </>'))
            ->setValidator(function ($data) {
                return $this->validateName($data, 'last name');
            });

        $user->last_name = $ask->ask($input, $output, $question);

        if (!$user = $this->app->users->createUser($user)) {
            $this->writeln('<error>Error trying to create the user. Please try again.</error>');
        }

        $output->writeln('<info>The user ' . $user->username . ' was successfully created.</info>');
    }

    protected function validateUsername($data)
    {
        if (trim($data) !== $data) {
            throw new \RuntimeException('The username can\'t start or end with a space');
        }

        if (strlen($data) < 3) {
            throw new \RuntimeException('The username must be at least 3 characters');
        }

        $user = $this->app->users->getUserByUsername($data);
        if ($user) {
            throw new \RuntimeException('There already is a user with this username');
        }

        return $data;
    }

    protected function validatePassword($data)
    {
        if (trim($data) !== $data) {
            throw new \RuntimeException('The password can\'t start or end with a space');
        }

        if (strlen($data) < 5) {
            throw new \RuntimeException('The password must be at least 5 characters');
        }

        if (strtolower($data) == 'password' || strtolower($data) == 'passw0rd') {
            throw new \RuntimeException('You need to do better than that...');
        }

        return $data;
    }

    protected function validateEmail($data)
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('Invalid email');
        }

        $user = $this->app->users->getUserByEmail($data);
        if ($user) {
            throw new \RuntimeException('There already is a user with this email');
        }

        return $data;
    }

    protected function validateName($data, $type)
    {
        if (trim($data) !== $data) {
            throw new \RuntimeException('The ' . $type . ' can\'t start or end with a space');
        }

        if (strlen($data) < 3) {
            throw new \RuntimeException('The ' . $type . ' must be at least 3 characters');
        }

        return $data;
    }
}
