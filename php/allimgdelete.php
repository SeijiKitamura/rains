<?php
require_once("view.class.php");
try{
 //エラー処理があいまいなのであとで見直す
 
 //引数チェック
 if(! preg_match("/^[0-9]+$/",$_GET["bnumber"])){
  throw new exception("物件番号が正しくありません。(".$_GET["bnumber"].")");
 }

 if(isset($_GET["imgid"]) && ! preg_match("/^[0-9]+$/",$_GET["imgid"])){
  throw new exception("画像番号が正しくありません。(".$_GET["imgid"].")");
 }

 $bnumber=$_GET["bnumber"];
 $imgid=$_GET["imgid"];
 
 //DBデータ削除
 $db=new RAINS();
 $db->delImgList($bnumber,$imgid);
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
