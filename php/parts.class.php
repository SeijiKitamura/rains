<?php
require_once("view.class.php");

class PARTS extends RAINS{
 public $rains;
 public $html;

 public $rainsdata;

 function __construct(){
  parent::__construct();
  $pages=$PAGES;
 }

 public function getHeader($page=null){
  global $PAGES;
  if(! $page){
   $page=basename($_SERVER["REQUEST_URI"]);
  }
  $html="";
  $html.="<!DOCTYPE html>";
  $html.="<html jang='ja'>";
  $html.="<head>";
  $html.="<meta charset='UTF-8'>";
  $html.="<meta name='viewport' content='width=device-width,user-scalable=no,maximum-scale=1'>";
  $html.="<title>".CORPNAME."</title>";
  $html.="<link rel='stylesheet' type='text/css' href='css/all.css'>";
  foreach($PAGES[$page]["css"] as $key=>$val){
   $html.="<link rel='stylesheet' type='text/css' href='css/".$val."'>";
  }
  $html.="<style></style>";
  $html.="</head>";
  $html.="<body>";
  $html.="<header>";
  $html.="<hr>";
  $html.="<div id='divlogo'>";
  $html.="<p>".CATCHWORD."</p>";
  $html.="<img id='logo' src='".LOGO."' alt='".CORPNAME."のロゴマーク'>";
  $html.="</div>";
  $html.="<dl class='telfax'>";
  $html.="<dt class='dt_tel'>TEL</dt><dd class='dd_tel'>".CORPTEL."</dd>";
  $html.="<dt class='dt_fax'>FAX</dt><dd class='dd_fax'>".CORPFAX."</dd>";
  $html.="</dl>";
  $html.="<div class='clr'></div>";
  $html.="<hr>";
  $html.="<nav class='topnavi'>";
  $html.=$this->getNavi($page);
  $html.="<div class='clr'></div>";
  $html.="</nav>";
  $html.="</header>";

  $this->rainsdata["header"]=$html;
 }

 public function getNavi($page=null){
  global $PAGES;
  if(! $page){
   $page=basename($_SERVER["REQUEST_URI"]);
  }
  $html="";
  $html.="<ul class='ulnav'>";
  foreach($PAGES as $key=>$val){
   $html.="<li>";
   $html.="<a ";
   if($page==$key){
    $html.="class='thispage'";
   }
   $html.=" href='".$key."'>";
   $html.=$val["title"];
   $html.="</a>";
   $html.="</li>";
  }
  $html.="</ul>";
  return $html;
 }

 public function smallparts(){
  global $FLD180;

  //絞り込むなら$this->whereに条件式をセットしておく
  
  //配列初期化
  unset($this->rainsdata["rains"]);
  unset($this->rainsdata["smalllist"]);
  $html="";
  
  //Rainsテーブルからデータを抽出
  $this->rainsdata["rains"]=$this->getRains();

  if(isset($this->rainsdata["rains"])){
   foreach($this->rainsdata["rains"] as $rows=>$row){
    //列名データを除く
    if(! $rows) continue;

    $html.="<div class='smalllist'>";
    $html.="<div class='smallimg'>";
    //画像パス配列リセット
    $imgpath=array();
    $imgpath=$this->getImgPath($row["fld000"]);
    if(is_array($imgpath)){
     foreach($imgpath as $key=>$val){
      if($key) break; //最初の画像しか表示しない
      $html.="<a href='detail.php?fld000=".$row["fld000"]."'>";
      $html.="<img src='.".IMG."/".$row["fld000"]."/".$val["fld002"]."' alt='".$row["fld021"]."'>";
      $html.="</a>";
     }
    }
    $html.="</div>";//div class='smallimg'

    $html.="<div class='smalldetail'>";
    $html.="<a href='detail.php?fld000=".$row["fld000"]."'>";
    $html.="<dl class='smalldl'>";

//    $html.="<dt>物件番号:</dt>";
//    $html.="<dd>".$row["fld000"]."</dd>";

    $html.="<dt>価格:</dt>";
    $html.="<dd class='price'>".number_format($row["fld054"])."<span class='yen'>円</span></dd>";

    $html.="<dt>礼敷金:</dt>";
    $html.="<dd>";

    if($row["fld074"]){
     $html.=" 礼金".$row["fld074"]."円 ";
     if($row["fld075"]){
      $html.="+税 ";
     }
    }
    elseif($row["fld076"]){
     $html.=" 礼金".($row["fld076"]*1)."ヶ月 ";
    }

    if($row["fld077"]){
     $html.="敷金 ".$row["fld077"]."円";
    }
    elseif($row["fld078"]){
     $html.="敷金".($row["fld078"]*1)."ヶ月";
    }

    $html.="</dd>";

    $html.="<dt>間取り:</dt>";
    if($row["fld180"]){
     $html.="<dd>";
     $html.=$row["fld180"].$row["fld179"];
     $html.="</dd>";
    }
    else{$html.="<dd>&nbsp;</dd>";}
    $html.="<dt>物件名:</dt>";
    $html.="<dd>".$row["fld021"]."&nbsp";
    if(isset($row["fld022"]) && $row["fld022"]) $html.=$row["fld022"]."号室";
    $html.="</dd>";
    
    if($row["fld224"]){
     $html.="<dt>所在階</dt>";
     $html.="<dd>";
     if($row["fld222"]){
      $html.=$row["fld222"]."階建 ";
     }
     $html.=$row["fld224"]."階";
     $html.="</dd>";
    }

    $html.="<dt>最寄駅:</dt>";
    $html.="<dd>".$row["fld025"].$row["fld026"]."駅 徒歩".$row["fld027"]."分</dd>";
    $html.="<dt>所在地:</dt>";
//    html.="<dd>".$row["fld017"].$row["fld018"].$row["fld019"].$row["fld020"]."</dd>";
    $html.="<dd>".$row["fld018"].$row["fld019"].$row["fld020"]."</dd>";
    $html.="</dl>";
    $html.="</a>";
    $html.="</div>";//div class='smalldetail'
    $html.="</div>";//div class='smalllist'
   }//foreach
  }//if
  $this->rainsdata["smalllist"]=$html; 
 }
 
