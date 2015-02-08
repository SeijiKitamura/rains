<?php require_once("php/html.function.php");?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>Rainsデータ更新</title>
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="css/all.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="js/bxslider/jquery.bxslider.min.js"></script>
  <link  href="js/bxslider/jquery.bxslider.css" rel="stylesheet">
 </head>
 <body>
  <div id="wrap">

   <div id="header">

    <hr>

    <div class="logoSpace">
     <p>地域の不動産、お任せください</p>
     <?php htmlLogo(); ?>
    </div><!-- div class="logoSpace" -->
    
    <div class="eventSpace">
    </div><!-- div class="eventSpace" -->

    <div class="storeInfo">
     <ul>
      <li><?php echo CORPNAME; ?></li>
      <li><?php echo CORPADDRESS; ?></li>
      <li>TEL:<span class="tel"><?php echo CORPTEL; ?></span><li>
      <li>FAX:<?php echo CORPFAX; ?></li>
     </ul>
    </div><!-- div class="storeinfo" -->
   
    <div class="clr"></div>
    <hr>

    <div class="naviBar">
     <ul>
      <li><a href="index.php">ホーム</a></li>
      <li><a href="#">賃貸</a></li>
      <li><a href="#">売買</a></li>
      <li><a href="#">事業用</a></li>
      <li><a href="#">Q&A</a></li>
      <li><a href="#">家主様</a></li>
      <li><a href="#">会社案内</a></li>
      <li><a href="#">お問い合せ</a></li>
     </ul>
     <div class="clr"></div>
    </div><!-- div class="naviBar" -->



    <div class="imageSpace">
     <img src="./img/00053.JPG">
    </div><!-- div class="imageSpace" -->

    <div class="commentSpace">
     <p>物件をお探しの方、こちらからどうぞ！</p>

     <div class="bigNavi">
      <ul>
       <li><a href="#">賃貸</a></li>
       <li><a href="#">売買</a></li>
       <li><a href="#">事業用</a></li>
      </ul>
      <div class="clr"></div>
     </div><!-- div class="Bignavi" -->

    </div><!-- div class="commentSpace" -->

    <div class="clr"></div>

    <hr>
    
   </div><!--div id="header" -->

   <div id="leftside">
   </div><!--div id="leftside" -->
   
   <div id="main">
<?php
$data=viewEntry(1);
partsEstateList($data);
partsEstateList($data);

echo "<pre>";
print_r($data);
echo "</pre>";
?>
   </div><!-- div id="main" -->
   
   <div id="rightside">
   </div><!-- div id="rightside" -->

   <div id="footer">
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>
</html>
