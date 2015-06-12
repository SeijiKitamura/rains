<?php
require_once("parts.function.php");

//-------------------------------------------------------//
// function スケルトン
//-------------------------------------------------------//

//function htmlXXXXXX(){
// try{
//  $mname="htmlXXXXXX(html.function.php) ";
//  $c="start ".$mname;wLog($c);
//  $html="";
//  echo $html;
//  $c="end ".$mname;wLog($c);
// }
// catch(Exception $e){
//  $c="error:".$mname.$e->getMessge();wLog($c);
// }
//}
//-------------------------------------------------------//


//-------------------------------------------------------//
//  ページヘッダーを表示
//-------------------------------------------------------//
function htmlHeader($title=null){
 global $PAGEARY;
 global $NAVI;
 global $MININAVI;
 try{
  $mname="htmlHeader(html.function.php) ";
  $c="start ".$mname;wLog($c);
  //現在ページ取得
  $nowpage=basename($_SERVER["PHP_SELF"]);

  //スケルトン読み込み
  $path=realpath("./").SKELETON."/header.html";
  $html=file_get_contents($path);

  //Googleクローラー
  $html=preg_replace("/<!--GOOGLEWEBMASTER-->/",GOOGLEWEBMASTER,$html);
  
  //タイトル
  $title.="|".CORPNAME;
  $html=preg_replace("/<!--title-->/",$title,$html);
  
  //CSS
  $css=".".CSS."/".$PAGEARY[$nowpage]["css1"];
  $html=preg_replace("/<!--css1-->/",$css,$html);
  $css=".".CSS."/".$PAGEARY[$nowpage]["css2"];
  $html=preg_replace("/<!--css2-->/",$css,$html);
  $css=".".CSS."/".$PAGEARY[$nowpage]["css3"];
  $html=preg_replace("/<!--css3-->/",$css,$html);
  
  //Description 
  $description=$PAGEARY[$nowpage]["description"];
  $html=preg_replace("/<!--description-->/",$description,$html);
  
  //キャッチワード
  $html=preg_replace("/<!--catchword-->/",CATCHWORD,$html);

  //ロゴ
  $logo=htmlLogo();
  $html=preg_replace("/<!--logo-->/",$logo,$html);
  
  //イベント（未対応）
  
  //会社名
  $html=preg_replace("/<!--corpname-->/",CORPNAME,$html);

  //会社住所
  $html=preg_replace("/<!--corpaddress-->/",CORPADDRESS,$html);
  
  //電話
  $html=preg_replace("/<!--corptel-->/",CORPTEL,$html);
  
  //FAX
  $html=preg_replace("/<!--corpfax-->/",CORPFAX,$html);
  
  //メールリンク
  $html=preg_replace("/<!--mailto-->/",MAILADDRESS,$html);

  //ログアウト
    
  //イベントバー
  $eventbar="";
  foreach($MININAVI as $key=>$val){
   $eventbar.="<li><a href='".$key."'";
   $eventbar.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--eventBar-->/",$eventbar,$html);
  
  //ナビゲーション
  $naviary=viewGroupFld();
  $navibar="";
  $fld001="";
  foreach($naviary["data"] as $key=>$val){
   if($fld001!=$val["fld001"]){
    if($key){
     $navibar.="</ul></li>";
    }
    $navibar.="<li><a href='#'>".$val["_fld001"]."</a>";
    $navibar.="<ul>";
    $fld001=$val["fld001"];
   }
   $navibar.="<li>";
   $navibar.="<a href='roomlist.php?type=";
   $navibar.=$val["fld001"]."_".$val["fld002"]."_".$val["fld003"]."'>";
   $navibar.=$val["_fld003"];
   $navibar.="</a>";
   $navibar.="</li>";
  }
  $navibar.="</ul></li>";


  foreach($NAVI as $key=>$val){
   $navibar.="<li><a href='".$key."'";
   $navibar.=">".$val."</a></li>";
  }

  session_start();
  if(isset($_SESSION["USERID"]) || $_SESSION["USERID"] || $_SESSION["USERID"]==md5(USERID)){
   $navibar.="<li>";
   $navibar.="<a href='menu.php'>管理画面</a>";
   $navibar.="</li>";
   $navibar.="<li>";
   $navibar.="<form id='loginForm' name='loginForm' action='login.php' method='POST'>";
   $navibar.="<input type='hidden' id='logout' name='logout' value='ログアウト'>";
   $navibar.="<a id='a_logout' href='#' onclick='document.forms.loginForm.submit();return false;'>ログアウト</a>";
   $navibar.="</form>";
   $navibar.="</li>";
  }
  
  //検索バー追加(未対応)
//  $navibar.="<li><input type='text' value='キーワード' name='serchword'>";
//  $navibar.="<input type='image' src='.".IMG."/search.png'></li>";

  $html=preg_replace("/<!--navibar-->/",$navibar,$html);

  echo $html;
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

//-------------------------------------------------------//
//ロゴを返す（表示はしない）
//-------------------------------------------------------//
function htmlLogo(){
 try{
  $mname="htmlLogo(html.function.php) ";
  $c="start ".$mname;wLog($c);
  $html="";
  $html ="<a href='index.php'>";
  $html.="<img src='".LOGO."' alt='".CORPNAME." ".CATCHWORD."'>";
  $html.="</a>";
  $c="end ".$mname;wLog($c);
  return $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

//-------------------------------------------------------//
// トップイメージを表示
//-------------------------------------------------------//
function htmlTopImage(){
 global $BIGNAVI;
 try{
  $mname="htmlTopImage(html.function.php) ";
  $c="start ".$mname;wLog($c);

  //スケルトン読み込み
  $path=realpath("./").SKELETON."/topimage.html";
  $html=file_get_contents($path);

  //トップイメージ
  $topimage="<img src='".TOPIMAGE."'>";
  $html=preg_replace("/<!--topimage-->/",$topimage,$html);
  
  echo $html;
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

//-------------------------------------------------------//
// フッターを表示
//-------------------------------------------------------//
function htmlFooter(){
 global $NAVI;
 global $SITECONTENTS;
 global $INFO;
 try{
  $mname="htmlFooter(html.function.php) ";
  $c="start ".$mname;wLog($c);
  
  //現在ページ取得
  $nowpage=basename($_SERVER["PHP_SELF"]);
  
  //スケルトン読み込み
  $path=realpath("./").SKELETON."/footer.html";
  $html=file_get_contents($path);

  //メールアドレス
  $html=preg_replace("/<!--mailto-->/",MAILADDRESS,$html);
  
  //ページ説明
  $sitehelp="このページは".CORPNAME."の";
  if($nowpage=="index.php"){
   $sitehelp.="トップページです。";
  }
  $sitehelp.=SITEHELP;
  $html=preg_replace("/<!--sitehelp-->/",$sitehelp,$html);

  //サイト説明
  $siteabout=SITEABOUT;
  $html=preg_replace("/<!--siteabout-->/",$siteabout,$html);

  //サイトコンテンツ($SITECONTENTS)
  $navibar="";
  foreach($SITECONTENTS as $key=>$val){
   $navibar.="<li><a href='".$key."'";
   $navibar.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--link01-->/",$navibar,$html);
  
  //売買物件
  $naviary=viewGroupFld();
  $replace="";
  foreach($naviary["data"] as $key=>$val){
   if($val["fld001"]=="1"){
    $replace.="<li><a href='roomlist.php?type=";
    $replace.=$val["fld001"]."_".$val["fld002"]."_".$val["fld003"];
    $replace.="'>".$val["_fld003"];
    $replace.="</a></li>";
   }
  }
  $html=preg_replace("/<!--baibailist-->/",$replace,$html);

  //賃貸物件
  $replace="";
  foreach($naviary["data"] as $key=>$val){
   if($val["fld001"]=="3"){
    $replace.="<li><a href='roomlist.php?type=";
    $replace.=$val["fld001"]."_".$val["fld002"]."_".$val["fld003"];
    $replace.="'>".$val["_fld003"];
    $replace.="</a></li>";
   }
  }
  $html=preg_replace("/<!--tintailist-->/",$replace,$html);

  
  //コピーライト
  $replace="COPYRIGHT ".CORPNAME." ALL RIGHTS RESERVED";
  $html=preg_replace("/<!--copyright-->/",$replace,$html);

  //画面追従型ナビゲーション(ここをHeaderと同じように表現する）
  //ここから
  
//  $naviary=viewGroupFld();
//  $fld001="";
  $navibar="";
  $navibar.="<li><a href='index.php'><img src='".LOGO."'></a></li>";
//  foreach($naviary["data"] as $key=>$val){
//   if($fld001!=$val["fld001"]){
//    if($key){
//     $navibar.="</ul></li>";
//    }
//    $navibar.="<li>".$val["_fld001"];
//    $navibar.="<ul>";
//    $fld001=$val["fld001"];
//   }
//   $navibar.="<li>";
//   $navibar.="<a href='roomlist.php?type=";
//   $navibar.=$val["fld001"]."_".$val["fld002"]."_".$val["fld003"]."'>";
//   $navibar.=$val["_fld003"];
//   $navibar.="</a>";
//   $navibar.="</li>";
//  }
//  $navibar.="</ul>";

  foreach($NAVI as $key=>$val){
   $navibar.="<li><a href='".$key."'";
   $navibar.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--shortnavi-->/",$navibar,$html);

  echo $html;

  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

//-------------------------------------------------------//
// 個別ページを表示
//-------------------------------------------------------//
function htmlContents($data){
 try{
  $mname="htmlHeader(html.function.php) ";
  $c="start ".$mname;wLog($c);
  //現在ページ取得
  $nowpage=basename($_SERVER["PHP_SELF"]);

  //スケルトン読み込み

  foreach($data["data"] as $key=>$val){
   //売買物件、賃貸物件判定
   if($val["fld001"]=="1"){
    $path=realpath("./").SKELETON."/contents.html";
   }
   elseif($val["fld001"]=="3"){
    $path=realpath("./").SKELETON."/contents2.html";
   }
   $html=file_get_contents($path);
   
   //物件名確定
   $replace="";
   if($val["fld021"]) $replace.=$val["fld021"]." ";
   if($val["fld022"]) $replace.=$val["fld022"]."号室";
   if(!$replace)      $replace =$val["fld019"];
   $html=preg_replace("/<!--bname-->/",$replace,$html);

   //メールリンク
   $replace=MAILADDRESS."?subject=".$replace."(物件番号".$val["fld000"].")の問い合せについて";
   $html=preg_replace("/<!--mailto-->/",$replace,$html);
  
   //駅名、徒歩を表示
   $replace="";
   if($val["fld026"]) $replace.=$val["fld026"]."駅";
   if($val["fld027"]) $replace.="徒歩".$val["fld027"]."分";
   $html=preg_replace("/<!--koutu-->/",$replace,$html);

   //図面を表示
   $replace="";
   foreach($val["imgfilepath"] as $key1=>$val1){
    if(! $key1) continue;
    $replace=$val1;
    break;
   }
   $html=preg_replace("/<!--zumen-->/",$replace,$html);

   //賃料を表示
   $replace="";
   if($val["fld054"]) $replace.=($val["fld054"]/10000)."万円";
   $html=preg_replace("/<!--price-->/",$replace,$html);
   
   //管理費を表示
   $replace="";
   if($val["fld137"]) $replace.="管理費".number_format($val["fld137"])."円";
   if($val["fld140"]) $replace.="/共益費".number_format($val["fld140"])."円";
   $html=preg_replace("/<!--kanrihi-->/",$replace,$html);
   
   //間取り
   $replace="";
   if($val["fld180"]) $replace.=$val["fld180"].$val["_fld179"];
   $html=preg_replace("/<!--madori-->/",$replace,$html);
   
   //面積を表示
   $replace="";
   if($val["fld068"]) $replace.=$val["fld068"]."m&sup2;";
   elseif($val["fld088"]) $replace.=$val["fld088"]."m&sup2;";
   $html=preg_replace("/<!--menseki-->/",$replace,$html);

   //面積を表示(検索用に平方メートルを抜く)
   $replace="";
   if($val["fld068"]) $replace.=$val["fld068"];
   elseif($val["fld088"]) $replace.=$val["fld088"];
   $html=preg_replace("/<!--menseki2-->/",$replace,$html);
   
   //敷金を表示
   $replace="";
   if($val["fld078"]) $replace.=($val["fld078"]*1)."ヶ月";
   if($val["fld077"] && ! $val["fld078"]) $replace.=$val["fld077"]."円";
   $html=preg_replace("/<!--sikikin-->/",$replace,$html);

   //礼金を表示
   $replace="";
   if($val["fld076"]) $replace.=($val["fld076"]*1)."ヶ月";
   if($val["fld074"] && ! $val["fld076"]) $replace.=$val["fld074"]."円";
   $html=preg_replace("/<!--reikin-->/",$replace,$html);

   //階数を表示
   $replace="";
   if($val["fld224"]) $replace.=$val["fld224"]."階";
   $html=preg_replace("/<!--kaisu-->/",$replace,$html);
   
   //総階数を表示
   $replace="";
   if($val["fld222"]) $replace.=$val["fld222"]."階";
   if($val["fld223"]) $replace.="(B".$val["fld223"]."階)";
   $html=preg_replace("/<!--soukaisu-->/",$replace,$html);
   
   //築年を表示
   $replace="";
   if($val["fld225"]) $replace.=substr($val["fld225"],0,4)."年";
   if($val["fld225"]) $replace.=substr($val["fld225"],5,2)."月";
   $html=preg_replace("/<!--tikunen-->/",$replace,$html);
   
   //方角を表示
   $replace="";
   if($val["fld230"]) $replace.=$val["_fld230"]."向き";
   $html=preg_replace("/<!--hougaku-->/",$replace,$html);

   //間取り詳細(正しく表示されないのであとで見直し)
   $replace="";
   if($val["fld183"]) $replace.=$val["fld183"]."階";
   if($val["fld184"]) $replace.=$val["_fld184"];
   if($val["fld185"]) $replace.="(".$val["fld185"]."帖)";
   if($val["fld186"] && $val["fld186"]>1) $replace.="x".$val["fld186"];
   if($val["fld184"]) $replace.="/";

   if($val["fld187"] && $val["fld183"]!=$val["fld187"]) $replace.=$val["fld187"]."階";
   if($val["fld188"]) $replace.=$val["_fld188"];
   if($val["fld189"]) $replace.="(".$val["fld189"]."帖)";
   if($val["fld190"] && $val["fld190"]>1) $replace.="x".$val["fld190"];
   if($val["fld188"]) $replace.="/";

   if($val["fld191"] && $val["fld187"]!=$val["fld191"]) $replace.=$val["fld191"]."階";
   if($val["fld192"]) $replace.=$val["_fld192"];
   if($val["fld193"]) $replace.="(".$val["fld193"]."帖)";
   if($val["fld194"] && $val["fld194"]>1) $replace.="x".$val["fld194"];
   if($val["fld192"]) $replace.="/";

   if($val["fld195"] && $val["fld191"]!=$val["fld195"]) $replace.=$val["fld195"]."階";
   if($val["fld196"]) $replace.=$val["_fld196"];
   if($val["fld197"]) $replace.="(".$val["fld197"]."帖)";
   if($val["fld198"] && $val["fld198"]>1) $replace.="x".$val["fld198"];
   if($val["fld196"]) $replace.="/";

   if($val["fld199"] && $val["fld195"]!=$val["fld199"]) $replace.=$val["fld199"]."階";
   if($val["fld200"]) $replace.=$val["_fld200"];
   if($val["fld201"]) $replace.="(".$val["fld201"]."帖)";
   if($val["fld202"] && $val["fld202"]>1) $replace.="x".$val["fld202"];
   if($val["fld200"]) $replace.="/";

   if($val["fld203"] && $val["fld199"]!=$val["fld203"]) $replace.=$val["fld203"]."階";
   if($val["fld204"]) $replace.=$val["_fld204"];
   if($val["fld205"]) $replace.="(".$val["fld205"]."帖)";
   if($val["fld206"] && $val["fld206"]>1) $replace.="x".$val["fld206"];
   if($val["fld204"]) $replace.="/";

   if($val["fld207"] && $val["fld203"]!=$val["fld207"]) $replace.=$val["fld207"]."階";
   if($val["fld208"]) $replace.=$val["_fld208"];
   if($val["fld209"]) $replace.="(".$val["fld209"]."帖)";
   if($val["fld210"] && $val["fld210"]>1) $replace.="x".$val["fld210"];
   if($val["fld208"]) $replace.="/";

   $html=preg_replace("/<!--utiwake-->/",$replace,$html);

   //画像が0枚の場合、表示しない
   if(! count($val["imgfilepath"])){
    $replace="";
    $html=preg_replace("/<!--loopbig-->.*<!--loopbigend-->/s",$replace,$html);
    $html=preg_replace("/<!--loopshort-->.*<!--loopshortend-->/s",$replace,$html);
   }

   //画像が1枚以上の場合、表示する
   $bigphoto="";
   $shortphoto="";
   foreach($val["imgfilepath"] as $key1=>$val1){
    $bigphoto.="<img class='sp-slide' src='".$val1."'>";
    $shortphoto.="<img class='sp-thumbnail' src='".$val1."'>";
   }
   $html=preg_replace("/<!--loopbig-->(.*)<!--loopbigend-->/s",$bigphoto,$html);
   $html=preg_replace("/<!--loopshort-->(.*)<!--loopshortend-->/s",$shortphoto,$html);
   
   //物件種別を表示
   $replace="";
   if($val["fld003"]) $replace.=$val["_fld003"];
   $html=preg_replace("/<!--syubetu-->/",$replace,$html);

   //問合せ番号を表示
   $replace="";
   if($val["fld000"]) $replace.=$val["fld000"];
   $html=preg_replace("/<!--fld000-->/",$replace,$html);

   //所在地を表示
   $replace="";
   if($val["fld017"]) $replace.=$val["fld017"];
   if($val["fld018"]) $replace.=$val["fld018"];
   if($val["fld019"]) $replace.=$val["fld019"];
   if($val["fld020"]) $replace.=$val["fld020"];
   $html=preg_replace("/<!--address-->/",$replace,$html);

   //地図情報をセット
   $replace="";
   if($val["latlng"]){
    $replace=$val["latlng"]["startlat"];
   }
   $html=preg_replace("/<!--startlat-->/",$replace,$html);

   $replace="";
   if($val["latlng"]){
    $replace=$val["latlng"]["startlng"];
   }
   $html=preg_replace("/<!--startlng-->/",$replace,$html);

   $replace="";
   if($val["latlng"]){
    $replace=$val["latlng"]["endlat"];
   }
   $html=preg_replace("/<!--endlat-->/",$replace,$html);

   $replace="";
   if($val["latlng"]){
    $replace=$val["latlng"]["endlng"];
   }
   $html=preg_replace("/<!--endlng-->/",$replace,$html);
   
   //建物構造
   $replace="";
   if($val["fld219"]) $replace.=$val["_fld219"];
   $html=preg_replace("/<!--kouzou-->/",$replace,$html);
   
   //更新料
   $replace="";
   if($val["fld147"]) $replace.=$val["fld147"]."円";
   if(! $val["fld147"] && $val["fld148"]) $replace.=($val["fld148"]*1)."ヶ月";
   $html=preg_replace("/<!--kousin-->/",$replace,$html);

   //現況
   $replace="";
   if($val["fld038"]) $replace.=$val["_fld038"];
   $html=preg_replace("/<!--genkyo-->/",$replace,$html);

   //契約形態
//   $replace="";
//   if($val["fld130"]) $replace.=$val["_fld130"];
//   $html=preg_replace("/<!--keiyaku-->/",$replace,$html);


   //契約期間
   $replace="";
   if($val["fld083"]){
    $replace.=substr($val["fld083"],0,2)*1;
    $replace.="年間";
   }
   $html=preg_replace("/<!--kikan-->/",$replace,$html);

   //入居日
   $replace="";
   if($val["fld043"]) $replace.=$val["fld043"];
   $html=preg_replace("/<!--nukyo-->/",$replace,$html);

   //保険
   $replace="";
   if($val["fld151"]) $replace.=$val["fld151"]."円";
   $html=preg_replace("/<!--hoken-->/",$replace,$html);

   //管理
   $replace="";
   if($val["fld133"]) $replace.="管理組合あり/";
   if($val["fld134"]) $replace.=$val["_fld134"];
   $html=preg_replace("/<!--hoken-->/",$replace,$html);

   //その他費用
   $replace="";

   //駐車場
   $replace="";
   if($val["fld212"]) $replace.="駐車場あり";
   $html=preg_replace("/<!--tyusyajyo-->/",$replace,$html);

   //土地関連
   $replace="";
   if($val["fld121"]) $replace.=$val["_fld121"];
   if($val["fld102"]) $replace.=" 借地料".$val["fld102"]."円";
   if($val["fld103"]) $replace.=" 借地期間(".$val["fld103"].") ";
   if($val["fld104"]) $replace.=" 借地期限(".$val["fld104"].") ";
   if($val["fld114"]) $replace.=$val["_fld114"];
   if($val["fld115"]) $replace.=" ".$val["_fld115"];
   if($val["fld116"]) $replace.=" ".$val["_fld116"];
   if($val["fld118"]) $replace.=" 建ぺい率".$val["fld118"]."%";
   if($val["fld119"]) $replace.=" 容積率".$val["fld119"]."%";
   if($val["fld157"]) $replace.=" ".$val["_fld157"];
   if($val["fld158"]){
    $replace.=" (".$val["_fld158"]."";
    if($val["fld161"]) $replace.=$val["_fld161"];
    if($val["fld162"]) $replace.=$val["fld162"]."m";
    $replace.=")";
   }
   if($val["fld163"]){
    $replace.=" (".$val["_fld163"]."";
    if($val["fld166"]) $replace.=$val["_fld166"];
    if($val["fld167"]) $replace.=$val["fld167"]."m";
    $replace.=")";
   }
   $html=preg_replace("/<!--uritikoumoku-->/",$replace,$html);

   //備考
   $replace="";
   if($val["bcomment"]) $replace.=$val["bcomment"];
   $html=preg_replace("/<!--bikou-->/",$replace,$html);

   //その他コメント(textarea用)
   $replace="";
   if($val["setubi"]) $replace.=$val["setubi"];
   $html=preg_replace("/<!--setubi-->/",$replace,$html);
   
   //その他コメント(表示用)
   $replace="";
   if($val["setubi"]) $replace.=preg_replace("/\n/s","<br/>",$val["setubi"]);
   $html=preg_replace("/<!--pSetubi-->/",$replace,$html);

   //取扱会社名
   $replace="";
   if($val["fld004"]) $replace.=$val["fld004"];
   $html=preg_replace("/<!--fld004-->/",$replace,$html);

   //代表電話番号
   $replace="";
   if($val["fld005"]) $replace.=$val["fld005"];
   $html=preg_replace("/<!--fld005-->/",$replace,$html);

   //電話番号
   $replace="";
   if($val["fld006"]) $replace.=$val["fld006"];
   $html=preg_replace("/<!--fld006-->/",$replace,$html);

   //担当者名
   $replace="";
   if($val["fld007"]) $replace.=$val["fld007"];
   $html=preg_replace("/<!--fld007-->/",$replace,$html);
   
   //問合せ番号
   $replace="";
   if($val["fld008"]) $replace.=$val["fld008"];
   $html=preg_replace("/<!--fld008-->/",$replace,$html);

   //Eメール
   $replace="";
   if($val["fld009"]) $replace.=$val["fld009"];
   $html=preg_replace("/<!--fld009-->/",$replace,$html);
   
   break;
  }//foreach($data["data"] as $key=>$val){

  $replace="";
  foreach($data["brother"]["data"] as $key=>$val){
   if($key>BROTHERLIMIT) continue;

   //画像リンク
   $imgfilepath="";
   foreach($val["imgfilepath"] as $key1=>$val1){
    if($key1==1){
     $imgfilepath=$val1;
     break;
    }
   }
   
   //物件名
   $bname="";
   if($val["fld021"]) $bname.=$val["fld021"]." ";
   if($val["fld022"]) $bname.=$val["fld022"]."号室";
   if(!$bname)        $bname =$val["fld019"];

   //賃料
   $price="";
   $price =($val["fld054"]/10000)."万円";

   //間取り
   $madori="";
   $madori=$val["fld180"].$val["_fld179"];

   //面積
   $menseki="";
   $menseki=$val["fld068"]."m&sup2;";
   
   //住所
   $address="";
   if($val["fld017"]) $address =$val["fld017"];
   if($val["fld018"]) $address.=$val["fld018"];
   if($val["fld019"]) $address.=$val["fld019"];
   if($val["fld020"]) $address.=$val["fld020"];

   //駅
   $station="";
   if($val["fld025"]) $station =$val["fld025"]." ";
   if($val["fld026"]) $station =$val["fld026"]."駅 ";
   if($val["fld027"]) $station.="徒歩".$val["fld027"]."分";

   $replace.="<div class='likeItem'>";
   $replace.="<p class='thumb'>";
   $replace.="<a href='room.php?fld000=".$val["fld000"]."'>";
   $replace.="<img src='".$imgfilepath."'>";
   $replace.="</a>";
   $replace.="</p>";
   $replace.="<p>";
   $replace.=$bname;
   $replace.="</p>";
   $replace.="<p>";
   $replace.="<span class='price'><strong>".$price."</strong>";
   $replace.="/".$madori."/".$menseki;
   $replace.="</p>";
   $replace.="<p class='pAddress'>".$address."</p>";
   $replace.="<p class='pStation'>".$station."</p>";
   $replace.="</div>";
  }
  $html=preg_replace("/<!--loopBrother-->.*<!--loopBrotherEnd-->/s",$replace,$html);

  echo $html;
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

?>
