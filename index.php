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


//タブ表示用
//$data=viewNewAndRank();
//partsRankTab($data);
//partsRankDiv($data);

//一覧表示
$data=viewTopData();
partsRankDiv($data,$loginflg);

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
 var topnavi=$("div.naviBar").offset()["top"];
 $(window).scroll(function(){
  if($(window).scrollTop()>topnavi){
   console.log("臨界点突破");
   console.log($(window).scrollTop());
   console.log(topnavi);
   $("div#shortNavi").slideDown();
  }
  else{
   $("div#shortNavi").slideUp();
  }
 });

 //非表示ボタン
 $("button").click(function(){ delItem($(this));});
}); 

//未使用
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

//非表示登録
function delItem(elem){
 var php="php/htmlSetBlackList.php";
 var fld000=elem.attr("data-fld000");
 var d={"fld000":fld000,"black":""};

 //物件番号チェック
 if(! fld000.match(/^[0-9]+$/)){
  alert("物件番号が数字ではありません");
  return false;
 }

 console.log(d);
 if(! confirm("非表示にしますか?")) return false;

 $.ajax({
  url:"php/htmlSetBlackList.php",
  type:"post",
  dataType:"html",
  data:d,
  async:false,
  complete:function(){},
  success:function(html){
   console.log(html);
   hideItem(elem);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

//非表示アクション
function hideItem(elem){
 var fld000=elem.attr("data-fld000");
 $("div.recomendItemList").each(function(){
  if($(this).attr("data-fld000")==fld000){
   $(this).slideUp();
  }
 });
}
 </script>
</html>
