<?php
require_once("import.function.php");
require_once("parts.function.php");

//CSVを配列へ変換しDBへ登録
$data=impCsv2DB($_FILES,RAINS);

//サイトマップ作成
$db=new DSET();
$db->dsetSiteMap();

//値をHTML形式で表示
//partsRainsTest($data);
?>
