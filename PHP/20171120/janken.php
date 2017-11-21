<?php
/**
 * じゃんけんゲーム
 *
 * Usage: $ php janken.php [p|g|c]
 *    p = パー
 *    g = グー
 *    c = チョキ
 * Author: M.Katsube
 */

//------------------------------------
// 変数の準備
//------------------------------------
// ラベル
$label = [
	  "g" => "グー"
	, "p" => "パー"
	, "c" => "チョキ"
];

// 勝敗のマトリックス
$janken = [
	  "g" => [
	  	    "g" => "Draw"
	  	  , "p" => "You Win"
	  	  , "c" => "You Loose"
	  ]
	, "p" => [
		    "g" => "You Loose"
		  , "p" => "Draw"
		  , "c" => "You Win"
	]
	, "c" => [
		    "g" => "You Win"
		  , "p" => "You Loose"
		  , "c" => "Draw"
	]
];

//------------------------------------
// プレイヤーの入力を得る
//------------------------------------
if( count($argv) === 2 ){
	$player = $argv[1];		// "g" or "p" or "c"
}
else{
	$player = null;
}

switch( $player  ){
	case "g":
	case "p":
	case "c":
		echo "YOU: " . $label[$player];
		echo "\n";
		break;	

	//エラー終了
	default:
		echo "Usage:  php janken.php [p|g|c]\n";
		echo "   g=グー, p=パー, c=チョキ\n";
		echo "\n";
		exit(1);
}

//------------------------------------
// CPUの手を決定する
//------------------------------------
$cpu = rand(1, 3);		// 1〜3の整数がランダムに返ってくる
if( $cpu === 1 ){
	$cpu = "g";
}
else if( $cpu === 2 ){
	$cpu = "p";
}
else{
	$cpu = "c";
}
// CPUの手を表示
echo "CPU: " . $label[$cpu];
echo "\n";

//------------------------------------
// 勝負する
//------------------------------------
echo $janken[$cpu][$player];
echo "\n";
