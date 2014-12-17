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

if($_GET["fld025"]){
 $where.=" and t.fld025='".$_GET["fld025"]."'";
}

if($_GET["fld026"]){
 $where.=" and t.fld026='".$_GET["fld026"]."'";
}


if($_GET["fld179"]){
 $where.=" and t.fld179='".$_GET["fld179"]."'";
}

if($_GET["fld180"]){
 $where.=" and t.fld180='".$_GET["fld180"]."'";
}

if(! $_GET["black"]){
 $where.=" and t1.fld000 is null ";
}
else{
 $where.=" and t1.fld000 is not null ";
}
//データ取得
$data=viewRainsData($where);

//間取りはDBの値を変更しているため配列から抽出
if($_GET["madori"] && $_GET["madori"]!=="なし"){
 $ary=array();
 foreach($data["data"] as $key=>$val){
  if($val["fld180"].$val["fld179"]==$_GET["madori"]){
   $ary[]=$val;
  }
 }
 unset($data["data"]);
 $data["data"]=$ary;
}

partsStationCount($data["station"]);
?>
