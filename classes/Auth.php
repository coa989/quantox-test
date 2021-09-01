<?php

namespace app\classes;

session_start();

use app\db\Database;

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
            } elseif ($this->user->find(['name' => $_POST['name']])){
                $data['name_err'] = 'Username already used';
            }

            if(empty($_POST['email'])){
                $data['email_err'] = 'Please enter email';
            } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $data['email_err'] = 'Please use valid email address';
            } else{
                if($this->user->find(['email' => $_POST['email']])){
                    $data['email_err'] = 'Email address already used';
                }
            }

            if(empty($_POST['password'])){
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($_POST['password']) < 9){
                $data['password_err'] = 'Password must be minimum 9 characters long';
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

    public function validateLogin()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            if(empty($_POST['email']) || empty($_POST['password'])){
                $empty_value = empty($_POST['email']) ? 'email' : 'password';
                $empty_value_err = $empty_value.'_err';
                $data[$empty_value_err] = 'Please enter your ' .$empty_value;

                $_SESSION['data'] = $data;
                die(header('Location: views/login.view.php'));
            }

            if(!$this->user->find(['email' => $_POST['email']])){
                $data['email_err'] = 'Incorrect email.';
                $_SESSION['data'] = $data;
                header('Location: views/login.view.php');
            }
            if(!$this->login($_POST['email'], $_POST['password'])){
                $data['password_err'] = 'Incorrect password.';
                $_SESSION['data'] = $data;
                header('Location: views/login.view.php');
            }
        }
    }
    private function login($email, $password)
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
}