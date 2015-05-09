<?php
require_once("php/html.function.php");
htmlHeader($NAVIARY["baibai.php"]["title"]);

$where="t1.fld001 is null and t.fld001='01' and t.fld002<>'04'";
$data=viewRainsData($where);
?>
   <div id="leftside">
<?php
partsFldCount($data["fldcount"]);
//partsMadoriCount($data["madori"]);
//partsStationCount($data["station"]);
?>
   </div><!--div id="leftside" -->
   
   <div id="main">
    <p>左の物件種類からご希望の物件をクリックしてください</p>
<?php
//新着データ表示
$newdata=array();
foreach($data["data"] as $key=>$val){
 if($key>RANKLIMIT) break;
 if(strtotime($val["idate"])>strtotime(NEWLIST)){
  $val["rank"]=1;
  $val["rankname"]="新着情報";
  $newdata[]=$val;
 }
}

if(isset($newdata) && is_array($newdata) && count($newdata)>0){
 partsNowRankList($newdata);
}
?>
   </div><!-- div id="main" -->
   
   <div id="rightside">
   </div><!-- div id="rightside" -->

   <div id="footer">
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>
 <script>
$(function(){
 $("li.fld003").on("click",function(){
  fld001($(this).attr("data-fld001"));
  fld002($(this).attr("data-fld002"));
  fld003($(this).attr("data-fld003"));
  fld179("reset");
  fld180("reset");
  showEstateList($(this));
  showMadori($(this));
 });
});

var fld001=setField();
var fld002=setField();
var fld003=setField();
var fld179=setField();
var fld180=setField();
  
function showEstateList(){
 var d={"fld001":fld001(),"fld002":fld002(),"fld003":fld003(),"fld179":fld179(),"fld180":fld180()};
 $("div#main").empty();

 $.ajax({
  url:"php/htmlGetEstateList.php",
  type:"get",
  dataType:"html",
  data:d,
  complete:function(){},
  success:function(html){
   $("div#main").append(html);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

function showMadori(elem){
 console.log(elem);
 fld001(elem.attr("data-fld001"));
 fld002(elem.attr("data-fld002"));
 fld003(elem.attr("data-fld003"));
 var d={"fld001":fld001(),"fld002":fld002(),"fld003":fld003()};

 $.ajax({
  url:"php/htmlGetMadoriMenu.php",
  type:"get",
  data:d,
  dataType:"html",
  success:function(html){
   $("h4").each(function(){
    if($(this).text()=="間取り"){
     $(this).remove();
    }
   });
   $("ul#ul_madori").remove();
   $("div#leftside").append(html);
   
   //間取りイベント
   $("li.fld180").on("click",function(){
    fld179($(this).attr("data-fld179"));  
    fld180($(this).attr("data-fld180"));  
    showEstateList();
   });
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

function setField(){
 var val1;
 return function(fldval){
  if(fldval){
   if(fldval=="reset") val1="";
   else val1=fldval;
  }
  return val1;
 }
}
 </script>
</html>


