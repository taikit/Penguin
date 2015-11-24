<?php

class User extends Model
{
    function __construct()
    {
        $this->table = 'users';
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
        $res["status"] = $db_res;
        echo json_encode($res);
    }

    public function login()
    {
    }

    public function find()
    {
    }

    //Model
    public function validation()
    {

    }
}


