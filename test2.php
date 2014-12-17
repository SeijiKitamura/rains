<!DOCTYPE html5>
<html lang="ja">
 <head>
  <meta charset="UTF-8">
  <title>テストフォーム</title>
  <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
 </head>
 <body>
<?php
echo "<pre>";
print_r($_FILES);
print_r($_POST);
echo "</pre>";
?>

 </body>
 <script>
$(function(){
 $("#content").on("change", 'input[type="file"]', function(e){
  e.preventDefault();
  $.each(this.files,function(cnt){
   var formData = new FormData("form#content");
   var files = this;
   //画像ファイルをPOST
   formData.append('file', files);
   //その他データをPOST
   formData.append("test",$("input[type=hidden]").val());

   //ファイル送信
   $.ajax({
     url: 'php/test.php',
     type: 'post',
     data: formData,
     processData: false,
     contentType: false,
     dataType: 'html',
     complete: function(){},
     success: function(res) {console.log(res)}
   })
  })
 });
});
//$(function(){
// $("input[type=submit]").on("click",function(){getFileObj();return false;});
//});
//function getFileObj(){
// $.each($("input").get(0).files,function(e){
//  var fd=new FormData();
//  //画像ファイル名をセット
//  fd.append("filename",this.name);
//  //物件番号を取得
//  fd.append("bnumber",e);
//  $.ajax({
//    url:"php/test.php"
//   ,type:"POST"
//   ,data:fd
//   ,datatype:"json"
//   ,contentType:false
//   ,processData:false
//  }) 
//  .done(function(data){
//   console.log(data);
//  })
//  .fail(function(){
//   console.log("errer")
//  })
// });
// return false;
//}
 </script>
</html>
<?php
?>
