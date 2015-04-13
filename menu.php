<?php
require_once("php/html.function.php");
session_start();
if(! isset($_SESSION["USERID"]) || $_SESSION["USERID"]==null || $_SESSION["USERID"]!==md5(USERID)){
 header("Location:login.php");
}
htmlHeader("メニュー");
?>

  <div id="contentsWrap">
   <div id="contentsLeft">
    <ul id="leftMenu">
     <li id="update"><div id="divupdate">データ更新</div>
      <ul class="subList">
       <li id="csvupload">CSVアップロード<input type="file" multiple="multiple" name="csvdata"></li>
       <li id="hreset">表示リセット</li>
       <li id="hhreset">非表示リセット</li>
       <li id="kanren">関連データ</li>
      </ul>
     </li>
     <li id="hyouji">表示リスト</li>
     <li id="hihyouji">非表示リスト</li>
     <li id="rank">ランキング</li>
     <li id="entry">エントリー</li>
    </ul>
   </div><!--div id="contentsLeft"-->
   <div class="clr"></div>
    <div id="contentsMiddle">
     <div id="contents">
     </div><!--div id="contents"-->
    </div><!--div id="contentsMiddle"-->
  </div><!--div id="contentsWrap"-->

<?php
//htmlFooter()
?>
  </div><!--div id="wrap"-->
 </div><!--div id="body"-->
 <script>
$(function(){
 subListEvent();
 showCSVUp();
 uploadCSV();
 resetHyouji();
 resetHihyouji();
 showData();
});

//サブリスト表示
function subListEvent(){
 $("ul.subList").hide();
 $("div#divupdate").click(function(){
  $("ul.subList").slideUp();
  if($("ul.subList").css("display")=="none"){
   $("ul.subList").slideDown();
  }
 });
}

//CSVボタン表示
function showCSVUp(){
 $("input[name=csvdata]").hide();
 $("li#csvupload").click(function(){
  $("input[name=csvdata]").show();
 });
}

//CSVボタンイベント
function uploadCSV(){
 $("input[name=csvdata]").change(function(){
  csvUpload(this);
 });
}

//CSVアップロードメソッド
function csvUpload(elem){
 $("div#contents").empty();
 $.each(elem.files,function(i,file){
  var formData=new FormData();
  formData.append("csvfile",file);
  //ファイル送信
  $.ajax({
    url: 'php/csvupload.php',
    type: 'post',
//    async:false,
    beforeSend:function(){
     $("ul.subList").slideUp();
     $("div#contents").text("データ送信中・・・").slideDown();
    },
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'html',
    complete: function(){
    },
    success: function(html) {
     $("div#contents").empty()
                     .append("更新しました");
     $("input[type=file]").val("").hide();
    },
    error:function(XMLHttpRequest,textStatus,errorThrown){
     console.log(XMLHttpRequest.responseText);
     $("div#contents").text(XMLHttpRequest.responseText);
     return false;
    }
  });
 });
}

//表示リセット
function resetHyouji(){
 $("li#hreset").click(function(){
  if(!confirm("表示リストをリセットしますか?")) return false;
  console.log("リセット");

  $.ajax({
   url: 'php/htmlDelRains.php',
   type: 'get',
   async:false,
   beforeSend:function(){
    $("ul.subList").slideUp();
    $("div#contents").text("表示リストリセット中・・・").slideDown();
   },
   dataType: 'html',
   complete: function(){
   },
   success: function(html) {
    $("div#contents").empty()
                    .append("リセットしました");
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    $("div#contents").text(XMLHttpRequest.responseText);
    return false;
   }
  });
 });
}


//非表示リセット
function resetHihyouji(){
 $("li#hhreset").click(function(){
  if(!confirm("非表示リストをリセットしますか?")) return false;
  console.log("リセット");
  $.ajax({
   url: 'php/htmlDelBlackList.php',
   type: 'get',
   async:false,
   beforeSend:function(){
    $("ul.subList").slideUp();
    $("div#contents").text("非表示リストリセット中・・・").slideDown();
   },
   dataType: 'html',
   complete: function(){
   },
   success: function(html) {
    $("div#contents").empty()
                    .append("リセットしました");
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    $("div#contents").text(XMLHttpRequest.responseText);
    return false;
   }
  });
 });
}

//表示リストメソッド
function showData(){
 $("li#hyouji").click(function(){
  $.ajax({
   url: 'php/htmlGetRankDiv.php',
   type: 'get',
   async:false,
   beforeSend:function(){
    $("ul.subList").slideUp();
    $("div#contents").text("表示リスト作成・・・").slideDown();
   },
   dataType: 'html',
   complete: function(){
   },
   success: function(html) {
    html="<div id='article'>"+html+"</div>";
    $("div#contents").empty()
                     .append(html);
    showDetail();
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    $("div#contents").text(XMLHttpRequest.responseText);
    return false;
   }
  });
 });
}

