<?php
require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use app\classes\Auth;

(new Auth())->validateLogin();
