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

 $("div.naviBar>ul>li").hover(function(){
  console.log($(this));
  $(this).find("ul").slideDown("slow");
 },function(){
  console.log($(this));
  $(this).find("ul").slideUp("slow");
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
    if(! confirm("この画像を削除しますか?")) return false;
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
// if(imgid){
//  if(! confirm("この画像を削除しますか?")) return false;
// }
// else{
//  if(! confirm("全画像を削除しますか?")) return false;
// }

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
 $("li#csvupload").click(function(){
  $("input[name=csvdata]").trigger("click");
  return false;
  //$("input[type=file").hide();
  //$("input[name=csvdata]").show();
  //return false;
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
  $("input[type=file").hide();
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
  $("input[type=file]").hide();
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

//チェックを残す
function checkIn(){
 $("button#checkin").click(function(){
  if(! confirm("チェックを残しますか?")) return false;
  $("div.imgpart ul li input[type=checkbox]").each(function(e){
   if($(this).is(":checked")){
   }
   else{
    var fld000=$(this).parent().attr("data-fld000");
    var imgid=$(this).attr("data-imgid");
    deleteImg(fld000,imgid);
   }
  });
 });
}

//チェックを削除
function checkOut(){
 $("button#checkout").click(function(){
  if(! confirm("チェックを削除しますか?")) return false;
  $("div.imgpart ul li input[type=checkbox]:checked").each(function(e){
   if($(this).val()){
    var fld000=$(this).parent().attr("data-fld000");
    var imgid=$(this).attr("data-imgid");
    deleteImg(fld000,imgid);
   }
  });
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

//画像拡大(未使用）
function zoomImg(){
 $("img#bigimg").elevateZoom({
   gallery:"shortphoto",
   cursor :"pointer",
   easing :true,
   galleryActiveClass:"active"
                 });
}

//関連データファイルダイアログ
function showFldData(){
 $("li#kanren").click(function(){
  $("input[name=flddata]").click();
  setFldData();
 });
}

//関連データ登録
function setFldData(){
 $("input[name=flddata]").change(function(){
  $.each(this.files,function(i,file){
   var formData=new FormData();
   formData.append("csvfile",file);
   //ファイル送信
   $.ajax({
    url: 'php/csvuploadfield.php',
    type: 'post',
//  async:false,
    beforeSend:function(){
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
     $("input[type=file]").val("");
    },
    error:function(XMLHttpRequest,textStatus,errorThrown){
     console.log(XMLHttpRequest.responseText);
     $("div.msgdiv").text(XMLHttpRequest.responseText);
     return false;
    }
   });
  });
 });
}

//ランキング表示
function showRankList(){
 $("li#rank").click(function(){
  $("input[type=file]").hide();
  $.ajax({
   url:"php/htmlRankList.php",
   type:"get",
   dataType:"html",
   success:function(html){
    $("div#contents").empty().append(html);
    showEntry();
    setRank();
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    $("div.msgdiv").text(XMLHttpRequest.responseText);
    return false;
   }
  });
 });
}

//エントリー表示
function showEntry(){
 $("div.ranklist table tr td").click(function(){
  $(this).parent().children().each(function(e){
   if(e==0){
    $("input[name=rank]").val($(this).text());
   }
   if(e==1){
    $("input[name=rankname]").val($(this).text());
   }
   if(e==2){
    $("input[name=rcomment]").val($(this).text());
   }
   if(e==3){
    $("input[name=startday]").val($(this).text());
   }
   if(e==4){
    $("input[name=endday]").val($(this).text());
   }
  });
 });
}

//ランク登録
function setRank(){
 $("a.a_rankentry").click(function(){
  var d={};
  var sdate;
  var edate;
  var chkflg;
  chkflg=1;
  
  //ランク値チェック
  d["rank"]=$("input[name=rank]").val();
  if(! d["rank"].match(/^[0-9]+$/)){
   consle.log("ランク数字以外");
   chkflg=0;
  }

  //タイトル空欄チェック
  d["rankname"]=$("input[name=rankname]").val();
  if(! d["rankname"].match(/^.+$/)){
   console.log("タイトル空欄");
   chkflg=0;
  }

  d["rcomment"]=$("input[name=rcomment]").val();
  
  //開始日チェック
  d["startday"]=$("input[name=startday]").val();
  if(! chkdate(d["startday"])){
   chkflg=0;
  }
  
  //終了日チェック
  d["endday"]=$("input[name=endday]").val();
  if(! chkdate(d["endday"])){
   chkflg=0;
  }

  //日付比較
  var sday=Date.parse(d["startday"]);
  var eday=Date.parse(d["endday"]);

  if(sday>eday){
   console.log("開始日、終了日比較エラー");
   chkflg=0;
  }

  d["flg"]=$("select[name=flg]").val();

  if(! chkflg){
   alert("入力エラーがあります");
   return false;
  }
  console.log(d);

  if(! confirm("登録しますか?")) return false;
  $.ajax({
   url:"php/htmlSetRank.php",
   data:d,
   dataType:"html",
   success:function(html){
    console.log(html);
    alert("登録しました");
    $("li#rank").trigger("click");
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    $("div.msgdiv").text(XMLHttpRequest.responseText);
    return false;
   }
  });
 });
}

//ランク変更
function chgRank(){
 $("select.selectRank").change(function(){
  var rank=$(this).val();
  var fld000=$(this).attr("data-fld000");
  var fld001=$(this).next().val();
  setEntry(rank,fld000,fld001);
 });
}

//エントリー変更
function chgEntry(){
 $("input[name=entry]").change(function(){
  var rank=$(this).prev().val();
  var fld000=$(this).prev().attr("data-fld000");
  var fld001=$(this).val();

  if(rank==0) return false;
  setEntry(rank,fld000,fld001);
 });
}

//物件ランク登録・削除
function setEntry(rank,fld000,fld001){
 if (! fld001) fld001=0;

 if(rank==0){
  var php="php/htmlDelEntry.php";
 }
 else{
  var php="php/htmlSetEntry2.php";
 }

 var d={"rank":rank,"fld000":fld000,"fld001":fld001};
 console.log(d);
 $.ajax({
  url:php,
  data:d,
  dataType:"html",
  success:function(html){
   console.log(html);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   alert(XMLHttpRequest.responseText);
   return false;
  }
 });
}

//物件コメント登録
function chgComment(){
 $("textarea").change(function(){
  var d={"fld000":$(this).attr("data-fld000"),"fld001":$(this).val()};
  $.ajax({
   url:"php/htmlSetBcomment.php",
   data:d,
   type:"POST",
   dataType:"html",
   success:function(html){
    console.log(html);
   },
   error:function(XMLHttpRequest,textStatus,errorThrown){
    console.log(XMLHttpRequest.responseText);
    alert(XMLHttpRequest.responseText);
    return false;
   }
  });
 });
} 

//日付チェック
function chkdate(hiduke){
 var h=hiduke.match(/^(20[0-9]{2})[\/-]?([0-1]?[0-9]{1})[\/-]?([0-3]?[0-9]{1})$/);
 if(!h){
  console.log("日付不正");
  return false;
 }
 else{
  var newdate=new Date(h[1],h[2]-1,h[3]);
  if(newdate.getFullYear()!=h[1]||newdate.getMonth()+1!=h[2]||newdate.getDate()!=h[3]){
  console.log("日付不正");
  return false;
  }
 }
 return true;
}

