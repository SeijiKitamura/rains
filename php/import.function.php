<?php
/*-----------------------------------------------------
 ファイル名:import.function.php
 接頭語    :imp
 主な動作  :各種データをDBにセットする
 返り値    :
 エラー    :メッセージを表示
----------------------------------------------------- */
require_once("db.class.php");


//------------------------------------------//
//POSTされたCSVファイルをUTF-8へ変換
//1行ずつ配列へ格納して返す
//------------------------------------------//
function impCsv2Ary($postfile){
 $mname="impCsv2Ary(import.function.php) ";
 try{
  $c="start ".$mname;wLog($c);
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
  $tmp_name=$postfile["csvfile"]["tmp_name"];
  $c=$mname."一時ファイル名ゲット。".$tmp_name;wLog($c);

  $detect_order="ASCII,JIS,UTF-8,CP51932,SJIS-win";
  $csv=array();
  setlocale(LC_ALL,"ja_JP.UTF-8");
  $c=$mname."一時ファイル名読み込み。".$tmp_name;wLog($c);
  $buffer=file_get_contents($tmp_name);
  if(! $encoding=mb_detect_encoding($buffer,$detect_order,true)){
   unset($buffer);
   throw new Exception("文字コード変換失敗。");
  }

  $c=$mname."一時ファイルの文字コードをUTF-8に変更。".$tmp_name;wLog($c);
  file_put_contents($tmp_name,mb_convert_encoding($buffer,"UTF-8",$encoding));
  unset($buffer);
  $fp=fopen($tmp_name,"rb");
  $c=$mname."行ごとに配列へ格納";wLog($c);
  while($row=fgetcsv($fp)){
   //空行はスキップｗ!
   if($row===array(null)){
    $c=$mname."空行のため、処理をスキップ";wLog($c);
    continue;
   }
   $csv[]=$row;
  }

  //読み込み終了後エンドポイントになっていなければエラー
  if(!feof($fp)){
   $c=$mname."読み込み終了後エンドポイントになっていない";wLog($c);
   throw new Exception("CSV変換エラー");
  }
  fclose($fp);
  $c="end ".$mname;wLog($c);
  return $csv;
 }
 catch(Exception $e){
  wLog("error:".$mname.$e->getMessage());
  echo "err:".$e->getMessage();
 }
}

//------------------------------------------//
//CSVファイルを1行ずつ配列へ格納して返す
//(UTF-8ファイル限定)
//------------------------------------------//
function impCsv2AryUTF($filename){
 $mname="impCsv2AryUTF(import.function.php)";
 try{
  //ファイル存在チェック
  if(! file_exists($filename)){
   throw new exception("ファイルがありません:".$filename);
  }

  //ファイル読み込み
  $fp=fopen($filename,"rb"); 
  
  //ファイルを行単位で配列へ格納
  while($row=fgetcsv($fp)){
   //空行はスキップｗ!
   if($row===array(null)){
    $c=$mname."空行のため、処理をスキップ";wLog($c);
    continue;
   }
   $csv[]=$row;
  }
  
  //読み込み終了後エンドポイントになっていなければエラー
  if(!feof($fp)){
   $c=$mname."読み込み終了後エンドポイントになっていない";wLog($c);
   throw new Exception("CSV変換エラー");
  }
  fclose($fp);
  $c="end:".$mname;wLog($c);
  return $csv;
 }
 catch(Exception $e){
  wLog("error:".$mname.$e->getMessage());
  echo "err:".$e->getMessage();
 }
}

//-------------------------------------------------//
// CSVファイルをDBに登録
// （impCsv2AryとimpCsv2SQLのコンボ)
//-------------------------------------------------//
function impCsv2DB($postfile,$tablename){
 $mname="impCsv2DB";
 try{
  $c="start ".$mname;wLog($c);
  //CSVを配列へ
  $csv=impCsv2Ary($postfile);
  
  //CSV値チェック
  if($tablename!==FLD && ! impChkCsv($csv)){
   throw new exception("CSVにエラーがあります");
  }

  //CSVをSQL用配列に変換
  $sql=impCsv2SQL($tablename,$csv);

  //echo "<pre>";
  //print_r($sql);
  //echo "</pre>";

  //DB登録
  $db=new DB();
  $db->updatearray($sql);
  $c="end ".$mname;wLog($c);
  return $sql;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
 }
}


//------------------------------------------//
//CSVファイルをDBに登録（UTF-8ファイル限定)
//(impCsv2AryUTFとimpCsv2SQLのコンボ)
//------------------------------------------//
function impCsv2DBUTF($tablename,$filename){
 global $TABLES;

 $mname="impCsv2DBUTF(import.function.php)";
 try{
  $csv=impCsv2AryUTF($filename);
  $sql=impCsv2SQL($tablename,$csv);
  $db=new DB();
  $db->from=TABLE_PREFIX.$tablename;
  $db->where="id>0";
  $db->delete();
  $db->updatearray($sql);
  echo "UPDATEしました";
 }
 catch(Exception $e){
  wLog("error:".$mname.$e->getMessage());
  echo "err:".$e->getMessage();
 }
}

