<?php
require_once("php/import.class.php");
try{
// $db=new DB();
// $db->CreateTable();
//
// $csv=impLoadCsv(realpath(".")."/rainsfld.csv");
// $sql=impCsv2SQL(FLD,$csv);
// $db->updatearray($sql);
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
