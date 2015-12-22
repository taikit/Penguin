<?php
//2週間
session_start([
    'cookie_lifetime' => 1209600,
]);


require_once('model.php');

$model_name = $_GET['model'];
$action_name = $_GET['action'];

header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');

//モデル、アクションの実行
if (!empty($model_name) && !empty($action_name)) {
    //定数を文字列中で展開する関数
    $_ = function ($s) {
        return $s;
    };
    //PDO接続
    try {
        $GLOBALS['dbh'] = new PDO("mysql:host={$_(DB_HOST)}; dbname={$_(DB_NAME)};charset=utf8", DB_USER, DB_PASS,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"]);
    } catch (PDOException $e) {
        $res = [
            'status' => false,
            'content' => $e->getMessage()
        ];
        exit(json_encode($res));
    }
    $model = new $model_name();
    call_user_func([$model, $action_name]);
    if (!empty($model->stmt)) {
        $model->res["db_error_info"] = $model->stmt->errorInfo();
    }
    $model->res['session'] = $_SESSION;
    echo json_encode($model->res);
}