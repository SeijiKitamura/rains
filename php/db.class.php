<?php
//----------------------------------------------------//
//  db.class.php
//  PDOを使用した独自のDBインターフェイス
//  メソッド一覧
//  getArray()    データ表示。配列として返す
//  update()      データ更新。更新件数を返す
//  delete()      データ削除。更新件数を返す
//  BeginTran()   トランザクション開始
//  Commit()      コミット
//  RollBack()    ロールバック
//  RESET()       SQL文をリセット
//  __QUERY()     SQL実行。デバックモード有効時に動作。
//  CreateTable() 配列にセットされたテーブルを作成。
//----------------------------------------------------//
require_once("config.php");

class DB{
 private $pdo;
 private $dsn;
 public $ary;
 protected $sql;

 public $select;
 public $from;
 public $where;
 public $group;
 public $order;
 public $having;
 public $updatecol;

 // -------------------------------------------- //
 // 説明:PDOを初期化してセット
 // -------------------------------------------- //
 function __construct(){
  try{
   if(DBENGIN=="mysql"){
    $this->dsn="mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8;";
   }

   if(DBENGIN=="postgres"){
    $this->dsn="pgsql:host=".DBHOST." dbname=".DBNAME;
   }
   
   $this->pdo=new PDO($this->dsn,DBUSER,DBPASS);
 
   //エラー処理方法をセット
   $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

   wLog("DB接続:".$this->dsn);
  }
  catch(PDOException $e){
   $c="データベース接続に失敗しました";
   wLog($c);
   throw new exception($c);
  }
 } //__construct

 function SQLRESET(){
  wLog("SQLリセット:");
  //SQLリセット
  $this->select=null;
  $this->from  =null;
  $this->where =null;
  $this->group =null;
  $this->order =null;
  $this->having=null;
  $this->sql=null;
 }

 // -------------------------------------------- //
 // SELECT系SQLをセットして$this->aryに配列を返す
 // -------------------------------------------- //
 public function getArray(){
  wLog("start getArray(DB class)");
  //各値チェック
  if(! $this->select) throw new exception("SELECT句がセットされていません");
  if(! $this->from)   throw new exception("FROM句がセットされていません");

  //SQLセット
  $this->sql ="select ".$this->select." ";
  $this->sql.="from   ".$this->from." ";
  if($this->where) $this->sql.="where    ".$this->where." ";
  if($this->group) $this->sql.="group by ".$this->group." ";
  if($this->order) $this->sql.="order by ".$this->order." ";
  if($this->having)$this->sql.="having ".$this->having." ";

  //配列初期化
  $this->ary=null;

  //クエリー実行
  try{
   wlog("getArray(DB class):".$this->sql);
   $recodeset=$this->pdo->query($this->sql);
 
   //配列変換
   while($row =$recodeset->fetch(PDO::FETCH_ASSOC)){
    $this->ary[]=$row;
   }//while

   //SQLリセット
   $this->SQLRESET();
 
   //配列を返す
   wLog("end getArray(DB class)");
   return $this->ary;
  }//try
  catch(PDOException $e){
   //メッセージ作成
   $msg="データ取得に失敗しました。";
   if(DEBUG){
    $msg.="<br />";
    $msg.="SQL: ".$this->sql."<br />";
    $msg.="PDO: ".$e->getMessage();
   }
   wLog("error:getArray(DB class) ".$this-sql);
   //SQLリセット
   $this->SQLRESET();

   //メッセージスロー
   throw new exception($msg);
  }//catch
 } //getArray