 public function smallparts2(){
  global $FLD;
  
  //絞り込むなら$this->whereに条件式をセットしておく
  
  //配列初期化
  unset($this->rainsdata["rains"]);
  unset($this->rainsdata["smalllist"]);
  $html="";
  //Rainsテーブルからデータを抽出
  $this->rainsdata["rains"]=$this->getRains();

  if(isset($this->rainsdata["rains"])){
   foreach($this->rainsdata["rains"] as $rows=>$row){
    //列名データを除く
    if(! $rows) continue;
    $html.="<div class='smalllist2'>";
    $html.="<div class='smallimg2'>";
    //画像パス配列リセット
    $imgpath=array();
    $imgpath=$this->getImgPath($row["fld000"]);
    if(is_array($imgpath)){
     foreach($imgpath as $key=>$val){
      if($key) break; //最初の画像しか表示しない
      $html.="<a href='detail.php?fld000=".$row["fld000"]."'>";
      $html.="<img src='".$val."' alt='".$row["fld021"]."'>";
      $html.="</a>";
     }
    }
    $html.="</div>";//div class='smallimg'

    $html.="<a href='detail.php?fld000=".$row["fld000"]."'>";
    $html.="<dl class='smalldetail2'>";
    $html.="<dt>間取り:</dt>";
    if($row["fld180"]){
     $html.="<dd class='madori'>";
     $html.=$row["fld180"].$row["fld179"];
     $html.="</dd>";
    }
    else{$html.="<dd class='madori'>&nbsp;</dd>";}

    $html.="<dt>価格:</dt>";
    $html.="<dd class='price'>".number_format($row["fld054"])."<span class='yen'>円</span></dd>";

    $html.="<dt>最寄駅:</dt>";
    //$html.="<dd>".$row["fld025"].$row["fld026"]."駅 徒歩".$row["fld027"]."分</dd>";
    $html.="<dd>".$row["fld026"]."駅 徒歩".$row["fld027"]."分</dd>";


    $html.="</dl>";
    $html.="</a>";
    $html.="</div>";
   }
  }
  $this->rainsdata["smalllist"]=$html; 

 }
 
 //各種データを取得する
 public function getData($bnumber){
  global $FLD;

  if(!preg_match("/^[0-9]+$/",$bnumber)) throw new exception("物件番号を確認してください");
  
  //配列初期化
  $this->rainsdata=array();
  
  //Rainsデータ取得
  $this->where="fld000='".$bnumber."'";
  $rains=$this->getRains();
  $rainsdata["rains"]=$rains[0];
  
  //地図データ取得
  $rainsdata["latlng"]=$this->getLatLng($bnumber);

  //画像データ取得
  $rainsdata["imgpath"]=$this->getImgPath($bnumber);

  //画像データをフルパスに変更
  foreach($rainsdata["imgpath"] as $key=>$val){
   $rainsdata["imgpath"][$key]["fld002"]=".".IMG."/".$bnumber."/".$val["fld002"];
  }
  $this->rainsdata=$rainsdata;
 }
 
 //ページタイトル生成
 public function getTitle(){
  global $FLD;
  
  //配列初期化
  unset($this->rainsdata["title"]);
  
  //元データがなければ終了
  if(! isset($this->rainsdata["rains"])) return;
  
  $rainsdata["rains"]=$this->rainsdata["rains"];

  $title="";
  
  //物件名
  $title=$rainsdata["rains"]["fld021"];
  if($rainsdata["rains"]["fld022"]){
   $title.=$rainsdata["rains"]["fld022"]."号室";
  }

  //間取り
  $title.=" ".$rainsdata["rains"]["fld180"].$FLD["fld179"][$rainsdata["rains"]["fld179"]];
  
  //所在地
  $title.=" ".$rainsdata["rains"]["fld018"].$rainsdata["rains"]["fld019"].$rainsdata["rains"]["fld020"];
  
  //沿線
  if($rainsdata["rains"]["fld025"]){
   $title.=" ".$rainsdata["rains"]["fld025"];
   if($rainsdata["rains"]["fld026"]){
    $title.=" ".$rainsdata["rains"]["fld026"]."駅 ";
    if($rainsdata["rains"]["fld027"]){
     $title.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
    }

    if($rainsdata["rains"]["fld028"]){
     $title.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
    }
   }
  }

  if($rainsdata["rains"]["fld030"]){
   $html.=" ".$rainsdata["rains"]["fld030"];
   if($rainsdata["rains"]["fld031"]){
    $title.=" ".$rainsdata["rains"]["fld031"]."バス停 ";
    if($rainsdata["rains"]["fld032"]){
     $title.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
    }

    if($rainsdata["rains"]["fld033"]){
     $title.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
    }
   }
  }
  $title.=" | ".CORPNAME;
  $html="<title>".$title."</title>";
  $this->rainsdata["title"]=$html;
 }
 //H1タイトル作成
 public function getH1(){
  //配列初期化
  unset($this->rainsdata["h1"]);
  
  //元データがなければ終了
  if(! isset($this->rainsdata["rains"])) return;

  $rainsdata["rains"]=$this->rainsdata["rains"];
  $html="";

  $bname="";
  $bname=$rainsdata["rains"]["fld021"];
  if($rainsdata["rains"]["fld022"]){
   $bname.=$rainsdata["rains"]["fld022"]."号室";
  }
  $html.="<h1 class='h1detail'>".$bname."</h1>";

  $this->rainsdata["h1"]=$html;
 }
  //
 //画像パート生成($this->rainsdata["rains"]にデータが入っている前提)
 public function getImgPart(){
  //配列初期化
  unset($this->rainsdata["imgpart"]);
  
  //元データがなければ終了
  if(! isset($this->rainsdata["rains"])) return;
  
  //画像パスがなければ終了
  if(! isset($this->rainsdata["imgpath"])) return;

  $html="";

   //画像
  $html.="<div class='divimg'>";
  $html.="<div class='bigimg'>";
  $html.="<ul class='bxslider'>";
  foreach($this->rainsdata["imgpath"] as $key=>$val){
   $html.="<li>";
   $html.="<img src='".$val["fld002"]."' alt='".$this->rainsdata["rains"]["fld021"].$key."'>";
   $html.="</li>";
  }//foreach
  $html.="</ul>";
  $html.="</div>";//div.bigimg
  $html.="</div>";//div.divimg
  $this->rainsdata["imgpart"]=$html;
 }

