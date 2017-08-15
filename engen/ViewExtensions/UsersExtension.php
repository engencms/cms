<?php namespace Engen\ViewExtensions;

use Closure;
use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class UsersExtension implements ExtensionInterface
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var RouterInterface
     */
    protected $app;

    /**
     * Methods to register
     * @var array
     */
    protected $methods = [
        'users',
        'gravatar',
        'isMe',
        'currentUser',
    ];


    /**
     * @param Enstart\App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }


    /**
     * Register the extension
     *
     * @param  Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;

        // Register the view methods
        foreach ($this->methods as $method) {
            $engine->registerFunction($method, [$this, $method]);
        }
    }


    /**
     * Get all menus
     *
     * @return array
     */
    public function users()
    {
        return $this->app->users->getUsers();
    }


    /**
     * Check if a user id is me
     *
     * @return boolean
     */
    public function isMe($id)
    {
        $user = $this->app->auth->getUser();

        return $user && $user->id === $id;
    }


    /**
     * Get current logged in user, if any
     *
     * @return User|null
     */
    public function currentUser()
    {
        return $this->app->auth->getUser();
    }


    /**
     * Get a gravatar image
     *
     * @param  string  $email
     * @param  integer $size
     * @return string
     */
    public function gravatar($email, $size = 100)
    {
        $email = md5($email);
        return "https://www.gravatar.com/avatar/{$email}?s={$size}&d=mm";
    }
}
