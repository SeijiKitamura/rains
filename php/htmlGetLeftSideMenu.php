<?php
require_once("parts.function.php");
if(!$_GET["black"]){
 $where="t1.fld000 is null";
 $data=viewRainsData($where);
}
else{
 //$where="t1.fld000 is not null";
 $data=viewBlackList();
}
partsNewList($data["count"]);
partsFldCount($data["fldcount"]);
partsMadoriCount($data["madori"]);
partsStationCount($data["station"]);

?>
