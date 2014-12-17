<?php
require_once("view.class.php");
if(!preg_match("/^[0-9]+$/",$_GET["bnumber"])){
 return false;
}
$db=new RAINS();
$json=$db->setImgPathWithEncode($_GET["bnumber"]);
echo json_encode($json);
?>
