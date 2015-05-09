<?php
require_once("parts.function.php");

//抽出条件をセット
if($_GET["fld001"]){
 $where="t.fld001='".$_GET["fld001"]."'";
}
if($_GET["fld002"]){
 $where.=" and t.fld002='".$_GET["fld002"]."'";
}
if($_GET["fld003"]){
 $where.=" and t.fld003='".$_GET["fld003"]."'";
}
if($_GET["fld179"]){
 $where.=" and t.fld179='".$_GET["fld179"]."'";
}
if($_GET["fld180"]){
 $where.=" and t.fld180='".$_GET["fld180"]."'";
}

$where.=" and t1.fld000 is null";
//データ取得
$data=viewRainsData($where);
if(isset($data) && is_array($data) && count($data)){
 partsEstateList($data["data"]);
}
?>
