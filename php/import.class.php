<?php
require_once("db.class.php");

//-------------------------------------------------//
// CSVファイルをDBに登録する（getCSV setCSV2DBのラッパー)
//-------------------------------------------------//
function setCSV2DB($sql){
 try{
  //$csv=getCSV($tablename);
  //$sql=setCSV2DB($tablename,$csv);

  $db=new DB();
  $db->updatearray($sql);
  return true;
 }
 catch(Exception $e){
  echo "err:".$e->getMessage();
 }
}

//Rainsその他のフィールドデータを更新
function setCSV2DBFLD(){
 $csv=getCSV("rains");
 $sql=setCSV2SQL(FLD,$csv);
 $db=new DB();
 $db->updatearray($sql);
}
//-------------------------------------------------//
// CSVファイルを配列にして返す
//-------------------------------------------------//
function getCSV($filename){
 global $TABLES;
 global $CSVCOL;
 setlocale(LC_ALL,"ja_JP.UTF-8");

 try{
  $FILEPATH=dirname($_SERVER["SCRIPT_FILENAME"]).DATA."/".$filename.".csv";

//CSVファイル存在チェック
  if(! file_exists($FILEPATH)){
   throw new exception($filename.".csvがありません。");
  }

//CSVファイル読み込み
  $data=file_get_contents($FILEPATH); 

//文字コード変換
  $data=mb_convert_encoding($data,"UTF-8","sjis-win");
  
//一時ファイルに書き込み
  $temp=tmpfile();
  fwrite($temp,$data);
  rewind($temp);
  
//カンマ区切りして配列へ格納
  $csv=array();
  while(($data=fgetcsv($temp,0,",")) !==FALSE){
   $csv[]=$data;
  }
  fclose($temp);

//CSV読み込み順に配列へ格納
  return $csv;
 }
 catch(Exception $e){
  echo "err:".$e->getMessage();
 }
}

function getCsvNew($postfile){
 try{
  //アップロードチェック
  switch ($postfile["csvfile"]["error"]){
   case UPLOAD_ERR_OK:
     break;
   case UPLOAD_ERR_NO_FILE:
    throw new Exception("ファイルが選択されていません");
   case UPLOAD_ERRINI_SIZE:
   case UPLOAD_ERR_FORM_SIZE:
    throw new Exception("ファイルサイズが大きすぎます");
   default:
    throw new Exception("想定外のエラーです");
  }
  $tmp_name=$_FILES["csvfile"]["tmp_name"];
  $detect_order="ASCII,JIS,UTF-8,CP51932,SJIS-win";
  $csv=array();
  setlocale(LC_ALL,"ja_JP.UTF-8");

  $buffer=file_get_contents($tmp_name);
  if(! $encoding=mb_detect_encoding($buffer,$detect_order,true)){
   unset($buffer);
   throw new Exception("文字コード変換失敗。");
  }
  file_put_contents($tmp_name,mb_convert_encoding($buffer,"UTF-8",$encoding));
  unset($buffer);
  $fp=fopen($tmp_name,"rb");
  while($row=fgetcsv($fp)){
   //空行はスキップｗ!
   if($row===array(null)) continue;
   $csv[]=$row;
  }

  //読み込み終了後エンドポイントになっていなければエラー
  if(!feof($fp)){
   throw new Exception("CSV変換エラー");
  }
  fclose($fp);
  return $csv;
 }
 catch(Exception $e){
  echo "err:".$e->getMessage();
 }
}

//-------------------------------------------------//
// 配列をチェック
//-------------------------------------------------//
function checkCSV($csvarray){
 try{
  if(! is_array($csvarray))  throw new Exception("データ形式エラー");
  $errflg=1;
  foreach($csvarray as $key=>$val){
   //最初のデータは飛ばす
   if(! $key)continue;

   //物件番号が数字チェック
   if(! preg_match("/^[0-9]+$/",$val[0])){
    $errflg=0;
   }
  }
  if(! $errflg){
   return false;
  }
  return true;
 }
 catch(Exception $e){
  echo "err:".$e->getMessage();
  throw $e;
 }
}

