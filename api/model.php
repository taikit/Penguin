<?php

require_once('../.db/db.php');

$path = __DIR__ . '/model';

$models = scandir($path);
array_shift($models);
array_shift($models);

foreach ($models as $model) {
    require_once('model/' . $model);
}

class Model
{
    public $data;
    public $table;
    public $res;
    public $dbh;

    function __construct()
    {
        //テーブル名
        $this->table = mb_strtolower(get_class($this));

        //dataの取得
        $this->data = $_POST;
        if (!empty($_SESSION['user_id'])) {
            $this->data['user_id'] = $_SESSION['user_id'];
            $this->res['user_id'] = $_SESSION['user_id'];
        }

        //PDO接続
        $this->dbh = $GLOBALS['dbh'];
    }

//    public function find()
//    {
//        $sql = "SELECT * FROM $this->model";
//        $res = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//        echo json_encode($res);
//    }
//
//    public function create()
//    {
//        $keys = implode(",", array_keys($this->data));
//        $values = implode(",", array_values($this->data));
//        $sql = "INSERT INTO $this->model($keys) VALUES ($values)";
//        echo $sql;
//    }
}