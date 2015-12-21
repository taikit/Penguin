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
		time timestamp,
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
		time timestamp,
		room_id int,
		user_id int,
		read_count int,
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
		time timestamp,
		primary key(id),
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


?>
</body>
</html>