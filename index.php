<?php
require_once("php/parts.class.php");
?>
<?php
$db=new PARTS();
//Headerをゲット
$db->getHeader();
echo $db->rainsdata["header"];
?>
  <div id="topbanner">
   <div class="divimg">
    <img src="img/00053.JPG">
   </div>
   <p id="overimg">ご希望の不動産全力でお探しいたします。</p>
   <p id="comment1">物件をお探しのお客様はこちらからどうぞ↓</p>
   <ul class="ulbignavi">
    <li><a href="#">賃 貸</a></li>
    <li><a href="#">売 買</a></li>
    <li><a href="#">事業用</a></li>
   </ul>
   <div class="clr"></div>
   <hr>
  </div>
  <div class="clr"></div>
  <div class="newtintai">
<?php
$db->smallparts();
?>
  </div>
  <ul>
   <li><a href="list.php">一覧(お客様用)</a></li>
   <li><a href="uploadrains.php">データ更新</a></li>
  </ul>
 </body>
</html>
