<?php

class Message extends Model
{
    function __construct()
    {
        parent::__construct();
       $this->is_room_member();
        if ($this->res["data"]["is_room_menber"] == false) {
            throw new EXception('メンバーにいない');
        }

    }



    //Controller
    public function create()
    {
        //data={
        //"content":,
        //"room_id":,
        //parent_id }

        if (isset($this->data["parent_id"])) {

            $sql = "INSERT INTO $this->table (user_id, room_id, content,time,parent_id)
            VALUES (:user_id, :room_id, :content,now(),:parent_id)";
            $this->stmt = $this->dbh->prepare($sql);
            $this->res["db"] = $this->stmt->execute([
                ':user_id' => $this->data["user_id"],
                ':room_id' => $this->data["room_id"],
                ':content' => $this->data["content"],
                ':parent_id' => $this->data["parent_id"]
            ]);

            $this->update_message();


        } else {

            $sql = "INSERT INTO $this->table (user_id, room_id, content,time)
            VALUES (:user_id, :room_id, :content,now())";
            $this->stmt = $this->dbh->prepare($sql);
            $this->res["db"] = $this->stmt->execute([
                ':user_id' => $this->data["user_id"],
                ':room_id' => $this->data["room_id"],
                ':content' => $this->data["content"]
            ]);


        }
        $room = new Room;
        $room->room_update();

        $this->room_member_id_list();




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
              WHERE $this->table.room_id=:room_id and message_id<:last_message_id ORDER BY message.time DESC  limit 20 ";

            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':room_id' => $this->data["room_id"],
                ':last_message_id' => $this->data["last_message_id"],
            ]);


        } else {
            $sql = "SELECT  $this->table.id,  $this->table.content ,
                  $this->table.time ,user.name , $this->table.read_count
              FROM $this->table inner join user on  $this->table.user_id=user.id
              WHERE room_id=:room_id ORDER BY message.time   desc  ";
            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':room_id' => $this->data["room_id"]
            ]);
        }


        $this->res["data"] = $this->stmt->fetchAll(PDO::FETCH_ASSOC);


        $this->read_count();


    }

    public function reply_message(){

        //data={
          //now_message_id
          //  room_id}


       $sql="select parent_id ,is_children
         from message
         where id=:now_message_id " ;
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':now_message_id' => $this->data["now_message_id"],
        ]);

         $array=$this->stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->data["parent_id"]= $array[0]["parent_id"];
        $is_children=$array[0]["is_children"];





         //親
        if(isset( $this->data["parent_id"])){
            $sql="select message.content  ,message.time  ,user.name
           from message inner join user  on message.user_id=user.id
          where message.id=:parent_id " ;
            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':parent_id' => $this->data["parent_id"],
            ]);

         $this->res["data"]["parent"]=$this->stmt->fetchAll(PDO::FETCH_ASSOC);


        }
        //自分
        $sql="select message.content  ,message.time  ,user.name
           from message inner join user  on message.user_id=user.id
          where message.id=:now_message_id " ;
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':now_message_id' => $this->data["now_message_id"],
        ]);

        $this->res["data"]["me"]=$this->stmt->fetchAll(PDO::FETCH_ASSOC);
        //子供
        if($is_children==1){
            $sql="select message.content  ,message.time  ,user.name
           from message inner join user  on message.user_id=user.id
          where message.parent_id=:now_message_id " ;
            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':now_message_id' => $this->data["now_message_id"],
            ]);
        }
        $this->res["data"]["children"]=$this->stmt->fetchAll(PDO::FETCH_ASSOC);


    }







    //Model
    public function read_count()
    {

        $sql = "select read_date from enter where room_id=:room_id and user_id=:user_id ";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':room_id' => $this->data["room_id"],
            ':user_id' => $this->data["user_id"]
        ]);

        $this->data['read_date'] = $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0]['read_date'];


        $sql = "update message set read_count=read_count+1
            where user_id!=:user_id and room_id =:room_id
             and time >=:read_date";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"],
            ':read_date' => $this->data['read_date']
        ]);

        $sql = "update enter set read_date=now() where user_id=:user_id and room_id =:room_id ";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':user_id' => $this->data["user_id"],
            ':room_id' => $this->data["room_id"]

        ]);
    }


    public function  is_room_member()
    {
        $sql = "select id  from enter where user_id=:user_id and room_id=:room_id";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':room_id' => $this->data["room_id"],
            ':user_id' => $this->data["user_id"]
        ]);
        $id = $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        if (!isset($id)) {
            $this->res["data"]["is_room_menber"] = false;


        } else {
            $this->res["data"]["is_room_menber"] = true;

        }


    }

    public function update_message()
    {

        $sql = "select is_children  from  $this->table  where id=:parent_id";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':parent_id' => $this->data["parent_id"]

        ]);
        $is_children = $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0]["is_children"];
        if ($is_children == 0) {

            $sql = "update message set is_children=1 where id=:parent_id";
            $this->stmt = $this->dbh->prepare($sql);
            $this->res['db'] = $this->stmt->execute([
                ':parent_id' => $this->data["parent_id"]
            ]);

        }


    }
    public  function  room_member_id_list()
    {
        $sql = "select user_id as room_member_id from enter
           where room_id=:room_id and  user_id!=:user_id ";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $this->stmt->execute([
            ':room_id' => $this->data["room_id"],
            ':user_id' => $this->data["user_id"]
        ]);

        $this->res["data"] = $this->stmt->fetchAll(PDO::FETCH_ASSOC);


      }

    }












