<?php
require_once("server.conf.php");
//---------------------------------------------------//
// デバックモード(true で「する」、falseで「しない」 //
//---------------------------------------------------//
define("DEBUG",true);
//---------------------------------------------------//

//---------------------------------------------------//
// DBEngin 選択
//---------------------------------------------------//
//define("DBENGIN","mysql");
define("DBENGIN","postgres");

//---------------------------------------------------//
// ディレクトリ名定数
//---------------------------------------------------//
 define("IMG"     ,"/img"     ); //777
 define("JS"      ,"/js"      ); //705
 define("CSS"     ,"/css"     ); //705 
 define("DATA"    ,"/data"    ); //700 
 define("LOG"     ,"/log"     ); //700 
 define("SKELETON","/skeleton"); //700 

//---------------------------------------------------//
// ファイル定数
//---------------------------------------------------//
 define("LOGO"    ,".".IMG."/logo.gif"   );
 define("FAV"     ,".".IMG."/favicon.ico");
 define("JQNAME"  ,".".JS."/jquery.js"   );
define("TOPIMAGE" ,".".IMG."/topimage.jpg");

//---------------------------------------------------//
// テーブル名定数
//---------------------------------------------------//
define("RAINS","rains");
define("LATLNG","latlng");
define("IMGLIST","imglist");
define("FLD","rainsfld");
define("BLACKLIST","blacklist");
define("CHECKLIST","checklist");
define("RANK","rank");
define("ENTRY","entry");
define("BCOMMENT","bcomment");
//---------------------------------------------------//
// テーブル列名定数
//---------------------------------------------------//
 define("IDCOL","id"   ); //ID列
 define("IDATE","idate"); //作成日時
 define("CDATE","cdate"); //更新日時

 if(DBENGIN=="mysql"){
  define("IDSQL"," ".IDCOL." int auto_increment primary key");//MySQL
 }
 else if(DBENGIN=="postgres"){
  define("IDSQL"," ".IDCOL." serial not null primary key");//Postgres
 }
 define("IDATESQL"," ".IDATE." timestamp not null default current_timestamp");
 define("CDATESQL"," ".CDATE." timestamp null");


//---------------------------------------------------//
// パラメーター系
//---------------------------------------------------//
define("NEWLIST","-3days") ;
define("RANKLIMIT",5);
define("BROTHERLIMIT",4);
define("SITEHELP","周辺のマンション、アパート、一軒家、駐車場などのおすすめ情報をご案内中。詳細事項はもちろん、建物・室内の写真も掲載しております。");

define("SITEABOUT","地域周辺の・賃貸・売買・不動産を探すなら".CORPNAME."。お客様にご満足いただけるように確かな情報をお届けすることを心がけております。アパート・マンションを探すならぜひ".CORPNAME."にお任せください。");
//---------------------------------------------------//
// ページ情報
//---------------------------------------------------//

$PAGEARY=array( "index.php"
                              =>array( "title"=>"ホーム"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>"index.css"
                                      ,"description"=>CORPNAME."は".CORPADDRESS."にある不動産屋です。この街の不動産なら当店にお任せ。おすすめ物件はもちろん当店独自のランキングも掲載中です。賃貸アパート、賃貸マンション、一軒家などなんでもご相談ください。")
               ,"room.php"  
                              =>array( "title"=>"賃貸"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>"tintai.css"
                                      ,"description"=>"")
               ,"baibai.php"  
                              =>array( "title"=>"売買"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>"tintai.css"
                                      ,"description"=>"")
               ,"jigyou.php"  
                              =>array( "title"=>"事業用"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>"tintai.css"
                                      ,"description"=>"")
               ,"q_and_a.php" 
                              =>array( "title"=>"Q&A"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>""
                                      ,"description"=>"")
               ,"yanusi.php" 
                              =>array( "title"=>"家主様"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>""
                                      ,"description"=>"")
               ,"annai.php"  
                              =>array( "title"=>"会社案内"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>""
                                      ,"description"=>"")
               ,"toiawase.php"
                              =>array( "title"=>"お問い合せ"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>""
                                      ,"description"=>"")
               ,"estate.php"
                              =>array( "title"=>""
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>"estate.css"
                                      ,"description"=>"")
               ,"conpany.php"
                              =>array( "title"=>"会社概要"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>".css"
                                      ,"description"=>"")
               ,"storeinfo.php"
                              =>array( "title"=>"店舗情報"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>".css"
                                      ,"description"=>"")
               ,"privacy.php"
                              =>array( "title"=>"プライバシーポリシー"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>".css"
                                      ,"description"=>"")
               ,"sitemap.php"
                              =>array( "title"=>"サイトマップ"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>".css"
                                      ,"description"=>"")
               ,"newitem.php"
                              =>array( "title"=>"最新情報"
                                      ,"css1" =>"all.css"
                                      ,"css2" =>"header.css"
                                      ,"css3" =>".css"
                                      ,"description"=>"")
              );

$NAVI  =array(
                "tintai.php?station=all"=>"駅名で検索!"  
               ,"tinati.php?address=all"=>"住所で検索!"
               ,"tinati.php?madori=all" =>"間取で検索!"
               ,"jigyou.php"            =>"店舗・倉庫!"
               ,"tinatai.php?car=all"   =>"駐車場検索!"
               ,"baibai.php"            =>"売買で検索!"
              );

