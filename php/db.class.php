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
//  CreateTable() 配列にセットされたテーブルを作成。
//----------------------------------------------------//

//ここではトランザクションを書かない
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
   $mname="__construct(db.class.php) ";
   $c="start:".$mname;wLog($c);
   if(DBENGIN=="mysql"){
    $this->dsn="mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8;";
   }

   if(DBENGIN=="postgres"){
    $this->dsn="pgsql:host=".DBHOST." dbname=".DBNAME;
   }
   
   $this->pdo=new PDO($this->dsn,DBUSER,DBPASS);
 
   //エラー処理方法をセット
   $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   $c="end:".$mname;wLog($c);
  }
  catch(PDOException $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 } //__construct

 function SQLRESET(){
  $mname="SQLRESET(db.class.php) ";
  $c="start:".$mname;wLog($c);
  //SQLリセット
  $this->sql=null;
  $this->select=null;
  $this->from  =null;
  $this->where =null;
  $this->group =null;
  $this->order =null;
  $this->having=null;
 }

 // -------------------------------------------- //
 // SELECT系SQLをセットして$this->aryに配列を返す
 // -------------------------------------------- //
 public function getArray(){
  try{
   $mname="getArray(db.class.php) ";$c="start:".$mname;wLog($c);
   
   //配列初期化
   $this->ary=null;
   
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

   //クエリー実行
   try{
    $c="notice:".$mname.$this->sql;wLog($c);
    $recodeset=$this->pdo->query($this->sql);
 
    //配列変換
    while($row =$recodeset->fetch(PDO::FETCH_ASSOC)){
     $this->ary[]=$row;
    }//while

    $this->SQLRESET();

    //配列を返す
    $c="end:".$mname;wLog($c);
    return $this->ary;
   }//try
   catch(PDOException $e){
    $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
   }//catch
  }//try
  catch(Exception $e){
   $c="error:".$e->getMessage();wLog($c);echo $c;
  }
 } //getArray

 // --------------------------------------------------- //
 // UPDATE系SQLをセットして実行。影響を受けた行数を返す
 // --------------------------------------------------- //
 public function update(){
  try{
   $mname="update(db.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //条件確認
   if(! $this->updatecol) throw new Exception("データを選択してください");
   if(! $this->from     ) throw new Exception("テーブルを選択してください");
   if(! $this->where    ) throw new Exception("where句がありません");

   //一旦退避
   $from=$this->from;
   $where=$this->where;

   //既存データチェック
   $this->select="*";
   $this->group =null;
   $this->order =null;
   $this->getArray();    //$this->aryに既存データが入る

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
      $val=str_replace("__BR__","\n",$val);
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
      $val=str_replace("__BR__","\n",$val);
      $this->sql.=$key."=".$this->pdo->quote($val);
      $i++;
     }
     //データ更新日時をセット
     $this->sql.=",".CDATE."='".date("Y-m-d H:i:s")."'";
     $this->sql.=" where ".$this->where;
    }//else

    //DB更新
    $c="notice:".$mname.$this->sql;wLog($c);
    $resultrow=$this->pdo->exec($this->sql);
    $c="notice:".$mname."更新行数(".$resultrow.")";wLog($c);

    //SQLリセット
    $this->SQLRESET();
    $this->ary=null;

    //正常終了(処理件数を返す)
    $c="end:".$mname;wLog($c);
    return $resultrow;
   }//try
   catch(PDOException $e){
    $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
   }//catch
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }//public function update(){


 // -------------------------------------------- //
 // DELTE系SQLをセット。消去した行数を返す
 // -------------------------------------------- //
 public function delete(){
  try{
   $mname="delete(db.class.php) ";
   $c="start:".$mname;wLog($c);
   //条件確認
   if(! $this->from ) throw new Exception("テーブルを確認してください");
   if(! $this->where) throw new Exception("条件を確認してください");
    
   try{
    //SQLセット
    $this->sql="";
    $this->sql ="delete from ".$this->from." where ".$this->where;
 
    //DB更新
    $c="notice:".$mname.$this->sql;wLog($c);
    $resultrow=$this->pdo->exec($this->sql);
    $c="notice:".$mname."削除行数(".$resultrow.")";wLog($c);

    //SQLリセット
    $this->SQLRESET();

    //正常終了
    $c="end:".$mname;wLog($c);
    return $resultrow;
   }//try
   catch(PDOException $e){
    $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
   }//catch
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }//catch
 }//public function delete(){
 
 // -------------------------------------------- //
 // 説明:テーブル作成
 // -------------------------------------------- //
 public function CreateTable($t=null){
  try{
   $mname="CreateTable(db.class.php) ";
   $c="start:".$mname;wLog($c);
   //if(! DEBUG) throw new exception("現在のモードでは使用できません");

   //nullの場合はすべてのテーブルを作成
   if(! $t) $table=$GLOBALS["TABLES"]; 
   else     $table[$t]=$GLOBALS["TABLES"][$t];
   
   //データ存在確認
   if(!isset($table)||!is_array($table)||!count($table)) throw new exception("テーブルデータがありません");
   
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
     if(! $i) $this->sql.=IDSQL; 
     
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
    $c="notice:".$mname.$this->sql;wLog($c);
    $this->pdo->exec($this->sql);
    echo $t."を作成しました\n";//PDOがエラーを返さない

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
     $c="notice:".$mname.$this->sql;wLog($c);
     $this->pdo->exec($this->sql);
     echo $t."のインデックスを作成しました\n";
    }//if
   }//foreach $table
   $c="end:".$mname;wLog($c);
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }//catch
 }//public function CreateTable($t=null){

 public function BeginTran(){
  $mname="BeginTran(db.class.php) ";
  $c="start:".$mname;wLog($c);
  $this->pdo->beginTransaction();
 }//beginTran

 public function Commit(){
  $mname="Commit(db.class.php) ";
  $c="start:".$mname;wLog($c);
  $this->pdo->commit();
 }//commit

 public function RollBack(){
  $mname="RollBack(db.class.php) ";
  $c="start:".$mname;wLog($c);
  $this->pdo->rollBack();
 }//rollback
 
 // -------------------------------------------- //
 // 説明:SQL実行(削除予定)
 // -------------------------------------------- //
 public function __QUERY($sql=null){
  try{
   $mname="__QUERY(db.class.php) ";
   $c="start:".$mname;wLog($c);
   //SQLセット
   if($sql) $this->sql=$sql;
   if(! $this->sql) throw new exception("SQLがセットされていません");
   if(! DEBUG) throw new exception("現在のモードでは使用できません");
   try{
    //SQL実行
    $c="notice:".$mname.$this->sql;wLog($c);
    $this->pdo->exec($this->sql);

    //SQLリセット
    $this->SQLRESET();

    //正常終了
    $c="end:".$mname;wLog($c);
   }
   catch(PDOException $e){
    $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
   }//catch
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);echo $c;
  }
 }//public function __QUERY(){

 // -------------------------------------------- //
 //ここまで（削除予定)
 // -------------------------------------------- //

 public function updatearray($data){
  try{
   $mname="updatearray(db.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //データ存在確認
   if(!isset($data)||!is_array($data)||!count($data)) throw new exception("SQLがありません");
   
   //データを更新と挿入に分類
   foreach($data as $key=>$ary){

    if(!isset($ary["col"])||!is_array($ary["col"])||!count($ary["col"])){
     throw new exception("Update句がありません");
    }

    if(!$ary["from"]){
     throw new exception("From句がありません");
    }

    if(!isset($ary["where"])||!is_array($ary["where"])||!count($ary["where"])){
     throw new exception("Where句がありません");
    }
     
    //SQLリセット
    $this->SQLRESET();

    //UPDATE句をセット
    $this->updatecol=$ary["col"];
    
    //FROM句をセット
    $this->from=$ary["from"];

    //WHERE句をセット
    foreach($ary["where"] as $fld=>$val){
     //WHERE句をセット
     if($this->where) $this->where.=" and ";
     $this->where.=$fld."='".$val."'";
    }// foreach($ary["where"] as $fld=>$val){

    $this->update();
   }//foreach
   $c="end:".$mname;wLog($c);
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);
   echo $c;wLog($c);
  }
 }//public function 

 public function deletearray($data){
  try{
   $mname="deletearray(db.class.php) ";
   $c="start:".$mname;wLog($c);
   
   //データ存在確認
   if(!isset($data)||!is_array($data)||!count($data)) throw new exception("SQLがありません");
   
   //データを更新と挿入に分類
   foreach($data as $key=>$ary){

    if(!$ary["from"]){
     throw new exception("From句がありません");
    }

    if(!isset($ary["where"])||!is_array($ary["where"])||!count($ary["where"])){
     throw new exception("Where句がありません");
    }
     
    //SQLリセット
    $this->SQLRESET();

    //FROM句をセット
    $this->from=$ary["from"];

    //WHERE句をセット
    foreach($ary["where"] as $fld=>$val){
     //WHERE句をセット
     if($this->where) $this->where.=" and ";
     $this->where.=$fld."='".$val."'";
    }// foreach($ary["where"] as $fld=>$val){

    $this->delete();
   }//foreach
   $c="end:".$mname;wLog($c);
  }//try
  catch(Exception $e){
   $c="error:".$mname.$e->getMessage();wLog($c);
   echo $c;wLog($c);
  }
 }//public function 

} //class DB
?>
