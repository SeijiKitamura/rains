<?php
require_once("php/html.function.php");
htmlHeader("会社概要");
?>
   <div id="contents_wrap">
    <div id="contents_inner">
     <div id="divannai">
      <h2>会社概要</h2>
      <table class="itemTable">
       <colgroup span="1" style="width:100px;">
       <tbody>
        <tr>
         <td>商号</td>
         <td><?php echo CORPNAME;?></td>
        </tr>

        <tr>
         <td>代表取締役</td>
         <td><?php echo PRESIDENT;?></td>
        </tr>
        
        <tr>
         <td>本社所在地</td>
         <td><?php echo CORPADDRESS;?></td>
        </tr>

        <tr>
        <td>電話番号</td>
        <td><?php echo CORPTEL;?></td>
        </tr>

        <tr>
         <td>FAX</td>
         <td><?php echo CORPFAX;?></td>
        </tr>

        <tr>
         <td>営業時間</td>
         <td><?php echo EIGYOJIKAN;?></td>
        </tr>

        <tr>
         <td>定休日</td>
         <td><?php echo TEIKYUBI;?></td>
        </tr>
 
        <tr>        
         <td>免許番号</td>
         <td><?php echo LICENSE;?></td>
        </tr>

        <tr>        
         <td>事業内容</td>
         <td><?php echo JIGYO;?></td>
        </tr>
        
        <tr>
         <td>沿革</td>
         <td><?php echo ENKAKU;?></td>
        </tr>
       </tbody>
      </table>
      
      <h2>アクセスマップ</h2>
      <div class="storemap">
       <?php echo GMAP;?>
      </div><!--div class="storemap"-->
      <div class="">
      </div><!--div class=""-->
      <h2>店舗外観</h2>

      <div id="stores">
       <div class="store_wrap">
       <h3><?php echo CORPNAME;?></h3>
        <p><img src="img/store.jpg"></p>
        <table>
         <colgroup span="1" style="width:100px;">
         <tbody>
          <tr>
           <td>住所</td>
           <td><?php echo CORPADDRESS;?></td>
          </tr>

          <tr>
          <td>電話番号</td>
          <td><?php echo CORPTEL;?></td>
          </tr>

          <tr>
           <td>FAX</td>
           <td><?php echo CORPFAX;?></td>
          </tr>

          <tr>
           <td>営業時間</td>
           <td><?php echo EIGYOJIKAN;?></td>
          </tr>

          <tr>
           <td>定休日</td>
           <td><?php echo TEIKYUBI;?></td>
          </tr>
         </tbody>
        </table>
        <div class="clr"></div>
       </div><!--div class="store_wrap"-->
      </div><!--div id="stores"-->
      
      <h2>リンク</h2>
      <div id="links">
       <div class="links_wrap">
        <p><a href=""><img src=""></a></p>
        <p><a href=""><img src=""></a></p>
        <div class="clr"></div>
       </div><!--div class="links_wrap"-->
      </div><!--div id="links"-->

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


