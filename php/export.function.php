<?php
require_once("db.class.php");

function exportCSV($tablename){
 $mname="exportCSV(export.function.php)";
try{
  $c="start:".$mname;wLog($c);

  //データディレクトリゲット
  $cname=dirname(__FILE__)."/..".DATA."/";
  
  //CSVファイル名を絶対参照でセット
  $cname=realpath($cname)."/".$tablename.".csv";

  //データゲット
  $db=new DB();
  $ary=$db->export($tablename);
  
  //ファイルオープン
  if(! $handle=fopen($cname,"w")){
   throw new exception("ファイルオープンに失敗しました".$cname);
  }

  //データ出力
  foreach($ary as $key=>$val){
   $csvrow="";
   foreach($val as $key1=>$val1){
    if($csvrow) $csvrow.=",";
    
    //改行コードを置換
    $v=str_replace(array("\r\n","\n","\r"),"__BR__",$val1);

    //'は取り除く
    $v=str_replace("'","",$v);

    $csvrow.=$v;
   }
   fwrite($handle,$csvrow."\n");
  }

  //ファイルクローズ
  fclose($handle);

  $c="end:".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
 }
}

function exportCSVAll(){
 global $TABLES;
 $mname="exportCSV(export.function.php)";

 try{
  $c="start:".$mname;wLog($c);
  foreach($TABLES as $key=>$val){
   exportCSV($key);
  }
  $localpath=dirname(__FILE__)."/../local";
  $localpath=realpath($localpath);
  echo $localpath;
  chdir($localpath);
  echo getcwd();
  $a=`/bin/sh ./backup.sh`;
  echo $a;
  $c="end:".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
 }
}
?>
