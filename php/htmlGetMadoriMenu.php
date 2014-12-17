<?php
require_once("parts.function.php");

if($_GET["fld001"] &&! $_GET["fld002"] && ! $_GET["fld003"]){
 $where="t.fld001='".$_GET["fld001"]."'";
}

if($_GET["fld001"] && $_GET["fld002"] && ! $_GET["fld003"]){
 $where="t.fld001='".$_GET["fld001"]."' and t.fld002='".$_GET["fld002"]."'";
}

if($_GET["fld001"] && $_GET["fld002"] && $_GET["fld003"]){
 $where="t.fld001='".$_GET["fld001"]."' and t.fld002='".$_GET["fld002"]."'";
 $where.=" and t.fld003='".$_GET["fld003"]."'";
}

if(! $_GET["black"]){
 $where.=" and t1.fld000 is null ";
 $data=viewRainsData($where);
}
else{
// $where.=" and t1.fld000 is not null ";
 $data=viewBlackList($where);
}
partsMadoriCount($data["madori"]);

?>
