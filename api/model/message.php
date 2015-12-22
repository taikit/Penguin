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

        $sql = "INSERT INTO $this->table (user_id, room_id, content,time)
            VALUES (:user_id, :room_id, :content,now())";
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
            $sql = "SELECT $this->table.id  as message_id, $this->table.content , $this->table.time
              ,user.name, $this->table.read_count
              FROM $this->table  inner join user  on   $this->table.user_id=user.id
              WHERE $this->table.room_id=:room_id and message_id<:last_message_id ORDER BY message_id ASC  limit 20 ";

            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':room_id' => $this->data["room_id"],
                ':last_message_id' => $this->data["last_message_id"],


            ]);


        } else {
            $sql = "SELECT  $this->table.id  as message_id,  $this->table.content ,
                  $this->table.time ,user.name , $this->table.read_count
              FROM $this->table inner join user on  $this->table.user_id=user.id
              WHERE $this->table.room_id=:room_id ORDER BY message_id ASC  limit 20";
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

        $sql="select read_date from enter where room_id=:room_id and user_id=:user_id ";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':room_id' => $this->data["room_id"],
            ':user_id' => $this->data["user_id"]
        ]);

        $this->data["read_date"] = $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0]["read_date"];



        $sql = "update message set read_count=read_count+1
            whrere user_id!=:user_id and room_id =:room_id
             and (strtotime(time)-strtotime(".$this->data["read_date"]."))>=0";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"]

        ]);

  //       $sql="update enter set read_date=now() where user_id=:user_id and room_id =:room_id ";
    //     $this->stmt = $this->dbh->prepare($sql);
      //  $this->res['db'] = $this->stmt->execute([
        //    ':user_id' => $this->data["user_id"],
          //  ':room_id' => $this->data["room_id"]

       // ]);




    }


}


