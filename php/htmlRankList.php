<?php
require_once("parts.function.php");
$mname="htmlRankList.php";
$c="start:".$mname;wLog($c);

$data=viewRank();
partsRankList($data);
$c="end:".$mname;wLog($c);
?>
