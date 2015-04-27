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
  $title=$val["_fld003"];
  break;
 }
}

if(! $flg){
 //404ページを表示する
 $title="お探しの物件は現在表示できません";
}

htmlHeader($title);
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
  if($val["fld001"]=="01"){
   $d["baibai"][]=$val;
  }
  elseif($val["fld001"]=="03"){
   $d["tintai"][]=$val;
  }
 }
 partsRankDiv($d,$loginflg);
}
echo "<pre>";
print_r($d);
echo "</pre>";
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

  //ランク登録
  chgRank();
  chgEntry();

 }
});
 </script>
</html>

