<?php
require_once("parts.function.php");
$mname="htmlSetImgFileFormSite.php";

if(! preg_match("/^http/",$_GET["imgurl"])){
 $c="error:".$mname."URLを確認してください(".$_GET["url"].")";wLog($c);
 return false;
}

if(! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $c="error:".$mname."URLを確認してください(".$_GET["fld000"].")";wLog($c);
 return false;
}

partsSetImgFromSite($_GET["imgurl"],$_GET["fld000"]);
viewSetImage($_GET["fld000"]);
?>
