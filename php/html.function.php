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
 global $NAVIARY;
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
  $css=".".CSS."/".$NAVIARY[$nowpage]["css1"];
  $html=preg_replace("/<!--css1-->/",$css,$html);
  $css=".".CSS."/".$NAVIARY[$nowpage]["css2"];
  $html=preg_replace("/<!--css2-->/",$css,$html);
  $css=".".CSS."/".$NAVIARY[$nowpage]["css3"];
  $html=preg_replace("/<!--css3-->/",$css,$html);
  
  //Description 
  $description=$NAVIARY[$nowpage]["description"];
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

  //ナビゲーション
  $navibar="";
  foreach($NAVIARY as $key=>$val){
   //除外ページ(新しくページを追加した時はここをチェック)
   if($key=="estate.php") continue;

   $navibar.="<li><a href='".$key."'";
   if($nowpage==$key){
    $navibar.=" class='nowpage'";
   }
   $navibar.=">".$val["title"]."</a></li>";
  }
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
  
  //ナビゲーション
  $bignavi="";
  foreach($BIGNAVI as $key=>$val){
   $bignavi.="<li><a href='".$key."'";
   $bignavi.=">".$val."</a></li>";
  }
  $html=preg_replace("/<!--bignavi-->/",$bignavi,$html);

  echo $html;
  $c="end ".$mname;wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}
?>
