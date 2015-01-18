<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>Rainsインストール</title>
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="css/all.css">
  <link rel="stylesheet" type="text/css" href="css/upload.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="js/bxslider/jquery.bxslider.min.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <link  href="js/bxslider/jquery.bxslider.css" rel="stylesheet">
 </head>
 <body>
  <div id="wrapper">
   <div id="leftside">
   </div><!-- leftside -->
   <div id="main">
<?php
require_once("php/import.function.php");
try{
 $db=new DB();
 $db->CreateTable();

 $csv=impLoadCsv(realpath(".")."/rainsfld.csv");
 $sql=impCsv2SQL(FLD,$csv);
 $db->updatearray($sql);
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
   </div><!-- main -->
  </div><!-- wrapper -->
 </body>
 <script>
 </script>
</html>
