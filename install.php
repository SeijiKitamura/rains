<?php
require_once("php/import.class.php");
try{
 $db=new DB();
 //$db->CreateTable();
 $db->CreateTable(FLD);
 setCSV2DBFLD();
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
