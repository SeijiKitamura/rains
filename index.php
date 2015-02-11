<?php require_once("php/html.function.php");?>
<?php
htmlHeader(CATCHWORD."-");
htmlTopImage();
?>

   <div id="leftside">
   </div><!--div id="leftside" -->
   
   <div id="main">
<?php
$rank=viewNowRank();
foreach($rank as $key=>$val){
 $data=viewEntry($val["rank"]);
 partsNowRankList($data);
}
?>
   </div><!-- div id="main" -->
   
   <div id="rightside">
   </div><!-- div id="rightside" -->

   <div id="footer">
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>
</html>
