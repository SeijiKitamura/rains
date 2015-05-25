<?php
require_once("parts.function.php");

echo $_GET["imgurl"];
if(! preg_match("/^http/",$_GET["imgurl"])){
 $c="error:".$mname."URLを確認してください(".$_GET["imgurl"].")";wLog($c);
 return false;
}

if(! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $c="error:".$mname."物件番号を確認してください(".$_GET["fld000"].")";wLog($c);
 return false;
}

$url=partsImgPathFromSite($_GET["imgurl"]);
print_r($url);

if(! is_array($url) && ! isset($url) && ! count($url)){
 $c="error:".$mname."URL配列がありません";wLog($c);
 return false;
}
 
//画像DB登録
viewSetImage2($_GET["fld000"],$url);

echo "end";
?>
