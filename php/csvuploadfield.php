<?php
require_once("import.function.php");
require_once("export.function.php");
require_once("parts.function.php");

//既存データバックアップ
exportCSVAll();

//関連データ削除
$db=new DB();
$db->from="hp_rainsfld";
$db->where="id>0";
$db->delete();

//CSVを配列へ変換しDBへ登録
$data=impCsv2DB($_FILES,FLD);
?>

