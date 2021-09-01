<?php

use app\classes\User;

session_start();

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$result = (new User())->searchQuery($_GET['query']);

if(!empty($_GET['query'])) {
    $_SESSION['result'] = $result;
    header('Location: views/results.view.php');
} else {
    $_SESSION['err_msg'] = 'You must enter at least 1 character.';
    header('Location: views/home.view.php');
}
