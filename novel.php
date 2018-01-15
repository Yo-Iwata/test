<?php
//-------------------------------------------------
//準備
//-------------------------------------------------
$dsn  = 'mysql:dbname=noveldb;host=127.0.0.1';   //接続先
$user = 'root';         //MySQLのユーザーID
$pw   = 'H@chiouji1';   //MySQLのパスワード

if (array_key_exists('playername', $_GET)) {
	$sql = 'UPDATE user set name=:name';
	
	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	//プレースホルダに値を入れる
	$sth->bindValue(':name', $_GET['playername'], PDO::PARAM_STR);
	$sth->execute();                    //実行
	
	$playername = $_GET['playername'];
	
	// セーブデータの初期化
	$sql = 'UPDATE save SET scenarioid = 0, bg = "img1.jpg"';

	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	$sth->execute();                    //実行	
} else {
	$sql = 'SELECT name FROM user';
	
	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	$sth->execute();                    //実行
	
	//ここで1レコード取得
    $buff = $sth->fetch(PDO::FETCH_ASSOC);
    $playername = $buff['name'];
}

//-------------------------------------------------
// セーブデータの取得
//-------------------------------------------------
// 実行したいSQL
$sql = 'SELECT * FROM save';

$dbh = new PDO($dsn, $user, $pw);   //接続
$sth = $dbh->prepare($sql);         //SQL準備
$sth->execute();                    //実行	

//ここで1レコード取得
$buff = $sth->fetch(PDO::FETCH_ASSOC);
$scenarioid = $buff['scenarioid'];
$bg = $buff['bg'];



//-------------------------------------------------
// シナリオ準備
//-------------------------------------------------
// 実行したいSQL
$sql = 'SELECT * FROM scenario';

$dbh = new PDO($dsn, $user, $pw);   //接続
$sth = $dbh->prepare($sql);         //SQL準備
$sth->execute();                    //実行	

$scenario = '';
while( ($buff = $sth->fetch(PDO::FETCH_ASSOC)) !== false ){
   	$scenario .= "\t['" . $buff['cmd'] . "', '" . $buff['value'] . "'],\n";
};
$scenario = preg_replace("/,\n$/", "\n", $scenario); // 最後のカンマを削除

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Novel</title>
	<style>
		#novelwindow{
			border: 1px solid gray;
			width: 800px;
			height: 600px;
		}
		#message{
			position: absolute;
			top: 350px;
			left: 75px;
			
			border: 1px solid blue;
			width: 650px;
			height: 200px;
			
			font-size: 22pt;
			padding: 5px;
			
			background-color: rgba(255,255,255,0.7);
		}
		
		#char1{
			width: 800px;
			height: 600px;
		}
		
		#save {
			position: absolute;
			top: 325px;
			left: 675px;
		}
	</style>
