<?php

namespace Cocol\Redsocial\controllers;

use Cocol\Redsocial\lib\Controller;
use Cocol\Redsocial\models\PostImage;
use Cocol\Redsocial\models\User;

class Actions extends Controller
{
    public function __construct(private User $user)
    {
        parent::__construct();
    }

    public function like()
    {
        $post_id = $this->post('post_id');
        $origin = $this->post('origin');
        if (!is_null($post_id) && !is_null($origin)) {
            $post = PostImage::get($post_id);
            $post->addLike($this->user);
            header('location: /' . $origin);
        }
    }
}
