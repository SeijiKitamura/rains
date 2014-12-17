<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="css/estate.css">
  <link rel="stylesheet" type="text/css" href="css/smartphone.css">
  <title>ライフパートナー　物件一覧</title>
 </head>
 <body>
  <ul>
   <li><a href="list.php">哲彦パターン１</a> 哲彦パターン2</li>
  </ul>
  <h3><a>ライフパートナー　物件一覧</a></h3>
<?php
require_once("./php/parts.class.php");
try{
 $db=new PARTS();
 $db->smallparts2();
 echo $db->rainsdata["smalllist"];
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
 </body>
</html>
