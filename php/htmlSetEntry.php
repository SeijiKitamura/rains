<?php
require_once("parts.function.php");
$mname="htmlSetEntry.php";
$c="start:".$mname;wLog($c);

if(!preg_match("/^[0-9]+$/",$_GET["id"])){
 $c="error:".$mname." ID数字以外";wLog($c);
 echo $c;
 throw new exception($c);
}

if(!preg_match("/^[0-9]+$/",$_GET["fld001"])){
 $c="error:".$mname." エントリー番号数字以外";wLog($c);
 echo $c;
 throw new exception($c);
}

viewSetEntry($_GET);

$c="end:".$mname;wLog($c);

echo "success";

?>
