<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>ガチャ</title>
	<style>
		.img-char{
			width: 200px;
		}
		.txt-name{
			font-weight: bold;
		}

		footer{
			text-align: center;
		}
	</style>
</head>
<body>

<h1>ガチャ</h1>
<?php
/**
 * ガチャ on the Web
 *
 * @author     M.Katsube <katsubemakito@gmail.com>
 * @copyright  Copyright ©2016 M.Katsube All Rights Reserved.
 * @lisence    MIT license
 */

require_once('gacha.class.php');

//------------------------------------
// 引数取得
//------------------------------------
$loop = getArgv();
if($loop === false){
    print 'Error: オプションには1〜10の整数を指定してください';
    print PHP_EOL;  //PHP_EOL=改行(\n)
    exit(1);
}

//------------------------------------
// ガチャを引く
//------------------------------------
$gacha = new Gacha();
for($i=0; $i<$loop; $i++){
    $char = $gacha->draw();

	print_char($char);
}

//------------------------------------
// ログを記録
//------------------------------------
$gacha->addLog();
$gacha->clearHistory();


/**
 * ガチャから出たキャラを表示
 *
 * @param  array          $char    $char = [id=>'1001', name='バハムート', rarity='SR']
 * @return integer|false
 * @access public
 */
function print_char($char){
	printf('<p><img src="image/%s.png" class="img-char"></p>', $char['id']);
	printf('<span class="txt-name">[%s]%s</span>', $char['rarity'], $char['name']);
	printf('<hr>');
}

/**
 * クエリーから引数を取得する
 *
 * @return integer | false
 * @access public
 */
function getArgv(){
	$loop = isset($_REQUEST['loop'])?   (int)$_REQUEST['loop']:null;

    // 引数が未指定の場合は 1
    if( $loop === false ){
        return(1);
    }
    // 引数が 1〜10の整数なら そのまま利用
    else if( 1 <= $loop && $loop <= 10 ){
        return($loop);
    }
    // それ以外の値が入っている場合は false を返却
    else{
        return(false);
    }
}
?>
	<footer>
		&copy;2014 CloverLab.,Inc.
	</footer>
</body>
</html>