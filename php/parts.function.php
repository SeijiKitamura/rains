<?php
/*-----------------------------------------------------
 ファイル名:parts.function.php
 接頭語    :parts
 主な動作  :受け取ったデータからHTMLを生成する
 返り値    :HTMLを表示(echo $html)
 エラー    :エラーメッセージを表示
----------------------------------------------------- */
require_once("view.function.php");

//------------------------------------------------------//
// ログイン時の画像リスト表示
//------------------------------------------------------//
function partsImage($data,$edit=null){
 try{
  $mname="partsImage(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }
  $html="";
  foreach($data as $key=>$val){
   $html.="<ul class='ul_image' data-fld000='".$val["fld000"]."'>";
   foreach($val["imgfile"] as $key1=>$val1){
    if(preg_match("/^http/",$val1["fld002"])){
     $imgpath=$val1["fld002"];
    }
    else{
     $imgpath=".".IMG."/".$val1["fld000"]."/".$val1["fld002"];
    }
    $html.="<li data-fld000='".$val["fld000"]."' data-imgid='".$val1["id"]."'>";
    if($edit){
     $html.="<input type='checkbox' data-imgid='".$val1["id"]."'>";
     $html.="<input type='text' value='".$val1["fld001"]."' data-fld000='".$val1["fld000"]."' data-imgid='".$val1["id"]."'>";
     $html.="<input type='button' value='削除' data-fld000='".$val1["fld000"]."' data-imgid='".$val1["id"]."'>";
    }
    //$html.="<div class='imgdiv'>";
    $html.="<img src='".$imgpath."' alt='".$val1["fld003"]."' data-fld000='".$val1["fld000"]."' data-imgid='".$val1["id"]."'>";
    //$html.="</div>";
    $html.="</li>";
   }
   $html.="</ul>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c); 
 }
}

//------------------------------------------------------//
// $pageurlの画像URLを配列にして返す
// $ary["src"]=> 画像URL(コンバート済み）
// $ary["_src"]=>画像URL（生URL)
//------------------------------------------------------//
function partsImgPathFromSite($pageurl){
 $mname="partsImgPathFromSite(parts.function.php) ";
 try{
  $c="start ".$mname;wLog($c);

  if(! $purl=parse_url($pageurl)){
   throw new exception("URLが認識できません(".$pageurl.")");
  }

  $c="notice:".$mname." URLセット(".$pageurl.")";wLog($c);

  $html=@file_get_contents($pageurl);
  if($html ===FALSE){
   $c="error:".$mname." ページが取得できません(".$pageurl.")";wLog($c);
   throw new exception ($c);
  }
  $c=$html;
  //wLog($c);
  
  //まずはimgタグだけ抜き出す
  $pattern="/<img.*?>/s";
  preg_match_all($pattern,$html,$match);
  
  $url=array();
  foreach($match[0] as $key=>$val){
   $col=array();
   
   //imgタグを除く
   $data=preg_replace("/^<img|\/?>$/","",$val);
   $c="notice:".$mname."imgタグ除外".$data;wLog($c);
   
   //'"を削除
   $data=preg_replace("/\'|\"/","",$data);
   $c="notice:".$mname."'を除外".$data;wLog($c);
   
   //空欄ごとに区切る
   $data=preg_split("/[\s]+/",$data);
   foreach($data as $key1=>$val1){
    $c="notice:".$mname."空欄区切り key1:".$key1." val1:".$val1;wLog($c);
   }
   
   //属性と値を配列に格納
   foreach($data as $key1=>$val1){
    $m=array();

    if(! $val1){
     $c="notice:".$mname."key1:".$key1." 値空欄のためスキップ";wLog($c);
     continue;
    }

    preg_match("/(.*?)=(.*)/",$val1,$m);
    $c="notice:".$mname."配列へ格納".$m[1]."=>".$m[2];wLog($c);
    $col[$m[1]]=mb_convert_encoding($m[2],"UTF-8","auto");
   }
   
   $flg=1;
   foreach($col as $key1=>$val1){
    $c="notice:".$mname."col[".$key1."]=>".$val1;wLog($c);
    if($key1=="src" && ! $val1){
     $flg=0;
    }
   }
   
  //src属性なければスキップ
   if(! $flg){
    $c="notice:".$mname." src属性(".$col["src"].")がありません。処理をスキップします(".$val.")";wLog($c);
    continue;
   }
   
  //src属性をバックアップ
   $col["_src"]=$col["src"];
   
  //suumo用に対策(data-srcを適用する）
   if(preg_match("/suumo\.jp/",$pageurl) && $col["data-src"]){
    $col["src"]=$col["data-src"];
   }
  
  //画像ファイルパスチェック
   if(! preg_match("/^http/",$col["src"])){
    // 「//」から始まっている
    if(preg_match("/^\/\//",$col["src"])){
     $c="notice:".$mname." 画像パスが//で始まっている".$col["src"];wLog($c);
     $col["src"]=$purl["scheme"]."://".$col["src"];
    }
    // 「/」から始まっている
    elseif(preg_match("/^\//",$col["src"])){
     $c="notice:".$mname." 画像パスが/で始まっている".$col["src"];wLog($c);
     $col["src"]=$purl["scheme"]."://".$purl["host"].$col["src"];
    }
    
    // 「./」から始まっている
    elseif(preg_match("/^\.\//",$col["src"])){
     $c="notice:".$mname." 画像パスが./で始まっている".$col["src"];wLog($c);
     $col["src"]=dirname($pageurl).preg_replace("/^\./","",$col["src"]);
    }
    
    // 「/」から始まっていない
    elseif(preg_match("/^[^\/]/",$col["src"])){
     $c="notice:".$mname." 画像パスが相対パス".$col["src"];wLog($c);
     $col["src"]=dirname($pageurl)."/".$col["src"];
    }
   }
  
  //タウンハウジング用カスタマイズ(name属性有効でhttpから始まる場合)
   if($col["name"] && preg_match("/^http/",$col["name"])){
    $c="notice:".$mname." タウンハウジング用パス変換".$col["src"];wLog($c);
    $col["src"]=$col["name"];
   }
  
  //suumo用カスタマイズ(「&amp」を「&」へ)
   if(preg_match("/img01\.suumo\.com/",$col["src"])){
    $c="notice:".$mname."suumo用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/amp;/","",$col["src"]);
   }
   
  //suumo用カスタマイズ(w=452へ)
   if(preg_match("/img01\.suumo\.com/",$col["src"])){
    $c="notice:".$mname."suumo用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/w=[0-9]+/","w=452",$col["src"]);
   }
  
  //suumo用カスタマイズ(h=339へ)
   if(preg_match("/img01\.suumo\.com/",$col["src"])){
    $c="notice:".$mname."suumo用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/h=[0-9]+/","h=339",$col["src"]);
   }
   
  //homes用カスタマイズ(サイズ指定部分を削除)
   if(preg_match("/image\.homes\.co\.jp/",$col["src"])){
    $c="notice:".$mname."homes.co.jp用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/&amp;.*$/","",$col["src"]);
   }
   
  //homes用カスタマイズ(サイズ指定部分を削除)
   if(preg_match("/homes\.jp/",$col["src"])){
    $c="notice:".$mname."homes.jp用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/&amp;.*$/","",$col["src"]);
   }
   
  //athome用カスタマイズ(拡張子後のオプションを削除)
   if(preg_match("/athome\.co\.jp|athome\.jp/",$col["src"])){
    $c="notice:".$mname."athome用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/\?.*$/","",$col["src"]);
    $c="notice:".$mname."athome用パス変換終了".$col["src"];wLog($c);
   }
   
  //assist-jpn.com用カスタマイズ
   if(preg_match("/assist-jpn\.com/",$col["src"])){
    $c="notice:".$mname."assist-jpn用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/\&.*$/","",$col["src"]);
    $c="notice:".$mname."assist-jpn用パス変換終了".$col["src"];wLog($c);
   }
  
   $c="notice:".$mname."画像パス登録(".$col["src"].")";wLog($c);
   $url[]=$col;
  }
  
  unset($html);
  foreach($url as $key=>$val){
   $c="notice:".$mname."url[".$key."]=>".$val["src"];wLog($c);
  }
  $c="end:".$mname;wLog($c);
  return $url;
 }
 catch(Exception $e){
  //$html->clear();
  wLog("error:".$mname.$e->getMessage());
  echo "err:".$e->getMessage();
 }
}

