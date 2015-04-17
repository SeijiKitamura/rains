//Google Map
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(35.5839676,139.71252230000005);
  var mapOptions = {
    zoom:14,
    center: chicago
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start =new google.maps.LatLng($("span#startpoint").attr("data-lat"),$("span#startpoint").attr("data-lng"));
  var end =new google.maps.LatLng($("span#endpoint").attr("data-lat"),$("span#endpoint").attr("data-lng"));
  var request = {
      origin:start,
      destination:end,
      travelMode: google.maps.TravelMode.WALKING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
}

//google.maps.event.addDomListener(window, 'load', initialize);


//ナビゲーション追従
//全ページ
function navi(){
 var topnavi=$("div.naviBar").offset()["top"];
 $(window).scroll(function(){
  if($(window).scrollTop()>topnavi){
   console.log("臨界点突破");
   console.log($(window).scrollTop());
   console.log(topnavi);
   $("div#shortNavi").slideDown();
  }
  else{
   $("div#shortNavi").slideUp();
  }
 });
}

//非表示登録
//index.php
function delItem(elem){
 var php="php/htmlSetBlackList.php";
 var fld000=elem.attr("data-fld000");
 var d={"fld000":fld000,"black":""};

 //物件番号チェック
 if(! fld000.match(/^[0-9]+$/)){
  alert("物件番号が数字ではありません");
  return false;
 }

 console.log(d);
 if(! confirm("非表示にしますか?")) return false;

 $.ajax({
  url:"php/htmlSetBlackList.php",
  type:"post",
  dataType:"html",
  data:d,
  async:false,
  complete:function(){},
  success:function(html){
   console.log(html);
   hideItem(elem);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

//非表示アクション
//index.php
function hideItem(elem){
 var fld000=elem.attr("data-fld000");
 $("div.recomendItemList").each(function(){
  if($(this).attr("data-fld000")==fld000){
   $(this).slideUp();
  }
 });
}

//画像追加
//room.php
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

//非表示登録
//room.php
function delItemRoom(){
 var php="php/htmlSetBlackList.php";
 var fld000=$("div.loginpart").attr("data-fld000");
 var d={"fld000":fld000,"black":""};

 //物件番号チェック
 if(! fld000.match(/^[0-9]+$/)){
  alert("物件番号が数字ではありません");
  return false;
 }

 console.log(d);
 if(! confirm("非表示にしますか?")) return false;

 $.ajax({
  url:"php/htmlSetBlackList.php",
  type:"post",
  dataType:"html",
  data:d,
  async:false,
  complete:function(){},
  success:function(html){
   console.log(html);
   alert("非表示に登録しました");
   //window.location.href="index.php";
   $("li#hyouji").trigger("click");
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

//画像一覧表示
//room.php
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

   //番号選択状態
   $("div.imgpart ul.ul_image li input[type=text]").focus(function(){
    $(this).select();
   });
   
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

//画像番号変更
//room.php
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
//room.php
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
//room.php
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
    showImage();
    btnDel();
    addPhoto();
    delAllImg();
    outImg();
    chgImg();
//    zoomImg();
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


//非表示ボタンイベント
function btnDel(){
 $("button#delitem").click(function(){
  delItemRoom();
 });
}
//画像追加ボタンイベント
function addPhoto(){
 $("button#addphoto").click(function(){
   $("input[name=uploadimg]").trigger("click");
   chgInput();
 });
}

//画像追加イベント
function chgInput(){
 $("input[name=uploadimg]").on("change",function(){
  uploadImg(this);
 });
}

//画像全削除
function delAllImg(){
 $("button#delAll").click(function(){
  var fld000=$("div.loginpart").attr("data-fld000");
  deleteImg(fld000,null);
 });
}

//外部画像
function outImg(){
 $("button#outsideImage").click(function(){
  listImgPathFromSite();
 });
}

//画像変更
function chgImg(){
 $("div#shortphoto ul li a").click(function(){
  var moto=$(this).find("img").attr("src");
  $("img#bigimg").attr("src",moto);
//  $("img#bigimg").removeClass('active').addClass('active');
//  var ez=$("img#bigimg").data("elevateZoom");
//  ez.swaptheimage(moto,moto);
  return false; //リンク無効
 });
}

//画像拡大
function zoomImg(){
 $("img#bigimg").elevateZoom({
   gallery:"shortphoto",
   cursor :"pointer",
   easing :true,
   galleryActiveClass:"active"
                 });
}
