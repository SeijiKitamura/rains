<?php
require_once("parts.function.php");
$mname="htmlSetRank.php";
$c="start:".$mname;wLog($c);

if(!preg_match("/^[0-9]+$/",$_GET["rank"])){
 $c="error:".$mname." ランク数字以外";wLog($c);
 return false;
}

viewDelRank($_GET);

$c="end:".$mname;wLog($c);
?>