//物件詳細表示
function showDetail(){
 $("p.item_img a,div.tabSwitchH3 h3 span a").click(function(){
  var php="htmlGetContents.php";
  var query=$(this).attr("href");
  query=query.replace("room.php?","");
  var q=query.split("=");
  var d={"fld000":q[1]};
  $.ajax({
   url: php,
   data:d,
   type: 'get',
   //async:false,
   beforeSend:function(){
    $("ul.subList").slideUp();
    $("div#contents").text("表示リスト作成・・・").slideDown();
   },
   dataType: 'html',
   complete: function(){
   },
   success: function(html) {
    console.log(html);
    $("div#contents").empty().append(html);
    $("div#aside").remove();
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    $("div#contents").text(XMLHttpRequest.responseText);
    return false;
   }
  });
  return false;
 });
}

//画像追加ボタンイベント
function addPhoto(){
 $("button#addphoto").click(function(){
   $("input[name=uploadimg]").trigger("click");
 });
}

//画像追加イベント
function chgInput(){
 $("input[name=uploadimg]").on("change",function(){
  uploadImg(this);
 });
}

//画像一覧表示
function showImage(){
 var fld000=$("div.loginpart").attr("data-fld000");
 var d={"fld000":fld000};
 $.ajax({
  url: 'php/htmlGetImgList.php',
  type: 'get',
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   console.log(html);
   //画像追加
   $("div.imgpart").empty()
                   .append(html);

   //番号変更イベント
   $("div.imgpart ul.ul_image li input[type=text]").on("change",function(){
    console.log($(this));
    var fld000=$(this).attr("data-fld000");
    var imgid=$(this).attr("data-imgid");
    var imgnum=$(this).val();
    if(! imgnum.match(/^[0-9]+$/)){
     alert("数字を入力してください");
     return false;
    }
    changeImgNum(fld000,imgid,imgnum);
   });
   
   //削除ボタンイベント
   $("div.imgpart ul.ul_image li input[type=button]").on("click",function(){
    var fld000=$(this).attr("data-fld000");
    var imgid=$(this).attr("data-imgid");
    deleteImg(fld000,imgid);
   });
   
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

//画像追加
function uploadImg(elem){
 $.each(elem.files,function(i,file){
  console.log(elem);
  var fld000=$(elem).attr("data-fld000");
  var formData=new FormData();
  formData.append("allupimg",file);
  formData.append("fld000",fld000);
  //ファイル送信
  $.ajax({
    url: 'php/htmlSetImgFile.php',
    type: 'post',
    async:false,
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'html',
    complete: function(){},
    success: function(html) {
     //showImage(fld000);
     showImage();
    },
    error:function(XMLHttpRequest,textStatus,errorThrown){
     console.log(XMLHttpRequest.responseText);
    }
  });
 });
}

//画像番号変更
function changeImgNum(fld000,imgid,imgnum){
 var d={"fld000":fld000,"imgid":imgid,"imgnum":imgnum};
 $.ajax({
  url: 'php/htmlSetImgNum.php',
  type: 'get',
  async:false,
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   //showImage(fld000);
   showImage();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

//画像削除
function deleteImg(fld000,imgid){
 if(imgid){
  if(! confirm("この画像を削除しますか?")) return false;
 }
 else{
  if(! confirm("全画像を削除しますか?")) return false;
 }

 var d={"fld000":fld000,"imgid":imgid};
 $.ajax({
  url: 'php/htmlDelImgNum.php',
  type: 'get',
  async:false,
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   //showImage(fld000);
   showImage();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

//外部URL画像取り込み
function listImgPathFromSite(){
 var outsiteUrl=$("input[name=outsiteurl]").val();
 var datafld000=$("div.loginpart").attr("data-fld000");

 if(! outsiteUrl) return false;

 var d={"imgurl":outsiteUrl,
        "fld000":datafld000};

 $.ajax({
  url:"php/htmlSetImgFileFromSite2.php",
  type:"get",
  data:d,
  dataType:"html",
  beforeSend:function(){
   $("div.msgpart").empty().append("ダウンロード中・・・");
  },
  success:function(html){
   console.log(html);
   showImage();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgpart").text(XMLHttpRequest.responseText);
   return false;
  },
  complete:function(){
   $("div.msgpart").empty();
  }
 });
}


 </script>
</html>
