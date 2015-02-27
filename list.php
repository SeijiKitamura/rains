<?php
require_once("php/html.function.php");

//フラグセット
$flg=1;

//引数分解
if(! $_GET) $fld=0;

$fld=preg_split("/\|/",$_GET["keyval"]);
$r=array();
foreach($fld as $key=>$val){
 $sp=preg_split("/-/",$val);
 $r[$sp[0]]=$sp[1];
}

//where句をセット
$where="";
foreach($r as $key=>$val){
 if($where && $key && $val){
  $where.=" and ";
 }
 if($key && $val){
  $where.="t.".$key."='".$val."' ";
 }
}

//fld001が指定されていなければエラー
if(! $r["fld001"]) $flg=0;

$fld001="t.fld001='".$r["fld001"]."'";

//物件種別データ
$w=$fld001;
//if($r["fld002"]) $w.=" and t.fld002='".$r["fld002"]."'"; 
$kinds=viewGroupFld($w);

if($r["fld003"]){
 
//駅名データ(fld001,fld002,fld003)
 $w=$fld001;
 if($r["fld002"]) $w.=" and t.fld002='".$r["fld002"]."'"; 
 if($r["fld003"]) $w.=" and t.fld003='".$r["fld003"]."'"; 
 $station=viewStationList($w);

//徒歩(fld001,fld002,fld003,fld026)
 if($r["fld026"]){
  $w=$fld001;
  if($r["fld002"]) $w.=" and t.fld002='".$r["fld002"]."'"; 
  if($r["fld003"]) $w.=" and t.fld003='".$r["fld003"]."'"; 
  if($r["fld026"]) $w.=" and t.fld026='".$r["fld026"]."'"; 
  $walk=viewWalkGroup($w);
 }
 
 //間取り
 $w=$fld001;
 if($r["fld002"]) $w.=" and t.fld002='".$r["fld002"]."'"; 
 if($r["fld003"]) $w.=" and t.fld003='".$r["fld003"]."'"; 
 $madori=viewMadoriList($w);
 
 //賃料
 
 //礼金
 
 //敷金
 
 //登録年月日
 
 //所在階
 
 //築年月
 
 //バルコニー
 
 //面積
}


htmlHeader($title);
?>
  <div id="main">
<?php
//物件種別表示
htmlKindsListStation($kinds,$station);

//間取り一覧
if($madori){
 htmlMadoriList($madori,$link);
}
echo "<pre>";
echo $where;
print_r($kinds);
print_r($madori);
print_r($station);
echo "</pre>";
?>
  </div><!--div id="main"-->
