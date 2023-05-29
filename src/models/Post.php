<?php

namespace Cocol\Redsocial\models;

use Cocol\Redsocial\lib\Model;
use Cocol\Redsocial\models\Like;

use PDO;
use PDOException;

class Post extends Model
{
    private int $id;
    private array $likes;
    private User $user;

    protected function __construct(
        private string $title
    ) {
        parent::__construct();
        $this->likes = [];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getLikes(): int
    {
        return count($this->likes);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function fetchLikes() {
        $items = [];
        try {
            $query = $this->prepare("SELECT * FROM likes WHERE post_id = :post_id");
            $query->execute([
                'post_id' => $this->id
            ]);

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new Like($row['post_id'], $row['user_id']);
                $item->setId($row['id']);
                array_push($items, $item);
            }
            $this->likes = $items;
        } catch (PDOException $e) {
            
        }
    }

    public function addLike(User $user) {
        $like = new Like($this->id, $user->getId());
        $like->save();
        array_push($this->likes, $like);
    }
}
