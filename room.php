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
$description="";
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

 $description.=" ";
 $description.=$val["_fld001"]." ".$val["_fld002"]." ".$val["_fld003"]." ";
 if($val["fld021"]) $description.=$val["fld021"]." ";
 if($val["fld022"]) $description.=$val["fld022"]."号室 ";
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

}
htmlHeader($title,$description);
?>

  <div id="contentsWrap">
   <div id="contentsMiddle">
    <div id="contents">

<?php
htmlContents($data);
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
  
  //画像並べ替え
  imgSort();
  
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
 //$("img#bigimg").elevateZoom({scrollZoom:true});

 //画像スライド
 slideImg();
// $(window).on("resize load",function(){
//  console.log($(window).width());
//  var win_width=$(window).width();
//  if(win_width<640){
//   console.log("スマホ");
//   slideImg();
//  }
//  else{
//   console.log("PC");
//  // chgImg();
//  }
// });

 //画像変更
// $("div.shortphoto ul li a").click(function(){
//  var moto=$(this).find("img").attr("src");
//  $("img#bigimg").attr("src",moto);
//  $("div.zoomWindowContainer div").css("background-image","url("+moto+")");
//  return false; //リンク無効
// });
});

 </script>
</html>
