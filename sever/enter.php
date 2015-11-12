<?php
require_once "../connect/mysql_account.php";
	try{
		$pdo=new PDO("mysql:host=". $ms_host . "; dbname=" . $ms_name,
		$ms_user, $ms_pass,
		array(
				PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf-8'")
			);
	}catch(PDOException $e){
		echo "ごめんwできてないから(爆)"
		die($e->getMessage());
	}



	echo "OK<br>";
	$sql="CREATE table enter(
		id INT,
		use_id int,
		group_id int,
		time timestamp,
		primary key(id)
		foreign key(user_id)
		references user(id)
		foreign key(group_id)
		references group(id)
	)";
	$result=$pdo->query($sql);
	


?>
