<?php
use app\classes\Auth;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

(new Auth())->validateLogin();
