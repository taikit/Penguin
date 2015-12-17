<?php

class Room extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->data["is_friend"] = $this->data["is_friend"] == "True" ? true : false;
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
        $sql = "select room.id as room_id  room.name as room_name ,enter.isfriend,message.coment from  $this->table   inner  join  enter
            on   $this->table.id =enter.room_id  inner join message on  room.id =message.room_id
         order by message.timestamp ASC  limit =20
             where enter.user_id=:user_id  and message.timestamp in(select max(timesttamp) from message group by room_id ),";

        $stmt = $this->dbh->prepare($sql);
        $this->res["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $array = $this->res["data"];

        foreach ($array as $val => $array) {
            if (!$array['isfriend']) {
                $sql = "select user.name from enter  inner join user on user.id=enter.user_id where user_id!=:user_id  and room_id=" . $array['room_id'];
                $stmt = $this->dbh->prepare($sql);
                $this->res["db"] = $stmt->execute([
                    ':user_id' => $this->data["user_id"]

                ]);
                $array['room_name'] = $stm['user_name'];


            }

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

