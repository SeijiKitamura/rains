<?php
require_once("php/html.function.php");
htmlHeader("インタビュー");
?>
   <div id="contents_wrap">
    <div id="contents_inner">
     <div id="divintvw">

      <!--トップイメージ-->
      <div class="intvwTopImage">
       <img src="">
      </div><!--div class="intvwTopImage"-->
 
      <h2>にインタビューしました。</h2>

      <!-- 写真左のひな形 -->
      <div class="intvwpart">

       <div class="Ldivintvwimg">
        <img src="">
       </div><!--div class="Ldivintvwimg"-->

       <div class="Linner-part">
       </div><!--div class="Linner-part"-->

       <h3>質問事項</h3>
       <p>
          回答
       </p>

      </div><!--div class="intvwpart"-->

      <!-- 写真右のひな形 -->
      <div class="intvwpart">

       <div class="Rdivintvwimg">
        <img src="">
       </div><!--div class="Rdivintvwimg"-->

       <div class="Rinner-part">
       </div><!--div class="Rinner-part"-->

       <h3>質問事項</h3>
       <p>
          回答
       </p>

      </div><!--div class="intvwpart"-->

      <div class="contactItemBox">
      <h4><?php echo CORPNAME;?>へのお問い合せは下記までにご連絡くださいませ。</h4>
       <p>
        <img src="img/tel.png">
        <a href="mailto:<?php echo MAILADDRESS;?>>"><img src="img/mailto.png"></a>
       </p>
      </div><!--div id="contactItemBox"-->

     </div><!--div id="divannai"-->
    </div><!--div id="contents_inner"-->
   </div><!--div id="contents_wrap"-->

   <div id="footer">
<?php
htmlFooter();
?>
   </div><!-- div id="footer" -->
  </div><!-- div id="wrap" -->
 </body>
 <script>
$(function(){
 navi();
});
 </script>
</html>



