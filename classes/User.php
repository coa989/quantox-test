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

    public function findByName($name)
    {
        $statement = $this->db->pdo->prepare('SELECT * FROM users WHERE name = :name');
        $statement->bindValue(':name', $name);
        $statement->execute();

        if($statement->rowCount() > 0){
            return true;
        } else{
            return false;
        }
    }

    public function findByEmail($email)
    {
        $statement = $this->db->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();

        if($statement->rowCount() > 0){
            return true;
        } else{
            return false;
        }
    }
}