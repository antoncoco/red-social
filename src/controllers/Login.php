<?php

namespace Cocol\Redsocial\controllers;

use Cocol\Redsocial\lib\Controller;
use Cocol\Redsocial\models\User;

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function auth()
    {
        $username = $this->post("username");
        $password = $this->post("password");

        if (
            !is_null($username) &&
            !is_null($password)
        ) {
            if (User::exists($username)) {
                $user = User::get($username);
                if ($user->comparePassword($password)) {
                    $_SESSION['user'] = serialize($user);
                    error_log('user logged in');
                    header('location: /home');
                } else {
                    error_log('Incorrect password');
                    header('location: /login');
                }
            } else {
                error_log('User doesnt exists');
                header('location: /login');
            }
        } else {
            error_log('data incomplete');
            header('location: /login');
        }
    }
}
