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
//  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
// }
//}

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

  //イベントバー
  $eventbar="";
  foreach($MININAVI as $key=>$val){
   $eventbar.="<li><a href='".$key."'";
   $eventbar.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--eventBar-->/",$eventbar,$html);
  
  //ナビゲーション
  $navibar="";
  foreach($NAVI as $key=>$val){
   $navibar.="<li><a href='".$key."'";
   $navibar.=">".$val."</a></li>";
  }
  //検索バー追加
  $navibar.="<li><input type='text' value='キーワード' name='serchword'>";
  $navibar.="<input type='image' src='.".IMG."/search.png'></li>";
  $html=preg_replace("/<!--navibar-->/",$navibar,$html);

  echo $html;
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

//ロゴを返す（表示はしない）
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
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

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
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

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
  
  //ナビゲーション
  $navibar="";
  foreach($NAVI as $key=>$val){
   $navibar.="<li><a href='".$key."'";
   $navibar.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--link02-->/",$navibar,$html);

  //インフォメーション($INFO)
  $navibar="";
  foreach($INFO as $key=>$val){
   $navibar.="<li><a href='".$key."'";
   $navibar.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--link03-->/",$navibar,$html);

  //住所検索(<!--addresslist-->
  $navibar="";
  $data=viewRentAddress();
  foreach($data["data"] as $key=>$val){
   $navibar.="<li><a href='#'>".$val["fld019"]."(".$val["count"].")"."</a></li>";
  }
  $html=preg_replace("/<!--addresslist-->/",$navibar,$html);

  //間取り一覧(賃貸マンション)
  $navibar="";
  $data=viewRentMadoriM();
  foreach($data["data"] as $key=>$val){
   $navibar.="<li><a href='#'>".$val["fld180"].$val["_fld179"]."(".$val["cnt"].")"."</a></li>";
  }
  $html=preg_replace("/<!--madorilistM-->/",$navibar,$html);
  
  //間取り一覧(賃貸アパート)
  $navibar="";
  $data=viewRentMadoriA();
  foreach($data["data"] as $key=>$val){
   $navibar.="<li><a href='#'>".$val["fld180"].$val["_fld179"]."(".$val["cnt"].")"."</a></li>";
  }
  $html=preg_replace("/<!--madorilistA-->/",$navibar,$html);

  //コピーライト
  $replace="COPYRIGHT ".CORPNAME." ALL RIGHTS RESERVED";
  $html=preg_replace("/<!--copyright-->/",$replace,$html);

  //画面追従型ナビゲーション
  $navibar="";
  $navibar.="<li><a href='index.php'><img src='".LOGO."'></a></li>";
  foreach($NAVI as $key=>$val){
   $navibar.="<li><a href='".$key."'";
   $navibar.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--shortnavi-->/",$navibar,$html);

  echo $html;

  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}
?>
