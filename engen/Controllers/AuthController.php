<?php namespace Engen\Controllers;

class AuthController extends BaseController
{
    public function showLogin()
    {
        dd($this->auth->addUser([
            'username' => 'mange',
            'password' => 'mange',
            'first_name' => 'Magnus',
            'last_name'  => 'Eriksson',
            'email'      => 'mange@reloop.se'
        ]));

        return $this->views->render("admin::auth/login");
    }

    public function login()
    {
        $response = $this->makeJsonEntity();



        $response->setError('Invalid username and/or password');
        return $response;
    }
}
