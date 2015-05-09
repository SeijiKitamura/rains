<?php
require_once("php/html.function.php");
htmlHeader("不動産のQ&A");
?>
   <div id="topImage">
    <div class="imageSpace">
    </div>
   </div>
   <div id="contents_wrap">
    <div id="contents_inner">
     <div id="reason_part">
      <div class="contactItemBox">
      <h4><?php echo CORPNAME;?>へのお問い合せは下記までにご連絡くださいませ。</h4>
       <p>
        <img src="img/tel.png">
        <a href="mailto:<?php echo MAILADDRESS;?>>"><img src="img/mailto.png"></a>
       </p>
      </div><!--div id="contactItemBox"-->
     </div><!--div id="reason_part"-->
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


