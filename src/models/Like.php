<?php

namespace Cocol\Redsocial\models;

use Cocol\Redsocial\lib\Model;
use PDOException;

class Like extends Model
{
    private int $id;
    
    public function __construct(
        private int $post_id,
        private int $user_id
    ) {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    public function save() {
        try {
            $query = $this->prepare('INSERT INTO likes(post_id, user_id) VALUES (:post_id, :user_id)');
            $query->execute([
                'post_id' => $this->post_id,
                'user_id' => $this->user_id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}