 //アイキャッチ生成
 public function getEyeCatch(){
  global $FLD;
  
  //配列初期化
  unset($this->rainsdata["eyecatch"]);
  
  //元データがなければ終了
  if(! isset($this->rainsdata["rains"])) return;
  
  $rainsdata["rains"]=$this->rainsdata["rains"];

  $html="";
  $html.="<div class='eyecatch'>";
  $html.="<ul>";
  $html.="<li>".$rainsdata["rains"]["fld180"].$rainsdata["rains"]["fld179"]."</li>";
  $html.="<li>".number_format($rainsdata["rains"]["fld054"])."<span class='yen'>円</span></li>";

  if($rainsdata["rains"]["fld026"]){
   $html.="<li>";
   $html.="<span class='yen'>".$rainsdata["rains"]["fld025"]."</span>";
   $html.="</li>";
   $html.="<li>";
   $html.=$rainsdata["rains"]["fld026"]."<span class='yen'>駅</span>";
   if($rainsdata["rains"]["fld027"]){
    $html.=" <span class='yen'>徒歩</span>".$rainsdata["rains"]["fld027"]."<span class='yen'>分</span>";
   }
   $html.="</li>";

   if($rainsdata["rains"]["fld028"]){
    $html.="<li>";
    $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
    $html.="</li>";
   }
  }

  if(! $rainsdata["rains"]["fld026"] && $rainsdata["rains"]["fld031"]){
   $html.="<li>";
   $html.=$rainsdata["fld031"]." バス停";
   $html.="</li>";
   if($rainsdata["rains"]["fld032"]){
    $html.="<li>";
    $html.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
    $html.="</li>";
   }

   if($rainsdata["rains"]["fld033"]){
    $html.="<li>";
    $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
    $html.="</li>";
   }
  }
  $html.="</ul>";
  $html.="</div>";

  $this->rainsdata["eyecatch"]=$html;
 }

