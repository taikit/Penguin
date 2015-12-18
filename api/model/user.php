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
        $sql = "SELECT id, name FROM $this->table WHERE email=:email";
        $this->stmt = $this->dbh->prepare($sql);
        $this->res['db'] = $this->stmt->execute([
            ':email' => $this->data["email"],
        ]);
        $this->res["data"] = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }


  //  public function change_pass(){
    //    if($this->data["email"])


   // }



    //Model
    public function validation()
    {

    }
}


