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
  $mname="__construct(dset.class.php) ";
  $c="start:".$mname;wLog($c);

  parent::__construct();

  $this->flds=$this->dsetSubFld();
  $c="end:".$mname;wLog($c);
 }
 
 //DBからRainsデータを抽出
 //select句,where句、order句は予めセットしておく
 //order句は特に指定がなければ物件番号昇順になる
 public function dsetRains(){
  $mname="dsetRains(dset.class.php) ";
  $c="start:".$mname;wLog($c);
  $this->r=array();

  if(! $this->order){
   $this->order="case when t.fld000='物件番号' then 0 else 1 end,t.fld000";
  }

  if(! $this->select) $this->select="t.*,t1.fld000 as blacklist,t2.fld001 as setubi,t2.fld002 as bcomment";
  $this->from =TABLE_PREFIX.RAINS." as t ";
  $this->from.=" left outer join ";
  $this->from.=TABLE_PREFIX.BLACKLIST." as t1 on ";
  $this->from.=" t.fld000=t1.fld000 ";
  $this->from.=" left outer join ";
  $this->from.=TABLE_PREFIX.BCOMMENT." as t2 on ";
  $this->from.=" t.fld000=t2.fld000 ";

  $this->r=array();
  $this->r["data"]=$this->getArray();

  $c="end:".$mname;wLog($c);
  return $this->r;
 }
  
 //Rains関連データを配列にセット
 public function dsetRainsFld(){
  try{
   $mname="dsetRainsFld(dset.class.php) ";
   $c="start:".$mname;wLog($c);

   if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
    throw new exception("Rainsデータがありません");
   }

   if(!is_array($this->flds) ||!isset($this->flds)|| count($this->flds)==0){
    throw new exception("関連データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    if(! preg_match("/^[0-9]+$/",$val["fld000"])) continue;

    foreach($this->flds as $key1=>$val1){
     if($val1["fldname"]=="fld001"){
      if($val["fld001"]==$val1["bnum"])
      { 
       $this->r["data"][$key]["_fld001"]=$val1["bname"];

       $c="notice:".$mname."物件番号".$val["fld000"]."に「_fld001=>".$val1["bname"]."」を追加しました。";wLog($c);
      }
      continue;
     }

     if($val1["fldname"]=="fld002"){
      if($val["fld001"]==$val1["fld001"] &&
         $val["fld002"]==$val1["fld002"])
      { 
       $this->r["data"][$key]["_fld002"]=$val1["bname"];

       $c="notice:".$mname."物件番号".$val["fld000"]."に「_fld002=>".$val1["bname"]."」を追加しました。";wLog($c);
      }
      continue;
     }

     if($val1["fldname"]=="fld003"){
      if($val["fld001"]==$val1["fld001"] &&
         $val["fld002"]==$val1["fld002"] &&
         $val[$val1["fldname"]]==$val1["bnum"])
      { 
       $this->r["data"][$key]["_fld003"]=$val1["bname"];

       $c="notice:".$mname."物件番号".$val["fld000"]."に「_fld003=>".$val1["bname"]."」を追加しました。";wLog($c);
      }
      continue;
     }

     if($val["fld001"]==$val1["fld001"] &&
        $val["fld002"]==$val1["fld002"] &&
        $val[$val1["fldname"]]==$val1["bnum"])
     { 

      // $this->r["data"][$key][$val1["fldname"]]=$val1["bname"]; 
      $this->r["data"][$key]["_".$val1["fldname"]]=$val1["bname"]; 

      $c="notice:".$mname."物件番号".$val["fld000"]."に_".$val1["fldname"]."列を「".$val1["bname"]."」に追加しました。aaa";wLog($c);
      continue;
     }

     if(! $val1["fld001"] && !$val1["fld002"] && $val[$val1["fldname"]]==$val1["bnum"]){

      $this->r["data"][$key]["_".$val1["fldname"]]=$val1["bname"];

      $c="notice:".$mname."物件番号".$val["fld000"]."に_".$val1["fldname"]."列を「".$val1["bname"]."」に追加しました。bbb";wLog($c);
     }
    }
   }
   $c="end:".$mname;wLog($c);
   return $this->r;
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 //DBからLatLngデータを抽出
 public function dsetGetLatLng(){
  try{
   $mname="dsetGetLatLng(dset.class.php) ";
   $c="start:".$mname;wLog($c);

   //データ存在チェック
   if(!is_array($this->r["data"])||! isset($this->r["data"])||!count($this->r["data"])){
    throw new exception("Rainsデータがありません。");
   }
   
   //１件目のデータだけ取り出す
   foreach($this->r["data"] as $key=>$val){
    $fld000=$val["fld000"];
    $c="notice:".$mname."fld000:".$fld000;wLog($c);

    //物件番号チェック
    if(!preg_match("/^[0-9]+$/",$fld000)){
     throw new exception("物件番号を確認してください".$fld000);
    }

    $this->select="*";
    $this->from=TABLE_PREFIX.LATLNG;
    $this->where ="fld000='".$fld000."'";
    $this->where.=" and startlat<>'' and startlng<>'' ";
    $this->where.=" and endlat<>'' and endlng<>'' ";
    $this->getArray();
    if(isset($this->ary) || is_array($this->ary)||count($this->ary)>0){
     $c="notice:".$mname."DBにLatLngデータ有り".$fld000;wLog($c);

     $this->r["data"][$key]["latlng"]=$this->ary[0];
    }
    else{
     $this->dsetStart2End();
    }

    $c="end:".$mname;wLog($c);
    return $this->r;
   }//foreach
  }//try
  catch(Exception $e){
   $c="error:".$e->getMessage();wLog($c);echo $c;
  }
 }
 
 //DBから出発地点と到着地点の住所をゲット
 public function dsetStart2End(){
  try{
   $mname="dsetStart2End(dset.class.php) ";
   $c="start:".$mname;wLog($c);

   if(! isset($this->r["data"]) || !is_array($this->r["data"])|| !count($this->r["data"])){
    throw new exception("物件データがありません。");
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
    $c="notice:".$mname."出発地点名 ".$start;wLog($c);

    //到着地点チェック
    //fld020(所在地３)が空欄はエラー扱い
    if(! $val["fld020"]){
     $c=$mname."物件番号".$val["fld000"]."の所在地が確定しません";wLog($c);
     return;
    }

    $end=$val["fld017"].$val["fld018"].$val["fld019"].$val["fld020"];
    $c="notice:".$mname."到着地点名 ".$end;wLog($c);

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
    $c="end:".$mname;wLog($c);
    return;
   }//foreach
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }
 
 //GoogleからLatLngデータをゲット
 public function dsetGoogleLatLng($address){
  try{
   $mname="dsetGoogleLatLng(dset.class.php) ";
   $c="start:".$mname;wLog($c);

   $url="http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&language=ja&region=jp";

   $c="notice:".$mname."Google URL".$url;wLog($c);

   $json=file_get_contents($url);
   $json=json_decode($json,true);
   
   if($json["status"]!=="OK"){
    throw new exception("Googleから地点情報取得に失敗しました:".$address);
   } 

   $latlng=$json["results"][0]["geometry"]["location"];

   $c="end:".$mname;wLog($c);
   return $latlng;
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 //DBにLatLngデータを登録
 private function dsetUpLatLng(){
  try{
   $mname="dsetUpLatLng(dset.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //物件データチェック
   if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
    throw new exception("物件データがありません");
   }

   //1件目のデータしか登録しない
   foreach($this->r["data"] as $key=>$val){
    //LatLngデータチェック
    if(! isset($val["latlng"]) || ! is_array($val["latlng"]) || ! count($val["latlng"])){
     throw new exception("物件番号".$val["fld000"] ."の位置データがありません");
    }
    //DBへ登録
    $this->updatecol=$val["latlng"];
    $this->from=TABLE_PREFIX.LATLNG;
    $this->where="fld000='".$val["fld000"]."'";
    $this->update();
    $c="end:".$mname;wLog($c);
    return;
   }
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }
 
 //画像データ抽出
 public function dsetGetImgList($imgid=null){
  try{
   $mname="dsetGetImgList(dset.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //物件データチェック
   if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
    throw new exception("物件データがありません。");
   }

   foreach($this->r["data"] as $key=>$val){
    $c="notice:".$mname."画像リスト初期化。";wLog($c);

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
     $c="notice:".$mname."物件番号".$val["fld000"]."に画像リストをセットしました";wLog($c);
    }
    else{
     $c="notice:".$mname."物件番号".$val["fld000"]."は画像リストが登録されていません。";wLog($c);
    }
   }

   $c="end:".$mname;wLog($c);
   return $this->r;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }

 }
 
 //画像パスを絶対参照、URLエンコードする
 //dsetGetImgListからのコンボ利用を想定
 public function dsetImgPathWithEncode(){
  try{
   $mname="dsetImgPathWithEncode(dset.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //物件データチェック
   if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
    throw new exception("物件データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    if(! isset($val["imgfile"]) || ! is_array($val["imgfile"]) ||! count($val["imgfile"])){
     $c="notice".$mname."物件番号(".$val["fld000"].")の画像リストがありません。";wLog($c);
     continue;
    }//if
    $c="notice:".$mname."物件番号(".$val["fld000"].")の画像パス初期化。";wLog($c);

    $this->r["data"][$key]["imgfilepath"]=array();

    foreach($val["imgfile"] as $key1=>$val1){
     $imgpath=".".IMG."/".$val["fld000"]."/".urlencode($val1["fld002"]);
     $c="notice:".$mname."画像パス変換".$val1["fld002"]."=>".$imgpath;wLog($c);
     $this->r["data"][$key]["imgfilepath"][$key1]=$imgpath;
    }
   }

   $c="end:".$mname;wLog($c);
   return $this->r;
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }//catch
 }

 //画像リスト登録
 public function dsetUpImgList(){
  try{
   $mname="dsetUpImgList(dset.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //物件データチェック
   if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
    throw new exception("物件データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    //ディレクトリ存在チェック
    $imgpath=realpath("..").IMG."/".$val["fld000"];
    $c="notice".$mname."画像ディレクトリ".$imgpath."をセット";wLog($c);

    if(! file_exists($imgpath)){
     $c="notice:".$mname."物件番号".$val["fld000"]."の画像ディレクトリ".$imgpath."がありませんのでDBデータを削除します";wLog($c);

     $this->from=TABLE_PREFIX.IMGLIST;
     $this->where="fld000='".$val["fld000"]."'";
     $this->delete();
     $c="notice:".$mname."物件番号".$val["fld000"]."のimgfileを初期化";wLog($c);

     $this->r["data"][$key]["imgfile"]=array();
     continue;
    }
    //画像リスト存在チェック
    if(! isset($val["imgfile"])||! is_array($val["imgfile"]) ||!count($val["imgfile"])){
     $c="notice:".$mname."物件番号".$val["fld000"]."の画像リストがありません(imglistテーブル未登録)";wLog($c);
    }//if(isset($val

    //DBデータを検索対象として画像ファイルをチェック
    foreach($val["imgfile"] as $key1=>$val1){
     $flg=0;
     if(! $handle=opendir($imgpath)){
      $e="notice:".$mname."画像ディレクトリ".$imgpath."が開けません";wLog($e);
      continue;
     }//if

     while(false!==($file=readdir($handle))){
      if($file=="." || $file=="..")continue;
      if($file==$val1["fld002"]){
       //画像リスト有り、ファイルありは何もしない
       $c="notice:".$mname."DB画像リストと画像ファイル一致！画像ファイル名".$val1["fld002"];wLog($c);
       $flg=1;
       break;
      }//if
     }//while

     if(!$flg){
      //画像リスト有り、ファイルなしはDB削除
      $c="notice:".$mname."DB画像リストあり、画像ファイルなしのためDBリストを削除します。ファイル名".$val1["fld002"];wLog($c);

      $this->from=TABLE_PREFIX.IMGLIST;
      $this->where =" fld000='".$val["fld000"]."'";
      $this->where.=" and fld002='".$val1["fld002"]."'";
      $this->delete();
     }
    }//foreach($val["imgfile"
    closedir($handle);
    
    //画像ファイルを検索対象としてDBデータをチェック
    if(! $handle=opendir($imgpath)){
     $e="notice:".$mname."画像ディレクトリ".$imgpath."が開けません";wLog($e);
     continue;
    }//if($handle

    while(false!==($file=readdir($handle))){
     $flg=0;
     if($file=="." || $file=="..")continue;
     if(isset($val["imgfile"])||is_array($val["imgfile"])){
      foreach($val["imgfile"] as $key1=>$val1){
       if($file==$val1["fld002"]){
        $c="notice:".$mname."DB画像リストと画像ファイル一致！画像ファイル名".$val1["fld002"];wLog($c);
        $flg=1;
        break;
       }
      }//foreach
     }//if(isset

     if(!$flg){
      //画像リストなし、ファイルありは登録
      $c="notice:".$mname."DB画像リストなし、画像ファイルあり。DBに登録します。ファイル名".$file;wLog($c);

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
   $this->dsetGetImgList();

   $c="end:".$mname;wLog($c);
   return $this->r;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }
 
 //画像並び順セット
 public function dsetImgNum($imgid,$imgnum){
  try{
   $mname="dsetImgNum(dset.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //画像番号チェック
   if(!preg_match("/^[0-9]+$/",$imgid)){
    throw new exception("画像番号が不正です。(".$imgid.")");
   }
   
   //画像番号チェック
   if(!preg_match("/^[0-9]+$/",$imgnum)){
    throw new exception("画像表示番号が不正です。(".$imgnum.")");
   }

   $this->updatecol=array("fld001"=>$imgnum);
   $this->from=TABLE_PREFIX.IMGLIST;
   $this->where="id=".$imgid;
   $this->update();
   
   $c="end:".$mname;wLog($c);
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 //画像削除
 public function dsetDelImg($imgid=null){
  try{
   $mname="dsetDelImg(dset.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //物件データチェック
   if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
    throw new exception("物件データがありません。");
   }
   
   //画像番号チェック
   if($imgid && !preg_match("/^[0-9]+$/",$imgid)){
    throw new exception("画像番号が不正です。(".$imgid.")");
   }
   
   foreach($this->r["data"] as $key=>$val){
    $c="notice:".$mname."物件番号".$val["fld000"]."の画像削除を開始します。";wLog($c);

    $imgpath=realpath("..").IMG."/".$val["fld000"];
    if(! file_exists($imgpath)){
     $c="notice:".$mname."物件番号".$val["fld000"]."の画像ディレクトリがありません。".$imgpath;wLog($c);
     contine;
    }

    $c="notice:".$mname."削除対象ディレクトリセット:".$imgpath;wLog($c);

    if($imgid){
     $c="notice:".$mname."削除画像番号".$imgid."をセット。";wLog($c);
     
     //画像指定削除
     if(!isset($val["imgfile"])||!is_array($val["imgfile"])||!count($val["imgfile"])){
      $c="notice:".$mname."物件番号".$val["fld000"]."の画像リストがありません。処理を飛ばします。";wLog($c);
      continue;
     }//if(!isset

     foreach($val["imgfile"] as $key1=>$val1){
      if($val1["id"]==$imgid){
       $imgfile=$imgpath."/".$val1["fld002"];
       $c="notice:".$mname."指定画像削除開始(画像番号".$imgid.")".$imgfile;wLog($c);
       if(! unlink($imgfile)){
        $c="notice:dsetDelImg(DSET class)指定画像削除失敗(画像番号".$imgid.")".$imgfile;wLog($c);
       }//if(! unlink
       $c="notice:".$mname."指定画像削除成功(画像番号".$imgid.")".$imgfile;wLog($c);
       break;
      }//if($val1["id"]
     }//foreach($val["imgfile"]
    }//if($imgid
    else{
     $c="notice:".$mname."ディレクトリ内画像全削除:".$imgpath;wLog($c);
     //画像ディレクトリ内すべて削除
     if($handle=opendir($imgpath)){
      while(false!==($file=readdir($handle))){
       $c="notice:".$mname."ディレクトリ内ファイルゲット".$imgpath."/".$file;wLog($c);
       if($file=="." ||$file=="..") continue;
       $c="notice:".$mname."削除開始".$imgpath."/".$file;wLog($c);
       //ファイル削除(該当ファイルを配列へ格納）
       if(! unlink($imgpath."/".$file)){
        $c="notice:".$mname."削除失敗".$imgpath."/".$file;wLog($c);
        continue;
       }
       $c="notice:".$mname."削除成功".$imgpath."/".$file;wLog($c);
      }
     }
     else{
      $c="notice:".$mname."ディレクトリが開けません。".$imgpath;wLog($c);
     }
    }//else
   }//foreach($this->r["data"]

   
   //画像リスト再登録、再取得(DBリストあり、画像ファイルなしはこれで削除される）
   $this->dsetUpImgList();

   $c="end:".$mname;wLog($c);
   return $this->r;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }
 
 //データ削除
 public function dsetDelAll(){
  try{
   $mname="dsetDelAll(dset.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //物件データチェック
   if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
    throw new exception("物件データがありません。");
   }

   foreach($this->r["data"] as $key=>$val){
    $fld000=$val["fld000"];

    $c="notice:".$mname."Rainsデータ削除開始 物件番号(".$fld000.")";wLog($c);
    $this->from=TABLE_PREFIX.RAINS;
    $this->where="fld000='".$fld000."'";
    $this->delete();
   
    $c="notice:".$mname."LatLngデータ削除開始(".$fld000.")";wLog($c);
    $this->from=TABLE_PREFIX.LATLNG;
    $this->where="fld000='".$fld000."'";
    $this->delete();
    
   }

   $c="end:".$mname;wLog($c);
   return $this->r;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
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
  $this->from=TABLE_PREFIX.BLACKLIST." as t";
  $this->order="t.fld000";
  $this->r=array();
  $this->r["data"]=$this->getArray();

  $c="end ".$mname;wLog($c);
  return $this->r;
 }

 public function dsetUpBlackList(){
  try{
   $mname="dsetUpBlackList(DSET class)";
   $c="start ".$mname;wLog($c);

   if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
    throw new exception($mname."データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $ary=array();
    foreach($val as $key1=>$val1){
     if(!preg_match("/^fld/",$key1)) continue;
     $ary[$key1]=$val1;
    }

    $this->updatecol=$ary;
    $this->from=TABLE_PREFIX.BLACKLIST;
    $this->where="fld000='".$val["fld000"]."'";
    $this->update();
    $c=$mname."物件番号(".$val["fld000"].")をブラックリストに登録";wLog($c);
   }
   $c="end ".$mname;wLog($c);
   return $this->r;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetDelBlackList(){
  try{
   $mname="dsetDelBlackList(DSET class)";
   $c="start ".$mname;wLog($c);

   if(!is_array($this->r["data"]) ||!isset($this->r["data"])|| count($this->r["data"])==0){
    throw new exception($mname."データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $c=$mname."物件番号(".$val["fld000"].")をブラックリストから削除";wLog($c);
    $this->from=TABLE_PREFIX.BLACKLIST;
    $this->where="fld000='".$val["fld000"]."'";
    $this->delete();
   }

   $c="end ".$mname;wLog($c);
   return $this->r;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
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
  try{
   $mname="dsetDataCount(DSET class)";
   $c="start ".$mname;wLog($c);
   
   //物件データチェック
   if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
    throw new exception("物件データがありません。");
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
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }

 }

 //物件種別ごとにカウント
 public function dsetFldCount(){
  try{
  $mname="dsetFldCount(DSET class)";
  $c="start ".$mname;wLog($c);

  if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
   throw new exception("物件データがありません。");
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
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 //間取りごとにカウント
 public function dsetMadoriCount(){
  try{
   $mname="dsetMadoriCount(DSET class)";
   $c="start ".$mname;wLog($c);

   if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
    throw new exception("物件データがありません。");
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
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }
 
//間取りごとにカウント
//where句は予めセットしておく
 public function dsetMadoriCount2(){
  try{
   $mname="dsetStationCount2(DSET class)";
   $c="start ".$mname;wLog($c);
   $this->select="t.fld001,t.fld002,t.fld179,t.fld180,count(t.fld179) as cnt";
   $this->group ="t.fld001,t.fld002,t.fld180,t.fld179";
   $this->order =$this->group;
   if($this->where) $this->where.=" and ";
   $this->where.=" t1.fld000 is null";
   $this->dsetRains();
   foreach($this->r["data"] as $key=>$val){
    foreach($this->flds as $key1=>$val1){
     if($val1["fldname"]=="fld179"      &&
        $val["fld001"]==$val1["fld001"] && 
        $val["fld002"]==$val1["fld002"] &&
        $val["fld179"]==$val1["bnum"])
     {
      $val["_fld179"]=$val1["bname"];
      $this->r["data"][$key]["_fld179"]=$val1["bname"];
     }
    }
   }
   $c="end ".$mname;wLog($c);
   return $this->r;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 //最寄駅ごとにカウント
 public function dsetStationCount(){
  try{
   $mname="dsetStationCount(DSET class)";
   $c="start ".$mname;wLog($c);

   if(!isset($this->r["data"]) ||! is_array($this->r["data"]) || !count($this->r["data"])){
    throw new exception("物件データがありません。");
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
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetSubFld(){
  $this->select="*";
  $this->from=TABLE_PREFIX.FLD;
  $this->order="fldname,fld001,fld002";
  return $this->getArray();
 }

 public function dsetRank(){
  try{
   $mname="dsetRank(DSET class)";
   $c="start ".$mname;wLog($c);
   if(! $this->select)$this->select="*";
   $this->from=TABLE_PREFIX.RANK;
   $this->order="rank";
   $data=$this->getArray();
   $this->r["ranklist"]=$data;
   return $data;
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetUpRank(){
  try{
   $mname="dsetUpRank(DSET class)";
   $c="start ".$mname;wLog($c);
   
   //データチェック
   if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
    throw new exception("更新データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $this->updatecol=$val["col"];
    $this->from=$val["from"];
    $this->where=$val["where"];
    $this->update();
   }
   $c="end ".$mname;wLog($c);
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetDelRank(){
  try{
   $mname="dsetDelRank(DSET class)";
   $c="start ".$mname;wLog($c);
   //データチェック
   if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
    throw new exception("削除データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $this->from=$val["from"];
    $this->where=$val["where"];
    $this->delete();
   }
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetEntry(){
  try{
   $mname="dsetEntry(DSET class)";
   $c="start ".$mname;wLog($c);
   $this->select="t.id as entryid,t.fld000,t.fld001 as entry,t.ecomment,t.rank,t1.rankname,t1.rcomment,t1.startday,t1.endday,t2.*";
   $this->from =TABLE_PREFIX.ENTRY. " as t";
   $this->from.=" inner join ".TABLE_PREFIX.RANK." as t1 on";
   $this->from.=" t.rank=t1.rank";
   $this->from.=" inner join ".TABLE_PREFIX.RAINS." as t2 on";
   $this->from.=" t.fld000=t2.fld000";
   $this->order="t.rank,t.fld001,t.fld000";
   $c="end ".$mname;wLog($c);
   $this->r["data"]=$this->getArray();
   return $this->r["data"];
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetUpEntry(){
  try{
   $mname="dsetUpEntry(DSET class)";
   $c="start ".$mname;wLog($c);
   //データチェック
   if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
    throw new exception("更新データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $this->updatecol=$val["col"];
    $this->from=$val["from"];
    $this->where=$val["where"];
    $this->update();
   }

   $c="end ".$mname;wLog($c);
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetDelEntry(){
  try{
   $mname="dsetDelEntry(DSET class)";
   $c="start ".$mname;wLog($c);
   //データチェック
   if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
    throw new exception("削除データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $this->from=$val["from"];
    $this->where=$val["where"];
    $this->delete();
   }
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 public function dsetBcomment(){
  try{
   $mname="dsetBcomment(DSET class)";
   $c="start ".$mname;wLog($c);
   $this->select="*";
   $this->from =TABLE_PREFIX.BCOMMENT;
   $this->order="fld000";
   $c="end ".$mname;wLog($c);
   return $this->getArray();
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 //$this->r["data"]に以下の配列が格納されていることが前提
 //$this->r["data"][n]["col"]  =array("列名"=>"値");
 //$this->r["data"][n]["from"] ="テーブル名";
 //$this->r["data"][n]["where"]="where句";
 //
 // 動作テスト後、以下のメソッドを統合する
 // dsetUpRank()
 // dsetUpEntry()
 public function dsetUpdate(){
  try{
   $mname="dsetUpdate(DSET class)";
   $c="start ".$mname;wLog($c);
   //データチェック
   if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
    throw new exception("更新データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $this->updatecol=$val["col"];
    $this->from=$val["from"];
    $this->where=$val["where"];
    $this->update();
   }
   $c="end ".$mname;wLog($c);
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

 //$this->r["data"]に以下の配列が格納されていることが前提
 //$this->r["data"][n]["from"] ="テーブル名";
 //$this->r["data"][n]["where"]="where句";
 //
 // 動作テスト後、以下のメソッドを統合する
 // dsetDelRank()
 // dsetDelEntry()
 public function dsetDelete(){
  try{
   $mname="dsetDelete(DSET class)";
   $c="start ".$mname;wLog($c);
   //データチェック
   if(! isset($this->r["data"]) || ! is_array($this->r["data"]) || ! count($this->r["data"])){
    throw new exception("削除データがありません");
   }

   foreach($this->r["data"] as $key=>$val){
    $this->from=$val["from"];
    $this->where=$val["where"];
    $this->delete();
   }
  }
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }

}

?>


