<?php require_once("php/html.function.php");?>

<?php
$flg=1;

//引数チェック
if(! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 $flg=0;
}

//データ存在チェック
if($flg){
 $where="t.fld000='".$_GET["fld000"]."'";
 $data=viewRainsData($where);
 if(! count($data["data"])){
  $flg=0;
 }
}

//タイトルセット
if($flg){
 $estate=$data["data"][0];
 
 //建物名もしくは住所を表示
 if($estate["fld021"]){
  $title=$estate["fld021"]." ".$estate["fld022"];
 }
 else{
  $title=$estate["fld018"];
 }

 //間取り数を表示
 if($estate["fld180"]){
  $title.=" ".$estate["fld180"].$estate["_fld179"];
 }

 //広さを表示
 if($estate["fld068"]){
  $title.=" (".$estate["fld068"]."m&#178)";
 }

 //金額を表示
 $title.=" ".number_format($estate["fld054"])."円";

}

if(! $flg){
 $title="申し訳ございません。お探しの物件は現在お取り扱いがございません";
}
htmlHeader($title);
//echo $title;
//print_r($estate);
?>
   <div id="leftside">
<?php
if($flg){
 partsFldCount($data["fldcount"]);
}
?>
   </div>
   
   <div id="main">
<?php
$html.="<h1>".$title."</h1>";
$html.="<p>".$estate["bcomment"]."</p>";
echo $html;
if(!$flg){
 goto LABEL1;
}
partsEstateImage($data["data"]);
?>

   <div class="detail">
<?php
partsIndivi($data["data"]);
partsPrice($data["data"]);
partsRoomType($data["data"]);

LABEL1:
?>
    </div><!--div class="detail"-->
    <div id="map-canvas">
    </div><!--div id="map-canvas"-->
   </div><!-- div id="main" -->
  </div><!-- div id="wrap"-->
 </body>
 <script>
$(function(){
 initialize();
 calcRoute();
});
 </script>
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
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
  var start =new google.maps.LatLng($("dd#startpoint").attr("data-lat"),$("dd#startpoint").attr("data-lng"));
  var end =new google.maps.LatLng($("dd#endpoint").attr("data-lat"),$("dd#endpoint").attr("data-lng"));
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

