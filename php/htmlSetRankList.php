<?php
require_once("parts.function.php");
$mname="htmlSetRankList.php";
$c="start".$mname;wLog($c);

if(!preg_match("/^[0-9]+$/",$_GET["rank"])){
 $c="error:".$mname."ランク数字以外".$_GET["rank"];wLog($c);
 echo $c;
 return false;
}

if(!preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $c="error:".$mname."物件番号数字以外".$_GET["rank"];wLog($c);
 echo $c;
 return false;
}

$data=array("rank"=>$_GET["rank"],"fld000"=>$_GET["fld000"],"fld001"=>0);
viewSetEntry($data);

$elist=viewEntryList($_GET["fld000"]);
partsEntryList($elist);
?>
