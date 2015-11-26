<?php

class User extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    //Controller
    public function create()
    {
        $sql = "INSERT INTO $this->table (name, email, pass) VALUES (:name, :email, :pass)";
        $stmt = $this->dbh->prepare($sql);
        $db_res = $stmt->execute([
            ':name' => $this->data["name"],
            ':email' => $this->data["email"],
            ':pass' => password_hash($this->data["pass"], PASSWORD_DEFAULT)
        ]);
        $this->res["status"] = $db_res;
    }

    public function login()
    {
        $this->res["status"] = '{"test": "test"}';
    }

    public function find()
    {
    }

    //Model
    public function validation()
    {

    }
}


