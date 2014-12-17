<?php
require_once("parts.function.php");

$data=preg_split("/,/",$_POST["fld000"]);

if(! $_POST["black"]){
 foreach($data as $key=>$val){
  echo "white";
  viewSetBlackList($val);
 }
}
else{
 foreach($data as $key=>$val){
  echo "black";
  viewDelBlackList($val);
 }
}
?>
