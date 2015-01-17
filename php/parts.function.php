<?php
/*-----------------------------------------------------
 ファイル名:parts.function.php
 接頭語    :parts
 主な動作  :受け取ったデータからHTMLを生成する
 返り値    :HTMLを表示(echo $html)
 エラー    :エラーメッセージを表示
----------------------------------------------------- */

require_once("view.function.php");
//require_once("simple_html_dom.php");

function partsRainsList($data){
 try{
  $mname="partsRainsList(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  $html="";
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsRainsTable($data){
 try{
  $mname="partsRainsTable(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  $html="";

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }
  
  $fld="";

  $html.="<ul id='ul_menu'>";
  $html.="<li><a href='#'>選択</a>";
  $html.="<ul>";
  $html.="<li><a id='sAll' href='#'>すべて</a></li>";
  $html.="<li><a id='nAll' href='#'>選択解除</a></li>";
  $html.="<li><a id='delData'></a></li>"; //jQueryで表示する
  $html.="</ul>";
  $html.="</li>";//選択
  $html.="</ul>";
  $html.="<div class='clr'></div>";

  $html.="<ul class='ul_a'>";
  foreach($data as $key=>$val){
   //同じデータが連続したら赤くする
   $n=$val["fld002"].$val["fld003"].$val["fld018"].$val["fld019"].$val["fld068"].$val["fld088"];

   $html.="<li id='li_".$val["fld000"]."' data-fld000='".$val["fld000"]."'>";
   $html.="<div class='datarow";
   if($key && $fld==$n){
    $html.=" redrow ";
   }
   $html.="' data-fld000='".$val["fld000"]."'>";
   $html.="<label>";
   $html.="<input type='checkbox' name='inp_".$val["fld000"]."'>";
   $html.="<div class='div_5'>".$val["_fld002"]."</div>";
   $html.="<div class='div_5'>".$val["_fld003"]."</div>";
   $html.="</label>";
   $html.="<a class='a_detail' href='#'>";
   $html.="<div class='div_15 detail'>".$val["fld021"].$val["fld022"]."&nbsp;</div>";
   $html.="<div class='div_15 detail'>".$val["fld018"].$val["fld019"].$val["fld020"]."</div>";
   $html.="<div class='div_5 text-right'>".$val["fld180"].$val["_fld179"]."</div>";
   $html.="<div class='div_5 text-right'>".$val["fld068"].$val["fld088"]."</div>";
   $html.="<div class='div_10 text-right'>".number_format($val["fld054"])."</div>";

   $html.="<div class='div_5 text-right'>".number_format($val["fld137"])."</div>";
   $html.="<div class='div_10 paddingleft'>".$val["fld004"]."</div>";
   $html.="<div class='div_10'>".$val["fld005"]."</div>";
   $html.="<div class='div_10 text-right'>".$val["fld011"]."</div>";
   $html.="</a>";
   $html.="<div class='clr'></div>";
   $html.="</div>";//div class='datarow'
   $html.="</li>";
   $html.="<div class='clr'></div>";
   $fld=$n;
  }
  $html.="</ul>";
  $c="end ".$mname;wLog($c);
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsRainsTest($sql){
 try{
  $mname="partsRainsTest(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  $d=array();

  $c=$mname."SQL配列からcolを抜き出す";wLog($c);
  foreach($sql as $key=>$val){
   $d[]=$val["col"];
  }
  $db=new DSET();
  $db->r["data"]=$d;
  $result=$db->dsetRainsFld();
  partsRainsTable($result["data"]);
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

//たぶんボツ
function partsArea($data){
 try{
  $mname="partsArea(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $c=$mname."データ数カウント開始";wLog($c);
  $cnt0=array();
  $cnt1=array();

  foreach($data as $key=>$val){
   $cnt[$val["fld017"]]+=$val["count"];
   $cnt1[$val["fld018"]]+=$val["count"];
  }
  
  $c=$mname."HTML生成開始";wLog($c);
  $fld017="";
  $fld018="";
  $fld019="";
  $html="";
  $html.="<ul id=ul_area>";
  foreach($data as $key=>$val){
   //都道府県表示
   if($fld017!=$val["fld017"]){
    if($key) $html.="</ul></li>";//ul class='fld018'
    $html.="<li class='fld017'>".$val["fld017"];
    //カウント数表示
    foreach($cnt as $key1=>$val1){
     if($key1==$val["fld017"]){
      $html.="(".$val1.")";
      break;
     }
    }
    $html.="</li>";
    $html.="<li><ul class='fld018'>";
    $fld017=$val["fld017"];
   }

   //市区町村表示
   if($fld018!=$val["fld018"]){
    if($key) $html.="</ui></li>";//ul class='fld019'
    $html.="<li class='fld018'>".$val["fld018"];

    //カウント数表示
    foreach($cnt1 as $key1=>$val1){
     if($key1==$val["fld018"]){
      $html.="(".$val1.")";
      break;
     }
    }
    $html.="</li>";
    $html.="<li><ul class='fld019'>";
    $fld018=$val["fld018"];
   }

   //丁目表示
   if($fld019!=$val["fld019"]){
    $html.="<li class='fld019'>".$val["fld019"]."(".$val["count"].")</li>";
    $fld019=$val["fld019"];
   }

  }
  $html.="</ul>";
  $c="end ".$mname;wLog($c);
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsNewList($data){
 try{
  $mname="partsRainsList(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  $html.="<ul id=ul_area>";
  $html.="</ul>";//ul id=ul_area
  $c="end ".$mname;wLog($c);
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}
  
function partsFldCount($data){
 try{
  $mname="partsFldCount(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  $html.="<h4>物件種類</h4>";
  $html.="<ul id='ul_fld'>";
  foreach($data as $key=>$val){
   $fld001=mb_split("_",$key);
   $html.="<li class='fld001' data-fld001='".$fld001[0]."'>".$fld001[1]."</li>";
   $html.="<li><ul>";
   foreach($val as $key1=>$val1){
    $fld002=mb_split("_",$key1);
    foreach($val1 as $key2=>$val2){
     $fld003=mb_split("_",$key2);
     $html.="<li class='fld003' data-fld001='".$fld001[0]."' data-fld002='".$fld002[0]."' data-fld003='".$fld003[0]."'>".$fld003[1]."(".$val2.")</li>";
    }
   }
   $html.="</ul></li>";
  }
  $html.="</ul>";
  $c="end ".$mname;wLog($c);
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsMadoriCount($data){
 try{
  $mname="partsMadoriCount(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  $html.="<h4>間取り</h4>";
  $html.="<ul id='ul_madori'>";
  $html.="<li><ul class='ul_fld180'>";
  foreach($data as $key=>$val){
   $s=preg_split("/_/",$key);
   $mtype=$s[2];
   preg_match("/^[0-9]+/",$s[3],$r);
   $room=$r[0];
   $html.="<li class='fld180' data-fld179='".$mtype."' data-fld180='".$room."'>".$s[3]."(".$val.")</li>";
  }
  $html.="</ul></li></ul>";
  $c="end ".$mname;wLog($c);
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsStationCount($data){
 try{
  $mname="partsStationCount(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  $html.="<h4>最寄駅</h4>";
  $html.="<ul id='ul_station'>";
  foreach($data as $key=>$val){
   $html.="<li class='fld025' data-line='".$key."'>".$key."</li>";
   $html.="<li><ul class='ul_fld026'>";
   foreach($val as $key1=>$val1){
    $html.="<li class='fld026' data-line='".$key."' data-station='".$key1."'>".$key1."(".$val1.")</li>";
   }
   $html.="</ul></li>";
  }
  $html.="</ul>";
  $c="end ".$mname;wLog($c);
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsIndivi($data){
 try{
  $mname="partsIndiv(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  foreach($data as $key=>$val){
   $html.="<dl class='dl_indivi' data-fld000='".$val["fld000"]."'>";
   $html.="<dt>物件種類</dt>";
   $html.="<dd>:".$val["_fld001"]." ".$val["_fld002"]." ".$val["_fld003"]."</dd>";
   $html.="<dt>物件番号</dt>";
   $html.="<dd>:".$val["fld000"]."</dd>";
   $html.="<dt>物件名</dt>";
   $html.="<dd>:".$val["fld021"]." ".$val["fld022"];
   if($val["fld021"]){
    $html.="<a href='https://www.google.co.jp/search?hl=ja&source=hp&q=".urlencode($val["fld021"])."' target='_blank'>【検索】</a>";
   }
   $html.="</dd>";
   $html.="<dt>住所</dt>";

   $html.="<dd id='startpoint'";
   if(is_array($val["latlng"]) ||count($val["latlng"])){
    $html.=" data-lat='".$val["latlng"]["startlat"]."' ";
    $html.=" data-lng='".$val["latlng"]["startlng"]."' >";
   }
   else{
    $html.=">";
   }
   $html.=":".$val["fld017"]." ".$val["fld018"].$val["fld019"].$val["fld020"]."</dd>";

   $html.="<dt>最寄駅</dt>";
   $html.="<dd id='endpoint'";
   if(is_array($val["latlng"]) ||count($val["latlng"])){
    $html.=" data-lat='".$val["latlng"]["endlat"]."' ";
    $html.=" data-lng='".$val["latlng"]["endlng"]."' >";
   }
   else{
    $html.=">";
   }
   $html.=":".$val["fld026"]."駅 (".$val["fld025"].") 徒歩".$val["fld027"]."分</dd>";

   $html.="</dl>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsPrice($data){
 try{
  $mname="partsPrice(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  foreach($data as $key=>$val){
   $html.="<dl class='dl_price' data-fld000='".$val["fld000"]."'>";
   if    ($val["fld001"]=="01") $html.="<dt>価格</dt>";
   elseif($val["fld001"]=="03") $html.="<dt>賃料</dt>";
   $html.="<dd>:".number_format($val["fld054"])."円";
   if($val["fld055"])$html.="(消費税".number_format($val["fld055"])."円)";
   $html.="</dd>";

   $html.="<dt>管理費</dt>";
   $html.="<dd>:";
   if($val["fld137"]) $html.=number_format($val["fld137"])."円";
   if($val["fld138"]) $html.="(消費税".$val["fld138"]."円)";
   $html.="</dd>";

   $html.="<dt>敷礼金</dt>";
   $html.="<dd>:";
   if($val["fld077"] || $val["fld078"]){
    $html.="敷金";
    if($val["fld077"]) $html.=$val["fld077"]."円";
    if($val["fld078"]) $html.=($val["fld078"]*1)."ヶ月";
   }
   if($val["fld074"]|| $val["fld076"]){
    $html.=" 礼金";
    if($val["fld074"]) $html.=$val["fld074"]."円";
    if($val["fld075"]) $html.="(消費税".$val["fld075"]."円)";
    if($val["fld076"]) $html.=($val["fld076"]*1)."ヶ月";
   }
   $html.="</dd>";

   $html.="<dt>更新料</dt>";
   $html.="<dd>:";
   if($val["fld146"]) $html.="新賃料の";
   if($val["fld147"]) $html.=number_format($val["fld147"])."円";
   if($val["fld148"]) $html.=($val["fld148"]*1)."ヶ月";
   $html.="</dd>";

   $html.="<dt>保証金</dt>";
   $html.="<dd>:";
   if($val["fld069"]) $html.=number_format($val["fld069"])."円";
   if($val["fld070"]) $html.=($val["fld070"]*1)."ヶ月";
   $html.="</dd>";

   $html.="<dt>その他</dt>";
   $html.="<dd>";
   if($val["fld071"] || $val["fld072"] ||$val["fld073"]){
    $html.=" 権利金:";
    if($val["fld071"]) $html.=number_format($val["fld071"])."円";
    if($val["fld072"]) $html.="(消費税".number_format($val["fld072"])."円)";
    if($val["fld073"]) $html.=$val["fld071"]."ヶ月";
   }
   if($val["fld123"]) $html.=" 造作譲渡金:".number_format($val["fld123"])."円";
   if($val["fld124"]) $html.=" 定借権利金:".number_format($val["fld124"])."円";
   if($val["fld125"]) $html.=" 定借保証金:".number_format($val["fld125"])."円";
   if($val["fld126"]) $html.=" 定借敷金:".number_format($val["fld126"])."円";
   if($val["fld139"]) $html.=" 修繕積立金:".number_format($val["fld139"])."円";
   if($val["fld140"]) $html.=" 共益費:".number_format($val["fld140"])."円";
   if($val["fld141"]) $html.=" 共益費(消費税):".number_format($val["fld141"])."円";
   if($val["fld142"]) $html.=" 雑費:".number_format($val["fld142"])."円";
   if($val["fld143"]) $html.=" 雑費(消費税):".number_format($val["fld143"])."円";

   $html.="</dd>";
   $html.="</dl>";

   $html.="</dl>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsRoomType($data){
 try{
  $mname="partsRoomType(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  foreach($data as $key=>$val){
   $html.="<dl class='dl_room' data-fld000='".$val["fld000"]."'>";
   $html.="<dt>間取り</dt>";
   $html.="<dd>:".$val["fld180"].$val["_fld179"]."</dd>";

   $html.="<dt>間取詳細</dt>";
   $html.="<dd>:";

   $kai="";
   for($i=183;$i<=207;$i=$i+4){
    $f1="fld".$i;
    $f2="fld".($i+1);
    $f3="fld".($i+2);
    $f4="fld".($i+3);

    if($val[$f1]){
     if($kai!=$val[$f1]){
      $html.=$val[$f1]."階 ";
      $kai=$val[$f1];
     }
     $html.="[".$val["_".$f2].$val[$f3]."帖x".$val[$f4]."] ";
    }
    
   }
   $html.="</dd>";

   $html.="<dt>広さ</dt>";
   $html.="<dd>:";
   if($val["fld068"]) $html.="(専有)".$val["fld068"]."m&#178";
   if($val["fld088"]) $html.="(土地)".$val["fld088"]."m&#178";
   if($val["fld092"]) $html.="(建物)".$val["fld092"]."m&#178";
   if($val["fld095"]) $html.="(バルコニー)".$val["fld095"]."m&#178";
   if($val["fld105"]) $html.="(庭)".$val["fld105"]."m&#178";
   $html.="</dd>";

   $html.="<dt>建物構造</dt>";
   $html.="<dd>:";
   $html.=$val["_fld219"]." ";
   if($val["fld222"]) $html.="".$val["fld222"]."階建";
   if($val["fld223"]) $html.="(地下".$val["fld223"]."階)";
   $html.="</dd>";

   $html.="<dt>築年月</dt>";
   preg_match("/^([0-9]{4})([0-9]{2})/",$val["fld225"],$match);
   $html.="<dd>:";
   if($match[1]) $html.=$match[1]."年".$match[2]."月";
   $html.="</dd>";

   $html.="<dt>駐車場</dt>";
   $html.="<dd>:";
   if($val["fld213"]) $html.=$val["_fld212"]." 月額".number_format($val["fld213"])."円";
   if($val["fld215"]) $html.=" 敷金".$val["fld215"]."円";
   if($val["fld216"]) $html.=" 敷金".($val["fld216"]*1)."ヶ月";

   if($val["fld217"]) $html.=" 礼金".$val["fld217"]."円";
   if($val["fld218"]) $html.=" 礼金".($val["fld218"]*1)."ヶ月";
   $html.="</dd>";
   $html.="</dl>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsMember($data){
 try{
  $mname="partsMember(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  foreach($data as $key=>$val){
   $html.="<dl class='dl_member' data-fld000='".$val["fld000"]."'>";
   $html.="<dt>取扱会社</dt>";
   $html.="<dd>:".$val["fld004"]."</dd>";
   $html.="<dt>電話番号</dt>";
   $html.="<dd>:".$val["fld005"]." ".$val["fld006"]." ".$val["fld008"]."</dd>";
   $html.="<dt>メール</dt>";
   $html.="<dd>:".$val["fld009"]."</dd>";

   $html.="<dt>登録日</dt>";
   $html.="<dd>:".date("Y年m月d日",strtotime($val["fld011"]));
   if($val["fld012"]) $html.="(".date("Y年m月d日",strtotime($val["fld012"]))."変更)";
   $html.="</dd>";
   $html.="</dl>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsNavi($data,$edit=null){
 try{
  $mname="partsNavi(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }
  $html="";
  foreach($data as $key=>$val){
   $html.="<ul class='ul_navi'>";
   $html.="<li><a class='a_back' href='#' data-fld000='".$val["fld000"]."'><-戻る</a></li>";
   if($edit){
    $html.="<li><a class='a_upload' href='#'>画像送信</a>";
    $html.="<input name='uploadimg' type='file' value='画像登録' style='display:none;' data-fld000='".$val["fld000"]."' multiple></li>";
    $html.="<li><a class='a_delimg' href='#' data-fld000='".$val["fld000"]."'>画像全削除</a></li>";
    $html.="<li><a class='a_outsite' href='#'>画像取り込み</a></li>";
    $html.="<li><input name='outsite' type='text' value='' style='display:none;' data-fld000='".$val["fld000"]."' multiple></li>";
   }
   $html.="</ul>";
   $html.="<div class='clr'></div>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
 
}

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
    $imgpath=".".IMG."/".$val1["fld000"]."/".$val1["fld002"];
    $html.="<li data-fld000='".$val["fld000"]."' data-imgid='".$val1["id"]."'>";
    if($edit){
     $html.="<input type='text' value='".$val1["fld001"]."' data-fld000='".$val1["fld000"]."' data-imgid='".$val1["id"]."'>";
     $html.="<input type='button' value='削除' data-fld000='".$val1["fld000"]."' data-imgid='".$val1["id"]."'>";
    }
    //$html.="<div class='imgdiv'>";
    $html.="<img src='".$imgpath."' alt='".$val1["fld003"]."'>";
    //$html.="</div>";
    $html.="</li>";
   }
   $html.="</ul>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c); echo $c;
 }
}

function partsLapDetail($data){
 partsIndivi($data);
 partsPrice($data);
 partsRoomType($data);
 partsMember($data);
}

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
   throw new exception ("物件番号が数字以外です。(".$fld000.")");
  }

  //物件番号DB存在チェック
  if(! viewDetail($fld000)){
   throw new exception ("物件未登録です。(".$fld000.")");
  }

  //画像ディレクトリセット
  $imgdir=realpath("../").IMG."/".$fld000;
  
  //ディレクトリ存在チェック
  if(!file_exists($imgdir)){
   if(! mkdir($imgdir)){
    throw new exception("フォルダ作成に失敗しました。(".$fld000.")");
   }
  }

  //画像ファイルチェック
  $moto=$_FILES["allupimg"]["tmp_name"];
  if(!exif_imagetype($moto)){
   throw new exception("画像ファイルではありません");
  }

  //指定ディレクトリにファイルコピー
  $filename=mb_convert_encoding($post["allupimg"]["name"],"UTF-8","auto");
  $filename=$imgdir."/".$filename;
  if(! move_uploaded_file($moto,$filename)){
   throw new exception("ファイルコピーに失敗しました。");
  }
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsSetImgFromSite($imgurl,$fld000){
 try{
  $mname="partsSetImgFromSite(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  $html="";

  //物件番号数字チェック
  if(!preg_match("/^[0-9]+$/",$fld000)){
   throw new exception ("物件番号が数字以外です。(".$fld000.")");
  }

  //物件番号DB存在チェック
  if(! viewDetail($fld000)){
   throw new exception ("物件未登録です。(".$fld000.")");
  }

  //画像ディレクトリセット
  $imgdir=realpath("..").IMG."/".$fld000;

  //ディレクトリ存在チェック
  if(!file_exists($imgdir)){
   if(! mkdir($imgdir)){
    throw new exception("フォルダ作成に失敗しました。(".$fld000.")");
   }
  }

  $c="notice:".$mname." 画像URL(".$imgurl.")";wLog($c);
  $imgurl=urldecode($imgurl);
  $c="notice:".$mname." 画像URLデコード(".$imgurl.")";wLog($c);

  //ファイル名ゲット
  $filename=basename($imgurl);
  $c="notice:".$mname."画像ファイル名ゲット".$filename;wLog($c);
  $filename=urldecode($filename);
  $c="notice:".$mname."画像ファイル名デコード".$filename;wLog($c);
  $pattern="/[!\"#$%&'()=|`{}+*,<>\/;:]/"; 
  $filename=preg_replace($pattern,"_",$filename);
  $c="notice:".$mname."画像ファイル名変換".$filename;wLog($c);
  
  //ファイルダウンロード
  $data=file_get_contents($imgurl);
  
  //ファイル保存
  if(file_put_contents($imgdir."/".$filename,$data)===FALSE){
   $c="error:".$mname."画像ファイルの保存に失敗(".$imgurl.")";wLog($c);
   throw new exception($c);
  }
  $c="notice:".$mname."画像ファイルを保存しました(".$imgdir."/".$filename.")";wLog($c);
  
  //画像ファイルチェック
  if(!exif_imagetype($imgdir."/".$filename)){
   unlink($imgdir."/".$filename);
   $c="error:".$mname."画像ファイルではありません(".$val.")";wLog($c);
   throw new exception($c);
  }
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsImgPathFromSite($pageurl){
 $mname="partsImgPathFromSite(parts.function.php) ";
 try{
  $c="start ".$mname;wLog($c);

  $blacklist="/www\.townhousing\.co\.jp|suumo\.jp|www\.homes\.co\.jp/";

  if(! $purl=parse_url($pageurl)){
   throw new exception("URLが認識できません(".$pageurl.")");
  }

  $html=@file_get_contents($pageurl);
  if($html ===FALSE){
   $c="error:".$mname." ページが取得できません(".$pageurl.")";wLog($c);
   throw new exception ($c);
  }
  
  //まずはimgタグだけ抜き出す
  $pattern="/<img.*?>/s";
  preg_match_all($pattern,$html,$match);
  
  $url=array();
  foreach($match[0] as $key=>$val){
   //imgタグを除く
   $data=preg_replace("/^<img|\/?>$/","",$val);
   $c="notice:".$mname."imgタグ除外".$data;wLog($c);
   
   //'"を削除
   $data=preg_replace("/\'|\"/","",$data);
   $c="notice:".$mname."'を除外".$data;wLog($c);
   
   //空欄ごとに区切る
   $data=preg_split("/[\s]+/",$data);
   
  //属性と値を配列に格納
   $col=array();
   foreach($data as $key1=>$val1){
    if(! $val1){
     $c="notice:".$mname."値空欄のためスキップ";wLog($c);
     continue;
    }
    preg_match("/(.*?)={1}(.*)/",$val1,$m);
    $c="notice:".$mname."配列へ格納".$m[1]."=>".$m[2];wLog($c);
    $col[$m[1]]=$m[2];
   }

  //src属性なければスキップ
   if(!$col["src"]){
    $c="notice:".$mname." src属性がありません。処理をスキップします(".$val.")";wLog($c);
    continue;
   }
   
  //src属性をバックアップ
   $col["_src"]=$col["src"];
  
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
    
    // 「/」から始まっていない
    elseif(preg_match("/^[^\/]/",$col["src"])){
     $c="notice:".$mname." 画像パスが相対パス".$col["src"];wLog($c);
     $col["src"]=$pageurl.$col["src"];
    }
   }
  
  //タウンハウジング用カスタマイズ(name属性有効でhttpから始まる場合)
   if($col["name"] && preg_match("/^http/",$col["name"])){
    $c="notice:".$mname." タウンハウジング用パス変換".$col["src"];wLog($c);
    $col["src"]=$col["name"];
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
    $c="notice:".$mname."homes用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("/&amp;.*$/","",$col["src"]);
   }
   
  //athome用カスタマイズ(拡張子後のオプションを削除)
   if(preg_match("/athome\.co\.jp/",$col["src"])){
    $c="notice:".$mname."athome用パス変換".$col["src"];wLog($c);
    $col["src"]=preg_replace("\?.*$/","",$col["src"]);
   }
  //ブラックリスト除外
   if( preg_match($blacklist,$col["src"])){
    $c="notice:".$mname."ブラックリスト該当".$col["src"];wLog($c);
    continue;
   }

   $c="notice:".$mname."画像パス登録";wLog($c);
   $url[]=$col;
  }
  
  unset($html);
  $c="end:".$mname;wLog($c);
  return $url;
 }
 catch(Exception $e){
  //$html->clear();
  wLog("error:".$mname.$e->getMessage());
  echo "err:".$e->getMessage();
 }
}

function partsImgListFromSite($data){
 try{
  $mname="partsImgListFromSite(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("画像データがありません");wLog($c);
  }
  $html="";
  $html.="<ul class='ul_image'>";
  foreach($data as $key=>$val){
   $html.="<li>";
   $html.="<input type='button' value='Pick'>";
   $html.="<img src='".$val["src"]."'>";
   $html.="</li>";
  }
  $html.="</ul>";
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsImgListDiv($fld000){
 try{
  $mname="partsImgListDiv(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  if(!preg_match("/^[0-9]+$/",$fld000)){
   throw new exception("物件番号が正しくありません");wLog($c);
  }

  $html="";
  $html.="<div class='divoutsite'data-fld000='".$fld000."'>";
  $html.="<label class='outsitelabel' for='outsiteurl'>外部URL:</label>";
  $html.="<input type='text' name='outsiteurl' id='outsiteurl'>";
  $html.="<a class='a_get' href='#'>Get</a>";
  $html.="<a class='a_close' href='#'>閉じる</a>";
  $html.="</div>";
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsRankEntry(){
 try{
  $mname="partsRankEntry(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  $html="";
  $html.=<<<EOF
<div class='divrankentry'>
 <ul class='ul_rankentry'>
  <li><span class='spn_5 titlecolor'>番号</span>
      <span class='spn_15 titlecolor'>タイトル</span>
      <span class='spn_15 titlecolor'>コメント</span>
      <span class='spn_5 titlecolor'>開始日</span>
      <span class='spn_5 titlecolor'>終了日</span>
      <span class='spn_5 titlecolor'>表示</span>
      <div class='clr'></div>
  </li>

  <li><span class='spn_5  bodercolor' ><input type='text' name='rank' value=''></span>
      <span class='spn_15 bodercolor'><input type='text' name='rankname' value=''></span>
      <span class='spn_15 bodercolor'><input type='text' name='rcomment' value=''></span>
      <span class='spn_5 bodercolor'><input type='text' name='startday' value=''></span>
      <span class='spn_5 bodercolor'><input type='text' name='endday'   value=''></span>
      <span class='spn_5 bodercolor'>
       <select name='flg'>
        <option value='1'>する</option>
        <option value='0'>しない</option>
       </select>
      </span>
    
      <div class='clr'></div>
  </li>

  <li><a class='a_rankdel'   href='#'>削除</a>
      <a class='a_rankentry' href='#'>登録</a>
  </li>
 </ul>
</div>
EOF;
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsRankList($data){
 try{
  $mname="partsRankList(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  $html="";
  $html.="<div class='divrankentry'>";
  $html.="<ul class='ul_rank'>";
  $html.="<li><span class='spn_5 titlecolor'>番号</span>";
  $html.="<span class='spn_15 titlecolor'>タイトル</span>";
  $html.="<span class='spn_15 titlecolor'>コメント</span>";
  $html.="<span class='spn_5 titlecolor'>開始日</span>";
  $html.="<span class='spn_5 titlecolor'>終了日</span>";
  $html.="<span class='spn_5 titlecolor'>表示</span>";
  $html.="<div class='clr'></div>";
  $html.="</li>";
  if(! isset($data)||! is_array($data)||! count($data)){
   $c="notice:".$mname."ランクデータがありません";wLog($c);
   return false;
  }
  foreach($data as $key=>$val){
   $html.="<li>";
   $html.="<span class='spn_5 boxborder'>".$val["rank"]."</span>";
   $html.="<span class='spn_15 boxborder'>".$val["rankname"]."</span>";
   $html.="<span class='spn_15 boxborder'>".$val["rcomment"]."</span>";
   $html.="<span class='spn_5 boxborder'>".$val["startday"]."</span>";
   $html.="<span class='spn_5 boxborder'>".$val["endday"]."</span>";
   $html.="<span class='spn_5 boxborder'>";
   if($val["flg"]==1) $html.="する";
   elseif($val["flg"]==0) $html.="しない";
   $html.="</span>";
   $html.="<div class='clr'></div>";
   $html.="</li>";
  }
  $html.="</ul></div>";

  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsRankListShort($data){
 try{
  $mname="partsRankListShort(parts.function.php) ";
  $c="start ".$mname;wLog($c);

  $html="";
  $html.="<div class='divshortrank'>";
  $html.="<ul class='ul_shortrank'>";
  $html.="<li><span class='spn_5 titlecolor'>番号</span>";
  $html.="<span class='spn_15 titlecolor'>タイトル</span>";
  $html.="<span class='spn_5 titlecolor'>開始日</span>";
  $html.="<span class='spn_5 titlecolor'>終了日</span>";
  $html.="<div class='clr'></div>";
  $html.="</li>";
  if(! isset($data)||! is_array($data)||! count($data)){
   $c="notice:".$mname."ランクデータがありません";wLog($c);
   return false;
  }
  foreach($data as $key=>$val){
   $html.="<li>";
   $html.="<span class='spn_5 boxborder'>".$val["rank"]."</span>";
   $html.="<span class='spn_15 boxborder'>".$val["rankname"]."</span>";
   $html.="<span class='spn_5 boxborder'>".$val["startday"]."</span>";
   $html.="<span class='spn_5 boxborder'>".$val["endday"]."</span>";
   $html.="<div class='clr'></div>";
   $html.="</li>";
  }
  $html.="</ul></div>";

  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsEntryList($data){
 try{
  $mname="partsEntryList(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  if(! isset($data)||! is_array($data)||! count($data)){
   $c="エントリーデータがありません";wLog($c);
   return false;
  }

  $html="";
  $html.="<h4>ランキング</h4>";
  $html.="<ul>";
  $html.="<li><span class='spn_5 titlecolor'>番号</span>";
  $html.="<span class='spn_15 titlecolor'>タイトル</span>";
  //$html.="<span class='spn_5 titlecolor'>開始日</span>";
  //$html.="<span class='spn_5 titlecolor'>終了日</span>";
  $html.="<div class='clr'></div>";
  $html.="</li>";
  
  foreach($data as $key=>$val){
   $html.="<li>";
   $html.="<span class='spn_5 boxborder'>".$val["rank"]."</span>";
   $html.="<span class='spn_15 boxborder'>".$val["rankname"]."</span>";
  // $html.="<span class='spn_5 boxborder'>".$val["startday"]."</span>";
  // $html.="<span class='spn_5 boxborder'>".$val["endday"]."</span>";
   $html.="<div class='clr'></div>";
   $html.="</li>";
  }
  $html.="</ul>";

  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsEntry($data){
 try{
  $mname="partsEntry(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  if(! isset($data)||! is_array($data)||! count($data)){
   $c="エントリーデータがありません";wLog($c);
   return false;
  }
  $html="";
  $html.="<h3>ランキング詳細</h3>";
  $html.="<a class='a_delall' href='#'>全削除</a>";
  $html.="<ul class='ul_entry'>";
  $html.="<li>";
  $html.="<span class='spn_5  titlecolor'>削除</span>";
  $html.="<span class='spn_5  titlecolor'>順位</span>";
  $html.="<span class='spn_15 titlecolor'>物件名</span>";
  $html.="<span class='spn_5  titlecolor'>価格</span>";
  $html.="<span class='spn_20 titlecolor'>コメント</span>";
  $html.="<div class='clr'></div>";
  $html.="</li>";
  foreach($data as $key=>$val){
   $html.="<li>";
   $html.="<span class='spn_5 bodercolor'><a href='#' class='a_entrydel' data-id='".$val["entryid"]."' data-rank='".$val["rank"]."'>削除</a></span>";
   $html.="<span class='spn_5 bodercolor'><input type='text' value='".$val["entry"]."'";
   $html.=" data-id='".$val["entryid"]."' name='entry'></span>";
   $html.="<span class='spn_15 bodercolor'>";
   if($val["fld021"]){
    $html.=$val["fld021"].$val["fld022"];
   }
   else{
    $html.=$val["fld018"].$val["fld019"].$val["fld020"];
   }
   $html.="</span>";
   $html.="<span class='spn_5 bodercolor'>";
   $html.=number_format($val["fld054"]);
   $html.="</span>";
   $html.="<span class='spn_20 bodercolor'>";
   $html.="<input type='text' value='".$val["ecomment"]."' data-id='".$val["entryid"]."' name='ecomment'>";
   $html.="</span>";
   $html.="<div class='clr'></div>";
   $html.="</li>";
  }
  $html.="</ul>";

  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsComment($data){
 try{
  $mname="partsRankList(parts.function.php) ";
  $c="start ".$mname;wLog($c);
  if(! isset($data)||! is_array($data)||! count($data)){
   $c="物件データがありません";wLog($c);
   return false;
  }
  $html="";
  foreach($data["data"] as $key=>$val){
   $html.="<h4>その他設備</h4>";
   $html.="<textarea name='txt_setubi' data-fld000='".$val["fld000"]."'>".$val["setubi"]."</textarea>";
   $html.="<h4>コメント</h4>";
   $html.="<input name='inp_bcomment' type='text' value='".$val["bcomment"]."' data-fld000='".$val["fld000"]."'>";

   $html.="<h4>ランキング登録</h4>";
   $html.="<select name='select_rank' data-fld000='".$val["fld000"]."'>";
   $html.="<option value=0>選択してください</option>";
   foreach($data["ranklist"] as $key1=>$val1){
    $html.="<option value='".$val1["rank"]."'";
    if($val1["rank"]==$val["rank"]) $html.=" selected ";
    $html.=">";
    $html.=$val1["rankname"];
    $html.="</option>";
   }
   $html.="</select>";
  }
  echo $html;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}
?>
