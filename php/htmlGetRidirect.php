<?php
require_once("html.function.php");

if(LOCALMODE){
 echo "http://".WEBSERVER."/webupload.php";
}
else{
 echo "err:ローカルモードが有効ではありません";
}
?>
