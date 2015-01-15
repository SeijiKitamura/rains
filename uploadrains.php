<?php require_once("php/parts.function.php");?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>Rainsデータ更新</title>
  <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="css/all.css">
  <link rel="stylesheet" type="text/css" href="css/upload.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="js/bxslider/jquery.bxslider.min.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <link  href="js/bxslider/jquery.bxslider.css" rel="stylesheet">
 </head>
 <body>
  <div id="wrapper">
   <a href="index.php"><img src='<?php echo LOGO;?>'></a>
   <h1>Rainsデータ更新画面</h1>
   <ul>
    <li id="nowdata">  <a href="#">表示リスト  </a></li>
    <li id="blacklist"><a href="#">非表示リスト</a></li>
    <li id="dataup">   <a href="#">データ更新  </a></li>
    <li id="rankup">   <a href="#">ランキング  </a></li>
    <li id="entryup">   <a href="#">エントリー  </a></li>
   </ul>
   <div class="clr"></div>
   <div id="leftside">
   </div><!-- leftside -->
   <div id="main">
   </div><!-- main -->
  </div><!-- wrapper -->
 </body>
 <script>

$(function(){
 //現在データ表示
 $("li#nowdata").on("click",function(e){
  whiteBlack("reset");
  $("div#main").empty()
  showLeftSide();
 });

 $("li#blacklist").on("click",function(){
  whiteBlack("black");
  $("div#main").empty()
  showLeftSide();
 });

 $("li#dataup").on("click",function(){
  dataUpMenu();
 });

 $("li#rankup").on("click",function(){
  showRank();
 });

 $("li#entryup").on("click",function(){
  showEntry();
 });

 $("body").on("mouseup",function(){
  if($("ul#ul_menu li ul").css("display")!="none"){
   $("ul#ul_menu li ul").hide();
  }
 });
 $("div#map-canvas").hide();
});//$(function()

