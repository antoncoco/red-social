<?php
namespace Cocol\Redsocial\lib;
use PDO;
use PDOException;

class Database{
    private String $host;
    private String $db;
    private String $user;
    private String $password;
    private int $port;
    private String $charset;

    public function __construct()
    {
        $this->host = $_ENV['HOST'];
        $this->db = $_ENV['DB'];
        $this->user = $_ENV['USER'];
        $this->password = $_ENV['PASSWORD'];
        $this->port = (int) $_ENV['PORT'];
        $this->charset = $_ENV['CHARSET'];
    }

    public function connect(): PDO {
        try {
            $conection = "mysql:host=" . $this->host . ";port=". $this->port .";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $pdo = new PDO($conection, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}