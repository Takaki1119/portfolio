<?php

//ログアウト操作
session_start();

//セッション変数を空にする
$_SESSION = array(); 

//パソコン側のセッションIDをクッキーから削除する
if(isset($_COOKIE[session_name()])==true){

    setcookie(session_name(),'',time()-42000,'/'); //セッションIDをクッキーから削除する。
}
//セッションを破棄する
session_destroy(); 
?>

<DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>ポートフォリオ</title>
    </head>
<body>
   ログアウトしました。<br/>
   <br/>
   <a href = "../portfolio/member_login.php">ログイン画面へ</a>

</body>
</html>
