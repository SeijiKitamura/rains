<?php
require_once("view.class.php");
try{
 $db=new RAINS();
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
