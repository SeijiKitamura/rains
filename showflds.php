<?php
require_once("php/dset.class.php");
try{
 $db=new DSET();
 echo $db->dsetRainsSubData("fld001",null,null,"01");
 echo "<pre>";
 print_r($db->flds);
 echo "</pre>";
}
catch(Exception $e){
 echo "err:".$e->getMessage();
}


?>
