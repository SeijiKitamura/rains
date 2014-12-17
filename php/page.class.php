<?php
require_once("config.php");
require_once("db.class.php");
require_once("html.class.php");

class PAGE extends DB{
 public $pagename;
 public $items;
 
 function __construct(){
  parent::__construct();
  $this->from=TB_PAGECONF;
 }//__construct

//-------------------------------------------------------//
// グループごとのページ詳細を返す                        //
//-------------------------------------------------------//
 public function getGroup($flg0){
  $this->items=null;
  //attrをゲット
  $this->select ="attr";
  $this->from =TB_PAGECONF;
  $this->group =$this->select;
  $this->getArray();
  $attr=$this->ary;

  $this->items=null;
  $this->select =" t.pagename";
  foreach($attr as $rowcnt =>$rowdata){
   $this->select.=",max(case when t.attr='".$rowdata["attr"]."' then t.val else '' end ) as `".$rowdata["attr"]."`";
  }//foreach
  $this->from =TB_PAGECONF." as t ";
  $this->from.="inner join (";
  $this->from.=" select pagename,val from ".TB_PAGECONF;
  $this->from.=" where attr='flg0' and val='".$flg0."'";
  $this->from.=" group by pagename,val) as t1 on";
  $this->from.=" t.pagename=t1.pagename";
  $this->group=" t.pagename";
  $this->order=" case when t.attr='flg1' then t.val else 999999 end";
  $this->getArray();
  $this->items=$this->ary;
 }// public function getGroup($flg0){

//-------------------------------------------------------//
// 単一のページ詳細を返す                                //
//-------------------------------------------------------//
 public function getPage($page){
  $this->items=null;
  //attrをゲット
  $this->select ="attr";
  $this->from =TB_PAGECONF;
  $this->group =$this->select;
  $this->getArray();
  $attr=$this->ary;

  $this->items=null;
  $this->select =" t.pagename";
  foreach($attr as $rowcnt =>$rowdata){
   $this->select.=",max(case when t.attr='".$rowdata["attr"]."' then t.val else '' end ) as `".$rowdata["attr"]."`";
  }//foreach
  $this->from =TB_PAGECONF." as t ";
  $this->where=" t.pagename='".$page."'";
  $this->group=" t.pagename";
  $this->order=" case when t.attr='flg1' then t.val else 999999 end";
  $this->getArray();
  $this->items=$this->ary;
 }// public function getPage($page){
}//class page
?>
