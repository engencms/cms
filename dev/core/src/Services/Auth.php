<?php namespace Engen\Services;

use Engen\Entities\User;
use Engen\Libraries\Security;
use Engen\Repos\UsersInterface;
use Enstart\Http\SessionInterface;

class Auth
{
    /**
     * @var UsersInterface
     */
    protected $db;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Current logged in user
     * @var User|null
     */
    protected $user;

    /**
     * @var Security
     */
    protected $sec;


    /**
     * @param UsersInterface $db
     */
    public function __construct(UsersInterface $db, SessionInterface $session, Security $sec)
    {
        $this->db      = $db;
        $this->session = $session;
        $this->sec     = $sec;

        if ($user = $session->get('engen-admin/user')) {
            $this->user = is_array($user) ? User::make($user) : null;
        }
    }


    /**
     * Log in a user
     *
     * @param  string $username
     * @param  string $password
     * @return boolean
     */
    public function login($username, $password)
    {
        if (!$user = $this->authenticate($username, $password)) {
            return false;
        }

        $this->setUser($user);

        return true;
    }


    /**
     * Log out user
     */
    public function logout()
    {
        $this->session->clear();
        $this->user = null;
    }


    /**
     * Authenticate a user
     *
     * @param  string $username
     * @param  string $password
     * @return User|false
     */
    public function authenticate($username, $password)
    {
        if (!$user = $this->db->getUserByUsername($username)) {
            return false;
        }

        if (!$this->sec->verifyPassword($password, $user->password)) {
            return false;
        }

        return $user;
    }


    /**
     * Set the current user
     *
     * @param mixed
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        $this->session->set('engen-admin/user', $user->toArray([
            'password',
            'reset_token',
            'reset_date',
        ]));
    }


    /**
     * Get the current user
     *
     * @param string $key
     * @param mixed  $fallback
     * @param User|null
     */
    public function getUser($key = null, $fallback = null)
    {
        if (!$key) {
            return $this->user;
        }

        return $this->user && $this->user->has($key)
            ? $this->user->{$key}
            : $fallback;
    }


    /**
     * Check if the user is set
     *
     * @return boolean
     */
    public function hasUser()
    {
        return !is_null($this->user);
    }
}
