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

  <div id="main">
<?php
htmlContents($data);
?>
  </div>

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
 var topnavi=$("div.naviBar").offset()["top"];
 $(window).scroll(function(){
  if($(window).scrollTop()>topnavi){
   console.log("臨界点突破");
   console.log($(window).scrollTop());
   console.log(topnavi);
   $("div#shortNavi").slideDown();
  }
  else{
   $("div#shortNavi").slideUp();
  }
 });

 //ログインチェック
 if($("a#a_logout")[0]){
  //非表示
  $("button#delitem").click(function(){delItem();});
  
  //画像追加(ここから)
  $("button#addphoto").click(function(){
    $("input[name=uploadimg]").trigger("click");
  });

  $("input[name=uploadimg]").on("change",function(){
   uploadImg(this);
  });
  
  //画像全削除
  $("button#delAll").click(function(){
   var fld000=$("div.loginpart").attr("data-fld000");
   deleteImg(fld000,null);
  });
  //外部画像
  $("button#outsideImage").click(function(){listImgPathFromSite();});
  
  //画像一覧
  showImage();
 }
 else{
  //ログアウト
  $("div.loginpart").hide();
 }

 //画像拡大
 $("img#bigimg").elevateZoom({scrollZoom:true});

 //画像変更
 $("div.shortphoto ul li a").click(function(){
  var moto=$(this).find("img").attr("src");
  $("img#bigimg").attr("src",moto);
  $("div.zoomWindowContainer div").css("background-image","url("+moto+")");
  return false; //リンク無効
 });
});

//画像追加
function uploadImg(elem){
 $.each(elem.files,function(i,file){
  console.log(elem);
  var fld000=$(elem).attr("data-fld000");
  var formData=new FormData();
  formData.append("allupimg",file);
  formData.append("fld000",fld000);
  //ファイル送信
  $.ajax({
    url: 'php/htmlSetImgFile.php',
    type: 'post',
    async:false,
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'html',
    complete: function(){},
    success: function(html) {
     //showImage(fld000);
     showImage();
    },
    error:function(XMLHttpRequest,textStatus,errorThrown){
     console.log(XMLHttpRequest.responseText);
    }
  });
 });
}



//非表示登録
function delItem(){
 var php="php/htmlSetBlackList.php";
 var fld000=$("div.loginpart").attr("data-fld000");
 var d={"fld000":fld000,"black":""};

 //物件番号チェック
 if(! fld000.match(/^[0-9]+$/)){
  alert("物件番号が数字ではありません");
  return false;
 }

 console.log(d);
 if(! confirm("非表示にしますか?")) return false;

 $.ajax({
  url:"php/htmlSetBlackList.php",
  type:"post",
  dataType:"html",
  data:d,
  async:false,
  complete:function(){},
  success:function(html){
   console.log(html);
   alert("非表示に登録しました");
   window.location.href="index.php";
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}


//画像一覧表示
function showImage(){
 var fld000=$("div.loginpart").attr("data-fld000");
 var d={"fld000":fld000};
 $.ajax({
  url: 'php/htmlGetImgList.php',
  type: 'get',
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   console.log(html);
   //画像追加
   $("div.imgpart").empty()
                   .append(html);

   //番号変更イベント
   $("div.imgpart ul.ul_image li input[type=text]").on("change",function(){
    console.log($(this));
    var fld000=$(this).attr("data-fld000");
    var imgid=$(this).attr("data-imgid");
    var imgnum=$(this).val();
    if(! imgnum.match(/^[0-9]+$/)){
     alert("数字を入力してください");
     return false;
    }
    changeImgNum(fld000,imgid,imgnum);
   });
   
   //削除ボタンイベント
   $("div.imgpart ul.ul_image li input[type=button]").on("click",function(){
    var fld000=$(this).attr("data-fld000");
    var imgid=$(this).attr("data-imgid");
    deleteImg(fld000,imgid);
   });
   
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

//画像番号変更
function changeImgNum(fld000,imgid,imgnum){
 var d={"fld000":fld000,"imgid":imgid,"imgnum":imgnum};
 $.ajax({
  url: 'php/htmlSetImgNum.php',
  type: 'get',
  async:false,
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   //showImage(fld000);
   showImage();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

//画像削除
function deleteImg(fld000,imgid){
 if(imgid){
  if(! confirm("この画像を削除しますか?")) return false;
 }
 else{
  if(! confirm("全画像を削除しますか?")) return false;
 }

 var d={"fld000":fld000,"imgid":imgid};
 $.ajax({
  url: 'php/htmlDelImgNum.php',
  type: 'get',
  async:false,
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   //showImage(fld000);
   showImage();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

//外部URL画像取り込み
function listImgPathFromSite(){
 var outsiteUrl=$("input[name=outsiteurl]").val();
 var datafld000=$("div.loginpart").attr("data-fld000");

 if(! outsiteUrl) return false;

 var d={"imgurl":outsiteUrl,
        "fld000":datafld000};

 $.ajax({
  url:"php/htmlSetImgFileFromSite2.php",
  type:"get",
  data:d,
  dataType:"html",
  beforeSend:function(){
   $("div.msgpart").empty().append("ダウンロード中・・・");
  },
  success:function(html){
   console.log(html);
   showImage();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgpart").text(XMLHttpRequest.responseText);
   return false;
  },
  complete:function(){
   $("div.msgpart").empty();
  }
 });
}

 </script>

 <script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(35.5839676,139.71252230000005);
  var mapOptions = {
    zoom:14,
    center: chicago
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start =new google.maps.LatLng($("span#startpoint").attr("data-lat"),$("span#startpoint").attr("data-lng"));
  var end =new google.maps.LatLng($("span#endpoint").attr("data-lat"),$("span#endpoint").attr("data-lng"));
  var request = {
      origin:start,
      destination:end,
      travelMode: google.maps.TravelMode.WALKING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
}

//google.maps.event.addDomListener(window, 'load', initialize);
 </script>

</html>