 // --------------------------------------------------- //
 // UPDATE系SQLをセットして実行。影響を受けた行数を返す
 // --------------------------------------------------- //
 public function update(){
  wLog("start update(DB class)");
  
  //条件確認
  if(! $this->updatecol) throw new Exception("データを選択してください");
  if(! $this->from     ) throw new Exception("テーブルを選択してください");
  if(! $this->where    ) throw new Exception("条件を選択してください");

  //一旦退避
  $from=$this->from;
  $where=$this->where;

  //既存データチェック
  $this->select="*";
  $this->group =null;
  $this->order =null;
  $this->getArray();    //$this->aryに既存データが入いる

  $this->from=$from;
  $this->where=$where;

  //SQL実行
  try{
   if(count($this->ary)===0){
    //既存データがないためINSERT処理を開始
    $this->sql="";
    $this->sql ="insert into ".$this->from."(";
 
    //列名をセット
    $i=0;
    foreach($this->updatecol as $key=>$val){
     if($i>0) $this->sql.=",";
     $this->sql.=$key;
     $i++;
    }
    $this->sql.=") values(";
 
    //値をセット
    $i=0;
    foreach($this->updatecol as $key=>$val){
     if($i>0) $this->sql.=",";
     $this->sql.=$this->pdo->quote($val);
     $i++;
    }
    $this->sql.=")";
   }//if
 
   else{
   //既存データがあるのでUPDATE処理
    $this->sql="";
    $this->sql ="update ".$this->from." set ";
    $i=0;
    foreach($this->updatecol as $key=>$val){
     if($i>0) $this->sql.=",";
     $this->sql.=$key."=".$this->pdo->quote($val);
     $i++;
    }
    //データ更新日時をセット
    $this->sql.=",".CDATE."='".date("Y-m-d H:i:s")."'";
    $this->sql.=" where ".$this->where;
   }//else

   //DB更新
   wLog("update(DB class):".$this->sql);
   $resultrow=$this->pdo->exec($this->sql);

   //SQLリセット
   $this->SQLRESET();
   $this->updatecol=null;
   $this->ary=null;

   //正常終了(処理件数を返す)
   wLog("end update(DB class):result=>".$result);
   return $resultrow;
  }//try
  catch(PDOException $e){
   //メッセージ作成
   $msg="データ更新に失敗しました。 ";
   if(DEBUG){
    $msg.="<br />";
    $msg.="SQL: ".$this->sql."<br />";
    $msg.="PDO: ".$e->getMessage();
   }
   //SQLリセット
   $this->SQLRESET();
   $this->updatecol=null;
   //メッセージスロー
   wLog("error:update(DB class) ".$this-sql);
   throw new exception($msg);
  }//catch
 }//public function update(){

 public function updatearray($data){
  wLog("start updatearray(DB class)");

//データ存在確認
  if(!isset($data)) throw new exception("データがありません");

//データを更新と挿入に分類
  $insertdata=array();
  $updatedata=array();
  foreach($data as $key=>$ary){
   if(! isset($ary["where"])) throw new exception("Where句が指定されていません");

   //SQLリセット
   $this->SQLRESET();
   

   //FROM句をセット
   //$this->from=TABLE_PREFIX.$ary["from"];
   $this->from=$ary["from"];

   foreach($ary["where"] as $fld=>$val){
    //SELECT句をセット
    if(! $this->select) $this->select=$fld;
    else $this->select.=",".$fld;
    //WHERE句をセット
    if(! $this->where) $this->where=$fld."='".$val."' ";
    else{
     $this->where.=" and ".$fld."='".$val."'";
    }
   }// foreach($ary["where"] as $fld=>$val){
   //データ検索
   $this->getArray();

   if(count($this->ary)===0){
    //INSERT実行
    //$this->sql="insert into ".TABLE_PREFIX.$ary["from"]."(";
    $this->sql="insert into ".$ary["from"]."(";
    $i=0;
    foreach($ary["col"] as $fld=>$val){
     if($i) $this->sql.=",";
     $this->sql.=$fld;
     $i++;
    }
    $this->sql.=") values(";
    $i=0;
    foreach($ary["col"] as $fld=>$val){
     if($i) $this->sql.=",";
     $this->sql.="'".$val."'";
     $i++;
    }
    $this->sql.=")";
   }
   else{
    //UPDATE実行
    $this->sql="update ".TABLE_PREFIX.$ary["from"];
    $this->sql="update ".$ary["from"];
    $this->sql.=" set ";
    $i=0;
    foreach($ary["col"] as $fld=>$val){
     if($i) $this->sql.=",";
     $this->sql.=" ".$fld."='".$val."'";
     $i++;
    }
    $this->sql.=",cdate=current_timestamp";

    $this->sql.=" where ";
    $i=0;
    foreach($ary["where"] as $fld=>$val){
     if($i) $this->sql.=" and ";
     $this->sql.=$fld."='".$val."'";
     $i++;
    }
   }
   //SQL実行
   try{
//echo $this->sql."<br>";
    wLog("updatearray(DB class):".$this->sql);
    $this->pdo->exec($this->sql);
   }
   catch(PDOException $e){
    wLog("error:updatearray(DB class) ".$this->sql);
    throw new exception ($e->getMessage());
   }
   wLog("end updatearray(DB class)");
  }//foreach

 }//public function 

