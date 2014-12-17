<?php
require_once("parts.function.php");
//画像をディレクトリへセット
partsSetImg($_FILES,$_POST["fld000"]);

//画像をDBへ登録
$data=viewSetImage($_POST["fld000"]);

?>
