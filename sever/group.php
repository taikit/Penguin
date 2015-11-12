<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
<?php
require_once "../sever/mysql_account.php";
	try{
		$pdo=new PDO("mysql:host=". $ms_host . "; dbname=" . $ms_name,
		$ms_user, $ms_pass,
		array(
				PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'")
			);
	}catch(PDOException $e){
		echo "もう一度見直してくさい";
		die($e->getMessage());
	}



	echo "OK<br>";
	$sql="CREATE table group_penguin(
		id INT,
		name char(80) not null,
		time timestamp,
		primary key(id)
	)";
	$result=$pdo->query($sql);
	if($result){
	echo "でｋｋｋっきたーーーー！";
	}else{
	echo "失敗は成功のもと。元気にやり直そう!"  . mysql_error() . "\n";
	}


?>
</body>
</html>