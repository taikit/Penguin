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
        $sql = "INSERT INTO $this->table (name, email, password) VALUES (:name, :email, :pass)";
        $stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $stmt->execute([
            ':name' => $this->data["name"],
            ':email' => $this->data["email"],
            ':pass' => password_hash($this->data["password"], PASSWORD_DEFAULT)
        ]);
    }

    public function login()
    {
        $this->res["status"] = '{"test": "test"}';
    }

    public function find()
    {
        $sql = "SELECT id, name FROM $this->table WHERE email=:email";
        $stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $stmt->execute([
            ':email' => $this->data["email"],
        ]);
        $this->res["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Model
    public function validation()
    {

    }
}


