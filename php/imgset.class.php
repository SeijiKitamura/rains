<?php
require_once("view.class.php");
class IMGSET extends RAINS{

 function __construct(){
  parent::__construct();
 }
 
 public function createtest(){
  $rains=$this->getRainsWithImg();
  $this->from=TABLE_PREFIX.IMGLIST;
  $this->where="id<>0";
  $this->delete();
  foreach($rains as $key=>$val){
   for($i=0;$i<5;$i++){
    $this->updatecol=array( "fld000"=>$val["fld000"]
                           ,"fld001"=>$i
                           ,"fld002"=>$val["fld000"]."_".$i.".jpg"
                           ,"fld003"=>"テストコメント_".$i
                          );
    $this->from=TABLE_PREFIX.IMGLIST;
    $this->where="fld000='".$val["fld000"]."' and fld001=".$i;
    $this->update();
   }

  }//foreach
 }
 
 //登録済み物件一覧を表示
 public function getListImg(){
  $rains=$this->getRainsWithImg();
  if(! isset($rains)) return;

  $html="";

  foreach($rains as $key=>$val){
   if(!is_numeric($val["fld000"])) continue;
   $html.="<div class='imglist'>";
   $html.="<a href='imgset.php?bnumber=".$val["fld000"]."'>";
   //画像を表示
   foreach($val["imglist"] as $key1=>$val1){
    $html.="<img src='".IMG."/".$val1["fld002"]."'>";
    break;
   }
   $html.="<ul>";
   $html.="<li>物件番号:".$val["fld000"]."</li>";

   $html.="<li>物件名 :".$val["fld021"];
   if($val["fld022"]) $html.=$val["fld022"]."号室";
   $html.="</li>";

   $html.="<li>価格:".number_format($val["fld054"])."円</li>";
   
   $html.="<li>所在地:".$val["fld017"].$val["fld018"].$val["fld019"].$val["fld020"]."</li>";
   $html.="</ul>";
   $html.="</a>";
   $html.="</div>";//div.imglist
  }
  echo $html;
 }


 //個別物件の画像登録
 public function getListImg2($bnumber){
  $this->where="fld000='".$bnumber."'";
  $rains=$this->getRainsWithImg();
  $rains=$rains[0];
  //ここから
  $html="";
  foreach($rains["imglist"] as $key=>$val){
   $html.="<div class='divimgset'>";
   $html.="<img src='".IMG."/".$rains["fld000"]."/".$val["fld000"]."'>";
   $html.="<dl>";
   $html.="<dt>表示順:</dt>";
   $html.="<dd><input name='hyouji' type='text' value='".$val["fld001"]."'></dd>";
   $html.="<dt>撮影場所:</dt>";
   $html.="<dd><input name='imgcomment' type='text' value='".$val["fld003"]."'></dd>";
   $html.="<dt></dt>";
   $html.="<dd>";
   $html.="<input name='imgupbtn_".$val["id"]."' type='button' value='変更'>";
   $html.="<input name='imgdelbtn_".$val["id"]."' type='button' value='削除'>";
   $html.="</dd>";
   $html.="</dl>";
   $html.="</div>";//divimgset
  }//foreach($rains as $key=>$val){

  //新規用
  if(count($rains["imglist"])<10){
   for($i=count($rains["imglist"]);$i<=10;$i++){
    $html.="<div class='divimgset'>";
    $html.="<img src=''>";
    $html.="<dl>";
    $html.="<dt>表示順:</dt>";
    $html.="<dd><input name='hyouji' type='text' value='".$i."'></dd>";
    $html.="<dt>撮影場所:</dt>";
    $html.="<dd><input name='imgcomment' type='text' value=''></dd>";
    $html.="<dt></dt>";
    $html.="<dd>";
    //新規は「9999」
    $html.="<input name='imgupbtn_9999' type='button' value='追加'>";
    $html.="</dd>";
    $html.="</dl>";
    $html.="</div>";//divimgset

   }//for}
  }

  echo $html;
  echo "<pre>";
  print_r($rains);
  echo "</pre>";
 }
}
?>