 //物件概要パート生成
 public function getBpart(){
  global $FLD;
  
  //配列初期化
  unset($this->rainsdata["bpart"]);
  
  //元データがなければ終了
  if(! isset($this->rainsdata["rains"])) return;
  $rainsdata["rains"]=$this->rainsdata["rains"];

  $html="";
  $html.="<h3>【物件概要】</h3>";
  $html.="<dl class='bigdl'>";
  $html.="<dt>物件名:</dt>";
  $html.="<dd>".$rainsdata["rains"]["fld021"]."&nbsp";
  if(isset($rainsdata["rains"]["fld022"]) && $rainsdata["rains"]["fld022"]) $html.=$rainsdata["rains"]["fld022"]."号室";
  if($rainsdata["rains"]["fld224"]){
   $html.="(".$rainsdata["rains"]["fld224"]."階)";
  }
  $html.="</dd>";

  if($rainsdata["rains"]["fld224"]){
   $html.="<dt>所在階:</dt>";
   $html.="<dd>";
   if($rainsdata["rains"]["fld222"]){
    $html.=$rainsdata["rains"]["fld222"]."階建 ";
   }
   $html.=$rainsdata["rains"]["fld224"]."階";
   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld025"]){
   $html.="<dt>最寄駅:</dt>";
   $html.="<dd>";
   $html.=$rainsdata["rains"]["fld025"];
   if($rainsdata["rains"]["fld026"]){
    $html.=" ".$rainsdata["rains"]["fld026"]." ";
    if($rainsdata["rains"]["fld027"]){
     $html.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
    }

    if($rainsdata["rains"]["fld028"]){
     $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
    }
   }
   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld030"]){
   $html.="<dt>最寄バス停:</dt>";
   $html.="<dd>";
   $html.=$rainsdata["rains"]["fld030"];
   if($rainsdata["rains"]["fld031"]){
    $html.=" ".$rainsdata["rains"]["fld031"]." ";
    if($rainsdata["rains"]["fld032"]){
     $html.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
    }

    if($rainsdata["rains"]["fld033"]){
     $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
    }
   }
   $html.="</dd>";
  }

  $html.="<dt>所在地:</dt>";
  $html.="<dd>".$rainsdata["rains"]["fld018"].$rainsdata["rains"]["fld019"].$rainsdata["rains"]["fld020"]."</dd>";


  if($rainsdata["rains"]["fld219"]){
   $html.="<dt>建築構造:</dt><dd>";
   $html.=$rainsdata["rains"]["fld219"];
   if($rainsdata["rains"]["fld222"]){
    $html.=" 地上".$rainsdata["rains"]["fld222"]."階建 ";
   }
   if($rainsdata["rains"]["fld223"]){
    $html.=" 地下".$rainsdata["rains"]["fld223"]."階";
   }
   if($rainsdata["rains"]["fld225"]){
    $nen=mb_substr($rainsdata["rains"]["fld225"],0,4);
    $tuki=mb_substr($rainsdata["rains"]["fld225"],5,2);
    $tiku=date("Y")-$nen;
    $html.="(".$nen."年".$tuki."月 築".$tiku."年)";
   }
   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld180"]){
   $html.="<dt>間取り:</dt>";
   $html.="<dd>";
   $html.=$rainsdata["rains"]["fld180"].$rainsdata["rains"]["fld179"];
   $html.=" (";
   if($rainsdata["rains"]["fld068"]){
    $html.=" ".$rainsdata["rains"]["fld068"]."㎡ ";
   }
   if($rainsdata["rains"]["fld181"]){
    $html.=$rainsdata["rains"]["fld181"];
   }
   $html.=")</dd>";
  }
  else{$html.="<dd>&nbsp;</dd>";}

  $html.="<dt>部屋詳細:</dt>";
  $html.="<dd>";

  $kai="";
  if($rainsdata["rains"]["fld183"]){
   $html.=$rainsdata["rains"]["fld183"]."階 ";
   $kai=$rainsdata["rains"]["fld183"];

   if($rainsdata["rains"]["fld184"]){
    $html.=$rainsdata["rains"]["fld184"]." ";

    if($rainsdata["rains"]["fld185"]){
     $html.=$rainsdata["rains"]["fld185"]."畳 ";
     if($rainsdata["rains"]["fld186"]){
      $html.=" x ".$rainsdata["rains"]["fld186"]."室";
     }
    }
   }
  }


  if($rainsdata["rains"]["fld187"]){
   if($kai!==$rainsdata["rains"]["fld187"]){
    $html.=$rainsdata["rains"]["fld187"]."階 ";
    $kai=$rainsdata["rains"]["fld187"];
   }
   if($rainsdata["rains"]["fld188"]){
    //部屋タイプ　配列から参照するように変更すること
    $html.=" ".$rainsdata["rains"]["fld188"]." ";

    if($rainsdata["rains"]["fld189"]){
     $html.=$rainsdata["rains"]["fld189"]."畳 ";
     if($rainsdata["rains"]["fld190"]){
      $html.=" x ".$rainsdata["rains"]["fld190"]."室";
     }
    }
   }
  }

  if($rainsdata["rains"]["fld191"]){
   if($kai!==$rainsdata["rains"]["fld191"]){
    $html.=$rainsdata["rains"]["fld191"]."階 ";
    $kai=$rainsdata["rains"]["fld191"];
   }

   if($rainsdata["rains"]["fld192"]){
    $html.=" ".$rainsdata["rains"]["fld192"]." ";

    if($rainsdata["rains"]["fld193"]){
     $html.=$rainsdata["rains"]["fld193"]."畳 ";
     if($rainsdata["rains"]["fld194"]){
      $html.=" x ".$rainsdata["rains"]["fld194"]."室";
     }
    }
   }
  }

  if($rainsdata["rains"]["fld195"]){
   if($kai!==$rainsdata["rains"]["fld195"]){
    $html.=$rainsdata["rains"]["fld195"]."階 ";
    $kai=$rainsdata["rains"]["fld195"];
   }

   if($rainsdata["rains"]["fld196"]){
    $html.=$rainsdata["rains"]["fld196"]." ";

    if($rainsdata["rains"]["fld197"]){
     $html.=$rainsdata["rains"]["fld197"]."畳 ";
     if($rainsdata["rains"]["fld198"]){
      $html.=" x ".$rainsdata["rains"]["fld198"]."室";
     }
    }
   }
  }

  if($rainsdata["rains"]["fld199"]){
   if($kai!==$rainsdata["rains"]["fld199"]){
    $html.=$rainsdata["rains"]["fld199"]."階 ";
    $kai=$rainsdata["rains"]["fld199"];
   }

   if($rainsdata["rains"]["fld200"]){
    $html.=$rainsdata["rains"]["fld200"]." ";

    if($rainsdata["rains"]["fld201"]){
     $html.=$rainsdata["rains"]["fld201"]."畳 ";
     if($rainsdata["rains"]["fld202"]){
      $html.=" x ".$rainsdata["rains"]["fld202"]."室";
     }
    }
   }
  }

  if($rainsdata["rains"]["fld203"]){
   if($kai!==$rainsdata["rains"]["fld203"]){
    $html.=$rainsdata["rains"]["fld203"]."階 ";
    $kai=$rainsdata["rains"]["fld203"];
   }

   if($rainsdata["rains"]["fld204"]){
    $html.=$rainsdata["rains"]["fld204"]." ";

    if($rainsdata["rains"]["fld205"]){
     $html.=$rainsdata["rains"]["fld205"]."畳 ";
     if($rainsdata["rains"]["fld206"]){
      $html.=" x ".$rainsdata["rains"]["fld206"]."室";
     }
    }
   }
  }

  if($rainsdata["rains"]["fld207"]){
   if($kai!==$rainsdata["rains"]["fld207"]){
    $html.=$rainsdata["rains"]["fld207"]."階 ";
    $kai=$rainsdata["rains"]["fld207"];
   }

   if($rainsdata["rains"]["fld208"]){
    $html.=$rainsdata["rains"]["fld208"]." ";

    if($rainsdata["rains"]["fld209"]){
     $html.=$rainsdata["rains"]["fld209"]."畳 ";
     if($rainsdata["rains"]["fld210"]){
      $html.=" x ".$rainsdata["rains"]["fld210"]."室 ";
     }
    }
   }
  }
  if($rainsdata["rains"]["fld211"]){
   $html.=$rainsdata["rains"]["fld211"];
  }   
  $html.="</dd>";
  $html.="<dt>物件番号:</dt>";
  $html.="<dd>".$rainsdata["rains"]["fld000"]."</dd>";
  $html.="</dl>";
  
  $this->rainsdata["bpart"]=$html;
 }
 