$MININAVI=array(
                "q_and_a.php" =>"Q&A"
                ,"yanusi.php" =>"オーナー様"
               );

$INFO=array    (
                 "conpany.php"=>"会社概要"
                ,"storeinfo.php"=>"店舗情報"
                ,"privacy.php"=>"プライバシーポリシー"
                ,"sitemap.php"=>"サイトマップ"
                ,"toiawase.php"=>"お問い合せ"
               );

$SITECONTENTS=array(
                     "q_and_a.php"=>"Q&A"
                    ,"yanusi.php"=>"オーナー様"
                    ,"newitem.php"=>"最新情報"
                   );
//未使用
$BIGNAVI=array( "tintai.php"  =>"賃貸"
               ,"baibai.php"  =>"売買"
               ,"jigyou.php"  =>"事業用"
              );

//------------------------------------------------------------//
// テーブル情報(テーブル作成時に「id」列などが自動で付加される
// indexに数字をセットするとテーブル作成時にCreate Indexが実行される
//
//     "table_a"=>array( 
//       "col_a"=>array(  "type"   =>"[int|float|varchar(x)|date|etc..]"
//                       ,"null"   =>"[null | not null]"
//                       ,"default"=>"defalut value"
//                       ,"local"  =>"local column name"
//                       ,"index"  =>"[0-xx]"
//                     ) // colA
//                    ) // "table_a"
//
//------------------------------------------------------------//
$TABLES=array( 
 RAINS=>array(
   "fld000" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"物件番号",	"index"=>"1")
  ,"fld001" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"データ種類",	"index"=>"0")
  ,"fld002" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"物件種別",	"index"=>"0")
  ,"fld003" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"物件種目",	"index"=>"0")
  ,"fld004" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"会員名",	"index"=>"0")
  ,"fld005" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"代表電話番号",	"index"=>"0")
  ,"fld006" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"(問合せ先)電話番号1",	"index"=>"0")
  ,"fld007" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"問合せ担当者（１）",	"index"=>"0")
  ,"fld008" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"問合せ電話番号（１）",	"index"=>"0")
  ,"fld009" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"Ｅメールアドレス（１）",	"index"=>"0")
  ,"fld010" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"図面",	"index"=>"0")
  ,"fld011" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"登録年月日",	"index"=>"0")
  ,"fld012" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"変更年月日",	"index"=>"0")
  ,"fld013" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約年月日",	"index"=>"0")
  ,"fld014" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"取引条件の有効期限",	"index"=>"0")
  ,"fld015" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"新築中古区分",	"index"=>"0")
  ,"fld016" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"特優賃区分",	"index"=>"0")
  ,"fld017" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"都道府県名",	"index"=>"0")
  ,"fld018" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"所在地名１",	"index"=>"0")
  ,"fld019" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"所在地名２",	"index"=>"0")
  ,"fld020" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"所在地３",	"index"=>"0")
  ,"fld021" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物名",	"index"=>"0")
  ,"fld022" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"部屋番号",	"index"=>"0")
  ,"fld023" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"その他所在地表示",	"index"=>"0")
  ,"fld024" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"棟番号",	"index"=>"0")
  ,"fld025" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"沿線略称（1）",	"index"=>"0")
  ,"fld026" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駅名（1）",	"index"=>"0")
  ,"fld027" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"徒歩（分）１（１）",	"index"=>"0")
  ,"fld028" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"徒歩（ｍ）２（１）",	"index"=>"0")
  ,"fld029" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"バス（１）",	"index"=>"0")
  ,"fld030" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"バス路線名（１）",	"index"=>"0")
  ,"fld031" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"バス停名称（１）",	"index"=>"0")
  ,"fld032" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"停歩(分)（１）",	"index"=>"0")
  ,"fld033" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"停歩(ｍ)（１）",	"index"=>"0")
  ,"fld034" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"車（ｋｍ）（１）",	"index"=>"0")
  ,"fld035" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"その他交通手段",	"index"=>"0")
  ,"fld036" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"交通（分）１",	"index"=>"0")
  ,"fld037" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"交通（ｍ）２",	"index"=>"0")
  ,"fld038" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"現況",	"index"=>"0")
  ,"fld039" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"現況予定年月",	"index"=>"0")
  ,"fld040" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"引渡入居時期",	"index"=>"0")
  ,"fld041" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"引渡入居年月(西暦)",	"index"=>"0")
  ,"fld042" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"引渡入居旬",	"index"=>"0")
  ,"fld043" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"入居日",	"index"=>"0")
  ,"fld044" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"取引態様",	"index"=>"0")
  ,"fld045" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"報酬形態",	"index"=>"0")
  ,"fld046" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"手数料割合率",	"index"=>"0")
  ,"fld047" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"手数料",	"index"=>"0")
  ,"fld048" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"負担割合貸主",	"index"=>"0")
  ,"fld049" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"負担割合借主",	"index"=>"0")
  ,"fld050" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"配分割合元付",	"index"=>"0")
  ,"fld051" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"配分割合客付",	"index"=>"0")
  ,"fld052" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"報酬ヶ月",	"index"=>"0")
  ,"fld053" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"報酬額",	"index"=>"0")
  ,"fld054" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"価格賃料",	"index"=>"0")
  ,"fld055" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"価格賃料消費税",	"index"=>"0")
  ,"fld056" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"坪単価",	"index"=>"0")
  ,"fld057" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"㎡単価",	"index"=>"0")
  ,"fld058" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約価格",	"index"=>"0")
  ,"fld059" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約価格消費税",	"index"=>"0")
  ,"fld060" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約坪単価",	"index"=>"0")
  ,"fld061" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約㎡単価",	"index"=>"0")
  ,"fld062" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約前価格賃料",	"index"=>"0")
  ,"fld063" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約前坪単価",	"index"=>"0")
  ,"fld064" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約前㎡単価",	"index"=>"0")
  ,"fld065" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"成約前価格賃料消費税",	"index"=>"0")
  ,"fld066" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"想定利回り（％）",	"index"=>"0")
  ,"fld067" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"面積計測方式",	"index"=>"0")
  ,"fld068" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"専有面積／使用部分面積",	"index"=>"0")
  ,"fld069" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"保証金１（額）",	"index"=>"0")
  ,"fld070" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"保証金２（ヶ月）",	"index"=>"0")
  ,"fld071" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"権利金１（額）",	"index"=>"0")
  ,"fld072" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"権利金消費税（額）",	"index"=>"0")
  ,"fld073" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"権利金２（ヶ月）",	"index"=>"0")
  ,"fld074" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"礼金１（額）",	"index"=>"0")
  ,"fld075" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"礼金消費税（額）",	"index"=>"0")
  ,"fld076" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"礼金２（ヶ月）",	"index"=>"0")
  ,"fld077" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"敷金１（額）",	"index"=>"0")
  ,"fld078" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"敷金２（ヶ月）",	"index"=>"0")
  ,"fld079" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"償却コード",	"index"=>"0")
  ,"fld080" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"償却総額",	"index"=>"0")
  ,"fld081" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"償却月数",	"index"=>"0")
  ,"fld082" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"償却率",	"index"=>"0")
  ,"fld083" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"契約期間",	"index"=>"0")
  ,"fld084" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"契約期限（西暦）",	"index"=>"0")
  ,"fld085" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"解約引総額",	"index"=>"0")
  ,"fld086" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"解約引月数",	"index"=>"0")
  ,"fld087" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"解約引率",	"index"=>"0")
  ,"fld088" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"土地面積",	"index"=>"0")
  ,"fld089" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"土地共有持分面積",	"index"=>"0")
  ,"fld090" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"土地共有持分（分子）",	"index"=>"0")
  ,"fld091" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"土地共有持分（分母）",	"index"=>"0")
  ,"fld092" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物面積１",	"index"=>"0")
  ,"fld093" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"私道負担有無",	"index"=>"0")
  ,"fld094" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"私道面積",	"index"=>"0")
  ,"fld095" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"バルコニー（テラス）面積",	"index"=>"0")
  ,"fld096" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"開発面積／総面積",	"index"=>"0")
  ,"fld097" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"販売総面積",	"index"=>"0")
  ,"fld098" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"販売区画数",	"index"=>"0")
  ,"fld099" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"工事完了年月（西暦）",	"index"=>"0")
  ,"fld100" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建築面積",	"index"=>"0")
  ,"fld101" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"延べ面積",	"index"=>"0")
  ,"fld102" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"借地料",	"index"=>"0")
  ,"fld103" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"借地期間",	"index"=>"0")
  ,"fld104" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"借地期限（西暦）",	"index"=>"0")
  ,"fld105" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"専用庭面積",	"index"=>"0")
  ,"fld106" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"セットバック区分",	"index"=>"0")
  ,"fld107" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"後退距離（ｍ）",	"index"=>"0")
  ,"fld108" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"セットバック面積（㎡）",	"index"=>"0")
  ,"fld109" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"施設費用項目（１）",	"index"=>"0")
  ,"fld110" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"施設費用（１）",	"index"=>"0")
  ,"fld111" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"国土法届出",	"index"=>"0")
  ,"fld112" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"登記簿地目",	"index"=>"0")
  ,"fld113" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"現況地目（登記簿と異なる場合）",	"index"=>"0")
  ,"fld114" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"都市計画",	"index"=>"0")
  ,"fld115" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"用途地域（１）",	"index"=>"0")
  ,"fld116" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"用途地域（２）",	"index"=>"0")
  ,"fld117" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"最適用途",	"index"=>"0")
  ,"fld118" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建ぺい率",	"index"=>"0")
  ,"fld119" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"容積率",	"index"=>"0")
  ,"fld120" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"地域地区",	"index"=>"0")
  ,"fld121" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"土地権利",	"index"=>"0")
  ,"fld122" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"付帯権利",	"index"=>"0")
  ,"fld123" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"造作譲渡金",	"index"=>"0")
  ,"fld124" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"定借権利金",	"index"=>"0")
  ,"fld125" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"定借保証金",	"index"=>"0")
  ,"fld126" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"定借敷金",	"index"=>"0")
  ,"fld127" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"地勢",	"index"=>"0")
  ,"fld128" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建築条件",	"index"=>"0")
  ,"fld129" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"オーナーチェンジ",	"index"=>"0")
  ,"fld130" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物賃貸借区分",	"index"=>"0")
  ,"fld131" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物賃貸借期間",	"index"=>"0")
  ,"fld132" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物賃貸借更新",	"index"=>"0")
  ,"fld133" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"管理組合有無",	"index"=>"0")
  ,"fld134" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"管理形態",	"index"=>"0")
  ,"fld135" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"管理会社名",	"index"=>"0")
  ,"fld136" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"管理人状況",	"index"=>"0")
  ,"fld137" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"管理費",	"index"=>"0")
  ,"fld138" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"管理費消費税",	"index"=>"0")
  ,"fld139" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"修繕積立金",	"index"=>"0")
  ,"fld140" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"共益費",	"index"=>"0")
  ,"fld141" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"共益費消費税",	"index"=>"0")
  ,"fld142" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"雑費",	"index"=>"0")
  ,"fld143" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"雑費消費税",	"index"=>"0")
  ,"fld144" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"その他月額費名称１",	"index"=>"0")
  ,"fld145" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"その他月額費用金額１",	"index"=>"0")
  ,"fld146" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"更新区分",	"index"=>"0")
  ,"fld147" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"更新料（額）",	"index"=>"0")
  ,"fld148" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"更新料（ヶ月）",	"index"=>"0")
  ,"fld149" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"保険加入義務",	"index"=>"0")
  ,"fld150" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"保険名称",	"index"=>"0")
  ,"fld151" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"保険料",	"index"=>"0")
  ,"fld152" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"保険期間",	"index"=>"0")
  ,"fld153" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"施主",	"index"=>"0")
  ,"fld154" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"施工会社名",	"index"=>"0")
  ,"fld155" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"分譲会社名",	"index"=>"0")
  ,"fld156" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"一括下請負人",	"index"=>"0")
  ,"fld157" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道状況",	"index"=>"0")
  ,"fld158" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道種別１",	"index"=>"0")
  ,"fld159" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道接面１",	"index"=>"0")
  ,"fld160" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道位置指定１",	"index"=>"0")
  ,"fld161" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道方向１",	"index"=>"0")
  ,"fld162" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道幅員１",	"index"=>"0")
  ,"fld163" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道種別２",	"index"=>"0")
  ,"fld164" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道接面２",	"index"=>"0")
  ,"fld165" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道位置指定２",	"index"=>"0")
  ,"fld166" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道方向２",	"index"=>"0")
  ,"fld167" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道幅員２",	"index"=>"0")
  ,"fld168" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道種別３",	"index"=>"0")
  ,"fld169" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道接面３",	"index"=>"0")
  ,"fld170" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道位置指定３",	"index"=>"0")
  ,"fld171" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道方向３",	"index"=>"0")
  ,"fld172" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道幅員３",	"index"=>"0")
  ,"fld173" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道種別４",	"index"=>"0")
  ,"fld174" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道接面４",	"index"=>"0")
  ,"fld175" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道位置指定４",	"index"=>"0")
  ,"fld176" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道方向４",	"index"=>"0")
  ,"fld177" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道幅員４",	"index"=>"0")
  ,"fld178" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"接道舗装",	"index"=>"0")
  ,"fld179" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"間取タイプ（１）",	"index"=>"0")
  ,"fld180" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"間取部屋数（１）",	"index"=>"0")
  ,"fld181" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"部屋位置",	"index"=>"0")
  ,"fld182" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"納戸数",	"index"=>"0")
  ,"fld183" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室所在階１（１）",	"index"=>"0")
  ,"fld184" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室タイプ１（１）",	"index"=>"0")
  ,"fld185" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室広さ１（１）",	"index"=>"0")
  ,"fld186" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室数１（１）",	"index"=>"0")
  ,"fld187" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室所在階２（１）",	"index"=>"0")
  ,"fld188" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室タイプ２（１）",	"index"=>"0")
  ,"fld189" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室広さ２（１）",	"index"=>"0")
  ,"fld190" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室数２（１）",	"index"=>"0")
  ,"fld191" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室所在階３（１）",	"index"=>"0")
  ,"fld192" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室タイプ３（１）",	"index"=>"0")
  ,"fld193" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室広さ３（１）",	"index"=>"0")
  ,"fld194" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室数３（１）",	"index"=>"0")
  ,"fld195" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室所在階４（１）",	"index"=>"0")
  ,"fld196" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室タイプ４（１）",	"index"=>"0")
  ,"fld197" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室広さ４（１）",	"index"=>"0")
  ,"fld198" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室数４（１）",	"index"=>"0")
  ,"fld199" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室所在階５（１）",	"index"=>"0")
  ,"fld200" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室タイプ５（１）",	"index"=>"0")
  ,"fld201" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室広さ５（１）",	"index"=>"0")
  ,"fld202" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室数５（１）",	"index"=>"0")
  ,"fld203" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室所在階６（１）",	"index"=>"0")
  ,"fld204" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室タイプ６（１）",	"index"=>"0")
  ,"fld205" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室広さ６（１）",	"index"=>"0")
  ,"fld206" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室数６（１）",	"index"=>"0")
  ,"fld207" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室所在階７（１）",	"index"=>"0")
  ,"fld208" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室タイプ７（１）",	"index"=>"0")
  ,"fld209" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室広さ７（１）",	"index"=>"0")
  ,"fld210" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"室数７（１）",	"index"=>"0")
  ,"fld211" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"間取りその他（１）",	"index"=>"0")
  ,"fld212" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駐車場在否",	"index"=>"0")
  ,"fld213" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駐車場月額",	"index"=>"0")
  ,"fld214" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駐車場月額消費税",	"index"=>"0")
  ,"fld215" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駐車場敷金（額）",	"index"=>"0")
  ,"fld216" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駐車場敷金（ヶ月）",	"index"=>"0")
  ,"fld217" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駐車場礼金（額）",	"index"=>"0")
  ,"fld218" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"駐車場礼金（ヶ月）",	"index"=>"0")
  ,"fld219" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物構造",	"index"=>"0")
  ,"fld220" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物工法",	"index"=>"0")
  ,"fld221" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"建物形式",	"index"=>"0")
  ,"fld222" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"地上階層",	"index"=>"0")
  ,"fld223" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"地下階層",	"index"=>"0")
  ,"fld224" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"所在階",	"index"=>"0")
  ,"fld225" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"築年月（西暦）",	"index"=>"0")
  ,"fld226" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"総戸数",	"index"=>"0")
  ,"fld227" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"棟総戸数",	"index"=>"0")
  ,"fld228" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"連棟戸数",	"index"=>"0")
  ,"fld229" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"新築フラグ",	"index"=>"0")
  ,"fld230" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"バルコニー方向（１）",	"index"=>"0")
  ,"fld231" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"増改築年月１",	"index"=>"0")
  ,"fld232" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"増改築履歴１",	"index"=>"0")
  ,"fld233" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"増改築年月２",	"index"=>"0")
  ,"fld234" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"増改築履歴２",	"index"=>"0")
  ,"fld235" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"増改築年月３",	"index"=>"0")
  ,"fld236" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"増改築履歴３",	"index"=>"0")
  ,"fld237" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"周辺環境（フリー）１",	"index"=>"0")
  ,"fld238" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"距離１",	"index"=>"0")
  ,"fld239" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"時間１",	"index"=>"0")
  ,"fld240" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"周辺アクセス１",	"index"=>"0")
  ,"fld241" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"備考１",	"index"=>"0")
  ,"fld242" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"備考２",	"index"=>"0")
  ,"fld243" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"［賃貸］賃貸戸数",	"index"=>"0")
  ,"fld244" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"［賃貸］棟総戸数",	"index"=>"0")
  ,"fld245" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"［賃貸］連棟戸数",	"index"=>"0")
  ,"fld246" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"自社管理欄",	"index"=>"0")
  ,"fld247" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"再建築不可フラグ",	"index"=>"0")
 )//RAINS
 ,LATLNG=>array(
   "fld000"  =>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"物件番号",	"index"=>"1")
  ,"startlat"=>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"StartLat",	"index"=>"0")
  ,"startlng"=>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"StartLng",	"index"=>"0")
  ,"endlat"  =>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"EndLat",	"index"=>"0")
  ,"endlng"  =>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"EndLng",	"index"=>"0")
 )//LATLNG
 ,IMGLIST=>array(
  	"fld000" =>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"物件番号",	"index"=>"1")
  ,"fld001" =>array("type"=>" int"    , "null"=>" not null",	"default"=>"99",	"local"=>"表示順",	"index"=>"0")
  ,"fld002" =>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"ファイル名",	"index"=>"0")
  ,"fld003" =>array("type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"コメント",	"index"=>"0")
 )//IMGLIST
 ,FLD=>array(
   "fldname"=>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"列名","index"=>"1")
  ,"fld001" =>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"データ種類","index"=>"2")
  ,"fld002" =>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"物件種別" ,"index"=>"3")
  ,"bnum"   =>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"値" ,"index"=>"4")
  ,"bname"  =>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"項目名" ,"index"=>"0")
 )//FLD
 ,RANK=>array(
   "rank"    =>array("type"=>" int"    , "null"=>" not null", "default"=>"0" , "local"=>"ランク"  ,"index"=>"1")
  ,"rankname"=>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"コメント","index"=>"0")
  ,"rcomment"=>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"コメント","index"=>"0")
  ,"startday"=>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"開始日"  ,"index"=>"2")
  ,"endday"  =>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"終了日"  ,"index"=>"3")
  ,"flg"     =>array("type"=>" int"    , "null"=>" not null", "default"=>"1" , "local"=>"表示"    ,"index"=>"4")
  )//RANK
 ,ENTRY=>array(
   "rank"    =>array("type"=>" int"    , "null"=>" not null", "default"=>"0" , "local"=>"ランク"  ,"index"=>"1")
  ,"fld000" =>array("type"=>" varchar" , "null"=>" not null", "default"=>"''", "local"=>"物件番号","index"=>"2")
  ,"fld001" =>array("type"=>" int"     , "null"=>" not null", "default"=>"0", "local"=>"表示順","index"=>"3")
  ,"ecomment"=>array("type"=>" varchar", "null"=>" not null", "default"=>"''", "local"=>"コメント","index"=>"4")
  )//ENTRY
 ,BCOMMENT=>array(
   "fld000" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"物件番号",	"index"=>"1")
  ,"fld001" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"その他設備",	"index"=>"0")
  ,"fld002" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"物件コメント",	"index"=>"0")
  ,"fld003" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"コメント3",	"index"=>"0")
  ,"fld004" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"コメント4",	"index"=>"0")
  ,"fld005" =>array(	"type"=>" varchar",	"null"=>" not null",	"default"=>"''",	"local"=>"コメント5",	"index"=>"0")
 )
);//$TABLES

