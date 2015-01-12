<?php
require_once("parts.function.php");

//物件番号がなければエラー
if(! $_GET["fld000"] || ! preg_match("/^[0-9]+$/",$_GET["fld000"])){
 echo "物件番号を確認してください(".$_GET["fld000"].")";
 return false;
}

$data=array( "fld000"=>$_GET["fld000"],
             "fld001"=>$_GET["fld001"],         
             "fld002"=>$_GET["fld002"],         
             "fld003"=>$_GET["fld003"],         
             "fld004"=>$_GET["fld004"],         
             "fld005"=>$_GET["fld005"]);         


viewSetBcomment($data);

echo "コメント更新成功";
?>
