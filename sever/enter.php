<?php
require_once "../sever/mysql_account.php";
	try{
		$pdo=new PDO("mysql:host=". $ms_host . "; dbname=" . $ms_name,
		$ms_user, $ms_pass,
		array(
				PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'")
			);
	}catch(PDOException $e){
		echo "ごめんwできてないから(爆)";
		die($e->getMessage());
	}



	echo "OK<br>";
	$sql="CREATE table enter(
		id INT auto_increment,
		user_id int,
		room_id int,
		time timestamp,
		primary key(id),
		foreign key(user_id)
		references user(id),
		foreign key(room_id)
		references room(id)
	)";
	$result=$pdo->query($sql);
	if($result){
	echo "でｋｋｋっきたーーーー！";
	}else{
	echo "失敗は成功のもと。元気にやり直そう!"  . mysql_error() . "\n";
	}


?>
