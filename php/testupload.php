<?php
require_once("import.function.php");
require_once("parts.function.php");
 
//CSVを配列へ変換
$data=impCsv2Ary($_FILES);
$data=impCsv2SQL(RAINS,$data);

//値をHTML形式で表示
partsRainsTest($data);
?>
