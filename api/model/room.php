<?php

class Room extends Model
{
    function __construct()
    {
        parent::__construct();
        if(isset($this->data["is_friend"])) {
            $this->data["is_friend"] = $this->data["is_friend"] == "True";
        }
    }


//Controller
    public
    function room_create()
    {
        $this->data["is_friend"] = 0;
        $this->create();
        $room_id = $this->dbh->lastInsertId('id');
        $entry = new Enter;
        $entry->data['room_id'] = $room_id;
        $entry->data['is_friend'] = 0;
        //自分を
        $entry->create();
        //みんな
        foreach ($this->data["friend_list"] as $id) {
            $entry->data['user_id'] = $id;
            $entry->create();
        }
    }

    public
    function friend_create()
    {
//        data={
//        "user_id": 自分のID
//        "friend_id": 友達のID
//        }
        $this->data["is_friend"] = true;
        $this->data['name'] = '';
        $this->create();
        $room_id = $this->dbh->lastInsertId('id');
        //自分をエントリー
        $entry = new Enter;
        $entry->data['room_id'] = $room_id;
        $entry->data['is_friend'] = true;
        $entry->create();
        //友達をエントリー
        $entry->data['user_id'] = $this->data['friend_id'];
        $entry->create();
    }

    public
    function index()
    {
        $sql = "select room.id as room_id,room.name as room_name,enter.is_friend,message.content as new_comemnt,enter.user_id,message.time
from  room
inner join enter on room.id=enter.room_id
inner join message on room.id=message.room_id
where enter.user_id = 4 and message.time in (select max(time) from message group by room_id)
order by message.time ASC limit 20";


        $stmt = $this->dbh->prepare($sql);

        $this->res["db"] = $stmt->execute([
            ':user_id' => $this->data["user_id"]

        ]);

        $this->res["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $array = $this->res["data"];

        foreach ($array as $val => $array) {
            if ($array['is_friend']==1) {
                $sql = "select user.name from enter  inner join user on user.id=enter.user_id where user_id!=:user_id  and room_id=" . $array['room_id'];
                $stmt = $this->dbh->prepare($sql);
                $this->res["db"] = $stmt->execute([
                    ':user_id' => $this->data["user_id"]

                ]);

                $stmt->fetchAll(PDO::FETCH_ASSOC);
                $array['room_name'] =  $this->res["data"]["room_name"]['name'] ;


            }
            //else{
             //   $sql="select count(room_id)from enter where room_id=". $array['room_id'];
               // $stmt = $this->dbh->prepare($sql);

           // }

        }
        $this->res["data"] = $array;


    }

//Model

    public
    function create()
    {
        $sql = "INSERT INTO $this->table (name, is_friend) VALUES (:name, :is_friend)";
        $stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $stmt->execute([
            ':name' => $this->data["name"],
            ':is_friend' => $this->data["is_friend"]
        ]);
    }
}