$TABLES[BLACKLIST]=$TABLES[RAINS];


$TINTAI=array( 
      0=>"fld000"
  ,   1=>"fld001"
  ,   2=>"fld002"
  ,   3=>"fld003"
  ,   4=>"fld004"
  ,   5=>"fld005"
  ,   6=>"fld007"
  ,   7=>"fld008"
  ,   8=>"fld009"
  ,   9=>"fld010"
  ,  10=>"fld011"
  ,  11=>"fld012"
  ,  12=>"fld014"
  ,  13=>"fld016"
  ,  14=>"fld017"
  ,  15=>"fld018"
  ,  16=>"fld019"
  ,  17=>"fld020"
  ,  18=>"fld021"
  ,  19=>"fld022"
  ,  20=>"fld023"
  ,  21=>"fld024"
  ,  22=>"fld025"
  ,  23=>"fld026"
  ,  24=>"fld027"
  ,  25=>"fld028"
  ,  26=>"fld029"
  ,  27=>"fld030"
  ,  28=>"fld031"
  ,  29=>"fld032"
  ,  30=>"fld033"
  ,  31=>"fld034"
  ,  32=>"fld035"
  ,  33=>"fld036"
  ,  34=>"fld037"
  ,  35=>"fld038"
  ,  36=>"fld039"
  ,  37=>"fld040"
  ,  38=>"fld041"
  ,  39=>"fld042"
  ,  40=>"fld044"
  ,  41=>"fld045"
  ,  42=>"fld048"
  ,  43=>"fld049"
  ,  44=>"fld050"
  ,  45=>"fld051"
  ,  46=>"fld052"
  ,  47=>"fld053"
  ,  48=>"fld054"
  ,  49=>"fld055"
  ,  50=>"fld056"
  ,  51=>"fld057"
  ,  52=>"fld069"
  ,  53=>"fld070"
  ,  54=>"fld071"
  ,  55=>"fld072"
  ,  56=>"fld073"
  ,  57=>"fld074"
  ,  58=>"fld075"
  ,  59=>"fld076"
  ,  60=>"fld077"
  ,  61=>"fld078"
  ,  62=>"fld079"
  ,  63=>"fld080"
  ,  64=>"fld081"
  ,  65=>"fld082"
  ,  66=>"fld083"
  ,  67=>"fld084"
  ,  68=>"fld085"
  ,  69=>"fld086"
  ,  70=>"fld087"
  ,  71=>"fld088"
  ,  72=>"fld067"
  ,  73=>"fld092"
  ,  74=>"fld068"
  ,  75=>"fld095"
  ,  76=>"fld105"
  ,  77=>"fld109"
  ,  78=>"fld110"
  ,  79=>"fld115"
  ,  80=>"fld116"
  ,  81=>"fld112"
  ,  82=>"fld113"
  ,  83=>"fld114"
  ,  84=>"fld118"
  ,  85=>"fld119"
  ,  86=>"fld120"
  ,  87=>"fld117"
  ,  88=>"fld127"
  ,  89=>"fld130"
  ,  90=>"fld131"
  ,  91=>"fld132"
  ,  92=>"fld137"
  ,  93=>"fld133"
  ,  94=>"fld138"
  ,  95=>"fld140"
  ,  96=>"fld141"
  ,  97=>"fld142"
  ,  98=>"fld143"
  ,  99=>"fld144"
  , 100=>"fld145"
  , 101=>"fld146"
  , 102=>"fld147"
  , 103=>"fld148"
  , 104=>"fld149"
  , 105=>"fld150"
  , 106=>"fld151"
  , 107=>"fld152"
  , 108=>"fld157"
  , 109=>"fld158"
  , 110=>"fld159"
  , 111=>"fld160"
  , 112=>"fld161"
  , 113=>"fld162"
  , 114=>"fld163"
  , 115=>"fld164"
  , 116=>"fld165"
  , 117=>"fld166"
  , 118=>"fld167"
  , 119=>"fld168"
  , 120=>"fld169"
  , 121=>"fld170"
  , 122=>"fld171"
  , 123=>"fld172"
  , 124=>"fld173"
  , 125=>"fld174"
  , 126=>"fld175"
  , 127=>"fld176"
  , 128=>"fld177"
  , 129=>"fld178"
  , 130=>"fld179"
  , 131=>"fld180"
  , 132=>"fld181"
  , 133=>"fld182"
  , 134=>"fld183"
  , 135=>"fld184"
  , 136=>"fld185"
  , 137=>"fld186"
  , 138=>"fld187"
  , 139=>"fld188"
  , 140=>"fld189"
  , 141=>"fld190"
  , 142=>"fld191"
  , 143=>"fld192"
  , 144=>"fld193"
  , 145=>"fld194"
  , 146=>"fld195"
  , 147=>"fld196"
  , 148=>"fld197"
  , 149=>"fld198"
  , 150=>"fld199"
  , 151=>"fld200"
  , 152=>"fld201"
  , 153=>"fld202"
  , 154=>"fld203"
  , 155=>"fld204"
  , 156=>"fld205"
  , 157=>"fld206"
  , 158=>"fld207"
  , 159=>"fld208"
  , 160=>"fld209"
  , 161=>"fld210"
  , 162=>"fld211"
  , 163=>"fld212"
  , 164=>"fld213"
  , 165=>"fld214"
  , 166=>"fld215"
  , 167=>"fld216"
  , 168=>"fld217"
  , 169=>"fld218"
  , 170=>"fld219"
  , 171=>"fld220"
  , 172=>"fld221"
  , 173=>"fld222"
  , 174=>"fld223"
  , 175=>"fld224"
  , 176=>"fld225"
  , 177=>"fld229"
  , 178=>"fld230"
  , 179=>"fld231"
  , 180=>"fld232"
  , 181=>"fld233"
  , 182=>"fld234"
  , 183=>"fld235"
  , 184=>"fld236"
  , 185=>"fld237"
  , 186=>"fld238"
  , 187=>"fld239"
  , 188=>"fld240"
  , 189=>"fld241"
  , 190=>"fld242"
  , 191=>"fld243"
  , 192=>"fld244"
  , 193=>"fld245"
  , 194=>"fld246"
 );

