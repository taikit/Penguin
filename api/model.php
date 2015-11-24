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
    public $model;
    public $pdo;
    public $data;
    public $table;

    function __construct()
    {
        //モデルの決定
        $this->model = get_class($this);

        //dataの取得
        $this->data = json_decode($_POST['data'], true);

        //定数を文字列中で展開する関数
        $_ = function ($s) {
            return $s;
        };

        //PDO接続
        try {
            $this->dbh = new PDO("mysql:host={$_(DB_HOST)}; dbname={$_(DB_NAME)};charset=utf8", DB_USER, DB_PASS,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"]);
        } catch (PDOException $e) {
            $res = [
                'status' => 'error',
                'content' => $e->getMessage()
            ];
            exit(json_encode($res));
        }
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