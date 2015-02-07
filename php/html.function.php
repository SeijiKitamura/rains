<?php
require_once("parts.function.php");

function htmlLogo(){
 $html="";
 $html ="<a href='index.php'>";
 $html.="<img src='".LOGO."' alt='".CORPNAME." ".CATCHWORD."'>";
 $html.="</a>";
 echo $html;
}
?>
