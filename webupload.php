<?php
require_once("php/html.function.php");
require_once("php/import.function.php");
require_once("php/export.function.php");
session_start();
if(! isset($_SESSION["USERID"]) || $_SESSION["USERID"]==null || $_SESSION["USERID"]!==md5(USERID)){
 header("Location:login.php?nextpage=webupload.php");
}
htmlHeader("Webアップロード画面");
?>
  <div id="contentsWrap">
   <div id="contentsLeft">
<?php
if(LOCALMODE){
 echo "err:ローカルモードが有効のため処理を中止します";
 return false;
}

//既存データバックアップ
exportCSVAll();

$csvfile=array(RAINS,FLD,IMGLIST,RANK,ENTRY,BCOMMENT);
foreach($csvfile as $key=>$val){
 $datafile="data/".$val.".csv";
 impFile2DB($val,$datafile);
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