 // -------------------------------------------- //
 // DELTE系SQLをセット。消去した行数を返す
 // -------------------------------------------- //
 public function delete(){
  wLog("start delete(DB class)");
  //条件確認
  if(! $this->from ) throw new Exception("テーブルを確認してください");
  if(! $this->where) throw new Exception("条件を確認してください");
   
  try{
   //SQLセット
   $this->sql="";
   $this->sql ="delete from ".$this->from." where ".$this->where;
 
   //DB更新
   wLog("delete(DB class):".$this->sql);
   $resultrow=$this->pdo->exec($this->sql);

   //SQLリセット
   $this->SQLRESET();

   //正常終了
   wLog("end delete(DB class):result=>".$resultrow);
   return $resultrow;
  }//try
  catch(PDOException $e){
   //メッセージ作成
   $msg="データ削除に失敗しました。 ";
   if(DEBUG){
    $msg.="<br />";
    $msg.="SQL: ".$this->sql."<br />";
    $msg.="PDO: ".$e->getMessage();
   }

   //SQLリセット
   $this->SQLRESET();

   //メッセージスロー
   wLog("error:delete(DB class)".$this->sql);
   throw new exception($msg);
  }//catch
 }//public function delete(){
 
 // -------------------------------------------- //
 // 説明:SQL実行(DEBUGが有効時に動作する。)
 // -------------------------------------------- //
 public function __QUERY($sql=null){
  wLog("start __QUERY(DB class)");
  //SQLセット
  if($sql) $this->sql=$sql;
  if(! $this->sql) throw new exception("SQLがセットされていません");
  if(! DEBUG) throw new exception("現在のモードでは使用できません");
  try{
   //SQL実行
   wLog("__QUERY(DB class):".$this->sql);
   $this->pdo->exec($this->sql);

   //SQLリセット
   $this->SQLRESET();

   //正常終了
   wLog("end __QUERY(DB class)");
   return true;
  }
  catch(PDOException $e){
   //メッセージ作成
   $msg="SQL実行に失敗しました。 ";
   if(DEBUG){
    $msg.="<br />";
    $msg.="SQL: ".$this->sql."<br />";
    $msg.="PDO: ".$e->getMessage();
    echo $msg;
    wLog("error:__QUERY(DB class)".$this->sql);
    throw $e;
   }
  }//catch
 }//public function __QUERY(){

 // -------------------------------------------- //
 // 説明:テーブル作成(DEBUGが有効なら動作)
 // -------------------------------------------- //
 public function CreateTable($t=null){
  wLog("start CreateTable(DB class)");
  if(! DEBUG) throw new exception("現在のモードでは使用できません");

  //nullの場合はすべてのテーブルを作成
  if(! $t){
   $table=$GLOBALS["TABLES"];
   if(! $table) throw new exception("テーブルデータがありません");
  }
  else{
   $table[$t]=$GLOBALS["TABLES"][$t];
   if(! $table[$t]) throw new exception("テーブルデータがありません");
  }
  
  foreach ($table as $tablename =>$columns){
   $t=TABLE_PREFIX.$tablename;
   //SQL初期化
   $this->sql="";
   $index=array();

   //テーブル名セット
   $this->sql.="drop table if exists ".$t.";";
   //$this->sql.="create table if not exists ".$t."("; //postgres8.4 error
   $this->sql.="create table ".$t."(";
   $i=0;
   foreach($columns as $column=>$types){
    
    //ID列生成
    if(! $i){
     $this->sql.=IDSQL;
    }
    //列名をセット
    $this->sql.=",";
    $this->sql.=$column;
    $this->sql.=" ".$types["type"];
    $this->sql.=" ".$types["null"];
    if($types["default"]){
     $this->sql.=" default ".$types["default"];
    }
    //index列を格納
    if($types["index"]) $index[$column]=$types["index"];
    $i++;
   }//foreach $columns
   $this->sql.=",".IDATESQL;
   $this->sql.=",".CDATESQL; 
   $this->sql.=") ";
   if(DBENGIN=="mysql") $this->sql.=" engine=innodb;"; //MySQL固有
   echo $this->sql;
   $this->__QUERY($this->sql); 
   echo $t."を作成しました(多分?)\n";//PDOがエラーを返さない

   echo "<pre>";
   print_r($index);
   echo "</pre>";
   //インデックス作成
   if(isset($index)){
    asort($index);
    $this->sql="create index ix_".$t." on ".$t."(";
    $i=0;
    foreach($index as $colname=>$indexnum){
     if($i) $this->sql.=",";
     $this->sql.=$colname;
     $i++;
    }// foreach($index as $colname=>$indexnum){
    $this->sql.=")";
    echo $this->sql;
    $this->__QUERY($this->sql);
    echo $t."のインデックスを作成しました\n";
   }
  }//foreach $table
  wLog("end CreateTable(DB class)");
 }//public function CreateTable($t=null){

 public function BeginTran(){
  wLog("start BeginTran(DB class)");
  $this->pdo->beginTransaction();
 }//beginTran

 public function Commit(){
  wLog("start Commit(DB class)");
  $this->pdo->commit();
 }//commit

 public function RollBack(){
  wLog("start RollBack(DB class)");
  $this->pdo->rollBack();
 }//rollback

} //class DB
?>
