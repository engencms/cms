<?php namespace Engen\Repos;

use Engen\Entities\User;

interface UsersInterface
{
    /**
     * Get all users
     *
     * @return array
     */
    public function getUsers();


    /**
     * Get a user by username
     *
     * @param  string $username
     * @return User|null
     */
    public function getUserByUsername($username);


    /**
     * Get a user by email
     *
     * @param  string $email
     * @return User|null
     */
    public function getUserByEmail($email);


    /**
     * Get a user by id
     *
     * @param  integer $id
     * @return User|null
     */
    public function getUserById($id);


    /**
     * Update a user
     *
     * @param  string $id
     * @param  array  $data
     * @return User|null
     */
    public function updateUser($id, array $data);


    /**
     * Add a new user
     *
     * @param  User   $user
     * @return User|null
     */
    public function createUser(User $user);


    /**
     * Delete a user
     *
     * @param  string $id
     * @return boolean
     */
    public function deleteUser($id);
}
