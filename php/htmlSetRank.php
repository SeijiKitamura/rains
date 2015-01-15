<?php
require_once("parts.function.php");
$mname="htmlSetRank.php";
$c="start:".$mname;wLog($c);

if(!preg_match("/^[0-9]+$/",$_GET["rank"])){
 $c="error:".$mname." ランク数字以外";wLog($c);
 echo $c;
 throw new exception($c);
}

preg_match("/^(20[0-9]{2})\/([0-1]?[0-9]{1})\/([0-3]?[0-9]{1})$/",$_GET["startday"],$match);
if(!$match){
 $c="error:".$mname." 開始日パターンエラー";wLog($c);
 echo $c;
 throw new exception($c);
}
if(!checkdate($match[2],$match[3],$match[1])){
 $c="error:".$mname." 開始日エラー";wLog($c);
 echo $c;
 throw new exception($c);
}

preg_match("/^(20[0-9]{2})\/([0-1]?[0-9]{1})\/([0-3]?[0-9]{1})$/",$_GET["endday"],$match);
if(!$match){
 $c="error:".$mname." 終了日パターンエラー";wLog($c);
 echo $c;
 throw new exception($c);
}

if(!checkdate($match[2],$match[3],$match[1])){
 $c="error:".$mname." 終了日エラー";wLog($c);
 echo $c;
 throw new exception($c);
}

if(strtotime($_GET["startday"])>strtotime($_GET["endday"])){
 $c="error:".$mname." 期間エラー";wLog($c);
 echo $c;
 throw new exception($c);
}

if(!preg_match("/^[0-9]+$/",$_GET["flg"])){
 $c="error:".$mname." 表示フラグ数字以外";wLog($c);
 echo $c;
 throw new exception($c);
}

viewSetRank($_GET);

$c="end:".$mname;wLog($c);

echo "success";
?>
