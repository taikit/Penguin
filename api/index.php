<?php

require_once('model.php');


$model_name = $_GET['model'];
$action_name = $_GET['action'];

header( "Content-Type: application/json; charset=utf-8" ) ;

//モデル、アクションの実行
if (!empty($model_name) && !empty($action_name)) {
    $model = new $model_name();
    call_user_func([$model, $action_name]);
}
