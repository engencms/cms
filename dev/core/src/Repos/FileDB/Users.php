<?php namespace Engen\Repos\FileDB;

use Engen\Entities\User;
use Engen\Libraries\Security;
use Engen\Repos\UsersInterface;
use Maer\FileDB\FileDB;

class Users implements UsersInterface
{
    /**
     * @var FileDB
     */
    protected $db;

    /**
     * @var Security
     */
    protected $sec;

    /**
     * List of users
     * @var array
     */
    protected $users = [];


    /**
     * @param FileDB $db
     */
    public function __construct(FileDB $db, Security $sec)
    {
        $this->db  = $db;
        $this->sec = $sec;
    }


    /**
     * Get all users
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->db->users
            ->orderBy('username', 'asc')
            ->asObj('Engen\Entities\User')
            ->get();
    }


    /**
     * Get a user by username
     *
     * @param  string $username
     * @return User|null
     */
    public function getUserByUsername($username)
    {
        return $this->db->users
            ->where('username', $username)
            ->asObj('Engen\Entities\User')
            ->first();
    }


    /**
     * Get a user by email
     *
     * @param  string $email
     * @return User|null
     */
    public function getUserByEmail($email)
    {
        return $this->db->users
            ->where('email', $email)
            ->asObj('Engen\Entities\User')
            ->first();
    }


    /**
     * Get a user by id
     *
     * @param  integer $id
     * @return User|null
     */
    public function getUserById($id)
    {
        return $this->db->users
            ->where('id', $id)
            ->asObj('Engen\Entities\User')
            ->first();
    }


    /**
     * Update a user
     *
     * @param  string $id
     * @param  array  $data
     * @return User|null
     */
    public function updateUser($id, array $data)
    {
        if (!$user = $this->getUserById($id)) {
            return false;
        }

        if (empty($data['updated'])) {
            $data['updated'] = time();
        }

        if (empty($data['created'])) {
            $data['created'] = time();
        }

        if (!empty($data['password'])) {
            $data['password'] = $this->sec->hashPassword($data['password']);
        }

        $data = array_replace($user->toArray(['id']), $data);

        if ($this->db->users->where('id', $id)->update($data) < 1) {
            return false;
        }

        return $this->getUserById($id);
    }


    /**
     * Add a new user
     *
     * @param  User   $user
     * @return User|null
     */
    public function createUser(User $user)
    {
        if ($user->updated == 0) {
            $user->updated = time();
        }

        if ($user->created == 0) {
            $user->created = time();
        }

        $user->password = $this->sec->hashPassword($user->password);

        if (!$id = $this->db->users->insert($user->toArray(['id']))) {
            return false;
        }

        return $this->getUserById($id);
    }


    /**
     * Delete a user
     *
     * @param  string $id
     * @return boolean
     */
    public function deleteUser($id)
    {
        return $this->db->users->where('id', $id)->delete() > 0;
    }
}
