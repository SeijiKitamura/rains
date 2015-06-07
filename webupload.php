<?php
require_once("php/html.function.php");
require_once("php/import.function.php");
session_start();
if(! isset($_SESSION["USERID"]) || $_SESSION["USERID"]==null || $_SESSION["USERID"]!==md5(USERID)){
 header("Location:login.php?nextpage=webupload.php");
}
htmlHeader("Webアップロード画面");
?>
  <div id="contentsWrap">
   <div id="contentsLeft">
<?php
$csvfile=array(RAINS,FLD,IMGLIST,RANK,ENTRY,BCOMMENT);

foreach($csvfile as $key=>$val){
 $datafile="data/".$val.".csv";
 impCsv2DBUTF($val,$datafile);
}
?>
   </div><!--div id="contentsLeft"-->
  </div><!--div id="contentsWrap"-->
 </body>
 <script>
$(function(){
 navi();
});
 </script>
</html>

