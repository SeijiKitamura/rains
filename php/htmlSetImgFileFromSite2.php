<?php
require_once("parts.function.php");

if(! preg_match("/^http/",$_GET["imgurl"])){
 $c="error:".$mname."URLを確認してください(".$_GET["url"].")";wLog($c);
 return false;
}

if(! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $c="error:".$mname."URLを確認してください(".$_GET["fld000"].")";wLog($c);
 return false;
}

$url=partsImgPathFromSite($_GET["imgurl"]);
print_r($url);

if(is_array($url) && isset($url) && count($url)){
 //画像ダウンロード
 foreach($url as $key=>$val){
  partsSetImgFromSite($val["src"],$_GET["fld000"]);
 }
 //画像DB登録
 viewSetImage($_GET["fld000"]);
}
?>
