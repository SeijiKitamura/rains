<?php
require_once("import.function.php");
require_once("parts.function.php");

//CSVを配列へ変換しDBへ登録
$data=impCsv2DB($_FILES,FLD);
?>

