<?php

class Group extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    //Controller

    public function room_create()
    {
      $this- create();

        ]);



        public function friend_create()
    {
        $this- create();

        ]);




    }

    public function find()
    {
    }

    //Model

    public function create()
    {

        $sql = "INSERT INTO $this->table (name,is_friend ) VALUES (:name, :is_friend)";
        $stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $stmt->execute([
            ':name' => $this->data["name"],
            ':is_friend' => $this->data["is_friend"]

        ]);




    }
}

