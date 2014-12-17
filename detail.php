<?php
require_once("php/parts.class.php");
$bnumber=$_GET["fld000"];

$db=new PARTS();
$db->getData($bnumber);

$db->getTitle();

$db->getH1();

$db->getBpart();

$db->getTpart();

$db->getSpart();

$db->getEyeCatch();

$db->getImgPart();

$db->getRoot();
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
<?php echo $db->rainsdata["title"]; ?>
  <link rel="stylesheet" type="text/css" href="css/all.css">
  <link rel="stylesheet" type="text/css" href="css/detail.css">
  <link rel="stylesheet" type="text/css" href="css/smartdetail.css">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="js/bxslider/jquery.bxslider.min.js"></script>
  <link  href="js/bxslider/jquery.bxslider.css" rel="stylesheet">
 </head>
 <body>
  <div class="wrapper">
   <div class="titlepart">
<?php //echo $db->rainsdata["h1"]; ?>
<?php echo $db->rainsdata["eyecatch"]; ?>
   </div><!-- titlepart -->
<?php echo $db->rainsdata["imgpart"]; ?>
    <div class="divdetail">
<?php echo $db->rainsdata["bpart"]; ?>
<?php echo $db->rainsdata["tpart"]; ?>
<?php echo $db->rainsdata["spart"]; ?>
    <div class="clr"></div>
   </div><!-- divdetail -->
<?php echo $db->rainsdata["googlemap"]; ?>
  </div><!-- wrapper -->

 </body>
 <script>
 $(function(){
  //画像スライド
  $(".bxslider").bxSlider(
   {adaptiveHeight: true
   }
   );
   
   //GoogleMap Root表示
   initialize();
   calcRoute();
 });

 </script>
</html>
