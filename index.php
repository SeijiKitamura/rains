<?php require_once("php/html.function.php");?>
<?php
htmlHeader($NAVIARY["index.php"]["title"]);
htmlTopImage();
?>

   <div id="leftside">
   </div><!--div id="leftside" -->
   
   <div id="main">
<?php
$data=viewEntry(1);
if(is_array($data)){
 partsEstateList($data);
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
