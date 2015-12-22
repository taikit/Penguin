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
        //data={
        //"content":,
        //"room_id": }

        $sql = "INSERT INTO $this->table (user_id, room_id, content) VALUES (:user_id, :room_id, :content)";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $this->stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"],
            ':content' => $this->data["content"]
        ]);
    }

    public function index()
    {
        //data={
        //"room_id":
        //last_message_id }

        if (isset($this->data["last_message_id"])) {
            $sql = "SELECT message.id  as message_id, content ,message.time ,user.name FROM $this->table join user message.user_id=user.id
              WHERE room_id=:room_id and id<:last_message_id ORDER BY message.id ASC  limit =20 ";

            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':room_id' => $this->data["room_id"],
                ':last_message_id' => $this->data["last_message_id"],


            ]);


        } else {
            $sql = "SELECT message.id  as message_id, content , message.time ,user.name FROM $this->table inner join user on message.user_id=user.id
              WHERE room_id=:room_id ORDER BY message.id ASC  limit 20";
            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':room_id' => $this->data["room_id"]
            ]);
        }
        $array = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($array as $val => $ar) {
            $this->data["id"] = $val["message_id"];
            $array[$val]["read_count"] = $this->read_count();

        }


    }

    //Model
    function read_count()
    {


        $sql = "update message set read_count+=read_count whrere user_id<>:user_id and id=" . $this->data["id"];
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':user_id' => $this->data["user_id"]
        ]);
        $this->stmt->fetchAll(PDO::FETCH_ASSOC);


        $sql = "select read_count from message whrere id " . $this->data["id"];
        $this->stmt = $this->dbh->prepare($sql);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }


}


