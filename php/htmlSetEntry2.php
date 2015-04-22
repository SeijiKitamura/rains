<?php
require_once("parts.function.php");
$mname="htmlSetEntry2.php";
$c="start:".$mname;wLog($c);

if(!preg_match("/^[0-9]+$/",$_GET["rank"])){
 $c="error:".$mname."ランク番号数字以外";wLog($c);
 echo $c;
 throw new exception($c);
}

if(!preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $c="error:".$mname." 物件番号数字以外";wLog($c);
 echo $c;
 throw new exception($c);
}

if(!preg_match("/^[0-9]+$/",$_GET["fld001"])){
 $c="error:".$mname." エントリー番号数字以外";wLog($c);
 echo $c;
 throw new exception($c);
}

viewSetEntry2($_GET);

$c="end:".$mname;wLog($c);

echo "success";

?>

