<!DOCTYPE html5>
<html lang="ja">
 <head>
  <meta charset="UTF-8">
  <title>テストフォーム</title>
  <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
 </head>
 <body>
<?php
require_once("php/import.function.php");
$data=file_get_contents("php/rains.csv");
echo "<pre>";
print_r($data);
echo "</pre>";
?>
success;
 </body>
 <script>
 </script>
</html>
<?php
?>
