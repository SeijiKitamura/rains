<?php
/*-----------------------------------------------------
 ファイル名:view.function.php
 接頭語    :view
 主な動作  :DBのwhere句をセットしてデータを抽出する
 返り値    :セットした結果を返す(return $dbdata)
 エラー    :エラーメッセージを表示
----------------------------------------------------- */
require_once("dset.class.php");

//----------------------------------------------------//
//似た物件を返す
//(引数で指定した物件と同じ分類、間取りで検索して価格順
//に表示)
//----------------------------------------------------//
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

//----------------------------------------------------//
// ブラックリストを返す
//----------------------------------------------------//
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

//----------------------------------------------------//
// ブラックリストを削除
//----------------------------------------------------//
function viewDelBlackList($fld000=null){
 try{
  $mname="viewDelBlackList(view.function.php)";
  $c="start ".$mname;wLog($c);
  if($fld000) $where="t.fld000='".$fld000."'";
  $data=viewBlackList($where);
  $db=new DSET();
  $db->r=$data;
  $db->dsetDelBlackList();
  
  //サイトマップ作成
  $db->dsetSiteMap();
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//----------------------------------------------------//
// エントリー削除
//----------------------------------------------------//
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

//----------------------------------------------------//
// Rainsデータ削除
//----------------------------------------------------//
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

//----------------------------------------------------//
// ImgListデータ削除
//----------------------------------------------------//
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

//----------------------------------------------------//
// ランキングデータ削除
//----------------------------------------------------//
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

//----------------------------------------------------//
// 個別物件データを返す
//----------------------------------------------------//
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

//----------------------------------------------------//
// ランキング登録されている物件を返す
//----------------------------------------------------//
function viewEntry($rank){
 try{
  $mname="viewEntry(view.function.php)";
  $c="start ".$mname;wLog($c);
  if(!preg_match("/^[0-9]+$/",$rank)){
   throw new exception("ランク番号入力エラー(".$rank.")");
  }
  $db=new DSET();
  $db->where ="t.rank=".$rank;
  $db->where.=" and t3.fld000 is null";
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

//----------------------------------------------------//
//物件種別を返す
//----------------------------------------------------//
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

//----------------------------------------------------//
//Rainsデータを以下の条件、並び順で抽出する
//(whiteList,登録日降順)
//----------------------------------------------------//
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

//----------------------------------------------------//
// 現在有効なランキングを返す
//----------------------------------------------------//
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

//----------------------------------------------------//
// Rainsデータを返す
//----------------------------------------------------//
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

//----------------------------------------------------//
// ランキングを返す
//----------------------------------------------------//
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

//----------------------------------------------------//
// 物件コメントを追加
//----------------------------------------------------//
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

//----------------------------------------------------//
// ブラックリスト　登録
//----------------------------------------------------//
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

  //サイトマップ作成
  $db->dsetSiteMap();

  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//----------------------------------------------------//
// エントリー　登録
//----------------------------------------------------//
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

//----------------------------------------------------//
// ImgList 登録
//----------------------------------------------------//
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

//----------------------------------------------------//
// ImgList 登録(外部URL)
//----------------------------------------------------//
function viewSetImage2($fld000,$aryurl){
 try{
  $mname="viewSetImage(view.function.php)";
  $c="start ".$mname;wLog($c);
  if(! preg_match("/^[0-9]+$/",$fld000)){
   throw new exception("物件番号を確認してください(".$fld000.")");
  }

  if(! is_array($aryurl) ||! isset($aryurl) || ! count($aryurl)){
   throw new exception("URL配列を確認してください)");
  }

  $sql=array();
  foreach($aryurl as $key=>$val){
   $sql[]=array("col"=>array("fld000"=>$fld000,
                             "fld002"=>$val["src"]),
                "from"=>TABLE_PREFIX.IMGLIST,
                "where"=>array("fld000"=>$fld000,
                               "fld002"=>$val["src"]
                              )
               );
  }

  $db=new DB();
  $db->updatearray($sql);
  return $sql;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//----------------------------------------------------//
// 画像番号　登録
//----------------------------------------------------//
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

//----------------------------------------------------//
// ランキング 登録
//----------------------------------------------------//
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

//----------------------------------------------------//
// Rainsデータを返す(地図データ除く)
//----------------------------------------------------//
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

//----------------------------------------------------//
// 新着データとランキングデータを返す
//----------------------------------------------------//
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

  $c="end ".$mname;wLog($c);
  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }
}

//----------------------------------------------------//
// 売買と賃貸のデータを返す
//----------------------------------------------------//
function viewAllData(){
 try{
  $mname="viewAllData(view.function.php)";
  $c="start ".$mname;wLog($c);
  //種別グループをセット
  $group=viewGroupFld();

  $data=array();
  $fld001="";
  foreach($group["data"] as $key=>$val){
   if($fld001==$val["fld001"]) continue;
   
   //データゲット
   $where="t.fld001='".$val["fld001"]."'";
   $rains=viewShortData($where);

   if($val["fld001"]=="1"){
    $data["baibai"]=$rains["data"];
   }
   if($val["fld001"]=="3"){
    $data["tintai"]=$rains["data"];
   }
   $fld001=$val["fld001"];
  }

  return $data;
 }
 catch(Exception $e){
  $c="error:".$e->getMessage().$mname;wLog($c);
 }

}
?>
