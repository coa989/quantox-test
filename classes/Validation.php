<?php

namespace app\classes;

class Validation extends Auth
{
    /**
     * Validate register $_POST data
     */
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

    /**
     * Validate login $_POST data
     */
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

    /**
     * Validate auth and search query
     */
    public function validateSearch($query)
    {
        if (isset($_SESSION['user_id'])) {
            $result = $this->user->searchQuery($query);

            if (!empty($query)) {
                $_SESSION['result'] = $result;
                header('Location: views/results.view.php');
            } else {
                $_SESSION['err_msg'] = 'You must enter at least 1 character.';
                header('Location: views/home.view.php');
            }
        } else {
            header('Location: views/login.view.php');
        }
    }

    /**
     * Validate auth
     */
    public function validateLogout()
    {
        if (isset($_SESSION['user_id'])) {
            $this->logout();
        }
    }
}