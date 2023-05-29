<?php
namespace Cocol\Redsocial\lib;

class Model {
    private Database $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function query(String $query): \PDOStatement | bool
    {
        return $this->db->connect()->query($query);
    }
    public function prepare(String $query): \PDOStatement | bool
    {
        return $this->db->connect()->prepare($query);
    }
}