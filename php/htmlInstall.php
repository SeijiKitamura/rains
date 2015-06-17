<?php
require_once("html.function.php");
require_once("import.function.php");
require_once("export.function.php");
session_start();
if(! isset($_SESSION["USERID"]) || $_SESSION["USERID"]==null || $_SESSION["USERID"]!==md5(USERID)){
 echo "ログインしてください";
 return false;
}

try{
 //server.conf.php存在チェック
 if(! file_exists("server.conf.php")){
  throw new exception("設定ファイルがありません");
 }
 
 //関連データファイル存在チェック
 $filename=realpath("../").DATA."/".FLD.".csv";
 echo $filename;

 //既存データバックアップ
 exportCSVAll();
 
 //DBテーブル作成
 $db=new DB();
 $db->CreateTable();

 //関連データインポート
 impCsv2DBUTF(FLD,$filename);
 echo "初期化しました";
}
catch(Exception $e){
 $e="error:".$e->getMessage();wLog($e);
 echo $e;
}
?>
