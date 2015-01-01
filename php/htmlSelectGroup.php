<?php
require_once("parts.function.php");
$mname="htmlSelectGroup.php";
$c="start:".$mname;wLog($c);

$match=preg_split("/_/",$_GET["group"]);

if($match[0] &&! preg_match("/^[0-9]{2}$/",$match[0])){
 $c="error:".$mname."グループ1が数字以外";wLog($c);
 throw new exception($c);
}

if($match[1] &&! preg_match("/^[0-9]{2}$/",$match[1])){
 $c="error:".$mname."グループ2が数字以外";wLog($c);
 throw new exception($c);
}

$data=viewShortData();

if(!$match[0] && ! $match[1]){
 $fldcount=$data["fldcount"];
 partsSelectBox($fldcount,"fld001",$match[0]);
}
elseif(!$match[1]){
 foreach($data["fldcount"] as $key=>$val){
  $m=preg_split("/_/",$key);
  if($m[0]==$match[0]){
   $fldcount=$data["fldcount"][$key];
  }
 }
 partsSelectBox($fldcount,"fld002",$match[1]);
}
else{
 foreach($data["fldcount"] as $key=>$val){
  $m=preg_split("/_/",$key);
  if($m[0]==$match[0]){
   foreach($data["fldcount"][$key] as $key1=>$val1){
    $m=preg_split("/_/",$key1);
    if($m[0]==$match[1]){
     $fldcount=$data["fldcount"][$key][$key1];
    }
   }
  }
 }
 partsSelectBox($fldcount,"fld003");
}
?>
