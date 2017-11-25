<?php
/**
 * Gachaクラス
 *
 * @author     M.Katsube <katsubemakito@gmail.com>
 * @copyright  Copyright ©2016 M.Katsube All Rights Reserved.
 * @license    MIT license
 */
class Gacha{
    private $datafile = 'data.csv';
    private $logfile  = 'discharge.log';
    private $chara    = [];
    private $history  = [];

    /**
     * コンストラクタ
     *
     * @return void
     * @access public
     */
    public function __construct(){
        //キャラクターデータを読み込む
        try{
            $this->_loadCharactor($this->datafile);
        }
        catch( Exception $e ){
            print 'Error:' . $e->getMessage() . "¥n";
            exit(1);
        }
    }

    /**
     * ガチャを引く
     *
     * @return  array  キャラデータ
     * @access  public
     */
    public function draw(){
        // 取り出すキャラを決定
        $len = count($this->chara);     //キャラクター数をカウント
        $i   = mt_rand(0, $len-1);      //0〜$len-1の中からランダムに1つだけ数値を作成

        //IDを履歴に入れる
        $this->history[] = $this->chara[$i]['id'];

        return( $this->chara[$i] );
    }

    /**
     * ログを記録する
     *
     * @param   $filepath  string  ログファイルのパス
     * @return  void
     * @access  public
     */
    public function addLog($filepath=null){
        // ログファイル未指定の場合は、デフォルトのファイルに記録
        if( $filepath === null){
            $filepath = $this->logfile;
        }

        // ファイルを開く
        $fp = fopen($filepath, 'a');
        if( $fp === false )
            throw new Exception('ファイルを開くことができません');

        // ファイルに書き込めるかチェック
        if( ! is_writable($filepath) ){
            throw new Exception('ファイルが存在しないか書き込むことができません');
        }

        // ロックする
        flock($fp, LOCK_EX);

        // 書き込む
        ini_set('date.timezone', 'Asia/Tokyo');
        $str = implode("\t", [date('Y-m-d H:i:s'), implode(',', $this->history)]);
        fwrite($fp, $str);
        fwrite($fp, PHP_EOL);          //PHP_EOL=改行(¥n)

        //ロックを解除
        flock($fp, LOCK_UN);

        // ファイルを閉じる
        fclose($fp);
    }

    /**
     * クラス内に保持しているガチャ履歴を削除する
     *
     * @return  void
     * @access  public
     */
    function clearHistory(){
        $this->history = [];
    }



    /**
     * キャラクターデータの読み込み
     *
     * 指定されたファイル(CSV)からキャラクターデータを読み込み、
     * プロパティ chara にセットする。
     * データファイルは以下の順番で並んでいること。
     *   ID,キャラ名称,レアリティ
     *
     * データファイルが存在しない、開けない場合は例外を発生させる。
     *
     * @param  $filepath  string  読み込むファイルのパス
     * @return void
     * @access private
     */
    private function _loadCharactor($filepath){
        // ファイルが存在するか、読み込むことができるかチェック
        if( ! (is_file($filepath) && is_readable($filepath)) ){
            throw new Exception('ファイルが存在しないか読み込めません');
        }

        // ファイルを開く
        $fp = fopen($filepath, 'r');
        if( $fp === false )
            throw new Exception('ファイルを開くことができません');

        // ファイルからデータ取得
        $chara = [];
        while( ($data = fgets($fp)) !== false ){
	        $data    = rtrim($data);            // 改行を削除
	        $buff    = explode(',', $data);     // カンマで分割する
	        $chara[] = [
                              'id'     => $buff[0]
                            , 'name'   => $buff[1]
                            , 'rarity' => $buff[2]
                        ];
        }
        fclose($fp);

        //プロパティに反映
        $this->chara = $chara;
    }
}