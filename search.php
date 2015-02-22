<?php
require_once("php/html.function.php");

//引数チェック

//タイトル確定
$title="";
if($_GET["station"]){
 $title="駅名で検索";
}
elseif($_GET["address"]){
 $title="住所で検索";
}
elseif($_GET["madori"]){
 $title="間取りで検索";
}
elseif($_GET["sale"]){
 $title="売買で検索";
}
else{
 $title="条件を指定して検索";
}
//ヘッダー表示
htmlHeader($title);
?>

  <div id="main">
<?php
if($_GET["station"]){
 //駅名で検索(賃貸)
 $data=viewRentStation();
 htmlStationList($data,"賃貸");

 //駅名で検索(売買)
 $data=viewSaleStation();
 htmlStationList($data,"売買");
}

if($_GET["address"]){
 //住所で検索(賃貸)
 $data=viewRentAddress();
 htmlAddressList($data,"賃貸");

 //住所で検索(売買)
 $data=viewSaleAddress();
 htmlAddressList($data,"売買");
}

if($_GET["madori"]){
 //間取りで検索(賃貸マンション)
 $data=viewRentMadoriM();
 htmlMadoriList($data,"賃貸マンション");
 
 //間取りで検索(賃貸アパート)
 $data=viewRentMadoriA();
 htmlMadoriList($data,"賃貸アパート");
 
 //間取りで検索(売買)
 $data=viewSaleMadori();
 htmlMadoriList($data,"売買");

}

if($_GET["sale"]){
 //駅名で検索(売買)
 $data=viewSaleStation();
 htmlStationList($data,"売買");
 
 //住所で検索(売買)
 $data=viewSaleAddress();
 htmlAddressList($data,"売買");
 
 //間取りで検索(売買)
 $data=viewSaleMadori();
 htmlMadoriList($data,"売買");
}

if(!$_GET){
 //駅名で検索(賃貸)
 $data=viewRentStation();
 htmlStationList($data,"賃貸");

 //住所で検索(賃貸)
 $data=viewRentAddress();
 htmlAddressList($data,"賃貸");

 //間取りで検索(賃貸マンション)
 $data=viewRentMadoriM();
 htmlMadoriList($data,"賃貸マンション");
 
 //間取りで検索(賃貸アパート)
 $data=viewRentMadoriA();
 htmlMadoriList($data,"賃貸アパート");

 //駅名で検索(売買)
 $data=viewSaleStation();
 htmlStationList($data,"売買");
 
 //住所で検索(売買)
 $data=viewSaleAddress();
 htmlAddressList($data,"売買");
 
 //間取りで検索(売買)
 $data=viewSaleMadori();
 htmlMadoriList($data,"売買");
}

?>
  </div><!--div id="main"-->
  <div id="footer">
<?php
htmlFooter()
?>
   </div><!-- div id="footer" -->
  </div><!-- div id="wrap" -->
 </body>
 <script></script>
</html>
