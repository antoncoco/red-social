<?php
namespace Cocol\Redsocial\controllers;
use Cocol\Redsocial\lib\Controller;
use Cocol\Redsocial\models\User;

class Profile extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserProfile(User $user) {
        $user->fetchPosts();
        $this->render('profile/index', [
            'user' => $user
        ]);
    }

    public function getUsernameProfile(String $username) {
        $user = User::get($username);
        $this->getUserProfile($user);
    }
}