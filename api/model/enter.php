<?php

class enter extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    //model
    public function create()
    {
        $sql = "INSERT INTO $this->table (user_id, room_id, is_friend) VALUES (:user_id, :room_id, :is_friend)";
        $stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"],
            ':is_friend' => $this->data["is_friend"]
        ]);
    }
}
