<?php
require_once("view.class.php");
$db=new RAINS();

try{
 //bnumber,imgid,ipthyouji,imgpathのエラーチェック
 if(! preg_match("/^[0-9]+$/",$_GET["imgid"])){
  echo "err:不正な値です。(画像番号 数字以外)";
  return false;
 }
 
 if(! preg_match("/^[0-9]+$/",$_GET["hyouji"])){
  echo "err:不正な値です。(表示順 数字以外)";
  return false;
 }
 
 
 if(! preg_match("/^[0-9]+$/",$_GET["bnumber"])){
  echo "err:不正な値です。(物件番号 数字以外)";
  return false;
 }
 
 //if(! file_exists(IMG."/".$_GET["imgpath"])){
 // echo "err:不正な値です。(画像が存在しません。)";
 // return false;
 //}
 
 $ary=array( "fld000"=>$_GET["bnumber"]
            ,"fld001"=>intval($_GET["hyouji"])
            ,"fld003"=>$_GET["imgcomment"]
           );
 print_r($ary);
 //DB更新
 $db->setImgNum($_GET["imgid"],$ary);
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
