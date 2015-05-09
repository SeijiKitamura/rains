<?php
require_once("php/html.function.php");

//物件存在チェック
$where="t.fld000='".$_GET["fld000"]."' and t1.fld000 is null ";
$data=viewRainsData($where);
htmlContents($data);
echo "success";
?>
