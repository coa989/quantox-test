<?php

namespace app\classes;

use app\db\Database;

class User
{
    private $db;
    private $tableName = 'users';

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

    public function find(array $where)
    {
        $tableName = $this->tableName;
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = $this->db->pdo->prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement->fetchObject();
    }

}