$BAIBAI=array( 
    0=>"fld000"
  , 1=>"fld001"
  , 2=>"fld002"
  , 3=>"fld003"
  , 4=>"fld004"
  , 5=>"fld005"
  , 6=>"fld007"
  , 7=>"fld008"
  , 8=>"fld009"
  , 9=>"fld010"
  , 10=>"fld011"
  , 11=>"fld012"
  , 12=>"fld014"
  , 13=>"fld015"
  , 14=>"fld017"
  , 15=>"fld018"
  , 16=>"fld019"
  , 17=>"fld020"
  , 18=>"fld021"
  , 19=>"fld022"
  , 20=>"fld023"
  , 21=>"fld024"
  , 22=>"fld025"
  , 23=>"fld026"
  , 24=>"fld027"
  , 25=>"fld028"
  , 26=>"fld029"
  , 27=>"fld030"
  , 28=>"fld031"
  , 29=>"fld032"
  , 30=>"fld033"
  , 31=>"fld034"
  , 32=>"fld035"
  , 33=>"fld036"
  , 34=>"fld037"
  , 35=>"fld038"
  , 36=>"fld039"
  , 37=>"fld040"
  , 38=>"fld041"
  , 39=>"fld042"
  , 41=>"fld043"
  , 42=>"fld044"
  , 43=>"fld045"
  , 44=>"fld046"
  , 45=>"fld047"
  , 46=>"fld054"
  , 47=>"fld055"
  , 48=>"fld056"
  , 49=>"fld057"
  , 50=>"fld066"
  , 51=>"fld067"
  , 52=>"fld088"
  , 53=>"fld089"
  , 54=>"fld090"
  , 55=>"fld091"
  , 56=>"fld092"
  , 57=>"fld068"
  , 58=>"fld093"
  , 59=>"fld094"
  , 60=>"fld095"
  , 61=>"fld105"
  , 62=>"fld106"
  , 63=>"fld107"
  , 64=>"fld108"
  , 65=>"fld096"
  , 66=>"fld097"
  , 67=>"fld098"
  , 68=>"fld099"
  , 69=>"fld100"
  , 70=>"fld101"
  , 73=>"fld102"
  , 74=>"fld103"
  , 75=>"fld104"
  , 76=>"fld109"
  , 77=>"fld110"
  , 78=>"fld111"
  , 79=>"fld112"
  , 80=>"fld113"
  , 81=>"fld114"
  , 82=>"fld115"
  , 83=>"fld116"
  , 84=>"fld117"
  , 85=>"fld118"
  , 86=>"fld119"
  , 87=>"fld120"
  , 88=>"fld121"
  , 89=>"fld122"
  , 90=>"fld123"
  , 91=>"fld124"
  , 92=>"fld125"
  , 93=>"fld126"
  , 94=>"fld127"
  , 95=>"fld128"
  , 96=>"fld129"
  , 97=>"fld133"
  , 98=>"fld134"
  , 99=>"fld135"
  , 100=>"fld136"
  , 101=>"fld137"
  , 102=>"fld138"
  , 103=>"fld139"
  , 104=>"fld144"
  , 105=>"fld145"
  , 106=>"fld153"
  , 107=>"fld154"
  , 108=>"fld155"
  , 109=>"fld156"
  , 110=>"fld157"
  , 111=>"fld158"
  , 112=>"fld159"
  , 113=>"fld160"
  , 114=>"fld161"
  , 115=>"fld162"
  , 116=>"fld163"
  , 117=>"fld164"
  , 118=>"fld165"
  , 119=>"fld166"
  , 120=>"fld167"
  , 121=>"fld168"
  , 122=>"fld169"
  , 123=>"fld170"
  , 124=>"fld171"
  , 125=>"fld172"
  , 126=>"fld173"
  , 127=>"fld174"
  , 128=>"fld175"
  , 129=>"fld176"
  , 130=>"fld177"
  , 131=>"fld178"
  , 132=>"fld179"
  , 133=>"fld180"
  , 134=>"fld181"
  , 135=>"fld182"
  , 136=>"fld183"
  , 137=>"fld184"
  , 138=>"fld185"
  , 139=>"fld186"
  , 140=>"fld187"
  , 141=>"fld188"
  , 142=>"fld189"
  , 143=>"fld190"
  , 144=>"fld191"
  , 145=>"fld192"
  , 146=>"fld193"
  , 147=>"fld194"
  , 148=>"fld195"
  , 149=>"fld196"
  , 150=>"fld197"
  , 151=>"fld198"
  , 152=>"fld199"
  , 153=>"fld200"
  , 154=>"fld201"
  , 155=>"fld202"
  , 156=>"fld203"
  , 157=>"fld204"
  , 158=>"fld205"
  , 159=>"fld206"
  , 160=>"fld207"
  , 161=>"fld208"
  , 162=>"fld209"
  , 163=>"fld210"
  , 164=>"fld211"
  , 165=>"fld212"
  , 166=>"fld213"
  , 167=>"fld214"
  , 168=>"fld215"
  , 169=>"fld216"
  , 170=>"fld217"
  , 171=>"fld218"
  , 172=>"fld219"
  , 173=>"fld220"
  , 174=>"fld221"
  , 175=>"fld222"
  , 176=>"fld223"
  , 177=>"fld224"
  , 178=>"fld225"
  , 179=>"fld226"
  , 180=>"fld227"
  , 181=>"fld228"
  , 182=>"fld230"
  , 183=>"fld231"
  , 184=>"fld232"
  , 185=>"fld233"
  , 186=>"fld234"
  , 187=>"fld235"
  , 188=>"fld236"
  , 189=>"fld237"
  , 190=>"fld238"
  , 191=>"fld239"
  , 192=>"fld240"
  , 193=>"fld241"
  , 194=>"fld242"
  , 195=>"fld246"
  , 196=>"fld247"
 );
