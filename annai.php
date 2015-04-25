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
         <td>不動産の売買・賃貸・仲介業務<br> 生命保険・損害保険募集代理店 <br>ファイナンシャルコンサルティング<br>冠婚葬祭の企画・運営・斡旋業務 </td>
        </tr>
        
        <tr>
         <td>沿革</td>
         <td></td>
        </tr>
        <tr>
         <td>ご案内</td>
         <td>弊社は東急池上線 石川台駅から歩いて2分の立地でございます。<br>
             五反田方面からお越しのお客様は、改札を出て右へお進み頂き、一つ目の十字路を右にまっすぐです。<br>
             蒲田方面からお越しのお客様は、改札を左へ出ていただき、線路沿いの道路（坂）を下って、一つ目の十字路を左へお進み頂き、ドラックストアのある十字路を右で当店が見えます。
         </td>
        </tr>
       </tbody>
      </table>
      
      <h2>アクセスマップ</h2>
      <div class="storemap">
<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E6%9D%B1%E4%BA%AC%E9%83%BD%E5%A4%A7%E7%94%B0%E5%8C%BA%E6%9D%B1%E9%9B%AA%E8%B0%B72-11-3&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=57.64762,79.013672&amp;brcurrent=3,0x6018f549a132a4bd:0xc9ddc2808ab18d8,0,0x6018f549a5ed8139:0x4cc989f0196651d8&amp;ie=UTF8&amp;hq=&amp;hnear=%E3%80%92145-0065+%E6%9D%B1%E4%BA%AC%E9%83%BD%E5%A4%A7%E7%94%B0%E5%8C%BA%E6%9D%B1%E9%9B%AA%E8%B0%B7%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%93&amp;t=m&amp;z=14&amp;ll=35.59601,139.684441&amp;output=embed"></iframe><br /><small><a href="https://www.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E6%9D%B1%E4%BA%AC%E9%83%BD%E5%A4%A7%E7%94%B0%E5%8C%BA%E6%9D%B1%E9%9B%AA%E8%B0%B72-11-3&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=57.64762,79.013672&amp;brcurrent=3,0x6018f549a132a4bd:0xc9ddc2808ab18d8,0,0x6018f549a5ed8139:0x4cc989f0196651d8&amp;ie=UTF8&amp;hq=&amp;hnear=%E3%80%92145-0065+%E6%9D%B1%E4%BA%AC%E9%83%BD%E5%A4%A7%E7%94%B0%E5%8C%BA%E6%9D%B1%E9%9B%AA%E8%B0%B7%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%93&amp;t=m&amp;z=14&amp;ll=35.59601,139.684441" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>
      </div><!--div class="storemap"-->
      <div class="">
      </div><!--div class=""-->
      <h2>店舗外観</h2>

      <div id="stores">
       <div class="store_wrap">
        <h3>ライフパートナー</h3>
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
      
      <h2>関連事業</h2>
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
</html>


