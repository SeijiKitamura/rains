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
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    $("div#contents").text(XMLHttpRequest.responseText);
    return false;
   }
  });
 });
}
 </script>
</html>
