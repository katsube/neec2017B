<?php
//-------------------------------------------------
// DB接続準備
//-------------------------------------------------
$dsn  = 'mysql:dbname=noveldb;host=127.0.0.1';   //接続先
$user = 'root';         //MySQLのユーザーID
$pw   = 'H@chiouji1';   //MySQLのパスワード

//-------------------------------------------------
// ユーザー名処理
//-------------------------------------------------
// 「ニューゲーム」
if( array_key_exists('playername', $_GET) ){
	$sql = 'update save set playername=:name';

	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	$sth->bindValue(':name', $_GET['playername'], PDO::PARAM_STR);
	$sth->execute();

	$playername = $_GET['playername'];
}
// 「ロード」
else{
	$sql = 'select playername from save';

	$dbh = new PDO($dsn, $user, $pw);   //接続
	$sth = $dbh->prepare($sql);         //SQL準備
	$sth->execute();
	$buff = $sth->fetch(PDO::FETCH_ASSOC);

	$playername = $buff['playername'];
}

//-------------------------------------------------
// シナリオ準備
//-------------------------------------------------
// $scenario

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
			
			background-image: url(image/earth.jpg);
			background-size: 800px 600px;
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
			height: 600px;
		}
	</style>
</head>
<body>

	<div id="novelwindow">
		<img id="char1" src="image/f127.png">
		<div id="message">
			あいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえお 
		</div>
	</div>

	<script>
		var payername = "<?= $playername ?>";
	
		//シナリオ定義
		var scenario = [
			  ["TXT",  "我輩は猫である"]
			, ["TXT",  "名前は##NAME##だ。"]
			, ["CHAR", "image/f363.png"]
		];

		var msg   = document.querySelector("#message");
		var char1 = document.querySelector("#char1");
		var i     = 0;
		msg.addEventListener("click", function(){
			var command = scenario[i][0];
			var value   = scenario[i][1];
			
			switch(command){
				case "TXT":
					value = value.replace(
								  /##NAME##/g
								, "<span style='color:red'>"+payername+"</span>"
							);
				
					msg.innerHTML = value;
					break;
				case "CHAR":
					char1.setAttribute("src", value);
					break;
			}
		
			i++;
		});
	</script>
</body>
</html>
