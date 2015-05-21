<?php
require_once("php/import.class.php");
try{
// $db=new DB();
// $db->CreateTable();
//
 $csvpath=realpath(".")."/data/rainsfld.csv";
 $csv=impLoadCsv($csvpath);
 echo "<pre>";
 print_r($csv);
 echo "</pre>";
 return;
 $sql=impCsv2SQL(FLD,$csv);
 echo "<pre>";
 print_r($sql);
 echo "</pre>";
 //$db->updatearray($sql);
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
