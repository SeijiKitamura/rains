<?php
/*-----------------------------------------------------
 ファイル名:view.function.php
 接頭語    :view
 主な動作  :DBのwhere句をセットしてデータを抽出する
 返り値    :セットした結果を返す(return $dbdata)
 エラー    :エラーメッセージを表示
----------------------------------------------------- */
require_once("dset.class.php");

function viewRainsData($where=null,$order=null){
 try{
  $mname="viewRainsData(view.function.php)";
  $c="start ".$mname;wLog($c);

  $db=new DSET();

  if($where) $db->where=$where;
  if($order) $db->order=$order;
  else{
   $db->order="t.fld001,t.fld002,t.fld003,t.fld017,t.fld018,t.fld019,t.fld025,t.fld026,t.fld027,t.fld068,t.fld088,t.fld054";
  }
  
  //Rainsテーブルからデータ抽出
  $db->dsetRains();
  
  //Rainsサブデータを反映
  $db->dsetRainsFld();
  
  //位置データをセット(物件データが複数の場合、最初の1件目だけ）
  $db->dsetGetLatLng();
  
  //画像リストをセット
  $db->dsetGetImgList();
  
  //画像パスをセット
  $db->dsetImgPathWithEncode();

  //ブラックリスト判定
//  $db->dsetBlackList();

  //データカウント
  $db->dsetDataCount();
  
  //物件種別カウント
  $db->dsetFldCount();

  //間取りカウント
  $db->dsetMadoriCount();

  //最寄駅カウント
  $db->dsetStationCount();

  $c="end ".$mname;wLog($c);
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
  throw $c;
 }
}

function viewDeleteRains($where=null,$order=null){
 try{
  $mname="viewDeleteRains(view.function.php)";
  $c="start ".$mname;wLog($c);

  $db=new DSET();

  if($where) $db->where=$where;
  if($order) $db->order=$order;
  
  //Rainsテーブルからデータ抽出
  $db->dsetRains();
  
  //物件データ削除
  $db->dsetDelAll();

  $c="end ".$mname;wLog($c);
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
  throw $c;
 }
}

//"$which="whitelist"で表示リスト
//"$where="blacklist"で非表示リスト
function viewArea($which=null,$where=null,$order=null){
 try{
  $mname="viewArea(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();

  if($which=="whitelist" || !$which){
   $c=$mname." 表示リスト選択 ";wLog($c);
   $db->where="t1.fld000 is null";
  }
  elseif($which=="blacklist"){
   $c=$mname." 非表示リスト選択 ";wLog($c);
   $db->where="t1.fld000 is not null";
  }
  if($where) $db->where.=" and ".$where;
  if($order) $db->order=$order;
  //Rainsテーブルからデータ抽出
  $db->dsetAreaCount();

  $c="end ".$mname;wLog($c);
  return $db->r;

 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
  throw $c;
 }
}

function viewDetail($fld000){
 try{
  $mname="htmlGetgDetail.php";
  $c="start ".$mname;wLog($c);
 
  //引数チェック
  if(! preg_match("/^[0-9]+$/",$fld000)){
   throw new exception("物件番号を確認してください".$fld000);
  }
  $where="t.fld000='".$fld000."'";
  return viewRainsData($where);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
  echo $c;
  throw $c;
 }
} 

function viewSetImage($fld000){
 try{
  $mname="viewSetImage(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  
  //引数チェック
  if(! preg_match("/^[0-9]+$/",$fld000)){
   throw new exception("物件番号を確認してください".$fld000);
  }
  $db->where="t.fld000='".$fld000."'";
  $db->dsetRains();
  $db->dsetUpImgList();
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
  echo $c;
  throw $c;
 }
}

function viewSetImageNum($imgid,$imgnum){
 try{
  $mname="viewSetImageNum(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  $db->dsetImgNum($imgid,$imgnum);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
  echo $c;
  throw $c;
 }
}

function viewDelImgNum($fld000,$imgid=null){
 try{
  $mname="viewDelImgNum(view.function.php)";
  $c="start ".$mname;wLog($c);
  $data=viewDetail($fld000);
  $db=new DSET();
  $db->r=$data;
  $db->dsetDelImg($imgid);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
  echo $c;
  throw $c;
 }
}

function viewBlackList($where=null){
 try{
  $mname="viewBlackList(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  if($where) $db->where=$where;

  $db->dsetBlackList();
  
  //Rainsサブデータを反映
  $db->dsetRainsFld();
  
  //位置データをセット(物件データが複数の場合、最初の1件目だけ）
  $db->dsetGetLatLng();
  
  //画像リストをセット
  $db->dsetGetImgList();
  
  //画像パスをセット
  $db->dsetImgPathWithEncode();

  //ブラックリスト判定
//  $db->dsetBlackList();

  //データカウント
  $db->dsetDataCount();
  
  //物件種別カウント
  $db->dsetFldCount();

  //間取りカウント
  $db->dsetMadoriCount();

  //最寄駅カウント
  $db->dsetStationCount();

  $c="end ".$mname;wLog($c);
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
  echo $c;
  throw $c;
 }
}

function viewSetBlackList($fld000){
 try{
  $mname="viewSetBlackList(view.function.php)";
  $c="start ".$mname;wLog($c);
  $data=viewDetail($fld000);
  $db=new DSET();
  $db->r=$data;
  $db->dsetUpBlackList();
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
  echo $c;
  throw $c;
 }
}

function viewDelBlackList($fld000=null){
 try{
  $mname="viewDelBlackList(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t1.fld000 is not null";
  if($fld000) $where.=" and  t.fld000='".$fld000."'";
  $data=viewRainsData($where);
  $db=new DSET();
  $db->r=$data;
  $db->dsetDelBlackList();
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
  echo $c;
  throw $c;
 }
}
?>
