<?php
require_once("parts.function.php");

//物件番号がなければエラー
if(! $_POST["fld000"] || ! preg_match("/^[0-9]+$/",$_POST["fld000"])){
 echo "物件番号を確認してください(".$_POST["fld000"].")";
 return false;
}

$data=array( "fld000"=>$_POST["fld000"],
             "fld001"=>$_POST["fld001"],         
             "fld002"=>$_POST["fld002"],         
             "fld003"=>$_POST["fld003"],         
             "fld004"=>$_POST["fld004"],         
             "fld005"=>$_POST["fld005"]);         


viewSetBcomment($data);

echo "コメント更新成功";
?>
