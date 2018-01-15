<?php
if (array_key_exists('playername', $_GET)) {
	$playername = $_GET['playername'];
} else {
	$playername = 'ももたろう';
}
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
			
			background-image: url(image/title.png);
			background-size: 800px 600px;
		}
	</style>
</head>
<body>

	<audio src="audio/title_bgm.mp3" autoplay loop></audio>

	<section id="novelwindow">
	<h1 id="name"></h1>
	<form action="setup.html" method="GET">
		<button>ニューゲーム</button>
	</form>
	<form action="novel.php" method="GET">
		<button>ロード</button>
	</form>
	</section>
	
	<script>
		var title = document.querySelector("#name");
		title.innerHTML = "<?= $playername ?>"+'伝説';		
	</script>
</body>
</html>
