<?php


namespace app\classes;


use app\db\Database;

class Auth
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


}