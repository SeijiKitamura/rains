<?php
/*-----------------------------------------------------
 ファイル名:dataset.class.php
 接頭語    :dset
 主な動作  :各種データを配列にセットするクラス
 返り値    :セットした結果を返す(return $this->d)
 エラー    :throw を投げる
 その他    :ここではwhere句は書かないこと
----------------------------------------------------- */
require_once("db.class.php");
class DSET extends DB{
 public $r;
 public $flds;
 public $fld000;
 //初期化
 function __construct(){
  wLog("start __construct(DSET class)");
  parent::__construct();

  //Rains列データを$fldsに格納
  wLog("__counstruct(DSET class):Rains列データを配列に格納");
  $this->flds=$this->dsetSubFld();
 }
 
 //DBからRainsデータを抽出
 //select句,where句、order句は予めセットしておく
 //order句は特に指定がなければ物件番号昇順になる
 public function dsetRains(){
  wLog("start dsetRains(DSET class)");
  $this->r=array();

  if(! $this->order){
   $this->order="case when t.fld000='物件番号' then 0 else 1 end,t.fld000";
  }

  if(! $this->select) $this->select="t.*,t1.fld000 as blacklist";
  $this->from =TABLE_PREFIX.RAINS." as t ";
  $this->from.=" left outer join ";
  $this->from.=TABLE_PREFIX.BLACKLIST." as t1 on ";
  $this->from.=" t.fld000=t1.fld000 ";
  $this->r=array();
  $this->r["data"]=$this->getArray();

  wLog("end dsetRains(DSET class)");
  return $this->r;
 }
  
 //Rains関連データを配列にセット
 public function dsetRainsFld(){
  wLog("start dsetRainsFld(DSET class)");
  if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
   $c="error:dsetRainsFld(DSET class)データがありません";
   wLog($c);
   throw new exception($c);
  }

