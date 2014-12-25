<?php
require_once("parts.function.php");
$data=viewDetail($_GET["fld000"]);

echo "<div class='divnavi'>";
partsNavi($data["data"],"edit");
echo "</div>";

echo "<div class='imglist'>";
partsImage($data["data"],"edit");
echo "</div>";


echo "<div class='divdetail'>";
partsLapDetail($data["data"]);
echo "</div>";

echo "<div id='map-canvas'></div>";

echo "<div class='clr'></div>";

?>
