<?php
require_once("db.class.php");

try{
 $db=new DB();
 $db->CreateTable();
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}

?>
