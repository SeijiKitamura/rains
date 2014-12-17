<?php
require_once("parts.function.php");
//$order="fld001,fld002,fld003,fld017,fld018,fld019,fld068,fld088,fld054";
$data=viewRainsData("",$order);
partsRainsTable($data["data"]);
?>