</head>
<body>
	<audio src="audio/novel_bgm.mp3" autoplay loop></audio>

	<div id="novelwindow">
		<img id="char1" src="image/img1.jpg">
		<div id="message">
			クリックして始める
		</div>
	</div>
	
	<form action="save.php" method="GET">
		<input type="hidden" name="savedata">
		<input type="hidden" name="img">
		<button id="save">セーブ</button>
	</form>

	<script>
		var playername = "<?= $playername ?>"	
		var bg = "<?= $bg ?>"
		
		//シナリオ定義
		var scenario = [
			['TXT', 'むかしむかしあるところに、'],
			['TXT', 'おじいさんとおばあさんが住んでいました。'],
			['TXT', 'おじいさんは山へ芝刈に、'],
			['TXT', 'おばあさんは川へ洗濯に行きました。'],
			['TXT', 'おばあさんが川で洗濯をしていると、'],
			['TXT', '川上から大きな桃がどんぶらこ、どんぶらこと流れてきました。'],
			['CHAR', 'img2.jpg'],
			['TXT', 'おばあさんはその桃を家に持って帰って割ってみました。'],
			['TXT', 'すると中から、元気な男の子が生まれてきました。'],
			['TXT', 'おじいさんとおばあさんはいいました。'],
			['TXT', '「この子の名前は##NAME##にしよう」'],
			['TXT', '二人は##NAME##を大切に育てました。'],
			['CHAR', 'img3.jpg'],
			['TXT', '##NAME##はみるみる大きく、強くなりました。'],
			['TXT', 'ある日、おじいさんとおばあさんにいいました。'],
			['TXT', '「おじいさん、おばあさん、僕はこれから鬼退治にいってくるよ」'],
			['TXT', 'おじいさんとおばあさんは、きび団子をつくって'],
			['TXT', '##NAME##にもたせてやりました。'],
			['CHAR', 'img4.jpg'],
			['TXT', '##NAME##が、鬼の住む鬼ヶ島へ向かって歩いていると、'],
			['TXT', '一匹の犬がやってきました。'],
			['TXT', '「##NAME##さん、##NAME##さん、おこしにつけた'],
			['TXT', '黍団子、ひとつ私にくださいな」'],
			['TXT', '##NAME##は答えました。'],
			['TXT', '「これから、鬼の征伐に付いてくるならあげましょう。」'],
			['CHAR', 'img5.jpg'],
			['TXT', 'こうして犬を家来にした##NAME##が、'],
			['TXT', 'しばらく行くと、こんどは雉子に出逢いました。'],
			['TXT', '「##NAME##さん、##NAME##さん、おこしにつけた'],
			['TXT', '黍団子、ひとつ私にくださいな」'],
			['TXT', '##NAME##は答えました。'],
			['TXT', '「これから、鬼の征伐に付いてくるならあげましょう。」'],
			['CHAR', 'img6.jpg'],
			['TXT', 'また、しばらく行くと、'],
			['TXT', '今度は、猿が出てきました。'],
			['TXT', '「##NAME##さん、##NAME##さん、おこしにつけた'],
			['TXT', '黍団子、ひとつ私にくださいな」'],
			['TXT', '##NAME##は答えました。'],
			['TXT', '「これから、鬼の征伐に付いてくるならあげましょう。」'],
			['CHAR', 'img7.jpg'],
			['TXT', 'こうして、犬と雉子と猿を家来にした##NAME##は、'],
			['TXT', '鬼ヶ島へ渡って行きました。'],
			['CHAR', 'img8.jpg'],
			['TXT', '##NAME##たちが鬼ヶ島へ着くと、赤鬼、青鬼が'],
			['TXT', '「なんだ、コイツらは。生意気な。やっつけろ」'],
			['TXT', 'と、かかってきました。'],
			['CHAR', 'img9.jpg'],
			['TXT', '雉子は鬼の頭を突っ突き、'],
			['TXT', '猿は鬼の顔を引っ掛き、'],
			['TXT', '犬は足に噛み付き、##NAME##は刀を振るって、'],
			['TXT', '鬼たちをやっつけました。'],
			['CHAR', 'img10.jpg'],
			['TXT', '「ごめんなさい、ごめんなさい。もう悪いことはしません。'],
			['TXT', 'どうか、許してください」'],
			['TXT', '鬼たちは、##NAME##に降参し、'],
			['TXT', 'たくさんの宝物を差し出しました。'],
			['CHAR', 'img11.jpg'],
			['TXT', 'こうして##NAME##は、たくさんの宝物をもって'],
			['TXT', 'おじいさんとおばあさんの待つ家に帰り、'],
			['TXT', 'みんなで幸せに暮らしました。'],
			['END', '']
		];
		
		var msg   = document.querySelector("#message");
		var char1 = document.querySelector("#char1");
		char1.setAttribute("src", "image/"+bg);
		document.querySelector("[name='img']").value = bg;
		
		var i     = "<?= $scenarioid ?>";
		msg.addEventListener("click", function(){
			var command = scenario[i][0];
			var value   = scenario[i][1];
			
			switch(command){
				case "TXT":
					value = value.replace(/##NAME##/g, 
										"<span style='color:red'>"+playername+"</span>");
					
					msg.innerHTML = value;
					break;
				case "CHAR":
					char1.setAttribute("src", "image/"+value);
					document.querySelector("[name='img']").value = value;
					break;
				case "END":
					window.location.href = 'ending.php';
					break;
			}
		
			i++;
		});
		
		var save = document.querySelector("#save");
		save.addEventListener("click", function() {
			document.querySelector("[name='savedata']").value = i - 1;
		});
	</script>
</body>
</html>
