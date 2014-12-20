<?php
/*-----------------------------------------------------
 ファイル名:parts.function.php
 接頭語    :parts
 主な動作  :受け取ったデータからHTMLを生成する
 返り値    :HTMLを表示(echo $html)
 エラー    :エラーメッセージを表示
----------------------------------------------------- */

require_once("view.function.php");

function partsRainsList($data){
 try{
  $mname="partsRainsList(view.function.php) ";
  $c="start ".$mname;wLog($c);
  $html="";
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessge();wLog($c);echo $c;
 }
}

function partsRainsTable($data){
 try{
  $mname="partsRainsTable(view.function.php) ";
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
   $html.="<div class='div_15 detail'>".$val["fld021"].$val["fld022"]."&nbsp;</div>";
   $html.="<div class='div_15 detail'>".$val["fld018"].$val["fld019"].$val["fld020"]."</div>";
   $html.="<div class='div_5 text-right'>".$val["fld180"].$val["_fld179"]."</div>";
   $html.="<div class='div_5 text-right'>".$val["fld068"].$val["fld088"]."</div>";
   $html.="<div class='div_10 text-right'>".number_format($val["fld054"])."</div>";

   $html.="<div class='div_5 text-right'>".number_format($val["fld137"])."</div>";
   $html.="<div class='div_10 paddingleft'>".$val["fld004"]."</div>";
   $html.="<div class='div_10'>".$val["fld005"]."</div>";
   $html.="<div class='div_10 text-right'>".$val["fld011"]."</div>";
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
  $mname="partsRainsTest(view.function.php) ";
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
  $mname="partsArea(view.function.php) ";
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
  $mname="partsRainsList(view.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  $html.="<ul id=ul_area>";
  $html.="<li class='allcnt'>すべて(".$data["all"].")</li>";
  $html.="<li class='newdata'>新規(".$data["newdata"].")</li>";
  $html.="<li class='noimg'>画像なし(".$data["noimg"].")</li>";
  $html.="<li class='blacklist'>非表示(".$data["blacklist"].")</li>";
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
  $mname="partsFldCount(view.function.php) ";
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
  $mname="partsMadoriCount(view.function.php) ";
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
  $mname="partsStationCount(view.function.php) ";
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
  $mname="partsIndiv(view.function.php) ";
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
   $html.="<dd>:".$val["fld021"]." ".$val["fld022"]."</dd>";
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
  $mname="partsPrice(view.function.php) ";
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
  $mname="partsRoomType(view.function.php) ";
  $c="start ".$mname;wLog($c);

  if(! isset($data)||! is_array($data)||! count($data)){
   throw new exception("データがありません");wLog($c);
  }

  $html="";
  foreach($data as $key=>$val){
   $html.="<dl class='dl_roomt' data-fld000='".$val["fld000"]."'>";
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
  $mname="partsMember(view.function.php) ";
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
  $mname="partsNavi(view.function.php) ";
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
  $mname="partsImage(view.function.php) ";
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
  $mname="partsSetImg(view.function.php) ";
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
?>
