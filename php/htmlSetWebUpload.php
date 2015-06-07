<?php
require_once("parts.function.php");

//LOCALMODE判定
if(! LOCALMODE){
 echo "err:ローカルードが有効ではありません";
 return false;
}

chdir("../data");

$db=new DB();

//Rainsテーブル出力
$cname="rains.csv";
$tname=RAINS;

foreach($TABLES[$tname] as $key=>$val){
 if($db->select) $db->select.=",";
 $db->select.=$key;
}
$db->from=TABLE_PREFIX.$tname;
$db->order="fld000";
$db->getArray();

$handle=fopen($cname,"w");
foreach($db->ary as $key=>$val){
 $csvrow="";
 foreach($val as $key1=>$val1){
  if($csvrow) $csvrow.=",";
  $csvrow.=$val1;
 }
 fwrite($handle,$csvrow."\n");
}
fclose($handle);

//Rainsfldテーブル出力
$cname="rainsfld.csv";
$tname=FLD;

foreach($TABLES[$tname] as $key=>$val){
 if($db->select) $db->select.=",";
 $db->select.=$key;
}
$db->from=TABLE_PREFIX.$tname;
$db->order="fldname,fld001,fld002";
$db->getArray();

$handle=fopen($cname,"w");
foreach($db->ary as $key=>$val){
 $csvrow="";
 foreach($val as $key1=>$val1){
  if($csvrow) $csvrow.=",";
  $csvrow.=$val1;
 }
 fwrite($handle,$csvrow."\n");
}
fclose($handle);

//Imglistテーブル出力
$cname="imglist.csv";
$tname=IMGLIST;

foreach($TABLES[$tname] as $key=>$val){
 if($db->select) $db->select.=",";
 $db->select.=$key;
}
$db->from=TABLE_PREFIX.$tname;
$db->order="fld000,fld001,fld002";
$db->getArray();

$handle=fopen($cname,"w");
foreach($db->ary as $key=>$val){
 $csvrow="";
 foreach($val as $key1=>$val1){
  if($csvrow) $csvrow.=",";
  $csvrow.=$val1;
 }
 fwrite($handle,$csvrow."\n");
}
fclose($handle);

//Rankテーブル出力
$cname="rank.csv";
$tname=RANK;

foreach($TABLES[$tname] as $key=>$val){
 if($db->select) $db->select.=",";
 $db->select.=$key;
}
$db->from=TABLE_PREFIX.$tname;
$db->order="rank";
$db->getArray();

$handle=fopen($cname,"w");
foreach($db->ary as $key=>$val){
 $csvrow="";
 foreach($val as $key1=>$val1){
  if($csvrow) $csvrow.=",";
  $csvrow.=$val1;
 }
 fwrite($handle,$csvrow."\n");
}
fclose($handle);

//Entryテーブル出力
$cname="entry.csv";
$tname=ENTRY;

foreach($TABLES[$tname] as $key=>$val){
 if($db->select) $db->select.=",";
 $db->select.=$key;
}
$db->from=TABLE_PREFIX.$tname;
$db->order="rank,fld001,fld000";
$db->getArray();

$handle=fopen($cname,"w");
foreach($db->ary as $key=>$val){
 $csvrow="";
 foreach($val as $key1=>$val1){
  if($csvrow) $csvrow.=",";
  $csvrow.=$val1;
 }
 fwrite($handle,$csvrow."\n");
}
fclose($handle);

//Bcommentテーブル出力
$cname="bcomment.csv";
$tname=BCOMMENT;

foreach($TABLES[$tname] as $key=>$val){
 if($db->select) $db->select.=",";
 $db->select.=$key;
}
$db->from=TABLE_PREFIX.$tname;
$db->order="fld000";
$db->getArray();

$handle=fopen($cname,"w");
foreach($db->ary as $key=>$val){
 $csvrow="";
 foreach($val as $key1=>$val1){
  if($csvrow) $csvrow.=",";
  $csvrow.=$val1;
 }
 fwrite($handle,$csvrow."\n");
}
fclose($handle);

chdir("../local");
$a=`/bin/sh export.sh`;
echo "アップロードしました";
?>
