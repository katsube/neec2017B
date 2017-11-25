<?php
/**
 * ガチャ CLI
 *
 *  使い方
 *    $ php gacha.php
 *    $ php gacha.php [1..10]
 *
 * @author     M.Katsube <katsubemakito@gmail.com>
 * @copyright  Copyright ©2016 M.Katsube All Rights Reserved.
 * @lisence    MIT license
 */

 //------------------------------------
//  Gachaクラス読み込み
//------------------------------------
require('Gacha.class.php');

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

    printf("%d回目 %s %s %s%s", $i+1, $char['rarity'], $char['name'], $char['id'], PHP_EOL);      //PHP_EOL=改行(\n)
}

//------------------------------------
// ログを記録
//------------------------------------
$gacha->addLog();
$gacha->clearHistory();

//------------------------------------
// 終了
//------------------------------------
exit(0);


/**
 * コマンドラインからの引数を取得する
 *
 * @return integer | false
 * @access public
 */
function getArgv(){
	global $argc, $argv;

    // 引数が未指定の場合は 1
    if( $argc === 1){           //$argc === count($argv)
        return(1);
    }
    // 引数が 1〜10の整数なら そのまま利用
    else if( $argc === 2 && 1 <= (int)$argv[1] && (int)$argv[1] <= 10 ){
        return($argv[1]);
    }
    // それ以外の値が入っている場合は false を返却
    else{
        return(false);
    }
}
