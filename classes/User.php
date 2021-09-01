<?php

namespace app\classes;

use app\db\Database;
use PDO;

class User
{
    private $db;
    private $tableName = 'users';

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param array $where
     * @return mixed
     */
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

    /**
     * @param $query
     * @return array
     */
    public function searchQuery($query)
    {
        $statement = $this->db->pdo->prepare("SELECT * FROM users WHERE name LIKE :name OR email LIKE :email");
        $statement->bindValue(':name', '%'.$query.'%');
        $statement->bindValue(':email', '%'.$query.'%');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

}