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
$sql="drop database penguin ";
if(mysql_query($sql,$link)){
    echo "データベース削除に成功しました。";
}else{
    echo 'データベース?ちょっと何をおっしゃっているのわかりません'  . mysql_error() . "\n";
}
?>
</body>
</html>