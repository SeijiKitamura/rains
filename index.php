<?php require_once("php/html.function.php");?>
<?php
htmlHeader(CATCHWORD."-");
htmlTopImage();
?>
   <div id="contentsWrap">
    <div id="contentsMiddle">
     <div id="contents">
      <div id="article">
<?php
$data=viewNewAndRank();
partsRankTab($data);
partsRankDiv($data);
?>
      </div><!--div id="article"-->
     </div><!--div id="contents"-->
    </div><!--div id="contentsMiddle"-->
   </div><!--div id="contentsWrap"-->
   
   <div id="rightside">
   </div><!-- div id="rightside" -->

   <div id="footer">
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>

 <script>
$(function(){
 $("ul#tab_link li a").on("click",function(){
  showTab(this);
 });
}); 

function showTab(elem){
 //aクリックイベントキャンセル
 event.preventDefault();

 //クリックされたliの番号をゲット
 var index=$(elem).parent().index();

 //クラス変更およびdiv表示・非表示
 $("ul#tab_link li").each(function(i,e){
  var id=$(this).attr("id");
  if(i==index){
   $(this).find("a").addClass("current");
   $("div#"+id).show();
  }
  else{
   $(this).find("a").removeClass("current");
   $("div#"+id).hide();
  }
 });

}
 </script>
</html>
