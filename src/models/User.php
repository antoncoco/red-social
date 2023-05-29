<?php

namespace Cocol\Redsocial\models;

use Cocol\Redsocial\lib\Database;
use Cocol\Redsocial\lib\Model;
use PDO;
use PDOException;

class User extends Model
{
    private int $id;
    private array $posts;
    private string $profile;
    public function __construct(
        private string $username,
        private string $password
    ) {
        parent::__construct();
        $this->posts = [];
        $this->profile = "";
        $this->id = -1;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPosts() {
        return $this->posts;
    }

    public function setPosts($posts) {
        $this->posts = $posts;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getProfile() {
        return $this->profile;
    }

    public function setProfile($profile) {
        $this->profile = $profile;
    }

    public function save()
    {
        try {
            //TODO: validar si existe primero el usuario
            $hash = $this->getHashPassword($this->password);
            $query = $this->prepare(
                'INSERT INTO users(username, password, profile) VALUES(:username, :password, :profile)'
            );
            $query->execute([
                'username' => $this->username,
                'password' => $hash,
                'profile' => $this->profile
            ]);
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    private function getHashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    public static function exists(String $username): bool {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT username FROM users WHERE username = :username');
            $query->execute([
                'username' => $username
            ]);

            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public static function get(String $username): User | null {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM users WHERE username = :username');
            $query->execute([
                'username' => $username
            ]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $user = new User($data['username'], $data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);
            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return NULL;
        }
    }

    public function comparePassword(String $password): bool {
        return password_verify($password, $this->password);
    }

    public function publish(PostImage $post) {
        try {
            $query = $this->prepare('INSERT INTO posts (user_id, title, media) VALUES (:user_id, :title, :media)');
            $query->execute([
                'user_id' => $this->id,
                'title' => $post->getTitle(),
                'media' => $post->getImage()
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getById(String $user_id): User | null {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM users WHERE user_id = :user_id');
            $query->execute([
                'user_id' => $user_id
            ]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $user = new User($data['username'], $data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);
            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return NULL;
        }
    }

    public function fetchPosts() {
        $this->posts = PostImage::getAlL($this->id);
    }
}
