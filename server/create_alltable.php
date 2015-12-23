<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
<?php
require_once('../.db/db.php');
try {
    //定数を文字列中で展開する関数
    $_ = function ($s) {
        return $s;
    };
    $pdo = new PDO("mysql:host={$_(DB_HOST)}; dbname={$_(DB_NAME)};charset=utf8", DB_USER, DB_PASS,
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"]);
} catch (PDOException $e) {
    echo "もう一度見直してくさい";
    die($e->getMessage());
}


echo "OK<br>";
$sql1 = "CREATE table user(
		id INT auto_increment,
		email char(255) unique,
		password char(255) unique not null,
		name char(255) not null,
		time timestamp,
		primary key(id)
	)";
$result = $pdo->query($sql1);
if ($result) {
    echo "でｋｋｋっきたーーーー！1" . "<br>";
} else {
    echo "失敗は成功のもと。元気にやり直そう!1" . mysql_error() . "\n";
}
$sql2 = "CREATE table room(
		id INT auto_increment,
		name char(255) not null,
		is_friend BOOLEAN not null,
        last_message_time datetime,
		primary key(id)

	)";
$result = $pdo->query($sql2);
if ($result) {
    echo "でｋｋｋっきたーーーー！2" . "<br>";
} else {
    echo "失敗は成功のもと。元気にやり直そう!2" . mysql_error() . "\n";
}
$sql3 = "CREATE table message(
		id INT auto_increment,
		content blob not null ,
		time datetime,
		room_id int,
		user_id int,
		read_count int default 0,
		primary key(id),
		foreign key(room_id)
		references room(id),
		foreign key(user_id)
		references user(id)
	)";
$result = $pdo->query($sql3);
if ($result) {
    echo "でｋｋｋっきたーーーー3！" . "<br>";
} else {
    echo "失敗は成功のもと。元気にやり直そう!3" . mysql_error() . "\n";
}

$sql4 = "CREATE table enter(
		id INT auto_increment,
		user_id int not null,
		room_id int not null,
		time  datetime,
		primary key(id),
		read_date  datetime,
		foreign key(user_id)
		references user(id),
		foreign key(room_id)
		references room(id),
		is_friend BOOLEAN not null
	)";
$result = $pdo->query($sql4);
if ($result) {
    echo "でｋｋｋっきたーーーー！4" . "<br>";
} else {
    echo "失敗は成功のもと。元気にやり直そう!4" . mysql_error() . "\n";
}

if ($_GET['seed']) {
    require_once('../api/model.php');

//    User
    $abc = [
        'a' => 'aの助',
        'b' => 'b吉',
        'c' => 'c太郎'
    ];
    foreach ($abc as $key => $val) {
        $user = [
            'email' => $key,
            'password' => $key,
            'name' => $val
        ];
        action('user', 'create', $user);
    }

//    room(friend)
    foreach ($abc as $key => $val) {
        if ($key != 'a') {
            $room = [
                'friend_id' => action('user', 'find', ["email" => $key])['data']['id']
            ];
            action('room', 'friend_create', $room);
        }
    }

    //room(group)
    $group = ['スキー', 'ABCテスト対策', '小和田セミナー生', '2017年理科大卒', 'R社インターン', '理科大小学校同窓会', 'RGP'];
    $id_list = [];
    foreach ($user as $key => $val) {
        array_push($id_list, action('user', 'find', ["email" => $key]));
    }
    foreach ($group as $val) {
        $room = [
            'friend_list' => $id_list,
            'name' => $val
        ];

        action('room', 'room_create', $room);
    }

    //message
    foreach (action('room', 'index', $room)['data'] as $val) {
        $data = [
            "room_id" => $val["room_id"],
            "content" => 'おはよー！'
        ];
        action('message', 'create', $data);
        $data['content'] = 'おつかれ';
        action('message', 'create', $data);
    };

}

function action($model, $action, $data)
{
    $_SESSION['user_id'] = 1;
    $model_name = $model;
    $action_name = $action;
    $_POST['data'] = json_encode($data);

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
    echo '<br>';
    return ($model->res);
}


?>
</body>
</html>