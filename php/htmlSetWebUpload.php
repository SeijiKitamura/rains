<?php
require_once("export.function.php");

//LOCALMODE判定
if(! LOCALMODE){
 echo "err:ローカルードが有効ではありません";
 return false;
}

$fileary=array(RAINS,FLD,IMGLIST,RANK,ENTRY,BCOMMENT);
foreach($fileary as $key=>$val){
 exportCSV($val);
}

chdir("../local");
$a=`/bin/sh export.sh`;
echo "アップロードしました";
?>