function showLeftSide(){
 $("div.imglist").empty();
 $("div#leftside").empty();
 var d={"black":whiteBlack()};
 console.log(d);
 //レフトサイドメニュー表示
 $.ajax({
  url:"php/htmlGetLeftSideMenu.php",
  type:"get",
  dataType:"html",
  data:d,
  complete:function(){},
  success:function(html){
   $("div#leftside").append(html);
   
   //レフトサイドイベントをセット
   leftSideEvent();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

function showMain(html){
 //結果表示
 $("div#main").empty()
              .append(html);
 
 if(whiteBlack()){
  $("a#delData").text("表示");
 }
 else{
  $("a#delData").text("非表示");
 }
 
 //ドロップダウンメニュー
 $("ul#ul_menu>li").on("click",function(){
  if($(this).children("ul").css("display")=="none"){
   $(this).children("ul").show();
  }
  else{
   $(this).children("ul").hide();
  }
 });

 $("ul#ul_menu>li>ul>li>a").on("click",function(){
  $(this).parent().parent().hide();
  selectEvent($(this));
  return false;//これを付けないとバブリングする
 });
 
 //詳細表示イベント
 $("a.a_detail").on("click",function(){
  var fld000=$(this).parent().attr("data-fld000");
  showDetail(fld000);
 });

 $("div.datarow input[type=checkbox]").on("change",function(){
  setCheck();
 });

 //Cookieを反映
 showCheck();

}

function selectEvent(elem){
 if(elem.attr("id")=="sAll"){
  $("div.datarow input[type=checkbox]").each(function(){
   $(this).attr("checked",true);
  });
  setCheck();
 }

 if(elem.attr("id")=="nAll"){
  $("div.datarow input[type=checkbox]").each(function(){
   $(this).attr("checked",false);
  })
  setCheck();
 }

 if(elem.attr("id")=="delData"){
  delData();
 }

}

function showCheck(){
 if(! $.cookie("fld000")) return false;
 var fld000=$.cookie("fld000").split(",");
 $("div.datarow input[type=checkbox]").each(function(){
  var datafld000=$(this).parent().parent().attr("data-fld000");
  for(var i=0;i<fld000.length;i++){
   if(datafld000==fld000[i]){
    $(this).attr("checked",true);
   }
  }
 });

}

function setCheck(){
 $.cookie.json=true;
 var fld000;
 fld000="";
 $("div.datarow input[type=checkbox]").each(function(){
  if($(this).attr("checked")){
   if(fld000) fld000+=",";
   fld000+=$(this).parent().parent().attr("data-fld000");
  }
 });
 if(fld000){
  $.cookie("fld000",fld000);
 }
 else{
  $.removeCookie("fld000");
 }
}

function delData(){
 var fld000;
 fld000="";

 $("div.datarow").each(function(i,elem){
  if($(this).find("input").attr("checked")){
   if(fld000) fld000+=",";
   fld000+=$(this).attr("data-fld000");
  }
 });

 if(!fld000) return false;
 var d={"fld000":fld000,"black":whiteBlack()};

 console.log(d);
 $.ajax({
  url:"php/htmlSetBlackList.php",
  type:"post",
  dataType:"html",
  data:d,
  async:false,
  complete:function(){},
  success:function(html){
   console.log(html);
   showLeftSide();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });

 $("div.datarow").each(function(i,elem){
  if($(this).find("input").attr("checked")){
   $(this).hide();
  }
 });
}

function setField(){
 var val1;
 return function(fldval){
  if(fldval){
   if(fldval=="reset") val1="";
   else val1=fldval;
  }
  return val1;
 }
}

var whiteBlack=setField();
var fld001=setField();
var fld002=setField();
var fld003=setField();
var fld179=setField();
var fld180=setField();
var fld025=setField();
var fld026=setField();

function leftSideEvent(){
 //
 $("ul#ul_fld li").hide();
 $("ul#ul_fld li.fld001").show();
 $("ul#ul_madori li").hide();
 $("ul#ul_station li").hide();
 
 //物件種類スライド
 $("ul#ul_fld li.fld001").toggle(
   function(){
    fld001($(this).attr("data-fld001"));
    fld002("reset");
    fld003("reset");
    fld179("reset");
    fld180("reset");
    fld025("reset");
    fld026("reset");

    $("li.fld001").css("background-color","white");
    $("li.fld003").css("background-color","white");
    $(this).css("background-color","#90EE90");
    $(this).next().slideDown().find("li").slideDown();
    
    //fld001で絞り込み
    var obj={"fld001":fld001()}
    filterData(obj);
    $("ul#ul_madori,ul#ul_station").slideUp();
   },

   function(){
    $(this).next().find("li").slideUp();
    $("ul#ul_madori,ul#ul_station").slideUp();
   }
  );


 $("li.fld003").on("click",function(){
  $("li.fld003").css("background-color","white");
  $(this).css("background-color","#90EE90");
  $("li.fld001").css("background-color","white");
  $(this).parent().parent().prev().css("background-color","#90EE90");
  fld001($(this).attr("data-fld001"));
  fld002($(this).attr("data-fld002"));
  fld003($(this).attr("data-fld003"));
  fld179("reset");
  fld180("reset");
  fld025("reset");
  fld026("reset");
  //fld001,fld002,fld003で絞り込み
  var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003()};
  filterData(obj);
  showMadori(obj);
  showStation(obj);
 });
}

function filterData(obj){
 obj["black"]=whiteBlack();
 console.log(obj);

 $.ajax({
  url:"php/htmlgetRainsTable.php",
  type:"get",
  async:false,
  data:obj,
  dataType:"html",
  success:function(html){
   showMain(html);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

function showMadori(obj){
 obj["black"]=whiteBlack();
 console.log(obj);
 $.ajax({
  url:"php/htmlGetMadoriMenu.php",
  type:"get",
  data:obj,
  dataType:"html",
  success:function(html){
   $("h4").each(function(){
    if($(this).text()=="間取り"){
     $("ul#ul_madori").remove();
     $(this).after(html).remove();
     $("li.fld180").on("click",function(){
      $("li.fld180").css("background-color","white");
      $(this).css("background-color","#90EE90");
      fld179($(this).attr("data-fld179"));
      fld180($(this).attr("data-fld180"));
      fld025("reset");
      fld026("reset");
      var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003(),"fld179":fld179(),"fld180":fld180()};
      filterData(obj);
      showStation(obj);
     });
    }
   });
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

function showStation(obj){
 obj["black"]=whiteBlack();
 console.log(obj);
 $.ajax({
  url:"php/htmlGetStationMenu.php",
  type:"get",
  data:obj,
  dataType:"html",
  success:function(html){
   $("h4").each(function(){
    if($(this).text()=="最寄駅"){
     $("ul#ul_station").remove();
     $(this).after(html).remove();

     $("li.fld025").on("click",function(){
      $("li.fld025").css("background-color","white");
      $("li.fld026").css("background-color","white");
      $(this).css("background-color","#90EE90");
      fld025($(this).attr("data-line"));
      fld026("reset");
      var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003(),"fld179":fld179(),"fld180":fld180(),"fld025":fld025()};
      filterData(obj);
     });

     $("li.fld026").on("click",function(){
      $("li.fld026").css("background-color","white");
      $(this).css("background-color","#90EE90");
      fld025($(this).attr("data-line"));
      fld026($(this).attr("data-station"));
      var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003(),"fld179":fld179(),"fld180":fld180(),"fld025":fld025(),"fld026":fld026()};
      filterData(obj);
     });

    }
   });
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }

 });
}

function showDetail(fld000){
 var d={"fld000":fld000};
 console.log(d);
 $.ajax({
  url: 'php/htmlGetDetail.php',
  type: 'get',
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   $("div#main").empty()
                .append(html);
   $("a.a_upload").on("click",function(){
    $("input[name=uploadimg]").trigger("click");
   });

   $("input[name=uploadimg]").on("change",function(){
    uploadImg(this);
   });

   $("a.a_outsite").on("click",function(){
    showOutSite(fld000);
   });

   $("div.imglist ul.ul_image li input[type=text]").on("change",function(){
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

   $("div.imglist ul.ul_image li input[type=button]").on("click",function(){
    var fld000=$(this).attr("data-fld000");
    var imgid=$(this).attr("data-imgid");
    deleteImg(fld000,imgid);
   });

   $("a.a_delimg").on("click",function(){
    var fld000=$(this).attr("data-fld000");
    deleteImg(fld000,null);
   });

   $("a.a_back").on("click",function(){
    backPage();
   });

   $("textarea[name=txt_setubi]").on("change",function(){
    chgSetubi();
   });

   $("input[name=inp_bcomment]").on("change",function(){
    chgSetubi();
   });

   $("select[name=select_rank]").on("change",function(){
    setRankList($(this).val(),$(this).attr("data-fld000"));
   });

   initialize();
   calcRoute();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

function showImage(fld000){
 var d={"fld000":fld000};
 $.ajax({
  url: 'php/htmlGetImgList.php',
  type: 'get',
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   $("div.imglist").empty()
                   .append(html);

   $("div.imglist ul.ul_image li input[type=text]").on("change",function(){
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

   $("div.imglist ul.ul_image li input[type=button]").on("click",function(){
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
     showImage(fld000);
    },
    error:function(XMLHttpRequest,textStatus,errorThrown){
     console.log(XMLHttpRequest.responseText);
    }
  });
 });
}

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
   showImage(fld000);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });

}

function deleteImg(fld000,imgid){
 if(! confirm("この画像を削除しますか?")) return false;

 var d={"fld000":fld000,"imgid":imgid};
 $.ajax({
  url: 'php/htmlDelImgNum.php',
  type: 'get',
  async:false,
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   showImage(fld000);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });

}

//かなりダサい。もっとスマートなやり方あるはず
function backPage(){
 if(fld001() && ! fld002() && ! fld003() && !fld179() && ! fld180() && ! fld025() && ! fld026()){
  console.log("fld001");
  var obj={"fld001":fld001()};
 }
 else if(fld001() && fld002() && fld003() && !fld179() && ! fld180() && ! fld025() && ! fld026()){
  console.log("fld003");
  var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003()};
 }
 else if(fld001() && fld002() && fld003() && fld179() && fld180() && ! fld025() && ! fld026()){
  console.log("fld180");
  var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003(),"fld179":fld179(),"fld180":fld180()};
 }
 else if(fld001() && fld002() && fld003() && fld179() && fld180() && fld025() && ! fld026()){
  console.log("fld025");
  var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003(),"fld179":fld179(),"fld180":fld180(),"fld025":fld025()};
 }
 else if(fld001() && fld002() && fld003() && fld179() && fld180() && fld025() && fld026()){
  console.log("fld026");
  var obj={"fld001":fld001(),"fld002":fld002(),"fld003":fld003(),"fld179":fld179(),"fld180":fld180(),"fld025":fld025(),"fld026":fld026()};
 }
 filterData(obj);

}

function chgSetubi(){
 var fld000=$("textarea[name=txt_setubi]").attr("data-fld000");
 var fld001=$("textarea[name=txt_setubi]").val();
 var fld002=$("input[name=inp_bcomment]").val();
 var d={"fld000":fld000,"fld001":fld001,"fld002":fld002};

 if(! fld000 || ! fld000.match(/^[0-9]+$/)){
  console.log("物件番号エラー");
  return false;
 }

 $.ajax({
  url:"php/htmlSetBcomment.php",
  type:"get",
  dataType:"html",
  data:d,
  complete:function(){},
  success:function(html){
   console.log(html);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }
 });
}

function dataUpMenu(){
 $("div#leftside").empty();
 $("div#main").empty();
 
 $("<a>").attr("href","#")
         .text("CSVアップロード")
         .addClass("csvbutton")
         .on("click",function(){
          $("input[name=csvdata]").click();
          })
         .appendTo("div#main");

 $("<input>").attr({name:"csvdata",
                    type:"file",
                    multiple:"multiple"
              })
             .hide()
             .change(function(){
               csvUpload(this);
              })
             .appendTo("div#main");
             

 $("<a>").attr("href","#")
         .text("表示リセット")
         .addClass("csvbutton")
         .on("click",function(){
          resetRains();
          })
         .appendTo("div#main");

 $("<a>").attr("href","#")
         .text("非表示リセット")
         .addClass("csvbutton")
         .on("click",function(){
          resetBlackList();
          })
         .appendTo("div#main");

 $("<div>").addClass("clr")
           .appendTo("div#main");

 $("<div>").addClass("msgdiv")
           .appendTo("div#main");

 $("<div>").addClass("datadiv")
           .appendTo("div#main");
}

function csvUpload(elem){
 $("div.datadiv").empty();
 $.each(elem.files,function(i,file){
  var formData=new FormData();
  formData.append("csvfile",file);
  //ファイル送信
  $.ajax({
    url: 'php/csvupload.php',
    type: 'post',
//    async:false,
    beforeSend:function(){
     $("div.msgdiv").text("データ送信中・・・").slideDown();
    },
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'html',
    complete: function(){
    },
    success: function(html) {
     $("div.datadiv").append(html);
     $("ul#ul_menu").hide();
     $("div.msgdiv").text("データ送信完了").slideUp(1000);
     $("input[type=file]").val("");
    },
    error:function(XMLHttpRequest,textStatus,errorThrown){
     console.log(XMLHttpRequest.responseText);
     $("div.msgdiv").text(XMLHttpRequest.responseText);
     return false;
    }
  });
 });
}

function resetRains(){
 if(!confirm("表示データをリセットしますか?")) return false;

 $.ajax({
  url: 'php/htmlDelRains.php',
  type: 'get',
//  async:false,
  beforeSend:function(){
   $("div.datadiv").empty();
   $("div.msgdiv").text("表示データ初期化中・・").slideDown();
  },
  dataType: 'html',
  complete: function(){
  },
  success: function(html) {
   $("div.msgdiv").text("表示データ初期化完了");
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function resetBlackList(){
 if(!confirm("非表示データをリセットしますか?")) return false;

 $.ajax({
  url: 'php/htmlDelBlackList.php',
  type: 'get',
//  async:false,
  beforeSend:function(){
   $("div.datadiv").empty();
   $("div.msgdiv").text("非表示データ初期化中・・").slideDown();
  },
  dataType: 'html',
  complete: function(){
  },
  success: function(html) {
   $("div.msgdiv").text("非表示データ初期化完了");
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function listImgPathFromSite(){
 var outsiteUrl=$("input[name=outsiteurl]").val();
 var datafld000=$("div.divoutsite").attr("data-fld000");

 var d={"url":outsiteUrl,
        "fld000":datafld000};

 $.ajax({
  url:"php/htmlImgListFromSite.php",
  type:"get",
  data:d,
  dataType:"html",
  success:function(html){
   $("div.divoutsite ul.ul_image").remove();
   $("div.divoutsite").append(html);

   $("div.divoutsite ul li input").on("click",function(){
    pickImg($(this));
   });
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function pickImg(elem){
 var imgurl=$(elem).siblings().attr("src");
 var fld000=$("div.divoutsite").attr("data-fld000");
 var d={"fld000":fld000,"imgurl":imgurl};

 $.ajax({
  url:"php/htmlSetImgFileFromSite.php",
  type:"get",
  data:d,
  dataType:"html",
  context:elem,
  success:function(html){
   $(elem).parent().hide();
   showImage(fld000);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function showOutSite(fld000){
 console.log(fld000);
 var d={"fld000":fld000};
 $.ajax({
  url:"php/htmlImgListDiv.php",
  type:"get",
  data:d,
  dataType:"html",
  success:function(html){
   $("div.divoutsite").remove();
   $("div.imglist").after(html);
   $("div.divdetail").hide();

   $("a.a_close").on("click",function(){
    $("div.divoutsite").hide();
    $("div.divdetail").show();
   });

   $("a.a_get").on("click",function(){
    listImgPathFromSite();
   });
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function showRank(){
 showRankList();
}

function showRankList(){
 $.ajax({
  url:"php/htmlRankList.php",
  type:"get",
  dataType:"html",
  success:function(html){
   $("div#main").empty().append(html);

   //ランクイベント
   $("ul.ul_rank li span").on("click",function(){
    getRank($(this));
   });

   //登録イベント
   $("a.a_rankentry").on("click",function(){
    setRank();
   });
   
   //削除イベント
   $("a.a_rankdel").on("click",function(){
    delRank();
   });

  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function getRank(elem){
 var rank=elem.siblings().eq(0).text();
 var d={"rank":rank};
 $.ajax({
  url:"php/htmlGetRank.php",
  type:"get",
  data:d,
  dataType:"json",
  context:elem,
  success:function(json){
   $.each(json,function(key,val){
    if(key!="id" && key!="flg" && key!="idate" && key!="cdate"){
     $("input[name="+key+"]").val(val);
    }
    if(key=="flg"){
     $("select[name=flg]").val(val);
    }
   });
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function setRank(){
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
   showRankList();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });

}

function delRank(){
 var d={};
 var chkflg;
 chkflg=1;
 //値チェック
 if(!$("input[name=rank]").val().match(/^[0-9]+$/)){
  console.log("ランク数字以外");
  chkflg=0;
 }
 d["rank"]=$("input[name=rank]").val();

 if(! chkflg) return false;

 if(! confirm("削除しますか?")) return false;
 $.ajax({
  url:"php/htmlDelRank.php",
  data:d,
  dataType:"html",
  success:function(html){
   console.log(html);
   alert("削除しました");
   showRankList();
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function showEntry(){
 //ランキング一覧表示
 $.ajax({
  url:"php/htmlGetEntryList.php",
  dataType:"html",
  success:function(html){
   $("div#main").empty().append(html);

   $("ul.ul_shortrank li span").on("click",function(){
    var rank=$(this).parent().children().first().text();
    showEntryList(rank);
   });
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function showEntryList(rank){
 console.log(rank);
 var d={"rank":rank};
 $.ajax({
  url:"php/htmlEntry.php",
  data:d,
  dataType:"html",
  success:function(html){
   $("div.diventry").empty().append(html);

   $("input[name=entry]").on("change",function(){
    var entryid=$(this).attr("data-id");
    var entry=$(this).val();
    var ecomment=$(this).parent().siblings().find("input").val();
    console.log(entryid+" "+entry +" "+ecomment);
    setEntry(entryid,entry,ecomment);
   });

   $("input[name=ecomment]").on("change",function(){
    var entryid=$(this).attr("data-id");
    var entry=$(this).parent().siblings().find("input").val();
    var ecomment=$(this).val();
    console.log(entryid+" "+entry +" "+ecomment);
    setEntry(entryid,entry,ecomment);
   });

   $("a.a_entrydel").on("click",function(){
    var rank=$(this).attr("data-rank");
    var id=$(this).attr("data-id");
    delEntry(rank,id);
   });

  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function setEntry(entryid,entry,ecomment){
 var d={"id":entryid,"fld001":entry,"ecomment":ecomment};
 console.log(d);
 $.ajax({
  url:"php/htmlSetEntry.php",
  data:d,
  dataType:"html",
  success:function(html){
   console.log(html);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });
}

function delEntry(rank,entryid){
 if(! confirm("削除しますか?")) return false;
 var d={"rank":rank,"id":entryid};
 console.log(d);
 $.ajax({
  url:"php/htmlDelEntry.php",
  data:d,
  dataType:"html",
  success:function(html){
   console.log(html);
   console.log(d);
   showEntryList(rank);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
   $("div.msgdiv").text(XMLHttpRequest.responseText);
   return false;
  }
 });

}

function setRankList(rank,fld000){
 if(rank==0){
  console.log("Rankが0");
  return false;
 }

 if(! fld000.match(/^[0-9]+$/)){
  console.log("物件番号数字以外");
  return false;
 }

 var d={"rank":rank,"fld000":fld000};
 $.ajax({
  url: "php/htmlSetRankList.php",
  type: 'get',
  data:d,
  dataType: 'html',
  complete: function(){},
  success: function(html) {
   $("div.diventrylist").empty()
                        .append(html);
  },
  error:function(XMLHttpRequest,textStatus,errorThrown){
   console.log(XMLHttpRequest.responseText);
  }//error
 });
}

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

 </script>
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
 <script>
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
  var start =new google.maps.LatLng($("dd#startpoint").attr("data-lat"),$("dd#startpoint").attr("data-lng"));
  var end =new google.maps.LatLng($("dd#endpoint").attr("data-lat"),$("dd#endpoint").attr("data-lng"));
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
 </script>
</html>

