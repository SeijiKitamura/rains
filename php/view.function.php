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
  
  //画像リストをセット
  $db->dsetGetImgList();
  
  //画像パスをセット
  $db->dsetImgPathWithEncode();
  
  //物件種別カウント
  $db->dsetFldCount();
  $c="end ".$mname;wLog($c);
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
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
  $c="error:".$mname.$e->getMessage();wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
              //"where"=>"fld000='".$data["fld000"]."' and rank=".$data["rank"]
              "where"=>"fld000='".$data["fld000"]."'"
             );
  }
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetUpEntry();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

function viewDelEntry($data){
 try{
  $mname="viewDelEntry(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array("from"=>TABLE_PREFIX.ENTRY,
             //"where"=>"id=".$data["id"]
             "where"=>"fld000='".$data["fld000"]."'"
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetDelEntry();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

function viewSetEntry2($data){
 try{
  $mname="viewSetEntry2(view.function.php)";
  $c="start ".$mname;wLog($c);
  $ary=array( "col"=>$data,
             "from"=>TABLE_PREFIX.ENTRY,
             "where"=>"fld000='".$data["fld000"]."'"
            );
  $db=new DSET();
  $db->r["data"][]=$ary;
  $db->dsetUpEntry();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//Rainsデータを以下の条件、並び順で抽出する
//whiteList,登録日降順
function viewNewRains($where=null){
 try{
  $mname="viewNewRains(view.function.php)";
  $c="start ".$mname;wLog($c);
  $order="t.fld011 desc offset 0 limit ".RANKLIMIT;
  $w="t1.fld000 is null ";
  if($where) $where=$w." and ".$where;
  else $where=$w;

  $c="end ".$mname;wLog($c);
  //return viewRainsData($where,$order);
  return viewShortData($where,$order);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
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
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

function viewTopData(){
 try{
  $mname="viewTopData(view.function.php)";
  $c="start ".$mname;wLog($c);
  
  //新着データ
  $new=viewNewRains();
  foreach($new["data"] as $key=>$val){
   if($key>RANKLIMIT) break;
   $data["new"][]=$val;
  }

  //ランキングデータ
  $rank=viewNowRank();
  foreach($rank as $key=>$val){
   $entry=array();
   $entry=viewEntry($val["rank"]);
   $data["rank".$val["rank"]]=$entry;
  }

  //売買物件
//  $where="t.fld001='01' and t1.fld000 is null";
//  $order="t.fld001,t.fld002,t.fld003,t.fld017,t.fld018,t.fld019,t.fld020,t.fld054";
//  $d=viewRainsData($where,$order);
//  $d=viewShortData($where,$order);
//  $data["baibai"]=$d["data"];

  //賃貸物件
//  $where="t.fld001='03' and t1.fld000 is null";
//  $order="t.fld001,t.fld002,t.fld003,t.fld017,t.fld018,t.fld019,t.fld020,t.fld054";
//  $d=viewRainsData($where,$order);
//  $d=viewShortData($where,$order);
//  $data["tintai"]=$d["data"];
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅カウントを返す
function viewStationList($where=null){
 try{
  $mname="viewStationList(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  $db->where=" t1.fld000 is null";
  if($where) $db->where.=" and ".$where;
  $db->dsetStationCount2();
  $c="end ".$mname;wLog($c);
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅カウントを返す("賃貸")
function viewRentStation(){
 try{
  $mname="viewRentStation(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03'";
  $data=viewStationList($where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅カウントを返す("売買")
function viewSaleStation(){
 try{
  $mname="viewSaleStation(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='01'";
  $data=viewStationList($where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//住所一覧を返す
function viewAddressList($where=null){
 try{
  $mname="viewAddressList(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  $db->where=" t1.fld000 is null";
  if($where) $db->where.=" and ".$where;
  $db->dsetAreaCount2();
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//住所一覧を返す(賃貸)
function viewRentAddress(){
 try{
  $mname="viewRentAddress(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03'";
  $data=viewAddressList($where);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//住所一覧を返す(売買)
function viewSaleAddress(){
 try{
  $mname="viewSaleAddress(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='01'";
  $data=viewAddressList($where);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取り一覧
function viewMadoriList($where=null){
 try{
  $mname="viewMadoriList(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  if($where) $db->where=$where;
  $db->dsetMadoriCount2();
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取り一覧(賃貸マンション)
function viewRentMadoriM(){
 try{
  $mname="viewRentMadoriM(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='01'";
  $data=viewMadoriList($where);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取り一覧(賃貸アパート)
function viewRentMadoriA(){
 try{
  $mname="viewRentMadoriA(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='02'";
  $data=viewMadoriList($where);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取り一覧(売買)
function viewSaleMadori(){
 try{
  $mname="viewSaleMadori(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='01'";
  $data=viewMadoriList($where);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//似た物件を表示(引数で指定した物件と同じ分類、間取りで検索して価格順に表示)
function viewBrother($fld000){
 try{
  $mname="viewBrother(view.function.php)";
  $c="start ".$mname;wLog($c);
  //引数チェック
  if(!preg_match("/^[0-9]+$/",$fld000)){
   throw new exception("物件番号を確認してください");
  }

  $db=new DSET();
  $db->where="t.fld000='".$fld000."' and t1.fld000 is null";
  $moto=$db->dsetRains();
  if(! count($moto)){
   $c="notice:".$mname." 該当データなし。物件番号(".$fld000.")";wLog($c);
   return false;
  }

  $where="";
  foreach($moto["data"] as $key=>$val){
   $where.="     t.fld001='".$val["fld001"]."'";
   $where.=" and t.fld002='".$val["fld002"]."'";
   $where.=" and t.fld003='".$val["fld003"]."'";
   $where.=" and t.fld179='".$val["fld179"]."'";
   $where.=" and t.fld180='".$val["fld180"]."'";
   break;
  }
  $where.=" and t1.fld000 is null";
  $where.=" and t.fld000<>'".$fld000."'";
  $order =" cast(t.fld054 as integer)";
  $data=viewRainsData($where,$order);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//住所から物件一覧を返す
function viewSearchAddress($address,$where=null){
 try{
  $mname="viewSearchAddress(view.function.php)";
  $c="start ".$mname;wLog($c);
  $w ="t.fld019 like '".$address."%' and t1.fld000 is null";
  if($where) $w.=" and ".$where;
  $order="t.fld019,t.fld020,t.fld021,t.fld022,t.fld054";
  $data=viewRainsData($w,$order);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//住所から物件一覧を返す(賃貸マンション)
function viewSearchAddressM($address){
 try{
  $mname="viewSearchAddressM(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='01'";
  $data=viewSearchAddress($address,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//住所から物件一覧を返す(賃貸アパート)
function viewSearchAddressA($address){
 try{
  $mname="viewSearchAddressA(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='02'";
  $data=viewSearchAddress($address,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//住所から物件一覧を返す(売買)
function viewSearchAddressS($address){
 try{
  $mname="viewSearchAddressA(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='01'";
  $data=viewSearchAddress($address,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅名から物件一覧を返す
function viewSearchStation($station,$where=null){
 try{
  $mname="viewSearchStation(view.function.php)";
  $c="start ".$mname;wLog($c);
  $w ="t.fld026='".$station."' and t1.fld000 is null";
  if($where) $w.=" and ".$where;
  $order="cast(t.fld027 as integer),t.fld019,t.fld020,t.fld021,t.fld022,t.fld054";
  echo $w;
  $data=viewRainsData($w,$order);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅名から物件一覧を返す(賃貸)
function viewSearchStationR($station){
 try{
  $mname="viewSearchStationR(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03'";
  $data=viewSearchStation($station,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅名から物件一覧を返す(賃貸マンション)
function viewSearchStationM($station){
 try{
  $mname="viewSearchStationM(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='01'";
  $data=viewSearchStation($station,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅名から物件一覧を返す(賃貸アパート)
function viewSearchStationA($station){
 try{
  $mname="viewSearchStationA(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='02'";
  $data=viewSearchStation($station,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//駅名から物件一覧を返す(売買)
function viewSearchStationS($station){
 try{
  $mname="viewSearchStationS(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='01'";
  $data=viewSearchStation($station,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取りから物件一覧を返す
function viewSearchMadori($heya,$type,$where=null){
 try{
  $mname="viewSearchMaodir(view.function.php)";
  $c="start ".$mname;wLog($c);
  $w ="t.fld180='".$heya."' and t.fld179='".$type."'";
  $w.=" and t1.fld000 is null";
  if($where) $w.=" and ".$where;
  $order ="t.fld180,t.fld179";
  $order.=",t.fld019,t.fld020,t.fld021,t.fld022,t.fld054";
  $data=viewRainsData($w,$order);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取りから物件一覧を返す(賃貸マンション)
function viewSearchMadoriM($heya,$type){
 try{
  $mname="viewSearchMadoriM(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='01'";
  $data=viewSearchMadori($heya,$type,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取りから物件一覧を返す(賃貸アパート)
function viewSearchMadoriA($heya,$type){
 try{
  $mname="viewSearchMadoriA(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='03' and t.fld002='03' and t.fld003='02'";
  $data=viewSearchMadori($heya,$type,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//間取りから物件一覧を返す(売買)
function viewSearchMadoriS($heya,$type){
 try{
  $mname="viewSearchMadoriS(view.function.php)";
  $c="start ".$mname;wLog($c);
  $where="t.fld001='01'";
  $data=viewSearchMadori($heya,$type,$where);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//物件種別を返す
function viewGroupFld($where=null){
 try{
  $mname="viewGroupFld(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  $db->select="t.fld001,t.fld002,t.fld003,count(t.fld001) as cnt";
  $db->group ="t.fld001,t.fld002,t.fld003";
  $db->order ="t.fld001,t.fld002,t.fld003";
  $db->where ="t1.fld000 is null";
  if($where) $db->where.=" and ".$where;
  $db->dsetRains();
  $db->dsetRainsFld();
  $c="end ".$mname;wLog($c);
  return $db->r;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//物件種別を返す(賃貸)
function viewGroupFldR($where=null){
 try{
  $mname="viewGroupFldR(view.function.php)";
  $c="start ".$mname;wLog($c);
  $w="t.fld001='03' ";
  if($where) $w.=" and ".$where;
  $data=viewGroupFld($w);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//物件種別を返す(売買)
function viewGroupFldS($where=null){
 try{
  $mname="viewGroupFldS(view.function.php)";
  $c="start ".$mname;wLog($c);
  $w="t.fld001='01' ";
  if($where) $w.=" and ".$where;
  $data=viewGroupFld($w);
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//徒歩を返す
function viewWalkGroup($where=null){
 try{
  $mname="viewGroupFldS(view.function.php)";
  $c="start ".$mname;wLog($c);
  $db=new DSET();
  if($where) $db->where=$where;
  $data=$db->dsetWalkCount();
  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//売買物件一覧を返す
function viewSaleList($where=null){
 try{
  $mname="viewSaleList(view.function.php)";
  $c="start ".$mname;wLog($c);

  $w=" t.fld001='01' and t1.fld000 is null";
  if($where) $w.=" and ".$where;
  $d=viewShortData($w,null);
  return $d["data"];
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}
?>
