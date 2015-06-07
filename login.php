<?php 
require_once("php/html.function.php");
session_start();
$msg="ユーザー名、パスワードを入力してください";
if(isset($_POST["login"])){
 if($_POST["userid"]===USERID && $_POST["password"]===PASSWORD){
  $_SESSION["USERID"]=md5($_POST["userid"]);
  $msg="";
  if($_POST["nextpage"] && ! LOCALMODE){
   header("Location:".$_POST["nextpage"]);
  }
  else{
   header("Location:menu.php");
  }
 }
 else{
  session_destroy();
  $msg="ユーザー名、パスワードが違います";
 }
}

if(isset($_POST["logout"])){
 $_SESSION=array();
 if(ini_get("session.use_cookies")){
  $params=session_get_cookie_params();
  setcookie(session_name(),time(),-42000,$params["path"],$params["domain"],
            $params["secure"],$params["httponly"]);
  session_destroy();
  $msg="ログアウトしました。";
 }
}
htmlHeader("ログイン");
?>
   <div id="contentsWrap">
    <div id="contentsMiddle">
     <div id="contents">
      <div id="article">
       <div><?php echo $msg; ?></div>
       <form id="loginForm" name="loginForm" action="login.php" method="POST">
        <ul>
         <li><label for="userid">  ユーザー名<input id="userid" name="userid" type="text"></li>
         <li><label for="password">パスワード<input id="password" name="password" type="password"></li>
         <li><input type="submit" id="login"  name="login"  value="ログイン">
             <input type="submit" id="logout" name="logout" value="ログアウト"></li>
             <li><input id="nextpage" name="nextpage" type="hidden" value="<?php echo $_GET["nextpage"]; ?>"></li>
        </ul>
       </form>
      </div><!--div id="article"-->
     </div><!--div id="contents"-->
    </div><!--div id="contentsMiddle"-->
   </div><!--div id="contentsWrap"-->

   <div id="footer">
<?php
//htmlFooter()
?>
   </div><!-- div id="footer" -->
   
  </div><!-- div id="wrap" -->
 </body>
 <script>
$(function(){
 navi();
});
 </script>
</html>
