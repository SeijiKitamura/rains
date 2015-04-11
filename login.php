<?php 
require_once("php/html.function.php");
session_start();
$msg="ユーザー名、パスワードを入力してください";
if(isset($_POST["login"])){
 if($_POST["userid"]===USERID && $_POST["password"]===PASSWORD){
  $_SESSION["USERID"]=md5($_POST["userid"]);
  $msg="";
  header("Location:menu.php");
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
        <label for="userid">  ユーザー名<input id="userid" name="userid" type="text">
        <label for="password">パスワード<input id="password" name="password" type="password">
        <input type="submit" id="login"  name="login"  value="ログイン">
        <input type="submit" id="logout" name="logout" value="ログアウト">
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
</html>