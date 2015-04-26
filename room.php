<?php
require_once("php/html.function.php");
$flg=1;

//引数チェック
if(! $_GET["fld000"] ||! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $flg=0;
}

//物件存在チェック
if($flg==1){
 $where="t.fld000='".$_GET["fld000"]."' and t1.fld000 is null ";
 $data=viewRainsData($where);
 if(! count($data["data"])){
  $flg=0;
 }
}

//タイトルセット
$title="";
if($flg==0){
 $title="お探しの物件は現在ご紹介できません";
}
else{
 foreach($data["data"] as $key=>$val){
  if($val["fld021"]) $title =$val["fld021"];
  if($val["fld022"]) $title.=$val["fld022"]."号室";
  if(!$title) $title=$val["fld019"];
 }
 $data["brother"]=viewBrother($_GET["fld000"]);
}
htmlHeader($title);
?>

  <div id="contentsWrap">
   <div id="contentsMiddle">
    <div id="contents">

<?php
htmlContents($data);
echo "<pre>";
print_r($data);
echo "</pre>";
?>
    </div><!--div id="contents"-->
   </div><!--div id="contentsMiddle"-->
  </div><!--div id="contentsWrap"-->

  <div id="footer">
<?php
htmlFooter();
?>
  </div><!--div id="footer"-->
 </body>

 <script>
$(function(){
 //画像がなければ非表示
 if(! $("div.bigphoto a img").attr("src")){
  $("div#roomPhotoAlbum").hide();
 }

 //位置情報がなければ非表示
 if(! $("span#startpoint").attr("data-lat")|| !$("span#startpoint").attr("data-lng")){
  $("h3#instMap").hide();
  $("div#map-canvas").hide();
 }
 else{
  initialize();
  calcRoute();
 }

 //画面追従メニュー
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
  
  //画像全削除イベント
  delAllImg();

  //外部画像イベント
  $("button#outsideImage").click(function(){listImgPathFromSite();});
  
  //チェック残すイベント
  checkIn();

  //チェック削除イベント
  checkOut();
  
  //画像一覧イベント
  showImage();

  //コメントイベント
  chgComment();

  
 }
 else{
  //ログアウト中
  $("div.loginpart").hide();
 }

 //画像拡大
 $("img#bigimg").elevateZoom({scrollZoom:true});

 chgImg();
// //画像変更
// $("div.shortphoto ul li a").click(function(){
//  var moto=$(this).find("img").attr("src");
//  $("img#bigimg").attr("src",moto);
//  $("div.zoomWindowContainer div").css("background-image","url("+moto+")");
//  return false; //リンク無効
// });
});

 </script>
</html>
