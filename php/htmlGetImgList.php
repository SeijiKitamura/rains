<?php
require_once("parts.function.php");
$data=viewDetail($_GET["fld000"]);
partsImage($data["data"],"edit");
?>