//-------------------------------------------------//
// CSV配列をSQL配列へ変換して返す
//-------------------------------------------------//
function impCsv2SQL($tablename,$csv){
 global $TABLES;
 global $CSVCOL;
 $mname="impCsv2SQL(import.function.php) ";
 try{
  $c="start ".$mname;wLog($c);
//テーブル存在確認
  if(!isset($TABLES[$tablename])){
   throw new exception("テーブル定義が登録されていません");
  }
  
//CSVデータ確認
  if(! isset($csv)){
   throw new exception("CSVデータがありません");
  }
  
//CSV列をコンバート
  if($tablename==RAINS){
   $colnum=impCvrtTable($csv);
  }
  else{
   $colnum=impCvrtTable2($tablename);
  }

//where句対象列を配列にセット
  foreach($colnum as $key=>$val){
   if($TABLES[$tablename][$val]["index"]){
    $c=$mname."where句に".$val."をセット";
    $wherecol[$key]=$val;
   }
  }
  
//CSV読み込み
  $sql=array();
  foreach($csv as $rows=>$row){
   $col=array();
   //1列目が数字以外はスキップ
   if($tablename!=FLD && ! preg_match("/^[0-9]+$/",$row[0])){
    $c=$mname."1列目(".$row[0].")が数字以外なのでスキップ";wLog($c);
    continue;
   }
//データを列名=>値にセット
   foreach($row as $n=>$val){
    if(! $colnum[$n]) continue;
    $c=$mname."データ更新列".$colnum[$n]."に".$val."をセット";wLog($c);
    if(preg_match("/^[0-9]+$/",$val)){
     $col[$colnum[$n]]=(float)$val;
    }
    else{
     $col[$colnum[$n]]=$val;
    }
   }//foreach

//where句を列名=>値にセット
   foreach($wherecol as $n=>$colname){
    $c=$mname."where句に".$colname."=".$row[$n]."をセット";wLog($c);
    $where[$colname]=$row[$n];
   }
//配列に格納
   $sql[]=array( "col"=>$col
                ,"from"=>TABLE_PREFIX.$tablename
                ,"where"=>$where
               );
  }//foreach
  $c="end ".$mname;wLog($c);
  return $sql;
 }
 catch(exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
 }
}

//-------------------------------------------------//
// CSVをRainsテーブル用にコンバート
//-------------------------------------------------//
function impCvrtTable($csv){
 global $TABLES;
 global $TINTAI;
 global $BAIBAI;
 $mname="impCvrtTable(import.function.php)";
 try{
  $c="start ".$mname;wLog($c);
  $ary=array();
//自社物件
  if(count($csv[0])==248){
   $c=$mname."列数248なので列名にRAINSを使用";wLog($c);
   foreach($TABLES[RAINS] as $colname=>$val){
    $ary[]=$colname;
   }
  }
//他社賃貸
  elseif(count($csv[0])==195){
   $c=$mname."列数195なので列名にTINTAIを使用";wLog($c);
   $ary=$TINTAI;
  }
//売買土地
  elseif(count($csv[0])==197){
   $c=$mname."列数197なので列名にBAIBAIを使用";wLog($c);
   $ary=$BAIBAI;
  }
  else{
   throw new exception("CSV列数が定義されていません。");
  }
  $c="end ".$mname;wLog($c);
  return $ary;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
 }
}

//-------------------------------------------------//
// CSVをRainsテーブル用にコンバート
// (テーブル名がわかっている場合に使用)
//-------------------------------------------------//
function impCvrtTable2($tablename){
 global $TABLES;
 $mname="impCvrtTable2(import.function.php)";
 try{
  $c="start ".$mname;wLog($c);
  foreach($TABLES[$tablename] as $colname=>$val){
   $ary[]=$colname;
  }
  $c="end ".$mname;wLog($c);
  return $ary;
 }
 catch(Exception $e){
  $c="error:".$mname.$e->getMessage();wLog($c);
  echo $c;
 }
}

//-------------------------------------------------//
// 配列をチェック(最初の行に列名が入っている前提)
//-------------------------------------------------//
function impChkCsv($csv){
 $mname="impChkCsv(import.function.php) ";
 try{
  $c="start ".$mname;wLog($c);
  if(! is_array($csv))  throw new Exception("データ形式エラー");
  $errflg=1;
  foreach($csvarray as $key=>$val){
   //最初のデータは飛ばす
   if(! $key)continue;

   //物件番号が数字チェック
   if(! preg_match("/^[0-9]+$/",$val[0])){
    $c="error:".$mname."物件番号が不正です。".$val[0];wLog($c);
    $errflg=0;
   }
  }
  if(! $errflg){
   return false;
  }
  $c="end ".$mname;wLog($c);
  return true;
 }
 catch(Exception $e){
  wLog("error:".$mname.$e->getMessage());
  echo "err:".$e->getMessage();
 }
}


?>
