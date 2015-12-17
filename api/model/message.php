<?php

class Message extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    //Controller
    public function create()
    {
        $sql = "INSERT INTO $this->table (user_id, room_id, content) VALUES (:user_id, :room_id, :content)";
        $stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"],
            ':content' => $this->data["content"]
        ]);
    }

    public function index()
    {


        if (isset($this->data["last_message_id"])) {
            $sql = "SELECT message.id  as message_id, content ,time ,user.name FROM $this->table join user message.user_id=user.id
             ORDER BY message.id DESC  limit =20 WHERE room_id=:room_id and id<last_message_id  ";

            $stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $stmt->execute([
                ':room_id' => $this->data["room_id"],
                ':last_message_id' => $this->data["last_message_id"],
                ':user_id' => $this->data["user_id"]

            ]);

        } else {
            $sql = "SELECT message.id  as message_id, content ,time ,user.name FROM $this->table join user message.user_id=user.id
             ORDER BY message.id DESC  limit =20 WHERE room_id=:room_id";
            $stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $stmt->execute([
                ':room_id' => $this->data["room_id"],

                ':user_id' => $this->data["user_id"]

            ]);
        }


        $this->res["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);


    }
    //Model
}

