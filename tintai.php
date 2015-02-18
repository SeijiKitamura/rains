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
}
htmlHeader($title);
?>

  <div id="main">
<?php
htmlContents($data["data"]);
?>
  </div>

  <div id="footer">
<?php
htmlFooter();
echo "<pre>";
print_r($data["data"]);
echo "</pre>";
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
});
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