  if(!is_array($this->flds) ||!isset($this->flds)|| count($this->flds)==0){
   $c="error:dsetRainsFld(DSET class)関連データがありません";
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   if(! preg_match("/^[0-9]+$/",$val["fld000"])) continue;

   foreach($this->flds as $key1=>$val1){
    if($val1["fldname"]=="fld001"){
     if($val["fld001"]==$val1["bnum"])
     { 
      $c="dsetRainsFld(DSET class):物件番号".$val["fld000"]."に「_fld001=>".$val1["bname"]."」を追加しました。";
      wLog($c);
      $this->r["data"][$key]["_fld001"]=$val1["bname"];
     }
     continue;
    }

    if($val1["fldname"]=="fld002"){
     if($val["fld001"]==$val1["fld001"] &&
        $val["fld002"]==$val1["fld002"])
     { 
      $c="dsetRainsFld(DSET class):物件番号".$val["fld000"]."に「_fld002=>".$val1["bname"]."」を追加しました。";
      wLog($c);
      $this->r["data"][$key]["_fld002"]=$val1["bname"];
     }
     continue;
    }

    if($val1["fldname"]=="fld003"){
     if($val["fld001"]==$val1["fld001"] &&
        $val["fld002"]==$val1["fld002"] &&
        $val[$val1["fldname"]]==$val1["bnum"])
     { 
      $c="dsetRainsFld(DSET class):物件番号".$val["fld000"]."に「_fld003=>".$val1["bname"]."」を追加しました。";
      wLog($c);
      $this->r["data"][$key]["_fld003"]=$val1["bname"];
     }
     continue;
    }

    if($val["fld001"]==$val1["fld001"] &&
       $val["fld002"]==$val1["fld002"] &&
       $val[$val1["fldname"]]==$val1["bnum"])
    { 

     // $this->r["data"][$key][$val1["fldname"]]=$val1["bname"]; 
     $this->r["data"][$key]["_".$val1["fldname"]]=$val1["bname"]; 

     $c="dsetRainsFld(DSET class):物件番号".$val["fld000"]."に_".$val1["fldname"]."列を「".$val1["bname"]."」に追加しました。";
     wLog($c);
    }

    if(! $val1["fld001"] && !$val1["fld002"] && $val[$val1["fldname"]]==$val1["bnum"]){

     $this->r["data"][$key]["_".$val1["fldname"]]=$val1["bname"];

     $c="dsetRainsFld(DSET class):物件番号".$val["fld000"]."に_".$val1["fldname"]."列を「".$val1["bname"]."」に追加しました。";
     wLog($c);
    }
   }
  }
  wLog("end dsetRainsFld(DSET class)");
  return $this->r;
 }

 //DBからLatLngデータを抽出
 public function dsetGetLatLng(){
  wLog("start dsetGetLatLng(DSET class)");

  //データ存在チェック
  if(!is_array($this->r["data"])||! isset($this->r["data"])||!count($this->r["data"])){
   $c="error:dsetGetLatLng(DSET class):物件データがありません。";
   wLog($c);
   throw new exception($c);
  }
  //１件目のデータだけ取り出す
  foreach($this->r["data"] as $key=>$val){
   $fld000=$val["fld000"];
   $c="dsetGetLatLng(Dset class):fld000 ".$fld000;
   wLog($c);

   //物件番号チェック
   if(!preg_match("/^[0-9]+$/",$fld000)){
    $c="error:dsetGetLatLng(Dset class) 物件番号を確認してください".$fld000;
    wLog($c);
    throw new exception($c);
   }

   $this->select="*";
   $this->from=TABLE_PREFIX.LATLNG;
   $this->where ="fld000='".$fld000."'";
   $this->where.=" and startlat<>'' and startlng<>'' ";
   $this->where.=" and endlat<>'' and endlng<>'' ";
   $this->getArray();
   if(isset($this->ary) || is_array($this->ary)||count($this->ary)>0){
    $c="dsetGetLatLng(DSET class):DBにLatLngデータ有り".$fld000;
    wLog($c);
    $this->r["data"][$key]["latlng"]=$this->ary;
   }
   else{
    $this->dsetStart2End();
   }
   wLog("end dsetGetLatLng(DSET class)");
   return $this->r;
  }
 }
 
 //DBから出発地点と到着地点の住所をゲット
 public function dsetStart2End(){
  wLog("start dsetStart2End(DSET class)");

  if(! isset($this->r["data"]) || !is_array($this->r["data"])|| !count($this->r["data"])){
   $e="error:dsetStart2End(DSET class)物件データがありません。";
   wLog($e);
   throw new exception($e);
  }
  
  //スタート地点とゴール地点を配列へセット(１件目のデータのみ)
  foreach($this->r["data"] as $key=>$val){
   $fld000=$val["fld000"];

   if($val["fld025"] && $val["fld026"]){
    //都道府県＋駅名＋"駅”
    $start=$val["fld017"]."  ".$val["fld026"]."駅";
   }
   elseif($val["fld030"] && $val["fld031"]){
    //都道府県＋バス停名+"バス停"
    $start=$val["fld017"].$val["fld031"]."バス停";
   }
   wLog("dsetStart2End(DSET class)出発地点名 ".$start);

   //到着地点チェック
   //fld020(所在地３)とfld021(建物名)が空欄はエラー扱い
   if(! $val["fld020"] && ! $val["fld021"]){
    $c="dsetStart2End(DSET class)物件番号".$val["fld000"]."の所在地が確定しません";
    wLog($c);
    return false;
   }
   $end=$val["fld017"].$val["fld018"].$val["fld019"].$val["fld020"];
   wLog("dsetStart2End(DSET class)到着地点名 ".$end);

   //latlngを配列へセット
   $startlatlng=$this->dsetGoogleLatLng($start);
   $endlatlng=$this->dsetGoogleLatLng($end);
   $this->r["data"][$key]["latlng"]=array( "startlat"=>$startlatlng["lat"]
                                          ,"startlng"=>$startlatlng["lng"]
                                          ,"endlat"  =>$endlatlng["lat"]
                                          ,"endlng"  =>$endlatlng["lng"]
                                          ,"fld000"  =>$fld000
                                         );

   //DBへ登録
   $this->dsetUpLatLng();
   wLog("end dsetStart2End(DSET Class)");
   return;
  }//foreach
 }
 
 //GoogleからLatLngデータをゲット
 public function dsetGoogleLatLng($address){
  wLog("start dsetGoogleLatLng(DSET Class)");
  $url="http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&language=ja&region=jp";
  $json=file_get_contents($url);
  $json=json_decode($json,true);
  
  if($json["status"]!=="OK"){
   $c="error:dsetGoogleLatLng(DSET Class) Googleから地点情報取得に失敗しました:".$address;
   wLog($c);
   throw new exception($c);
  } 
  $latlng=$json["results"][0]["geometry"]["location"];
  $c="end dsetGoogleLatLng(DSET Class)";
  wLog($c);
  return $latlng;
 }

 //DBにLatLngデータを登録
 private function dsetUpLatLng(){
  wLog("start dsetUpLatLng(DSET class)");
  //物件データチェック
  if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
   $c="error:dsetUpLatLng(DSET class) 物件データがありません";
   wLog($c);
   throw new exception($c);
  }

  //1件目のデータしか登録しない
  foreach($this->r["data"] as $key=>$val){
   //LatLngデータチェック
   if(! isset($val["latlng"]) || ! is_array($val["latlng"]) || ! count($val["latlng"])){
    $c="error:dsetUpLatLng(DSET class)物件番号".$val["fld000"] ."の位置データがありません";
    wLog($c);
    //return false;<-　これにしようか悩む。(入力データ次第ではGoogleが位置データを返さない場合もあるので)
    throw new exception($c);
   }
   //DBへ登録
   $this->updatecol=$val["latlng"];
   $this->from=TABLE_PREFIX.LATLNG;
   $this->where="fld000='".$val["fld000"]."'";
   $this->update();
   wLog("end dsetUpLatLng(DSET class)");
   return;
  }
 }
 
 //画像データ抽出
 public function dsetGetImgList($imgid=null){
  wLog("start dsetGetImgList(DSET class)");
  
  //物件データチェック
  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   $c="dsetGetImgList(DSET class)物件データがありません。";
   wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   $c="dsetGetImgList(DSET class)画像リスト初期化。";
   wLog($c);
   $this->r["data"][$key]["imgfile"]=array();
   
   //画像リスト取得
   $this->select="*";
   $this->from=TABLE_PREFIX.IMGLIST;
   $this->where="fld000='".$val["fld000"]."'";
   if($imgid){
    $this->where.=" and id=".$imgid;
   }
   $this->order="fld000,fld001";
   $this->getArray();
   if(isset($this->ary) || is_array($this->ary) || count($this->ary)){
    $this->r["data"][$key]["imgfile"]=$this->ary;
    $c="dsetGetImgList(DSET class)物件番号".$val["fld000"]."に画像リストをセットしました";
    wLog($c);
   }
   else{
    $c="dsetGetImgList(DSET class)物件番号".$val["fld000"]."は画像リストが登録されていません。";
    wLog($c);
   }
  }
  $c="end dsetGetImgList(Dset class)";
  wLog($c);
  return $this->r;
 }
 
 //画像パスを絶対参照、URLエンコードする
 //dsetGetImgListからのコンボ利用を想定
 public function dsetImgPathWithEncode(){
  wLog("start dsetImgPathWithEncode(DSET class)");
  
  //物件データチェック
  if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
   $c="error:dsetImgPathWithEncode(DSET class)物件データがありません";
   wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   if(! isset($val["imgfile"]) || ! is_array($val["imgfile"]) ||! count($val["imgfile"])){
    $c="dsetImgPathWithEncode(DSET class)物件番号(".$val["fld000"].")の画像リストがありません。";
    wLog($c);
    continue;
   }//if
   $c="dsetImgPathWithEncode(DSET class)物件番号(".$val["fld000"].")の画像パス初期化。";
   wLog($c);
   $this->r["data"][$key]["imgfilepath"]=array();

   foreach($val["imgfile"] as $key1=>$val1){
    $imgpath=".".IMG."/".$val["fld000"]."/".urlencode($val1["fld002"]);
    $c="dsetImgPathWithEncode(DSET class)画像パス変換".$val1["fld002"]."=>".$imgpath;
    wLog($c);
    //$this->r["data"][$key]["imgfilepath"][$key1]["fld002"]=$imgpath;
    $this->r["data"][$key]["imgfilepath"][$key1]=$imgpath;
   }
  }

  wLog("end dsetImgPathWithEncode(DSET class)");
  return $this->r;
 }

 //画像リスト登録
 public function dsetUpImgList(){
  wLog("start dsetUpImgList(DSET class)");
  
  //物件データチェック
  if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
   $c="error:dsetUpImgList(DSET class)物件データがありません";
   wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   //ディレクトリ存在チェック
   $imgpath=realpath("..").IMG."/".$val["fld000"];
   $c="dsetUpImgList(DSET class)画像ディレクトリ".$imgpath."をセット";
   wLog($c);

   if(! file_exists($imgpath)){
    $c="dsetUpImgList(DSET class)物件番号".$val["fld000"]."の画像ディレクトリ".$imgpath."がありませんのでDBデータを削除します";
    wLog($c);
    $this->from=TABLE_PREFIX.IMGLIST;
    $this->where="fld000='".$val["fld000"]."'";
    $this->delete();
    $c="dsetUpImgList(DSET class)物件番号".$val["fld000"]."のimgfileを初期化";
    wLog($c);
    $this->r["data"][$key]["imgfile"]=array();
    continue;
   }
   //画像リスト存在チェック
   if(! isset($val["imgfile"])||! is_array($val["imgfile"]) ||!count($val["imgfile"])){
    $c="dsetUpImgList(DSET class)物件番号".$val["fld000"]."の画像リストがありません(imglistテーブル未登録)";
    wLog($c);
   }//if(isset($val

   //DBデータを検索対象として画像ファイルをチェック
   foreach($val["imgfile"] as $key1=>$val1){
    $flg=0;
    if(! $handle=opendir($imgpath)){
     $e="error:dsetUpImgList(DSET class)画像ディレクトリ".$imgpath."が開けません";
     wLog($e);
     continue;
    }//if

    while(false!==($file=readdir($handle))){
     if($file=="." || $file=="..")continue;
     if($file==$val1["fld002"]){
      //画像リスト有り、ファイルありは何もしない
      $c="dsetUpImgList(DSET class)DB画像リストと画像ファイル一致！画像ファイル名".$val1["fld002"];
      wLog($c);
      $flg=1;
      break;
     }//if
    }//while

    if(!$flg){
     //画像リスト有り、ファイルなしはDB削除
     $c="dsetUpImgList(DSET class)DB画像リストあり、画像ファイルなしのためDBリストを削除します。ファイル名".$val1["fld002"];
     wLog($c);
     $this->from=TABLE_PREFIX.IMGLIST;
     $this->where =" fld000='".$val["fld000"]."'";
     $this->where.=" and fld002='".$val1["fld002"]."'";
     $this->delete();
    }
   }//foreach($val["imgfile"
   closedir($handle);
   
   //画像ファイルを検索対象としてDBデータをチェック
   if(! $handle=opendir($imgpath)){
    $e="error:dsetUpImgList(DSET class)画像ディレクトリ".$imgpath."が開けません";
    wLog($e);
    continue;
   }//if($handle
   while(false!==($file=readdir($handle))){
    $flg=0;
    if($file=="." || $file=="..")continue;
    if(isset($val["imgfile"])||is_array($val["imgfile"])){
     foreach($val["imgfile"] as $key1=>$val1){
      if($file==$val1["fld002"]){
       $c="dsetUpImgList(DSET class)DB画像リストと画像ファイル一致！画像ファイル名".$val1["fld002"];
       wLog($c);
       $flg=1;
       break;
      }
     }//foreach
    }//if(isset

    if(!$flg){
     //画像リストなし、ファイルありは登録
     $c="dsetUpImgList(DSET class)DB画像リストなし、画像ファイルありのためDBに登録します。ファイル名".$file;
     wLog($c);
     $this->updatecol=array( "fld000"=>$val["fld000"]
                            ,"fld002"=>mb_convert_encoding($file,"UTF-8","AUTO")
                           );
     $this->from=TABLE_PREFIX.IMGLIST;
     $this->where =" fld000='".$val["fld000"]."'";
     $this->where.=" and fld002='".mb_convert_encoding($file,"UTF-8","AUTO")."'";
     $this->update();
    }
   }//while(false
   closedir($handle);

  }//foreach

  //画像リスト再取得
  $c="dsetUpImgList(DSET class)画像リスト再取得";
  wLog($c);
  $this->dsetGetImgList();

  $c="end dsetUpImgList(DSET class)";
  wLog($c);
  return $this->r;
 }
 
 //画像並び順セット
 public function dsetImgNum($imgid,$imgnum){
  wLog("start dsetImgNum(DSET class)");
  //画像番号チェック
  if(!preg_match("/^[0-9]+$/",$imgid)){
   $c="error:dsetImgNum(DSET class)画像番号が不正です。(".$imgid.")";
   wLog($c);
   throw new exception($c);
  }
  
  //画像番号チェック
  if(!preg_match("/^[0-9]+$/",$imgnum)){
   $c="error:dsetImgNum(DSET class)画像表示番号が不正です。(".$imgnum.")";
   wLog($c);
   throw new exception($c);
  }
  $this->updatecol=array("fld001"=>$imgnum);
  $this->from=TABLE_PREFIX.IMGLIST;
  $this->where="id=".$imgid;
  $this->update();
  
  wLog("end dsetImgNum(DSET class)");
 }

 //画像削除
 public function dsetDelImg($imgid=null){
  wLog("start dsetDelImg(DSET class)");
  //物件データチェック
  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   $c="dsetDelImg(DSET class)物件データがありません。";
   wLog($c);
   throw new exception($c);
  }
  
  //画像番号チェック
  if($imgid && !preg_match("/^[0-9]+$/",$imgid)){
   $c="error:dsetDelImg(DSET class)画像番号が不正です。(".$imgid.")";
   wLog($c);
   throw new exception($c);
  }
  foreach($this->r["data"] as $key=>$val){
   $c="dsetDelImg(DSET class)物件番号".$val["fld000"]."の画像削除を開始します。";
   wLog($c);

   $imgpath=realpath("..").IMG."/".$val["fld000"];
   if(! file_exists($imgpath)){
    $c="dsetDelImg(DSET class)物件番号".$val["fld000"]."の画像ディレクトリがありません。".$imgpath;
    wLog($c);
    contine;
   }

   $c="dsetDelImg(DSET class)削除対象ディレクトリセット:".$imgpath;
   wLog($c);
   if($imgid){
    $c="dsetDelImg(DSET class)削除画像番号".$imgid."をセット。";
    wLog($c);
    //画像指定削除
    if(!isset($val["imgfile"])||!is_array($val["imgfile"])||!count($val["imgfile"])){
     $c="dsetDelImg(DSET class)物件番号".$val["fld000"]."の画像リストがありません。処理を飛ばします。";
     wLog($c);
     continue;
    }//if(!isset

    foreach($val["imgfile"] as $key1=>$val1){
     if($val1["id"]==$imgid){
      $imgfile=$imgpath."/".$val1["fld002"];
      $c="dsetDelImg(DSET class)指定画像削除開始(画像番号".$imgid.")".$imgfile;
      wLog($c);
      if(! unlink($imgfile)){
       $c="error:dsetDelImg(DSET class)指定画像削除失敗(画像番号".$imgid.")".$imgfile;
       wLog($c);
      }//if(! unlink
      $c="dsetDelImg(DSET class)指定画像削除成功(画像番号".$imgid.")".$imgfile;
      wLog($c);
      break;
     }//if($val1["id"]
    }//foreach($val["imgfile"]
   }//if($imgid
   else{
    $c="dsetDelImg(DSET class)ディレクトリ内画像全削除:".$imgpath;
    wLog($c);
    //画像ディレクトリ内すべて削除
    if($handle=opendir($imgpath)){
     while(false!==($file=readdir($handle))){
      $c="dsetDelImg(DSET class)ディレクトリ内ファイルゲット".$imgpath."/".$file;
      wLog($c);
      if($file=="." ||$file=="..") continue;
      $c="dsetDelImg(DSET class)削除開始".$imgpath."/".$file;
      wLog($c);
      //ファイル削除(該当ファイルを配列へ格納）
      if(! unlink($imgpath."/".$file)){
       $c="error:dsetDelImg(DSET class)削除失敗".$imgpath."/".$file;
       wLog($c);
       continue;
      }
      $c="dsetDelImg(DSET class)削除成功".$imgpath."/".$file;
      wLog($c);
     }
    }
    else{
     $c="error:dsetDelImg(DSET class)ディレクトリが開けません。".$imgpath;
     wLog($c);
    }
   }//else
  }//foreach($this->r["data"]

  
  //画像リスト再登録、再取得
  //(DBリストあり、画像ファイルなしはこれで削除される）
  $c="dsetDelImg(DSET class)画像リスト再登録";
  wLog($c);
  $this->dsetUpImgList();
  wLog("end dsetDelImg(DSET class)");
  return $this->r;
 }
 
 //データ削除
 public function dsetDelAll(){
  $c="dsetDelAll(DSET class)データ削除開始";
  wLog($c);
  //物件データチェック
  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   $c="dsetDelAll(DSET class)物件データがありません。";
   wLog($c);
   throw new exception($c);
  }

  //$c="dsetDelAll(DSET class)画像ファイル削除開始";
  //wLog($c);
  //$this->dsetDelImg();

  foreach($this->r["data"] as $key=>$val){
   $fld000=$val["fld000"];

   $c="dsetDelAll(DSET class)Rainsデータ削除開始 物件番号(".$fld000.")";
   wLog($c);
   $this->from=TABLE_PREFIX.RAINS;
   $this->where="fld000='".$fld000."'";
   $this->delete();
  
   $c="dsetDelAll(DSET class)LatLngデータ削除開始(".$fld000.")";
   wLog($c);
   $this->from=TABLE_PREFIX.LATLNG;
   $this->where="fld000='".$fld000."'";
   $this->delete();
   
   //$c="dsetDelAll(DSET class)画像データ削除開始(".$fld000.")";
;
   //wLog($c);
   //$this->from=TABLE_PREFIX.IMGLIST;
   //$this->where="fld000='".$fld000."'";
   //$this->delete();
  }

  $c="end dsetDelAll(DSET class)データ削除終了";
  wLog($c);
  return $this->r;
 }

 public function dsetRainsSubData($fldname,$fld001=null,$fld002=null,$bnum=null){
  $mname="dsetRainsSubData";
  $c="start ".$mname;wLog($c);
  $this->select="bname";
  $this->from=TABLE_PREFIX.FLD;
  $this->where="fldname='".$fldname."'";
  if($fld001) $this->where.=" and fld001='".$fld001."'";
  if($fld002) $this->where.=" and fld002='".$fld002."'";
  if($bnum) $this->where.=" and bnum='".$bnum."'";
  $c="end ".$mname;wLog($c);
  $this->getArray();
  return $this->ary[0]["bname"];
 }

 public function dsetBlackList(){
  $mname="dsetBlackList(DSET class)";
  $c="start ".$mname;wLog($c);

  $this->select="t.*";
  $this->from=TABLE_PREFIX.BLACKLIST." as t1 ";
  $this->from.=" inner join ".TABLE_PREFIX.RAINS." as t on ";
  $this->from.=" t1.fld000=t.fld000 ";
  $this->order="t.fld000";
  $this->r=array();
  $this->r["data"]=$this->getArray();

  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 public function dsetUpBlackList(){
  $mname="dsetUpBlackList(DSET class)";
  $c="start ".$mname;wLog($c);

  if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
   $c="error:".$mname."データがありません"; wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   $this->updatecol=array("fld000"=>$val["fld000"]);
   $this->from=TABLE_PREFIX.BLACKLIST;
   $this->where="fld000='".$val["fld000"]."'";
   $this->update();
   $c=$mname."物件番号(".$val["fld000"].")をブラックリストに登録";wLog($c);
  }
  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 public function dsetDelBlackList(){
  $mname="dsetDelBlackList(DSET class)";
  $c="start ".$mname;wLog($c);
  if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
   $c="error:".$mname."データがありません"; wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   $this->from=TABLE_PREFIX.BLACKLIST;
   $this->where="fld000='".$val["fld000"]."'";
   $this->delete();
   $c=$mname."物件番号(".$val["fld000"].")をブラックリストから削除";wLog($c);
  }

  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 //DBからエリア集計をする
 //where句は予めセットしておく
 //order句は特に指定がなければfld017,fld018,fld019の昇順となる
 public function dsetAreaCount(){
  $mname="dsetAreaCount(DSET class)";
  $c="start ".$mname;wLog($c);
  $this->r=array();
  $this->select="t.fld017,t.fld018,t.fld019,t1.fld000,count(t.fld000)";
  $this->from=TABLE_PREFIX.RAINS." as t ";
  $this->from.=" left outer join ".TABLE_PREFIX.BLACKLIST." as t1 on ";
  $this->from.=" t.fld000=t1.fld000 ";
  $this->group="t.fld017,t.fld018,t.fld019,t1.fld000";
  if(! $this->order){
   $this->order=$this->group;
  }
  $this->r["data"]=$this->getArray();
  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 //登録済レコード数をカウント
 public function dsetDataCount(){
  $mname="dsetDataCount(DSET class)";
  $c="start ".$mname;wLog($c);
  
  //物件データチェック
  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   $c="dsetGetImgList(DSET class)物件データがありません。";
   wLog($c);
   throw new exception($c);
  }


  $cnt=0;
  $newdata=0;
  $blacklist=0;
  foreach($this->r["data"] as $key=>$val){
   if($val["blacklist"]){
    $blacklist++;
    continue;
   }

   if(count($val["imgfile"])){
    $cnt++;
   }

   if(strtotime($val["idate"])>strtotime(NEWLIST)){
    $newdata++;
   }

  }
  $this->r["count"]["all"]=count($this->r["data"])-$blacklist;
  $this->r["count"]["imgcnt"]=$cnt;
  $this->r["count"]["noimg"]=$this->r["all"]-$this->r["imgcnt"];
  $this->r["count"]["newdata"]=$newdata;
  $this->r["count"]["blacklist"]=$blacklist;
  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 //物件種別ごとにカウント
 public function dsetFldCount(){
  $mname="dsetFldCount(DSET class)";
  $c="start ".$mname;wLog($c);

  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   $c=$mname."物件データがありません。";
   wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   $fld001=$val["fld001"]."_".$val["_fld001"];
   $fld002=$val["fld002"]."_".$val["_fld002"];
   $fld003=$val["fld003"]."_".$val["_fld003"];

   if($this->r["fldcount"][$fld001][$fld002][$fld003]){
    $this->r["fldcount"][$fld001][$fld002][$fld003]++;
   }
   else{
    $this->r["fldcount"][$fld001][$fld002][$fld003]=1;
   }
  }

  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 //間取りごとにカウント
 public function dsetMadoriCount(){
  $mname="dsetMadoriCount(DSET class)";
  $c="start ".$mname;wLog($c);

  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   $c=$mname."物件データがありません。";
   wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   if(!$val["fld180"] && !$val["_fld179"]){
    $k="なし";
   }
   else{
    $k=$val["fld001"]."_".$val["fld002"]."_".$val["fld179"]."_".$val["fld180"].$val["_fld179"];
   }

   if($this->r["madori"][$k]){
    $this->r["madori"][$k]++;
   }
   else{
    $this->r["madori"][$k]=1;
   }
  }
  
  //配列並べ替え
  ksort($this->r["madori"]);
  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 //最寄駅ごとにカウント
 public function dsetStationCount(){
  $mname="dsetStationCount(DSET class)";
  $c="start ".$mname;wLog($c);

  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   $c=$mname."物件データがありません。";
   wLog($c);
   throw new exception($c);
  }

  foreach($this->r["data"] as $key=>$val){
   if(!$val["fld025"]) $line="沿線登録なし";
   else $line=$val["fld025"];

   if(!$val["fld026"]) $station="駅名なし";
   else $station=$val["fld026"];

   if($this->r["station"][$line][$station]){
    $this->r["station"][$line][$station]++;
   }
   else{
    $this->r["station"][$line][$station]=1;
   }
  }

  //配列並べ替え
  ksort($this->r["station"]);

  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 public function dsetSubFld(){
  $this->select="*";
  $this->from=TABLE_PREFIX.FLD;
  $this->order="fldname,fld001,fld002";
  return $this->getArray();
 }
}
?>


