<?php
require_once("php/parts.class.php");
try{
 $db=new PARTS();
 echo $db->getHeader();

}
catch(Exception $e){
 echo "err:".$e->getMessage();
}
?>