 //賃貸条件生成
 public function getTpart(){
  global $FLD;
  
  //配列初期化
  unset($this->rainsdata["tpart"]);
  
  //元データがなければ終了
  if(! isset($this->rainsdata["rains"])) return;
  $rainsdata["rains"]=$this->rainsdata["rains"];

  $html.="<h3>【賃貸物件】</h3>";
  $html.="<dl class='bigdl'>";
  if($rainsdata["rains"]["fld054"]){
   $html.="<dt>価格:</dt>";
   $html.="<dd>".number_format($rainsdata["rains"]["fld054"])."円</dd>";
  }
   
  if($rainsdata["rains"]["fld087"]){
   $html.="<dt>契約期間</dt>";
   $html.="<dd>".$rainsdata["rains"]["fld087"]."年</dd>";
  }
   
  if($rainsdata["rains"]["fld137"]){
   $html.="<dt>管理費</dt>";
   $html.="<dd>";
   $html.=$rainsdata["rains"]["fld137"]."円";
   if($rainsdata["rains"]["fld133"]){
    $html.="(管理組合:".$rainsdata["rains"]["fld133"].")";
   }
   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld138"]){
   $html.="<dt>管理費(消費税)</dt>";
   $html.="<dd>";
   $html.=$rainsdata["rains"]["fld138"]."円";
   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld069"] || $rainsdata["rains"]["fld070"]){
     $html.="<dt>保証金:</dt>";
     if($rainsdata["rains"]["fld069"]){
      $html.="<dd>".$rainsdata["rains"]["fld069"]."円</dd>";
     }
     if($rainsdata["rains"]["fld069"]){
      $html.="<dd>".$rainsdata["rains"]["fld070"]."ヶ月</dd>";
     }
  }

  if($rainsdata["rains"]["fld074"] || $rainsdata["rains"]["fld075"] || $rainsdata["rains"]["fld076"]){
   $html.="<dt>礼金:</dt>";
   if($rainsdata["rains"]["fld074"]){
    $html.="<dd>".$rainsdata["rains"]["fld074"]."円";
    if($rainsdata["rains"]["fld075"]){
     $html.="消費税(".$rainsdata["rains"]["fld075"]."円)";
    }
    $html.="</dd>";
   }
   if($rainsdata["rains"]["fld076"]){
    $html.="<dd>".($rainsdata["rains"]["fld076"]*1)."ヶ月</dd>";
   }
  }

  if($rainsdata["rains"]["fld077"] || $rainsdata["rains"]["fld078"]){
   $html.="<dt>敷金:</dt>";
   if($rainsdata["rains"]["fld077"]){
    $html.="<dd>".$rainsdata["rains"]["fld077"]."円</dd>";
   }
   if($rainsdata["rains"]["fld078"]){
    $html.="<dd>".($rainsdata["rains"]["fld078"]*1)."ヶ月</dd>";
   }
  }


  if($rainsdata["rains"]["fld147"] || $rainsdata["rains"]["fld148"]){
   $html.="<dt>更新料:</dt>";
   $html.="<dd>";
   if($rainsdata["rains"]["fld147"]){
    $html.=$rainsdata["rains"]["fld147"]."円";
   }
   if($rainsdata["rains"]["fld148"]){
    $html.=($rainsdata["rains"]["fld148"]*1)."ヶ月";
   }
   if($rainsdata["rains"]["fld146"]){
    $html.="(".$rainsdata["rains"]["fld146"].")";
   }
   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld149"]){
   $html.="<dt>保険加入:</dt>";
   $html.="<dd>";
   $html.=$rainsdata["rains"]["fld149"]." ";

   if($rainsdata["rains"]["fld150"]){
    $html.=$rainsdata["rains"]["fld150"]." ";
   }

   if($rainsdata["rains"]["fld151"]){
    $html.=$rainsdata["rains"]["fld151"]."円 ";
   }

   if($rainsdata["rains"]["fld152"]){
    $html.=$rainsdata["rains"]["fld152"]."年";
   }

   $html.="</dd>";
  }

  $html.="</dl>";
  
  $this->rainsdata["tpart"]=$html;
 }//public function getTpart

 public function getSpart(){
  global $FLD;
  global $FLD;
  
  //配列初期化
  unset($this->rainsdata["spart"]);
  
  //元データがなければ終了
  if(! isset($this->rainsdata["rains"])) return;
  $rainsdata["rains"]=$this->rainsdata["rains"];

  $html.="<h3>【諸条件】</h3>";

  $html.="<dl class='bigdl'>";
  if($rainsdata["rains"]["fld212"]){
   $html.="<dt>駐車場:</dt>";
   $html.="<dd>";
   $html.=$rainsdata["rains"]["fld212"];
   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld231"] || $rainsdata["rains"]["fld233"] || $rainsdata["rains"]["fld235"]){
   $html.="<dt>改装:</dt>";
   $html.="<dd>";
   if($rainsdata["rains"]["fld231"]){
    $nen=mb_substr($rainsdata["rains"]["fld231"],0,4)."年";
    $html.=$nen.$rainsdata["rains"]["fld232"]."。";
   }

   if($rainsdata["rains"]["fld233"]){
    $nen=mb_substr($rainsdata["rains"]["fld233"],0,4)."年";
    $html.=$nen.$rainsdata["rains"]["fld234"]."。";
   }

   if($rainsdata["rains"]["fld235"]){
    $nen=mb_substr($rainsdata["rains"]["fld235"],0,4)."年";
    $html.=$nen.$rainsdata["rains"]["fld236"]."。";
   }

   $html.="</dd>";
  }

  if($rainsdata["rains"]["fld241"]){
   $html.="<dt>コメント:</dt>";
   $html.="<dd>".$rainsdata["rains"]["fld241"]."</dd>";
  }
  $html.="</dl>";
  $this->rainsdata["spart"]=$html;
 }// public function getSpart(){

