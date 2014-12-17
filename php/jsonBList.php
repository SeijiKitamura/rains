<?php
require_once("view.class.php");
$db=new RAINS();
if($_GET["bname"]) $db->where="fld021 like '*".$_GET["bname"]."*'";
$json=$db->getRainsWithImg();
echo json_encode($json);
?>
