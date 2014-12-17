<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>画像詳細登録画面</title>
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="css/all.css">
  <link rel="stylesheet" type="text/css" href="css/detail.css">
  <link rel="stylesheet" type="text/css" href="css/smartdetail.css">
  <link rel="stylesheet" type="text/css" href="css/upload.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="js/bxslider/jquery.bxslider.min.js"></script>
  <link  href="js/bxslider/jquery.bxslider.css" rel="stylesheet">
 </head>
 <body>
  <div id="wrapper">
   <h1>画像詳細登録画面</h1>
   <div id="leftside">
   </div><!-- leftside -->
   <div id="main">
    <div class="header">
     <h2></h2>
     <h3 id="h3bnumber"></h3>
    </div><!-- header -->
    <div class="imglist">
    </div><!-- imglist -->
   </div><!-- main -->
  </div><!-- wrapper -->
 </body>
 <script>
 $(function(){
  getBList();
 });
 
 var maximglist=10;
 //登録物件一覧を表示
 function getBList(bname){
  var php="./php/jsonBList.php"
  var searchbname;
  searchbname="";
  if(bname) searchbname=bname;
  $.getJSON(php,{bname:searchbname},function(json){
   console.log(json);
   $("div#main div.header h2").text("");
   $("div#main div.header h3").text("");
   $("div#main div.imglist").empty();

   var ul=$("<ul>");
   $("<li>").append($("<h3>").text("登録済み物件")).appendTo(ul);
   $.each(json,function(){
    //物件番号が数字以外は飛ばす
    if(! this.fld000.match(/^[0-9]+$/)) return true;

    var li=$("<li>");
//    var div=$("<div>").addClass("bnumber_"+this.fld000);
    var div=$("<div>").attr("id",this.fld000);
    div.attr("class","listdiv");
    $("<h3>").append(this.fld021+this.fld022).appendTo(div);
    if(this.imglist){
     $("<img>").attr("src",(this.imglist[0]["fld002"])).appendTo(div);
    }
    $("<div>").attr("class","clr").appendTo(div);
    li.append(div).appendTo(ul);
   });
   $("div#leftside").empty().append(ul);
//   $("div[class^=bnumber]").click(function(){
//    var bnumber=$(this).attr("class").split("_")[1];
//    getBImg(bnumber);
//   });
   $("div.listdiv").click(function(){
    var bnumber=$(this).attr("id");
    getBImg(bnumber);
   });
  });
 }// function getBList(bname){

 //登録画像一覧を表示
 function getBImg(bnumberImg){
  var php="./php/jsonBimg.php";
  if(! bnumberImg.match(/^[0-9]+$/)) return false;
  console.log(php);
  $.getJSON(php,{"bnumber":bnumberImg},function(json){
   var bname=json[0]["fld021"]+json[0]["fld022"];
   $("div.header h2").text("物件名:"+bname);
   $("h3#h3bnumber").text("物件番号:"+json[0]["fld000"]);
   $("div.imglist").empty();
 console.log(json[0]["imglist"]);

   var html;
   html="";
   html="<form id='imgform'>";
   html+="<input type='hidden' name='bnumber' value='"+bnumberImg+"'>";
   html+="<input name='allupimg[]' type='file' multiple>";
   html+="<input name='alldelimg' type='button' value='全削除'>";
   html+="</form>";
   var i=0;
   if(json[0]["imglist"]){
    $.each(json[0]["imglist"],function(){
     html+="<div class='imgdiv'>";
     html+="<img src='"+this.fld002+"'>";
     html+="<dl>";
     html+="<dt>表示順:</dt>";
     html+="<dd><input name='hyouji_"+this.id+"' type='text' value='"+this.fld001+"'></dt>";
     html+="<dt>コメント:</dt>";
     html+="<dd><input name='comment_"+this.id+"' type='text' value='"+this.fld003+"'></dt>";
     //html+="<dt>ファイル名:</dt>";
     //html+="<dd id=imgpath_"+this.id+">"+decodeURI(this.fld002)+"</dd>";
     html+="<dt></dt>";
     html+="<dd>";
     //html+="<input name='changeimg_"+this.id+"' type='button' value='画像変更'>"
     html+="<input name='delimg_"+this.id+"' type='button' value='画像削除'>";
     html+="</dd>";
     html+="</dl>";
     html+="</div>";
     i++;
    });
   }
   $("div.imglist").append(html);
   
   //画像一括UPイベント
   $("form#imgform").on("change","input[type=file]",function(e){
    $.each(this.files,function(i,file){
     var formData=new FormData("form#imgform");
     formData.append("allupimg",file);
     formData.append("bnumber",$("h3#h3bnumber").text().match(/[0-9]+$/)[0]);
     //ファイル送信
     $.ajax({
       url: 'php/imgupload.php',
       type: 'post',
       data: formData,
       processData: false,
       contentType: false,
       dataType: 'html',
       complete: function(){},
       success: function(res) {
        console.log(res);
       }
     });
    });
    //処理が追いつかず、アップロードした画像が画面に表示されない場合がある。
    //対処方法が見当たらない。
    alert("アップロードしました");
    //getBList();
    getBImg(bnumberImg);
   });
   
   //画像一括削除イベント
   $("input[name=alldelimg]").on("click",function(){
    var bnumber=$("h3#h3bnumber").text().match(/[0-9]+$/);
    allImgDelete(bnumber[0]);
   });
   
   //表示順変更イベント
   $("input[name^=hyouji]").change(function(){
    var imgid=$(this).attr("name").split("_")[1];
    changeImg(imgid);
   });
   
   //コメント変更イベント
   $("input[name^=comment]").change(function(){
    var imgid=$(this).attr("name").split("_")[1];
    changeImg(imgid);
   });
   
   //画像削除イベント
   $("input[name^=delimg]").click(function(){
    var imgid=$(this).attr("name").split("_")[1];
    ImgDelete(imgid);
   });

  });
 }//function getBImg(bnumber){

 //単一画像削除
 function ImgDelete(imgid){
  var bnumber=$("h3#h3bnumber").text().match(/[0-9]+$/)[0];

  if(! confirm("この画像を削除しますか?")) return false;
  
  //エラーチェック
  if(! imgid.match(/^[0-9]+$/)){
   console.log("ImgDelete:画像番号不正("+imgid+")");
   alert("ImgDelete:画像番号不正("+imgid+")");
   return false;
  }

  if(! bnumber.match(/^[0-9]+$/)){
   console.log("ImgDelete:物件番号不正("+bnumber+")");
   alert("ImgDelete:物件番号不正("+bnumber+")");
   return false;
  }

  var php="php/allimgdelete.php";
  var data={"bnumber":bnumber,"imgid":imgid};
  $.get(php,data,function(html){
   console.log(html);
   getBImg(bnumber);
  });

 }
 //全画像削除
 function allImgDelete(bnumber){
  if(! confirm("すべての画像を削除しますか?")) return false;
  if(! bnumber.match(/^[0-9]+$/)){
   console.log("allImgDelete:物件番号不正("+bnumber+")");
   alert("allImgDelete:物件番号不正("+bnumber+")");
   return false;
  }
  var php="php/allimgdelete.php";
  var data={"bnumber":bnumber};
  $.get(php,data,function(html){
   if(html.match(/^[err]/)){
    alert(html);
   }
   else{
    getBList();
    alert("削除しました");
   }
  });
 }
 
 //表示順変更
 function changeImg(imgid){
  var php="./php/setImgHyouji.php";
  var bnumber=$("h3#h3bnumber").text().match(/[0-9]+/)[0];
  var hyouji=$("input[name=hyouji_"+imgid+"]").val();
  var imgpath=$("dd#imgpath_"+imgid).text();
  var imgcomment=$("input[name=comment_"+imgid+"]").val();

  var data={"imgid":imgid,"bnumber":bnumber,"hyouji":hyouji,"imgpath":imgpath,"imgcomment":imgcomment};

  console.log(data);

  //エラーチェック
  if(! hyouji.match(/^[0-9]+$/)){
   alert("数字を入力してください");
   return false;
  }

  if(!bnumber.match(/^[0-9]+$/)){
   alert("物件を選択してください");
   return false;
  }

  $.get(php,data,function(html){
   console.log(html);
   //エラーチェック
   if(html.match(/err:/)){
    alert(html);
    return false;
   }
   getBImg(bnumber);

  });
 }//function changeImg(imgid){
 </script>
</html>
