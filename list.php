<?php
require_once("php/parts.class.php");
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
  <title><?php echo CORPNAME;?>　物件一覧</title>
  <link rel="stylesheet" type="text/css" href="css/all.css">
  <link rel="stylesheet" type="text/css" href="css/list.css">
  <link rel="stylesheet" type="text/css" href="css/smartlist.css">
  <style>
  </style>
 </head>
 <body>
  <header>
   <hr>
   <p><?php echo CATCHWORD;?></p>
   <img id="logo" src="<?php echo LOGO;?>" alt="<?php echo CORPNAME;?>のロゴマーク">
   <dl class="telfax">
    <dt class="dt_tel">TEL</dt><dd class="dd_tel"><?php echo CORPTEL;?></dd>
    <dt class="dt_fax">FAX</dt><dd class="dd_fax"><?php echo CORPFAX;?></dd>
   </dl>
   <div class="clr"></div>
   <hr>
  </header>
<?php
require_once("./php/parts.class.php");
try{
 $db=new PARTS();
 $db->smallparts();
 echo $db->rainsdata["smalllist"];
}
catch(Exception $e){
 echo $e->getMessage();
}
?>
 </body>
</html>
