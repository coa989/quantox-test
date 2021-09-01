<?php

namespace app\classes;

session_start();

use app\db\Database;
use PDO;

class Auth
{
    private $db;
    private $user;

    public function __construct()
    {
        $this->db = new Database();
        $this->user = new User;
    }

    public function validateRegister()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            if(empty($_POST['name'])){
                $data['name_err'] = 'Please enter name';
            } elseif ($this->user->findByName($_POST['name'])){
                $data['name_err'] = 'Username already used';
            }

            if(empty($_POST['email'])){
                $data['email_err'] = 'Please enter email';
            } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $data['email_err'] = 'Please use valid email address';
            } else{
                if($this->user->findByEmail($_POST['email'])){
                    $data['email_err'] = 'Email address already used';
                }
            }

            if(empty($_POST['password'])){
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($_POST['password']) < 6){
                $data['password_err'] = 'Password must be minimum 6 characters long';
            }

            if(empty($_POST['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            } elseif($_POST['password'] != $_POST['confirm_password']){
                $data['confirm_password_err'] = 'Password do not match';
            }

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->register($data['name'], $data['email'], $hashed_password);
            } else{
                $_SESSION['data'] = $data;
                header('Location: views/register.view.php');
            }
        }
    }

    private function register($username, $email, $hashed_password)
    {
        $statement = $this->db->pdo->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
        $statement->bindValue(':name', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $hashed_password);
        $statement->execute();
        header('Location: views/login.view.php');
    }




}