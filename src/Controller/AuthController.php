<?php

namespace Controller;

use Core\Controller;
use Model\UserRepository;
use Service\UserService;

class AuthController extends Controller
{
    public function loginFormAction()
    {
        // Check if user already logged in
        if (isset($_SESSION['token'])) {
            $this->redirect('/dashboard');
        }

        $this->view->generate('Auth/loginForm');
    }

    public function loginAction()
    {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            $this->redirect('/', ['login_error' => 'Fill in all the fields.']);
        }

        $input_username = $_POST['username'];
        $input_pass = $_POST['password'];

        $user_repository = new UserRepository();
        $user = $user_repository->findByUsername($input_username);

        // Check if user exists and check password
        if (is_null($user) || !password_verify($input_pass, $user->getPassword())) {
            $this->redirect('/', ['login_error' => 'Wrong username or password.']);
        }

        // Create token for logged in user
        $session_token = md5($user->getPassword());
        $user->setSessionToken($session_token);

        if (!$user_repository->updateSessionToken($user)) {
            $this->redirect('/', ['login_error' => 'Error: Please try again later.']);
        }

        $_SESSION['token'] = $session_token;
        $this->redirect('/dashboard');
    }

    public function logoutAction()
    {
        $user_repository = new UserRepository();
        $user_service = new UserService($user_repository);
        $user = $user_service->getCurrentUser();

        if (is_null($user)) {
            $this->redirect('/', ['login_error' => 'Error: Please try again later.']);
        }

        $user->setSessionToken(null);
        if (!$user_repository->updateSessionToken($user)) {
            $this->redirect('/', ['login_error' => 'Error: Please try again later.']);
        }

        unset($_SESSION['token']);
        $this->redirect('/');
    }
}