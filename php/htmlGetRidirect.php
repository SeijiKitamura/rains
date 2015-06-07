<?php
require_once("html.function.php");

if(LOCALMODE){
 header("Location:http://".WEBSERVER."/webupload.php");
}
else{
 echo "err:ローカルモードが有効ではありません";
}
?>
