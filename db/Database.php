<?php

namespace app\db;

/**
 * Class Database
 * @package app\db
 */
class Database
{
    /**
     * @var \PDO
     */
    public \PDO $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $dsn = $_ENV['DB_DSN'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}