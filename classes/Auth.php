<?php

namespace app\classes;

session_start();

use app\db\Database;

class Auth
{
    private $db;
    protected $user;

    public function __construct()
    {
        $this->db = new Database();
        $this->user = new User;
    }

    protected function register($username, $email, $hashed_password)
    {
        $statement = $this->db->pdo->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
        $statement->bindValue(':name', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $hashed_password);
        $statement->execute();
        header('Location: views/login.view.php');
    }

    protected function login($email, $password)
    {
        $row = $this->user->find(['email' => $email]);

        if($row){
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)){
                $_SESSION['user_id'] = $row->id;
                $_SESSION['user_name'] = $row->name;
                $_SESSION['user_email'] = $row->email;
                $_SESSION['role'] = $row->role;
                if($_SESSION['role'] == 'admin'){
                    header('Location: admin.php');
                } else{
                    header('Location: views/home.view.php');
                }
                return $row;
            } else{
                return false;
            }
        }
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        return true;
    }
}