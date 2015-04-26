<?php require_once("php/html.function.php");
htmlHeader("物件リスト");
?>
   <div id="contentsWrap">
    <div id="contentsMiddle">
     <div id="contents">
      <div id="article">
<?php
$data["baibai"]=viewSaleList();
partsRankDiv($data);
echo "<pre>";
print_r($data);
echo "</pre>";
?>
      </div><!--div id="article"-->
     </div><!--div id="contents"-->
    </div><!--div id="contentsMiddle"-->
   </div><!--div id="contentsWrap"-->
   <div id="footer">
<?php
htmlFooter()
?>
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>
</html>

