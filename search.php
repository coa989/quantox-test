<?php

use app\classes\Validation;

session_start();

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

(new Validation())->validateSearch($_GET['query']);

