<?php
/*-----------------------------------------------------
 ファイル名:view.function.php
 接頭語    :view
 主な動作  :DBのwhere句をセットしてデータを抽出する
 返り値    :セットした結果を返す(return $dbdata)
 エラー    :エラーメッセージを表示
----------------------------------------------------- */
require_once("dset.class.php");

function viewShortData($where=null,$order=null){
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
  
  //物件種別カウント
  $db->dsetFldCount();
  $c="end ".$mname;wLog($c);
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
 }
}

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
  $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
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
  $c="error:".$mname.$e->getMessage();wLog($c); echo $c;
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
  $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
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
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
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
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
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
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
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
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
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
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewSetBlackList($fld000){
 try{
  $mname="viewSetBlackList(view.function.php)";
  $c="start ".$mname;wLog($c);
  //$data=viewDetail($fld000);
  if($fld000) $where="t.fld000='".$fld000."'";
  $data=viewRainsData($where);
  $db=new DSET();
  $db->r=$data;
  $db->dsetUpBlackList();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewDelBlackList($fld000=null){
 try{
  $mname="viewDelBlackList(view.function.php)";
  $c="start ".$mname;wLog($c);
  if($fld000) $where="t.fld000='".$fld000."'";
  $data=viewBlackList($where);
  $db=new DSET();
  $db->r=$data;
  $db->dsetDelBlackList();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewRank($where=null){
 try{
  $mname="viewRank(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  if($where) $db->where=$where;
  $c="end ".$mname;wLog($c);
  return $db->dsetRank();
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewSetRank($data){
 try{
  $mname="viewSetRank(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array( "col"=>$data,
             "from"=>TABLE_PREFIX.RANK,
             "where"=>"rank=".$data["rank"]
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetUpRank();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewDelRank($data){
 try{
  $mname="viewDelRank(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array("from"=>TABLE_PREFIX.RANK,
             "where"=>"rank=".$data["rank"]
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetDelRank();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewEntry($rank){
 try{
  $mname="viewEntry(view.function.php)";
  $c="start ".$mname;wLog($c);
  if(!preg_match("/^[0-9]+$/",$rank)){
   throw new exception("ランク番号入力エラー(".$rank.")");
  }
  $db=new DSET();
  $db->where="rank=".$rank;
  $c="end ".$mname;wLog($c);
  return $db->dsetEntry();
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewSetEntry($data){
 try{
  $mname="viewSetEntry(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array( "col"=>$data,
             "from"=>TABLE_PREFIX.ENTRY,
             "where"=>"id=".$data["id"]
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetUpEntry();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewDelEntry($data){
 try{
  $mname="viewDelEntry(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array("from"=>TABLE_PREFIX.ENTRY,
             "where"=>"id=".$data["id"]
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetDelEntry();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

?>
