<?php

namespace app\classes;

use app\db\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        $statement = $this->db->pdo->prepare('SELECT * FROM users');
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}