$PAGES=array( "index.php" =>array( "title"=>"ホーム"
                                  ,"content"=>CORPNAME."は不動産屋です。"
                                  ,"css"=>array("header.css")
                               )
             ,"tintai.php"=>array( "title"=>"賃貸情報"
                                  ,"content"=>""
                                  ,"css"=>array( "header.css"
                                                ,"test.css"
                                               )
                                 )
             ,"baibai.php"=>array( "title"=>"売買情報"
                                  ,"content"=>""
                                  ,"css"=>""
                                 )
             ,"jigyo.php" =>array( "title"=>"事業用"
                                  ,"content"=>""
                                  ,"css"=>""
                                 )
             ,"faq.php"   =>array( "title"=>"お部屋探しってどーしたらいいの？"
                                  ,"content"=>""
                                  ,"css"=>""
                                 )
             ,"link.php"  =>array( "title"=>"リンク"
                                  ,"content"=>""
                                  ,"css"=>""
                                 )
             ,"owner.php" =>array( "title"=>"家主様"
                                  ,"content"=>""
                                  ,"css"=>""
                                 )
             ,"annai.php" =>array( "title"=>"会社案内"
                                  ,"content"=>""
                                  ,"css"=>""
                                 )
             ,"contact.php" =>array( "title"=>"お問い合わせ"
                                    ,"content"=>""
                                    ,"css"=>""
                                   )
            );
