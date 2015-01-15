<?php
require_once("parts.function.php");

$mname="htmlDelEntry.php";
$c="start:".$mname;wLog($c);

if(!preg_match("/^[0-9]+$/",$_GET["id"])){
 $c="error:".$mname."エントリー番号数字以外";wLog($c);
 throw new exception($c);
}

viewDelEntry($_GET);
?>
