<?php
require_once("export.function.php");
require_once("view.function.php");

//既存データバックアップ
exportCSVAll();

viewDeleteRains();
echo "削除しました";
?>
