<?php

use app\classes\Validation;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$user = (new Validation())->validateLogout();

