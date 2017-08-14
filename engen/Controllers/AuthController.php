<?php namespace Engen\Controllers;

class AuthController extends BaseController
{
    /**
     * Show the log in form
     *
     * @return string
     */
    public function showLogin()
    {
        return $this->views->render("admin::auth/login");
    }


    /**
     * Log in a user
     *
     * @return jsonEntity
     */
    public function login()
    {
        $response = $this->makeJsonEntity();

        if (!$this->csrf->validateToken($this->request->post('token'), 'login')) {
            return $response->setError('Invalid token. Please update page and try again.');
        }

        $username = $this->request->post('username');
        $password = $this->request->post('password');

        if (!$this->auth->login($username, $password)) {
            return $response->setError('Invalid username and/or password');
        }

        $redirect = $this->session->get('redirect');

        if ($redirect) {
            // No XSS here!
            $redirect = htmlentities($redirect);
            $this->session->remove('redirect');
        }

        return $response->setData(
            $redirect ?: $this->router->getRoute('engen.dashboard')
        );
    }

    /**
     * Log out a user
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        $this->auth->logout();
        return $this->routeRedirect('engen.login');
    }
}
