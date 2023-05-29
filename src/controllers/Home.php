<?php
namespace Cocol\Redsocial\controllers;

use Cocol\Redsocial\lib\Controller;
use Cocol\Redsocial\lib\UtilImages;
use Cocol\Redsocial\models\PostImage;
use Cocol\Redsocial\models\User;

class Home extends Controller {
    public function __construct(
        private User $user
    )
    {
        parent::__construct();
    }

    public function index() {
        $posts = PostImage::getFeed();
        $this->render('home/index', [
            'user' => $this->user,
            'posts' => $posts
        ]);
    }

    public function store() {
        $title = $this->post('title');
        $image = $this->file('image');
        if (!is_null($title) && !is_null($image)) {
            $fileName = UtilImages::storeImage($image);

            $post = new PostImage($title, $fileName);
            $this->user->publish($post);
            header('location: /home');
        } else {
            header('location: /home');
        }
    }
}