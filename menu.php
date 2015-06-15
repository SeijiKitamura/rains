<?php
require_once("php/html.function.php");
session_start();
if(! isset($_SESSION["USERID"]) || $_SESSION["USERID"]==null || $_SESSION["USERID"]!==md5(USERID)){
 header("Location:login.php");
}
htmlHeader("メニュー");
?>

  <div id="contentsWrap">
   <div id="contentsLeft">
    <ul id="leftMenu">
     <li id="csvupload">CSVアップロード</li>
     <li id="hreset">表示リセット</li>
     <li id="hhreset">非表示リセット</li>
     <li id="kanren">関連データ</li>
     <li id="rank">ランキング</li>
     <li id="allreset">初期化</li>
     <li id="exportCSV">エクスポート</li>
    </ul>
    <input type="file" multiple="multiple" name="csvdata" style="display:none;">
    <input type="file" multiple="multiple" name="flddata" style="display:none;">
    </div><!--div id="contentsLeft"-->
    <div class="clr"></div>
    <div id="contentsMiddle">
     <div id="contents">
     </div><!--div id="contents"-->
    </div><!--div id="contentsMiddle"-->
   </div><!--div id="contentsLeft"-->
  </div><!--div id="contentsWrap"-->

<?php
//htmlFooter()
?>
  </div><!--div id="wrap"-->
 </div><!--div id="body"-->
 <script>
$(function(){
 navi();
// subListEvent();
 showCSVUp();
 uploadCSV();
 resetHyouji();
 resetHihyouji();
 //showData();
 showFldData();
 showRankList();
 showWebUpload();
 resetAll();
 exportCSV();
});



 </script>
</html>
