<?php
//-------------------------------------------------
//準備
//-------------------------------------------------
$dsn  = 'mysql:dbname=noveldb;host=127.0.0.1';   //接続先
$user = 'root';         //MySQLのユーザーID
$pw   = 'H@chiouji1';   //MySQLのパスワード

if (array_key_exists('savedata', $_GET)) {
	// セーブデータの更新
	$sql = 'UPDATE save SET scenarioid = :id';

	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	//プレースホルダに値を入れる
	$sth->bindValue(':id', $_GET['savedata'], PDO::PARAM_INT);
	$sth->execute();                    //実行	
} else {
	// セーブデータの初期化
	$sql = 'UPDATE save SET scenarioid = 0';

	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	$sth->execute();                    //実行	
}
if (array_key_exists('img', $_GET)) {
	// セーブデータの更新
	$sql = 'UPDATE save SET bg = :bg';

	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	//プレースホルダに値を入れる
	$sth->bindValue(':bg', $_GET['img'], PDO::PARAM_STR);
	$sth->execute();                    //実行	
} else {
	// セーブデータの初期化
	$sql = 'UPDATE save SET bg = "img1.jpg"';

	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	$sth->execute();                    //実行	
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>ノベルゲーム</title>
</head>
<body>
	<script>
		window.addEventListener("load", function(event) {
      		// 読み込み完了時の処理
      		window.location.href = 'novel.php';
    	});
	</script>
</body>
</html>
