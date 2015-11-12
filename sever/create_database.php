<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
<?php
	$link=mysql_connect('localhost','root','root');
	if(!$link){
	die('でっきませーんwww'.mysql_error());
	}
	$sql="CREATE database penguin character set utf8";
	if(mysql_query($sql,$link)){
		echo "データベース作成に成功しました。";
	}else{
		echo 'データベース?ちょっと何をおっしゃっているのわかりません'  . mysql_error() . "\n";
		} 
?>
</body>
</html>