function csv2HTMLTable($csvarray){
 try{
  $html.="<table>";
  $html.="<thead>";
  $html.="<tr>";
  $html.="<th>物件番号</th>";
  $html.="<th>物件名</th>";
  $html.="<th>賃料</th>";
  $html.="<th>住所</th>";
  $html.="</tr>";
  $html.="</thead>";
  $html.="<tbody>";
  foreach($csvarray as $key=>$val){
   if(!$key)continue;
   $html.="<tr>";
   $html.="<td>";
   if(! preg_match("/^[0-9]+$/",$val[0])){
    $html.="<span style='background-color:red'>";
   }
   $html.=$val[0];
   if(! preg_match("/^[0-9]+$/",$val[0])){
    $html.="</span>";
   }
   $html.="</td>";
   $html.="<td>".$val[21].$val[22]."</td>";
   $html.="<td>".$val[54]."</td>";
   $html.="<td>".$val[17].$val[18].$val[19].$val[20].$val[21]."</td>";
   $html.="</tr>";
  }
  $html.="</tbody>";
  $html.="</table>";
  return $html;

 }
 catch(Exception $e){
  echo "err:".$e->getMessage();
  throw $e;
 }
}
//-------------------------------------------------//
// 配列をDBへ登録
//$filetype=03 賃貸
//-------------------------------------------------//
function setCSV2SQL($tablename,$csv,$filetype=null){
 global $TABLES;
 global $CSVCOL;
 global $TINTAI;
 try{
//テーブル存在確認
  if(!isset($TABLES[$tablename])){
   throw new exception("テーブル定義が登録されていません");
  }
  
//CSVデータ確認
  if(! isset($csv)){
   throw new exception("CSVデータがありません");
  }
  
//index列格納
  $index=array();
  foreach($TABLES[$tablename] as $cols=>$col){
   foreach($col as $fld=>$val){
    if($fld=="index" && $val){
     $index[]=$cols;
    }
   }
  }

//列番号を配列にセット
//  foreach($TABLES[$tablename] as $colname=>$val){
//   $colnum[]=$colname;
//  }
  if(count($csv[0])==248){
   $colnum=convertTable($tablename);
  }
  elseif(count($csv[0])==195){
   $colnum=convertTable("tintai");
  }
  elseif(count($csv[0])==5){
   $colnum=convertTable($tablename);
  }

//where句を配列にセット
  foreach($colnum as $key=>$val){
   if($TABLES[$tablename][$val]["index"]){
    $wherecol[$key]=$val;
   }
  }
  
//CSV読み込み
  $sql=array();
  foreach($csv as $rows=>$row){
   $col=array();
//データを列名=>値にセット
   foreach($row as $n=>$val){
    $col[$colnum[$n]]=$val;
   }//foreach

//where句を列名=>値にセット
   foreach($wherecol as $n=>$colname){
    $where[$colname]=$row[$n];
   }
//配列に格納
   $sql[]=array( "col"=>$col
                ,"from"=>TABLE_PREFIX.$tablename
                ,"where"=>$where
               );
  }//foreach
  return $sql;
 }
 catch(exception $e){
  echo "err:".$e->getMessage();
 }
}

function convertTable($filetype=null){
 global $TABLES;
 global $TINTAI;
 $ary=array();
//デフォルト値
 if(!$filetype|| $filetype==RAINS){
  foreach($TABLES[RAINS] as $colname=>$val){
   $ary[]=$colname;
  }
 }
//他社賃貸
 elseif($filetype=="tintai"){
  $ary=$TINTAI;
 }
//Rainsフィールドデータ
 elseif($filetype==FLD){
  foreach($TABLES[FLD] as $colname=>$val){
   $ary[]=$colname;
  }
 }
 return $ary;
}
?>
