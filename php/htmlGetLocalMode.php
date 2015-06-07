<?php
require_once("parts.function.php");
if(LOCALMODE){
 shell_exec("/bin/sh local/export.sh 2>&1 /dev/null");
 //header("Location:http://".WEBSERVER."/webupload.php");
}
else{
 echo "err:no localmode";
}
?>
