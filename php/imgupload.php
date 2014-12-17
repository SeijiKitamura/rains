<?php
require_once("parts.function.php");

try{
 
 //アップロードチェック
 foreach($_FILES["allupimg"]["error"] as $key=>$val){
  if($val){
   throw new exception("ファイルアップロードに失敗しました。(".$val.")");
  }
 }
 
 //物件番号数字チェック
 $bnumber=$_POST["bnumber"];
 if(!preg_match("/^[0-9]+$/",$bnumber)){
  throw new exception ("物件番号が数字以外です。(".$bnumber.")");
 }
 
 //物件番号DB存在チェック
 $db=new RAINS();
 $db->where="fld000='".$bnumber."'";
 if(! $db->getRains()){
  throw new exception ("物件番号が未登録です。(".$bnumber.")");
 }

 //画像ディレクトリセット
 $imgdir=realpath("../").IMG."/".$bnumber;
 
 //ディレクトリ存在チェック
 if(!file_exists($imgdir)){
  if(! mkdir($imgdir)){
   throw new exception("フォルダ作成に失敗しました。(".$bnumber.")");

  }
 }

 $moto=$_FILES["allupimg"]["tmp_name"];
 
 //ファイル拡張子チェック
 if(!exif_imagetype($moto)){
  throw new exception("画像ファイルではありません");
 }

 $filename=mb_convert_encoding($_FILES["allupimg"]["name"],"UTF-8","auto");
 $filename=$imgdir."/".$filename;
// echo $moto." ".$filename;
 if(! move_uploaded_file($moto,$filename)){
  throw new exception("ファイルコピーに失敗しました。");
 }
 echo "success";
}
catch(Exception $e){
 echo "err:".$e->getMessage();
 throw $e;
}
?>
