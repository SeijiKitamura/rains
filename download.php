<?php
require_once("php/html.function.php");
//タイトルセット
$title="ダウンロード";
$description="解約通知書のダウンロードはこちらのページです";
htmlHeader($title,$description);
?>

  <div id="contentsWrap">
   <div id="contents_inner">
    <div id="reason_part">
     <div class="reason_box">
      <h2>ダウンロード</h2>
      <p>
        <a href="img/kaiyaku.pdf" target="_blank">解約通知書(pdf)</a>
      </p>
     </div><!--div class="reason_box"-->
     <div class="contactItemBox">
      <h4><?php echo CORPNAME;?>へのお問い合せは下記までにご連絡くださいませ。</h4>
      <p>
       <img src="img/tel.png">
       <a href="mailto:<?php echo MAILADDRESS;?>>"><img src="img/mailto.png"></a>
      </p>
     </div><!--div id="contactItemBox"-->
    </div><!--div id="reason_part"-->
   </div><!--div id="contents_inner"-->
  </div><!--div id="contentsWrap"-->

  <div id="footer">
<?php
htmlFooter();
?>
  </div><!--div id="footer"-->
 </body>

 <script>
$(function(){
 //画面追従メニュー
 navi();
 
 //ログインチェック
 if($("a#a_logout")[0]){
 }
 else{
  //ログアウト中
  $("div.loginpart").hide();
 }
 
});

 </script>
</html>