 public function getRoot(){
  if(! isset($this->rainsdata["latlng"])) return ;

  $latlng=$this->rainsdata["latlng"];
  //Mapを表示するJavaScriptをセット
  $googlemap=<<<EOF
<div id="map_canvas"></div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var haight = new google.maps.LatLng({$latlng["startlat"]},{$latlng["startlng"]});
var oceanBeach = new google.maps.LatLng({$latlng["endlat"]},{$latlng["endlng"]});

function initialize(){
  directionsDisplay = new google.maps.DirectionsRenderer();
  var mapOptions = {
    zoom: 14,
    center: haight
  };
  map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute(){
 var request = {
     origin: haight,
     destination: oceanBeach,
     travelMode: google.maps.TravelMode["WALKING"]
 };

 directionsService.route(request,function(response,status){
  if(status == google.maps.DirectionsStatus.OK){
   directionsDisplay.setDirections(response);
  }
 });
}

//google.maps.event.addDomListener(window,"load",initialize);
//calcRoute();
</script>
EOF;
  $this->rainsdata["googlemap"]=$googlemap;

 }//public function getRoot(){

 public function getDetail($bnumber){
  global $FLD;

  if(!preg_match("/^[0-9]+$/",$bnumber)) throw new exception("物件番号を確認してください");
  
  //配列初期化
  unset($this->rainsdata["rains"]);
  unset($this->rainsdata["detail"]);
  $html="";

  //Rainsデータ取得
  $this->where="fld000='".$bnumber."'";
  $rains=$this->getRains();
  $rainsdata["rains"]=$rains[0];
  
  //地図データ取得
  $rainsdata["latlng"]=$this->getLatLng($bnumber);

  //画像データ取得
  $rainsdata["imgpath"]=$this->getImgPath($bnumber);

  $html="";
  if(isset($rainsdata["rains"])){
   $html.="<div class='bigdetail'>";
   
   //タイトル
   $bname=$rainsdata["rains"]["fld021"];
   if($rainsdata["rains"]["fld022"]){
    $bname.=$rainsdata["rains"]["fld022"]."号室";
   }
   $html.="<h1 class='h1detail'>".$bname."</h1>";
   
   //アイキャッチ
   $html.="<div class='eyecatch'>";
   $html.="<ul>";
   $html.="<li>".$rainsdata["rains"]["fld180"].$rainsdata["rains"]["fld179"]." ";
   $html.=number_format($rainsdata["rains"]["fld054"])."<span class='yen'>円</span>";
   $html.="</li>";

   if($rainsdata["rains"]["fld026"]){
    $html.="<li>";
    $html.="<span class='yen'>".$rainsdata["rains"]["fld025"]."</span>";
    $html.="</li>";
    $html.="<li>";
    $html.=$rainsdata["rains"]["fld026"]."<span class='yen'>駅</span>";
    if($rainsdata["rains"]["fld027"]){
     $html.=" <span class='yen'>徒歩</span>".$rainsdata["rains"]["fld027"]."<span class='yen'>分</span>";
    }
    $html.="</li>";

    if($rainsdata["rains"]["fld028"]){
     $html.="<li>";
     $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
     $html.="</li>";
    }
   }

   if(! $rainsdata["rains"]["fld026"] && $rainsdata["rains"]["fld031"]){
    $html.="<li>";
    $html.=$rainsdata["fld031"]." バス停";
    $html.="</li>";
    if($rainsdata["rains"]["fld032"]){
     $html.="<li>";
     $html.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
     $html.="</li>";
    }

    if($rainsdata["rains"]["fld033"]){
     $html.="<li>";
     $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
     $html.="</li>";
    }
   }
   $html.="</ul>";
   $html.="</div>";
   
   $html.="<div class='clr'></div>";
   
   //画像
   $html.="<div class='divimg'>";
   $html.="<div class='bigimg'>";
   $html.="<ul class='bxslider'>";
   foreach($rainsdata["imgpath"] as $key=>$val){
    $html.="<li>";
    $html.="<img src='".$val."' alt='".$rainsdata["rains"]["fld021"]."'>";
    $html.="</li>";
   }//foreach
   $html.="</ul>";
   $html.="</div>";//div.bigimg
   $html.="</div>";//div.divimg

   $html.="<div class='divdetail'>";
//   if($rainsdata["rains"]["fld000"]){
//    $html.="<dt>物件番号:</dt>";
//    $html.="<dd>".$rainsdata["rains"]["fld000"]."</dd>";
//   }


   $html.="<h3>【物件概要】</h3>";
   $html.="<dl class='bigdl'>";
   $html.="<dt>物件名:</dt>";
   $html.="<dd>".$rainsdata["rains"]["fld021"]."&nbsp";
   if(isset($rainsdata["rains"]["fld022"]) && $rainsdata["rains"]["fld022"]) $html.=$rainsdata["rains"]["fld022"]."号室";
   if($rainsdata["rains"]["fld224"]){
    $html.="(".$rainsdata["rains"]["fld224"]."階)";
   }
   $html.="</dd>";

   if($rainsdata["rains"]["fld224"]){
    $html.="<dt>所在階:</dt>";
    $html.="<dd>";
    if($rainsdata["rains"]["fld222"]){
     $html.=$rainsdata["rains"]["fld222"]."階建 ";
    }
    $html.=$rainsdata["rains"]["fld224"]."階";
    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld025"]){
    $html.="<dt>最寄駅:</dt>";
    $html.="<dd>";
    $html.=$rainsdata["rains"]["fld025"];
    if($rainsdata["rains"]["fld026"]){
     $html.=" ".$rainsdata["rains"]["fld026"]." ";
     if($rainsdata["rains"]["fld027"]){
      $html.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
     }

     if($rainsdata["rains"]["fld028"]){
      $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
     }
    }
    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld030"]){
    $html.="<dt>最寄バス停:</dt>";
    $html.="<dd>";
    $html.=$rainsdata["rains"]["fld030"];
    if($rainsdata["rains"]["fld031"]){
     $html.=" ".$rainsdata["rains"]["fld031"]." ";
     if($rainsdata["rains"]["fld032"]){
      $html.=" 徒歩".$rainsdata["rains"]["fld027"]."分";
     }

     if($rainsdata["rains"]["fld033"]){
      $html.=" 徒歩".$rainsdata["rains"]["fld027"]."m";
     }
    }
    $html.="</dd>";
   }

   $html.="<dt>所在地:</dt>";
   $html.="<dd>".$rainsdata["rains"]["fld018"].$rainsdata["rains"]["fld019"].$rainsdata["rains"]["fld020"]."</dd>";


   if($rainsdata["rains"]["fld219"]){
    $html.="<dt>建築構造:</dt><dd>";
    $html.=$rainsdata["rains"]["fld219"];
    if($rainsdata["rains"]["fld222"]){
     $html.=" 地上".$rainsdata["rains"]["fld222"]."階建 ";
    }
    if($rainsdata["rains"]["fld223"]){
     $html.=" 地下".$rainsdata["rains"]["fld223"]."階";
    }
    if($rainsdata["rains"]["fld225"]){
     $nen=mb_substr($rainsdata["rains"]["fld225"],0,4);
     $tuki=mb_substr($rainsdata["rains"]["fld225"],5,2);
     $tiku=date("Y")-$nen;
     $html.="(".$nen."年".$tuki."月 築".$tiku."年)";
    }
    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld180"]){
    $html.="<dt>間取り:</dt>";
    $html.="<dd>";
    $html.=$rainsdata["rains"]["fld180"].$rainsdata["rains"]["fld179"];
    $html.=" (";
    if($rainsdata["rains"]["fld068"]){
     $html.=" ".$rainsdata["rains"]["fld068"]."㎡ ";
    }
    if($rainsdata["rains"]["fld181"]){
     $html.=$rainsdata["rains"]["fld181"];
    }
    $html.=")</dd>";
   }
   else{$html.="<dd>&nbsp;</dd>";}

   $html.="<dt>部屋詳細:</dt>";
   $html.="<dd>";

   $kai="";
   if($rainsdata["rains"]["fld183"]){
    $html.=$rainsdata["rains"]["fld183"]."階 ";
    $kai=$rainsdata["rains"]["fld183"];

    if($rainsdata["rains"]["fld184"]){
     $html.=$rainsdata["rains"]["fld184"]." ";

     if($rainsdata["rains"]["fld185"]){
      $html.=$rainsdata["rains"]["fld185"]."畳 ";
      if($rainsdata["rains"]["fld186"]){
       $html.=" x ".$rainsdata["rains"]["fld186"]."室";
      }
     }
    }
   }


   if($rainsdata["rains"]["fld187"]){
    if($kai!==$rainsdata["rains"]["fld187"]){
     $html.=$rainsdata["rains"]["fld187"]."階 ";
     $kai=$rainsdata["rains"]["fld187"];
    }
    if($rainsdata["rains"]["fld188"]){
     //部屋タイプ　配列から参照するように変更すること
     $html.=" ".$rainsdata["rains"]["fld188"]." ";

     if($rainsdata["rains"]["fld189"]){
      $html.=$rainsdata["rains"]["fld189"]."畳 ";
      if($rainsdata["rains"]["fld190"]){
       $html.=" x ".$rainsdata["rains"]["fld190"]."室";
      }
     }
    }
   }

   if($rainsdata["rains"]["fld191"]){
    if($kai!==$rainsdata["rains"]["fld191"]){
     $html.=$rainsdata["rains"]["fld191"]."階 ";
     $kai=$rainsdata["rains"]["fld191"];
    }

    if($rainsdata["rains"]["fld192"]){
     $html.=" ".$rainsdata["rains"]["fld192"]." ";

     if($rainsdata["rains"]["fld193"]){
      $html.=$rainsdata["rains"]["fld193"]."畳 ";
      if($rainsdata["rains"]["fld194"]){
       $html.=" x ".$rainsdata["rains"]["fld194"]."室";
      }
     }
    }
   }

   if($rainsdata["rains"]["fld195"]){
    if($kai!==$rainsdata["rains"]["fld195"]){
     $html.=$rainsdata["rains"]["fld195"]."階 ";
     $kai=$rainsdata["rains"]["fld195"];
    }

    if($rainsdata["rains"]["fld196"]){
     $html.=$rainsdata["rains"]["fld196"]." ";

     if($rainsdata["rains"]["fld197"]){
      $html.=$rainsdata["rains"]["fld197"]."畳 ";
      if($rainsdata["rains"]["fld198"]){
       $html.=" x ".$rainsdata["rains"]["fld198"]."室";
      }
     }
    }
   }

   if($rainsdata["rains"]["fld199"]){
    if($kai!==$rainsdata["rains"]["fld199"]){
     $html.=$rainsdata["rains"]["fld199"]."階 ";
     $kai=$rainsdata["rains"]["fld199"];
    }

    if($rainsdata["rains"]["fld200"]){
     $html.=$rainsdata["rains"]["fld200"]." ";

     if($rainsdata["rains"]["fld201"]){
      $html.=$rainsdata["rains"]["fld201"]."畳 ";
      if($rainsdata["rains"]["fld202"]){
       $html.=" x ".$rainsdata["rains"]["fld202"]."室";
      }
     }
    }
   }

   if($rainsdata["rains"]["fld203"]){
    if($kai!==$rainsdata["rains"]["fld203"]){
     $html.=$rainsdata["rains"]["fld203"]."階 ";
     $kai=$rainsdata["rains"]["fld203"];
    }

    if($rainsdata["rains"]["fld204"]){
     $html.=$rainsdata["rains"]["fld204"]." ";

     if($rainsdata["rains"]["fld205"]){
      $html.=$rainsdata["rains"]["fld205"]."畳 ";
      if($rainsdata["rains"]["fld206"]){
       $html.=" x ".$rainsdata["rains"]["fld206"]."室";
      }
     }
    }
   }

   if($rainsdata["rains"]["fld207"]){
    if($kai!==$rainsdata["rains"]["fld207"]){
     $html.=$rainsdata["rains"]["fld207"]."階 ";
     $kai=$rainsdata["rains"]["fld207"];
    }

    if($rainsdata["rains"]["fld208"]){
     $html.=$rainsdata["rains"]["fld208"]." ";

     if($rainsdata["rains"]["fld209"]){
      $html.=$rainsdata["rains"]["fld209"]."畳 ";
      if($rainsdata["rains"]["fld210"]){
       $html.=" x ".$rainsdata["rains"]["fld210"]."室 ";
      }
     }
    }
   }
   if($rainsdata["rains"]["fld211"]){
    $html.=$rainsdata["rains"]["fld211"];
   }   
   $html.="</dd>";
   $html.="<dt>物件番号:</dt>";
   $html.="<dd>".$rainsdata["rains"]["fld000"]."</dd>";
   $html.="</dl>";

   $html.="<h3>【賃貸物件】</h3>";
   $html.="<dl class='bigdl'>";
   if($rainsdata["rains"]["fld054"]){
    $html.="<dt>価格:</dt>";
    $html.="<dd>".number_format($rainsdata["rains"]["fld054"])."円</dd>";
   }
    
   if($rainsdata["rains"]["fld087"]){
    $html.="<dt>契約期間</dt>";
    $html.="<dd>".$rainsdata["rains"]["fld087"]."年</dd>";
   }
    
   if($rainsdata["rains"]["fld137"]){
    $html.="<dt>管理費</dt>";
    $html.="<dd>";
    $html.=$rainsdata["rains"]["fld137"]."円";
    if($rainsdata["rains"]["fld133"]){
     $html.="(管理組合:".$rainsdata["rains"]["fld133"].")";
    }
    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld138"]){
    $html.="<dt>管理費(消費税)</dt>";
    $html.="<dd>";
    $html.=$rainsdata["rains"]["fld138"]."円";
    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld069"] || $rainsdata["rains"]["fld070"]){
      $html.="<dt>保証金:</dt>";
      if($rainsdata["rains"]["fld069"]){
       $html.="<dd>".$rainsdata["rains"]["fld069"]."円</dd>";
      }
      if($rainsdata["rains"]["fld069"]){
       $html.="<dd>".$rainsdata["rains"]["fld070"]."ヶ月</dd>";
      }
   }

   if($rainsdata["rains"]["fld074"] || $rainsdata["rains"]["fld075"] || $rainsdata["rains"]["fld076"]){
    $html.="<dt>礼金:</dt>";
    if($rainsdata["rains"]["fld074"]){
     $html.="<dd>".$rainsdata["rains"]["fld074"]."円";
     if($rainsdata["rains"]["fld075"]){
      $html.="消費税(".$rainsdata["rains"]["fld075"]."円)";
     }
     $html.="</dd>";
    }
    if($rainsdata["rains"]["fld076"]){
     $html.="<dd>".($rainsdata["rains"]["fld076"]*1)."ヶ月</dd>";
    }
   }

   if($rainsdata["rains"]["fld077"] || $rainsdata["rains"]["fld078"]){
    $html.="<dt>敷金:</dt>";
    if($rainsdata["rains"]["fld077"]){
     $html.="<dd>".$rainsdata["rains"]["fld077"]."円</dd>";
    }
    if($rainsdata["rains"]["fld078"]){
     $html.="<dd>".($rainsdata["rains"]["fld078"]*1)."ヶ月</dd>";
    }
   }


   if($rainsdata["rains"]["fld147"] || $rainsdata["rains"]["fld148"]){
    $html.="<dt>更新料:</dt>";
    $html.="<dd>";
    if($rainsdata["rains"]["fld147"]){
     $html.=$rainsdata["rains"]["fld147"]."円";
    }
    if($rainsdata["rains"]["fld148"]){
     $html.=($rainsdata["rains"]["fld148"]*1)."ヶ月";
    }
    if($rainsdata["rains"]["fld146"]){
     $html.="(".$rainsdata["rains"]["fld146"].")";
    }
    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld149"]){
    $html.="<dt>保険加入:</dt>";
    $html.="<dd>";
    $html.=$rainsdata["rains"]["fld149"]." ";

    if($rainsdata["rains"]["fld150"]){
     $html.=$rainsdata["rains"]["fld150"]." ";
    }

    if($rainsdata["rains"]["fld151"]){
     $html.=$rainsdata["rains"]["fld151"]."円 ";
    }

    if($rainsdata["rains"]["fld152"]){
     $html.=$rainsdata["rains"]["fld152"]."年";
    }

    $html.="</dd>";
   }

   $html.="</dl>";
   $html.="<h3>【諸条件】</h3>";

   $html.="<dl class='bigdl'>";
   if($rainsdata["rains"]["fld212"]){
    $html.="<dt>駐車場:</dt>";
    $html.="<dd>";
    //物件種別によってデータが変化。データ確認してセット
    $html.=$rainsdata["rains"]["fld212"];
    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld231"] || $rainsdata["rains"]["fld233"] || $rainsdata["rains"]["fld235"]){
    $html.="<dt>改装:</dt>";
    $html.="<dd>";
    if($rainsdata["rains"]["fld231"]){
     $nen=mb_substr($rainsdata["rains"]["fld231"],0,4)."年";
     $html.=$nen.$rainsdata["rains"]["fld232"]."。";
    }

    if($rainsdata["rains"]["fld233"]){
     $nen=mb_substr($rainsdata["rains"]["fld233"],0,4)."年";
     $html.=$nen.$rainsdata["rains"]["fld234"]."。";
    }

    if($rainsdata["rains"]["fld235"]){
     $nen=mb_substr($rainsdata["rains"]["fld235"],0,4)."年";
     $html.=$nen.$rainsdata["rains"]["fld236"]."。";
    }

    $html.="</dd>";
   }

   if($rainsdata["rains"]["fld241"]){
    $html.="<dt>コメント:</dt>";
    $html.="<dd>".$rainsdata["rains"]["fld241"]."</dd>";
   }
   $html.="</dl>";

   $html.="<a href='mailto:".MAILADDRESS;
   $html.="'>メール</a>";
   $html.=LINE;
   $html.="</div>";//div.divdetail
   $html.="<div class='clr'></div>";
   $html.="<div id='map_canvas'></div>";
   $html.="</div>";//div class='bigdetail"

   $rainsdata["detail"]=$html;
  }// if(isset($rainsdata["rains"])){
  
  $this->rainsdata=$rainsdata;
 }
 
//GoogleMap(物件地点のみを表示)
 public function getMap(){
  global $GOOGLEURL;
  global $APIKEY;
  if(!isset($this->rains["location"])){
   return false;
  }

$googlemap=<<<EOF
     <script type="text/javascript" src="{$GOOGLEURL}{$APIKEY}"> </script>
     <script type="text/javascript">
      function initialize() {
       var LatLng=new google.maps.LatLng({$this->rains["location"]["lat"]}, {$this->rains["location"]["lng"]});
       var mapOptions = {
        center: LatLng,
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.ROADMAP
       };
       var map = new google.maps.Map(document.getElementById("map_canvas"),
                                     mapOptions);
       var marker=new google.maps.Marker({
          position:LatLng,
          title:"test"
         });
       marker.setMap(map);
      }
     </script>
EOF;
  $this->rainsdata["googlemap"]=$googlemap;
 }

 //GoogleMap（最寄駅から物件までのルート表示用)
 public function getMapRoot($bnumber){
  //Rainsデータの最寄駅、物件のLatLngをゲット
  $latlng=$this->getLatLng($bnumber);
  
  //Mapを表示するJavaScriptをセット
  $googlemap=<<<EOF
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var haight = new google.maps.LatLng({$latlng["startlat"]},{$latlng["startlng"]});
var oceanBeach = new google.maps.LatLng({$latlng["endlat"]},{$latlng["endlng"]});

function initialize(){
  directionsDisplay = new google.maps.DirectionsRenderer();
  var mapOptions = {
    zoom: 14,
    center: haight
  };
  map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute(){
 var request = {
     origin: haight,
     destination: oceanBeach,
     travelMode: google.maps.TravelMode["WALKING"]
 };

 directionsService.route(request,function(response,status){
  if(status == google.maps.DirectionsStatus.OK){
   directionsDisplay.setDirections(response);
  }
 });
}

//google.maps.event.addDomListener(window,"load",initialize);
//calcRoute();
</script>
EOF;
  $this->rainsdata["googlemap"]=$googlemap;
 }
}

?>
