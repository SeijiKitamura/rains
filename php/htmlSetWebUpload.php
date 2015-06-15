<?php
require_once("export.function.php");

//LOCALMODE判定
if(! LOCALMODE){
 echo "err:ローカルードが有効ではありません";
 return false;
}

exportCSVAll();

chdir("../local");
$a=`/bin/sh export.sh`;
echo "アップロードしました";
?>
