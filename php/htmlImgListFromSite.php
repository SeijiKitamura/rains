<?php
require_once("parts.function.php");
$mname="htmlImgListFormSite.php";

if(! preg_match("/^http/",$_GET["url"])){
 $c="error:".$mname."URLを確認してください(".$_GET["url"].")";wLog($c);
 return false;
}

if(! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $c="error:".$mname."物件番号を確認してください(".$_GET["fld000"].")";wLog($c);
 return false;
}

$data=partsImgPathFromSite($_GET["url"]);
partsImgListFromSite($data);
?>

