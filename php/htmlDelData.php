<?php
require_once("view.function.php");
//GET引数チェック
if(! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $c="error:htmlDelData.php 物件番号は数字で指定してください";wLog($c);
 echo $c;
 return false;
}

if(! preg_match("/^[0-9]+$/",$_GET["imgid"])){
 $c="error:htmlDelData.php 写真番号は数字で指定してください";wLog($c);
 echo $c;
 return false;
}
$fld000=$_GET["fld000"];
$imgid=$_GET["imgid"];
echo $fld000.$imgid;
viewDelImgNum($fld000,$imgid);
?>