function wLog($comment){
 //ログディレクトリセット
 $LOGDIR=dirname(__FILE__)."/..".LOG;
 //ディレクトリ存在チェック
 if(!file_exists($LOGDIR)){
 echo "ログディレクトリが存在しません。".$LOGDIR;
  return false;
 }

 //ファイルパスセット
 $filepath=$LOGDIR."/".date("Ymd").".log";
 
 //ログコメントセット
 $c=date("Y-m-d H:i:s")." ".$comment."\n";
 
 //ファイル書き込み
 if(! $fp=fopen($filepath,"a")){
  echo "ログファイルが開けません。".$filepath;
  return false;
 }

 //echo $c."<br>";

 fwrite($fp,$c);
 fclose($fp);
}

function showTables(){
 global $TABLES;
 foreach($TABLES as $tablename=>$rows){
  echo "<h2>".$tablename."</h2>";
  echo "<table><thead><tr>";
  echo "<th>列名</th>";
  echo "<th>日本語列名</th>";
  echo "<th>type</th>";
  echo "<th>null</th>";
  echo "<th>default</th>";
  echo "<th>index</th>";
  echo "</tr></thead><tbody>";
  foreach($rows as $fld=>$detail){
   echo "<tr>";
   echo "<td>".$fld."</td>";
   echo "<td>".$detail["local"]."</td>";
   echo "<td>".$detail["type"]."</td>";
   echo "<td>".$detail["null"]."</td>";
   echo "<td>".$detail["default"]."</td>";
   echo "<td>".$detail["index"]."</td>";
   echo "</tr>";
  }
  echo "</tbody></table>";
 }
}

?>
