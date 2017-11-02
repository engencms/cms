<?php namespace Engen\Controllers;

use Engen\Entities\User;

class UsersController extends BaseController
{
    public function __construct()
    {
        $this->addBreadCrumb([
            'Users' => $this->router->getRoute('engen.users'),
        ]);
    }


    /**
     * Show users list
     *
     * @return string
     */
    public function showUsers()
    {
        return $this->views->render("admin::users/list");
    }


    /**
     * Show user edit form
     *
     * @return string
     */
    public function editUser($id)
    {
        if (!$user = $this->users->getUserById($id)) {
            return $this->routeRedirect('engen.users');
        }

        $this->addBreadCrumb([
            'Edit' => $this->router->getRoute('engen.users.edit', [$id]),
        ]);

        return $this->views->render("admin::users/edit", [
            'user'      => $user,
            'isCurrent' => $user->id === $this->auth->getUser()->id,
        ]);
    }


    /**
     * Show new user form
     *
     * @return string
     */
    public function showNew()
    {
        $this->addBreadCrumb([
            'New' => $this->router->getRoute('engen.users.new'),
        ]);

        return $this->views->render("admin::users/edit", [
            'user' => new User,
        ]);
    }


    /**
     * Add/Update user
     *
     * @return JsonEntity
     */
    public function saveUser()
    {
        $response = $this->makeJsonEntity();

        if (!$this->csrf->validateToken($this->request->post('token'), 'edit-user')) {
            return $response->setError('Invalid token. Please update user and try again.');
        }

        $id     = $this->request->post('id');
        $data   = [
            'username'   => $this->request->post('username'),
            'email'      => $this->request->post('email'),
            'first_name' => $this->request->post('first_name'),
            'last_name'  => $this->request->post('last_name'),
            'password'   => $this->request->post('password'),
            'password_confirm'  => $this->request->post('password_confirm'),
        ];

        $result = $this->validator->user($data, $id);
        if ($result !== true) {
            return $response->setErrors($result)
                ->setMessage('validation_error');
        }

        if ($id) {
            if (empty($data['password'])) {
                unset($data['password']);
            }

            if (!$this->users->updateUser($id, $data)) {
                return $response->setError('Error updating user');
            }
        } else {
            if (!$user = $this->users->createUser(new User($data))) {
                return $response->setError('Error creating user');
            }

            $id = $user->id;
        }

        $this->session->setFlash('success', 'User saved');

        return $response->setData($this->router->getRoute('engen.users.edit', [$id]));
    }

    /**
     * Delete a user
     *
     * @return JsonEntity
     */
    public function deleteUser()
    {
        $response = $this->makeJsonEntity();

        $id    = $this->request->post('ref');
        $token = $this->request->post('token');

        if (!$id) {
            return $response->setError('Invalid id');
        }

        if ($id === $this->auth->getUser('id')) {
            return $response->setError('You can\'t delete yourself');
        }

        if (!$this->csrf->validateToken($token, 'delete-user')) {
            return $response->setError('Invalid call');
        }

        if (!$this->users->deleteUser($id)) {
            return $response->setError('Could not delete the user');
        }

        $this->session->setFlash('success', 'User successfully deleted.');

        return $response->setData($this->router->getRoute('engen.users'));
    }
}
