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
  $mname="viewShortData(view.function.php)";
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

  //ランキングリスト
  $db->dsetRank();


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

function viewNowRank($where=null){
 try{
  $mname="viewRank(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  $db->where =" to_date(startday,'YYYY/MM/DD')<='".date("Y-m-d")."' ";
  $db->where.=" and to_date(endday,'YYYY/MM/DD')>='".date("Y-m-d")."'";
  $db->where.=" and flg=1 ";
  if($where) $db->where.=" and ".$where;
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

function viewEntryList($fld000){
 try{
  $mname="viewEntryList(view.function.php)";
  $c="start ".$mname;wLog($c);
  if(!preg_match("/^[0-9]+$/",$fld000)){
   throw new exception("物件番号入力エラー(".$fld000.")");
  }
  $db=new DSET();
  $db->where="t.fld000='".$fld000."'";
  $c="end ".$mname;wLog($c);
  return $db->dsetEntry();
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
  $db->where="t.rank=".$rank;
  $db->dsetEntry();
  $db->dsetRainsFld();
  $db->dsetGetImgList();
  $db->dsetImgPathWithEncode();
  return $db->r["data"];
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewSetEntry($data){
 try{
  $mname="viewSetEntry(view.function.php)";
  $c="start ".$mname;wLog($c);
  //ここをfld000とrankにする
  if($data["id"]){
   $ary=array( "col"=>$data,
              "from"=>TABLE_PREFIX.ENTRY,
              "where"=>"id=".$data["id"]
             );
  }
  else{
   $ary=array( "col"=>$data,
              "from"=>TABLE_PREFIX.ENTRY,
              "where"=>"fld000='".$data["fld000"]."' and rank=".$data["rank"]
             );
  }
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

function viewBcomment($fld000){
 try{
  $mname="viewBcomment(view.function.php)";
  $c="start ".$mname;wLog($c);
  if(!preg_match("/^[0-9]+$/",$fld000)){
   throw new exception("物件番号入力エラー(".$fld000.")");
  }
  $db=new DSET();
  $db->where="fld000='".$fld000."'";
  $c="end ".$mname;wLog($c);
  return $db->dsetBcomment();
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewSetBcomment($data){
 try{
  $mname="viewSetBcomment(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array( "col" =>$data,
             "from" =>TABLE_PREFIX.BCOMMENT,
             "where"=>"fld000='".$data["fld000"]."'" 
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetUpdate();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

function viewDelBcomment($data){
 try{
  $mname="viewDelBcomment(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array("from"=>TABLE_PREFIX.BCOMMENT,
             "where"=>"fld000='".$data["fld000"]."'"
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetDelete();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

//Rainsデータを以下の条件、並び順で抽出する
//whiteList,登録日降順
function viewNewRains($where=null){
 try{
  $mname="viewNewRains(view.function.php)";
  $c="start ".$mname;wLog($c);
  $order="t.fld011 desc";
  $w="t1.fld000 is null ";
  if($where) $where=$w." and ".$where;
  else $where=$w;

  $c="end ".$mname;wLog($c);
  return viewRainsData($where,$order);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }
}

//新着物件とランキングデータを配列で返す
function viewNewAndRank(){
 try{
  $mname="viewNewAndRank(view.function.php)";
  $c="start ".$mname;wLog($c);

  $new=viewNewRains();
  foreach($new["data"] as $key=>$val){
   if($key>RANKLIMIT) break;
   $data["new"][]=$val;
  }

  $rank=viewNowRank();
  foreach($rank as $key=>$val){
   if($key>RANKLIMIT) break;
   $entry=array();
   $entry=viewEntry($val["rank"]);
   $data["rank".$val["rank"]]=$entry;
  }
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);echo $c;
 }

}
?>
