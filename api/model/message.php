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
            $sql = "SELECT message.id  as message_id, content ,message.time ,user.name,enter.read_count
              FROM $this->table join user message.user_id=user.id
              WHERE room_id=:room_id and id<:last_message_id ORDER BY message.id ASC  limit =20 ";

            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':room_id' => $this->data["room_id"],
                ':last_message_id' => $this->data["last_message_id"],


            ]);


        } else {
            $sql = "SELECT message.id  as message_id, content , message.time ,user.name ,enter.read_count
              FROM $this->table inner join user on message.user_id=user.id
              WHERE room_id=:room_id ORDER BY message.id ASC  limit 20";
            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':room_id' => $this->data["room_id"]
            ]);
        }
        $this->res["data"] = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->read_count();




    }

    //Model
    function read_count()
    {

        $sql="select read_date from enter whrere room_id=:room_id  and user_id=:user_id ";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':room_id' => $this->data["room_id"],
            ':user_id' => $this->data["user_id"]
        ]);
        $this->data['read_date']= $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0];



        $sql = "update message set read_count+=read_count
            whrere user_id=:user_id and room_id =:room_id  and time>". $this->data["read_date"];
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"]

        ]);

         $sql="update enter set read_date=now() where user_id=:user_id and room_id =:room_id ";
         $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"]

        ]);




    }


}


