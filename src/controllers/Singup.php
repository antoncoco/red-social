<?php

namespace Cocol\Redsocial\controllers;

use Cocol\Redsocial\lib\Controller;
use Cocol\Redsocial\lib\UtilImages;
use Cocol\Redsocial\models\User;

class Singup extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register() {
        $username = $this->post('username');
        $password = $this->post('password');
        $profile = $this->file('profile');
        if(
            !is_null($username) &&
            !is_null($password) &&
            !is_null($profile)
        ) {
            $pictureName = UtilImages::storeImage($profile);
            $user = new User($username, $password);
            $user->setProfile($pictureName);
            $user->save();
            header('location: /login');
        }else {
            $this->render('errors/index');
        }
    }
}