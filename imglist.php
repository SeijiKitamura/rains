<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="css/all.css">
  <link rel="stylesheet" type="text/css" href="css/detail.css">
  <link rel="stylesheet" type="text/css" href="css/smartdetail.css">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="js/bxslider/jquery.bxslider.min.js"></script>
  <link  href="js/bxslider/jquery.bxslider.css" rel="stylesheet">
 </head>
 <body>
<?php
require_once("php/imgset.class.php");
try{
$db=new IMGSET();
$db->createtest();
$db->getListImg();
echo "success";
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
 </body>
 <script>
 $(function(){
 });

 </script>
</html>
