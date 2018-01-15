<?php
//-------------------------------------------------
//準備
//-------------------------------------------------
$dsn  = 'mysql:dbname=noveldb;host=127.0.0.1';   //接続先
$user = 'root';         //MySQLのユーザーID
$pw   = 'H@chiouji1';   //MySQLのパスワード

// 名前の取得
$sql = 'SELECT * FROM user';

$dbh = new PDO($dsn, $user, $pw);   //接続
$sth = $dbh->prepare($sql);         //SQL準備
$sth->execute();                    //実行	
	
//ここで1レコード取得
$buff = $sth->fetch(PDO::FETCH_ASSOC);
$playername = $buff['name'];

// セーブデータの初期化
$sql = 'UPDATE save SET scenarioid = 0, bg = "earth.png"';

$dbh = new PDO($dsn, $user, $pw);   //接続
$sth = $dbh->prepare($sql);         //SQL準備
$sth->execute();                    //実行	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>ノベルゲーム</title>
	<link rel="stylesheet" href="style.css">
	<style>
		#novelwindow{
			border: 1px solid gray;
			width: 800px;
			height: 600px;
			
			background-image: url(image/ending.png);
			background-size: 800px 600px;
		}
	</style>
</head>
<body>
	<audio src="audio/ending_bgm.mp3" autoplay loop></audio>

	<section id="novelwindow">
	<h1>めでたし、めでたし</h1>
	<form action="title.php" method="GET">
		<input type="hidden" name="playername">
		<button id="title">タイトルに戻る</button>
	</form>
	</section>
	
	<script>
		var save = document.querySelector("#title");
		save.addEventListener("click", function() {
			document.querySelector("[name='playername']").value = "<?= $playername ?>";
		});
	</script>
</body>
</html>
