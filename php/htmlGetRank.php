<?php
require_once("parts.function.php");

$mname="htmlGetRank.php";
$c="start ".$mname;wLog($c);
if(!preg_match("/^[0-9]+$/",$_GET["rank"])){
 $c="error:".$mname." ランクが数字以外です(".$_GET["rank"].")";wLog($c);
 return false;
}

$data=viewRank("rank=".$_GET["rank"]);
echo json_encode($data[0]);
?>
