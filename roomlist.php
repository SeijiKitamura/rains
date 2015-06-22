<?php require_once("php/html.function.php");
//引数フラグ
$flg=1;

//引数チェック
if(! $_GET["type"]){
 $flg=0;
}
else{
 //引数分解
 $q=preg_split("/_/",$_GET["type"]);

 //引数カウントチェック
 if(count($q)!==3){
  $flg=0;
 }

 //引数数字チェック
 foreach($q as $key=>$val){
  if(! preg_match("/^[0-9]+$/",$val)){
   $flg=0;
  }
 }

 //クエリー作成
 $query ="t.fld001='".$q[0]."'";
 if($q[1]){
  $query.=" and t.fld002='".$q[1]."'";
 }
 if($q[2]){
  $query.=" and t.fld003='".$q[2]."'";
 }
 $query.=" and t1.fld000 is null";
}


if($flg){
 //物件データ取得
 $data=viewShortData($query);
 
 //データチェック
 if(! count($data)){
  $flg=0;
 }

 //最初のデータの_fld003をタイトルにセット
 foreach($data["data"] as $key=>$val){
  $title=$val["_fld001"]." ".$val["_fld002"]." ".$val["_fld003"];
  break;
 }

 $description="";
 $description=$title;
 foreach($data["data"] as $key=>$val){
  $description.=" ";
  if($val["fld021"]) $description.=$val["fld021"]." ";
  if($val["fld022"]) $description.=$val["fld022"]."号室 ";
  $description.="(";
  $description.=$val["fld018"].$val["fld019"].$val["fld020"]." ";
  if($val["fld026"]) $description.=$val["fld026"]."駅 ";
  if($val["fld027"]) $description.="徒歩".$val["fld027"]."分 ";
  if($val["fld180"]) $description.=$val["fld180"].$val["_fld179"]." ";
  if($val["fld068"]) $description.=$val["fld068"]."m&sup2; ";
  elseif($val["fld088"]) $description.=$val["fld088"]."m&sup2; ";
  if($val["fld078"]) $description.="敷金".($val["fld078"]*1)."ヶ月 ";
  if($val["fld077"] && ! $val["fld078"]) $description.="敷金".$val["fld077"]."円 ";
  if($val["fld076"]) $description.="礼金".($val["fld076"]*1)."ヶ月";
  if($val["fld074"] && ! $val["fld076"]) $description.="礼金".$val["fld074"]."円";
  $description.=")";
 }
}

if(! $flg){
 //404ページを表示する
 $title="お探しの物件は現在表示できません";
}

htmlHeader($title,$description);
?>
   <div id="contentsWrap">
    <div id="contentsMiddle">
     <div id="contents">
      <div id="article">
<?php
//ログインチェック
session_start();
if(isset($_SESSION["USERID"]) || $_SESSION["USERID"] || $_SESSION["USERID"]==md5(USERID)){
 $loginflg=1;
}
else{
 $loginflg=0;
}

if($flg){
 //物件データを分解
 $d=array();
 foreach($data["data"] as $key=>$val){
  if($val["fld001"]=="1"){
   $d["baibai"][]=$val;
  }
  elseif($val["fld001"]=="3"){
   $d["tintai"][]=$val;
  }
 }
 partsRankDiv($d,$loginflg);
}
?>
      </div><!--div id="article"-->
     </div><!--div id="contents"-->
    </div><!--div id="contentsMiddle"-->
   </div><!--div id="contentsWrap"-->
   <div id="footer">
<?php
htmlFooter()
?>
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>
 <script>
$(function(){
 navi();
  
 //ログインチェック
 if($("a#a_logout")[0]){
  //ログイン中
  //非表示ボタンイベント
  $("button#delitem").click(function(){delItemRoom();});
  
  //画像追加イベント
  $("button#addphoto").click(function(){
    $("input[name=uploadimg]").trigger("click");
  });

  $("input[name=uploadimg]").on("change",function(){
   uploadImg(this);
  });
  
  //非表示ボタン
  $("button").click(function(){ delItem($(this));});

  //ランク登録
  chgRank();
  chgEntry();

 }
});
 </script>
</html>