//------------------------------------------------------//
//viewNewAndRankで取得したデータを使用してを物件一覧を表示
//------------------------------------------------------//
function partsRankDiv($data,$loginflg=null){
 try{
  $mname="partsRankDiv(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  if(! isset($data)||! is_array($data)||! count($data)){
   $c="物件データがありません";wLog($c);
   return false;
  }
  //ランキングゲット
  //$rank=viewNowRank();
  
  //スケルトンファイル読み込み
  $skeletonpath=dirname(__FILE__)."/..".SKELETON."/recomendbox.html";
  $skeleton=file_get_contents($skeletonpath);
  
  //ループ部分抽出($match[2]にhtml格納)
  preg_match("/(<!--loop-->)(.*)(<!--loopend-->)/s",$skeleton,$match);

  $bunrui="";
  $html="";
  foreach($data as $key=>$val){
   $s=$skeleton;

   $s=preg_replace("/<!--id-->/",$key,$s);

//   if($key=="new") $display="";
//   else $display="none;";
   $s=preg_replace("/<!--display-->/",$display,$s);

   if($key=="new") $rankname="新着物件";
   elseif($key=="baibai") $rankname="売買物件";
   elseif($key=="tintai") $rankname="賃貸物件";
   else{
    foreach($val as $key1=>$val1){
     $rankname=$val1["rankname"];
     break;
    }
   }
   $s=preg_replace("/<!--rankname-->/",$rankname,$s);

   if($key=="new") $rcomment="新着物件のご案内です。";
   elseif($key=="baibai") $rcomment="売買物件のご案内です。";
   elseif($key=="tintai") $rcomment="賃貸物件のご案内です。";
   else{
    foreach($val as $key1=>$val1){
     $rcomment=$val1["rcomment"];
     break;
    }
   }
   $s=preg_replace("/<!--rcomment-->/",$rcomment,$s);
   
   $loop="";
   foreach($val as $key1=>$val1){
    $itembox=$match[2];
    
    //分類表示
    if($rankname=="売買物件" || $rankname=="賃貸物件"){
// echo "rankname ".$rankname." bunrui".$bunrui." val1".$val1["_fld003"]."<br>";
     if($bunrui!==$val1["_fld003"]){
      $replace ="<div class='clr'></div>";
      $replace.="<h3>".$val1["_fld003"]."</h3>";
      $itembox=preg_replace("/<!--bunrui-->/",$replace,$itembox);
      $bunrui=$val1["_fld003"];
     }
    }

    //物件番号
    $fld000=$val1["fld000"];
    $itembox=preg_replace("/<!--fld000-->/",$fld000,$itembox);
    
    //個別ページ
    $path="room.php?fld000=";
    $itembox=preg_replace("/<!--estatepath-->/",$path.$val1["fld000"],$itembox);
    
    if(!isset($val1["imgfilepath"]) ||! is_array($val1["imgfilepath"])||! count($val1["imgfilepath"])){
     //画像なし
     $img='<img src="<!--imgfilepath-->" alt="<!--imgalt-->" class="lazyload">';
     $itembox=preg_replace("/".$img."/","",$itembox);
    }

    //画像あり
    foreach($val1["imgfilepath"] as $key2=>$val2){
     $itembox=preg_replace("/<!--imgfilepath-->/",$val2,$itembox);
     break;
    }

    //物件名
    if($val1["fld021"]) $estatename=$val1["fld021"].$val1["fld022"]; else $estatename=$val1["fld018"].$val1["fld019"];
    $itembox=preg_replace("/<!--estatename-->/",$estatename,$itembox);
    
    //価格
    $replace="";
    $replace=number_format($val1["fld054"]);
    $itembox=preg_replace("/<!--price-->/",$replace,$itembox);
    
    //広さ
    $replace="";
    $replace=$val1["fld068"].$val1["fld088"]."m&sup2";
    $itembox=preg_replace("/<!--estatemenseki-->/",$replace,$itembox);
    //間取り
    $replace="";
    $replace=$val1["fld180"].$val1["_fld179"];
    $itembox=preg_replace("/<!--estatemadori-->/",$replace,$itembox);
    
    //住所
    $estateaddress=$val1["fld018"].$val1["fld019"].$val1["fld020"];
    $itembox=preg_replace("/<!--estateaddress-->/",$estateaddress,$itembox);

    //路線
    $rail=$val1["fld025"];
    $itembox=preg_replace("/<!--rail-->/",$rail,$itembox);

    //駅名
    $station=$val1["fld026"]."駅";
    $itembox=preg_replace("/<!--station-->/",$station,$itembox);

    //徒歩
    $toho=$val1["fld027"];
    $itembox=preg_replace("/<!--toho-->/",$toho,$itembox);

    //建設年月日
    if($val1["fld225"]){
     $build=substr($val1["fld225"],0,4)."年".substr($val1["fld225"],5,2)."月";
    }
    else $build="";
    $itembox=preg_replace("/<!--build-->/",$build,$itembox);

    //総階数
    if($val1["fld222"]) $floors="/".$val1["fld222"]."階建";
    else $floors="";
    $itembox=preg_replace("/<!--floors-->/",$floors,$itembox);

    //地下階
    if($val1["fld223"]) $underground="(地下".$val1["fld223"]."階)";
    else $underground="";
    $itembox=preg_replace("/<!--underground-->/",$underground,$itembox);

    //ログイン中なら削除ボタン追加
    if($loginflg){
     $replace="<button data-fld000=".$val1["fld000"].">非表示</button>";
     $itembox=preg_replace("/<!--delbutton-->/",$replace,$itembox);
    }

    //ログイン中ならランキング追加
    if($loginflg){
     if(isset($rank) && count($rank)){
      $replace="<select class='selectRank' data-fld000=".$val1["fld000"].">";
      $replace.="<option value=0>ランク外</option>";
      foreach($rank as $rkey=>$rval){
       $replace.="<option value=".$rval["rank"];
       if($val1["rank"]==$rval["rank"]) $replace.=" selected ";
       $replace.=">".$rval["rankname"]."</option>";
      }
      $replace.="</select>";
      $replace.="<input name='entry'value=".$val1["entry"].">";
      $itembox=preg_replace("/<!--rank-->/",$replace,$itembox);
     }
    }
    $loop.=$itembox;
   }

   $s=preg_replace("/<!--loop-->.*<!--loopend-->/s",$loop,$s);
   $html.=$s;
  }//foreach
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

//------------------------------------------------------//
// エントリー用フォームを表示
//------------------------------------------------------//
function partsRankEntry2(){
 try{
  $mname="partsRankEntry2(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  //スケルトンファイル読み込み
  $skeletonpath=dirname(__FILE__)."/..".SKELETON."/entrytable.html";
  $html=file_get_contents($skeletonpath);
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

//------------------------------------------------------//
// ランキング一覧表示
//------------------------------------------------------//
function partsRankListTable($data){
 try{
  $mname="partsRankList(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  //スケルトンファイル読み込み
  $skeletonpath=dirname(__FILE__)."/..".SKELETON."/ranklist.html";
  $html=file_get_contents($skeletonpath);

  //loopからloopendまで抜き取り($loop[0]）
  preg_match("/<!--loop-->.*<!--loopend-->/s",$html,$loop);

  //loop範囲を一旦削除
  $html=preg_replace("/<!--loop-->.*<!--loopend-->/s","",$html);

  foreach($data as $key=>$val){
   $tr=$loop[0];
   $tr=preg_replace("/<!--rank-->/",$val["rank"],$tr);
   $tr=preg_replace("/<!--rankname-->/",$val["rankname"],$tr);
   $tr=preg_replace("/<!--rcomment-->/",$val["rcomment"],$tr);
   $tr=preg_replace("/<!--startday-->/",$val["startday"],$tr);
   $tr=preg_replace("/<!--endday-->/",$val["endday"],$tr);
   if($val["flg"]==1) $hyouji="する";
   else               $hyouji="しない";
   $tr=preg_replace("/<!--hyouji-->/",$hyouji,$tr);
   $tr=$tr."<!--foreach-->";
   $html=preg_replace("/<!--foreach-->/",$tr,$html);
  }

  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}

//------------------------------------------------------//
// 画像追加
//------------------------------------------------------//
function partsSetImg($post,$fld000){
 try{
  $mname="partsSetImg(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  
  //アップロードチェック
  foreach($post["allupimg"]["error"] as $key=>$val){
   if($val){
    throw new exception("ファイルアップロードに失敗しました。(".$val.")");
   }
  }
  
  //物件番号数字チェック
  if(!preg_match("/^[0-9]+$/",$fld000)){
   throw new exception ("物件番号が数字以外です。(".$fld000.")");wLog($c);
  }

  //物件番号DB存在チェック
  if(! viewDetail($fld000)){
   throw new exception ("物件未登録です。(".$fld000.")");wLog($c);
  }

  //画像ディレクトリセット
  $imgdir=realpath("../").IMG."/".$fld000;
  $c="notice:".$mname." 画像ディレクトリをセット(".$imgdir.")";wLog($c);
  
  //ディレクトリ存在チェック
  if(!file_exists($imgdir)){
   if(! mkdir($imgdir)){
    throw new exception("フォルダ作成に失敗しました。(".$fld000.")");wLog($c);
   }
  }

  //画像ファイルチェック
  $moto=$_FILES["allupimg"]["tmp_name"];
  if(!exif_imagetype($moto)){
   throw new exception("画像ファイルではありません");wLog($c);
  }

  //指定ディレクトリにファイルコピー
  $filename=mb_convert_encoding($post["allupimg"]["name"],"UTF-8","auto");
  $filename=$imgdir."/".$filename;
  if(! move_uploaded_file($moto,$filename)){
   throw new exception("ファイルコピーに失敗しました。");wLog($c);
  }
  $c="end:".$mname." 画像を保存しました";wLog($c);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);
 }
}


?>
