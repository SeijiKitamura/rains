<?php require_once("php/html.function.php");?>
<?php
htmlHeader(CATCHWORD);
htmlTopImage();
?>
   <div id="contentsWrap">
    <div id="contentsMiddle">
     <div id="contents">
      <div id="article">
<?php
//ログインチェック
session_start();
if(isset($_SESSION["USERID"]) || $_SESSION["USERID"] || $_SESSION["USERID"]==md5(USERID)){
 $loginflg=1;
}
else{
 $loginflg=0;
}

//一覧表示
$data=viewTopData();
partsRankDiv($data,$loginflg);
echo "<pre>";
print_r($data);
echo "</pre>";
?>
      </div><!--div id="article"-->
     </div><!--div id="contents"-->
    </div><!--div id="contentsMiddle"-->
   </div><!--div id="contentsWrap"-->
   
   <div id="rightside">
   </div><!-- div id="rightside" -->

   <div id="footer">
<?php
htmlFooter()
?>
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>

 <script>
$(function(){
 
 //ナビゲーション追従
 navi();
 
 //非表示ボタン
 $("button").click(function(){ delItem($(this));});

 //ランク登録
 chgRank();
 chgEntry();
}); 

 </script>
</html>
