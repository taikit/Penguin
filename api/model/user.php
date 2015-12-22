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
        //data={
        //  "name":名前,
        //  "email":メールアドレス,
        //   "password ":pass
        //}


        $sql = "INSERT INTO $this->table (name, email, password) VALUES (:name, :email, :pass)";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res["db"] = $this->stmt->execute([
            ':name' => $this->data["name"],
            ':email' => $this->data["email"],
            ':pass' => password_hash($this->data["password"], PASSWORD_DEFAULT)
        ]);
        $this->res["data"] = $this->res['db'];
        if ($this->res['data']) {
            $_SESSION['user_id'] = $this->dbh->lastInsertId('id');
        }
    }

    public function login()
    {
        //data={
        //   "email":
        //  "password": }
        $sql = "SELECT id, password FROM $this->table WHERE email=:email";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':email' => $this->data["email"]
        ]);
        $db_res = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->res['data'] = password_verify($this->data['password'], $db_res[0]['password']);
        if ($this->res['data']) {
            $_SESSION['user_id'] = $db_res[0]['id'];
        }
    }

    public function logout()
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
            session_destroy();
        }
        $this->res['data'] = true;
    }

    public function find()
    {
        //data={
        // "email": }

        $sql = "SELECT id, name FROM $this->table WHERE email=:email";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':email' => $this->data["email"],
        ]);
        $this->res['data'] = $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $this->res["data"]["is_friend"] = false;
        $this->data["friend_id"] = $this->res["data"]['id'];

        $this->is_friend();

    }

    public function is_friend()
    {
        $sql = "select B.user_id as friend_id from enter as A inner join enter as B on A.room_id=B.room_id
      where A.user_id=:user_id  and
     A.user_id <>B.user_id  and A.is_friend=1";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([':user_id' => $this->data["user_id"]]);
        $array = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($array as $val) {
            if ($val['friend_id'] == $this->data["friend_id"]) {
                $this->res["data"]["is_friend"] = true;
                exit;
            }
        }
    }

    public function status()
    {
        $this->res['data'] = true;
    }
}