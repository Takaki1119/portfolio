<DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
    <?php require_once('elements/head.php')?>
    </head>
    <body class="d-flex flex-column h-100">
<header>

</header>
<body>
    <h1 class="bg-dark text-center text-white">ログイン画面<br/></h1>
    <br/>
 <form method="post" action="member_login_check.php">
  <div class="CenterFrame">
    
    <p>名前<br/></p>  
    <input type="text"   name="name"><br/>
    <p>パスワード<br/></p>
    <input type="password" name="pass"><br/>
    <br/>
    <input type="submit" value="ログイン"><br/>
    <br/>
    <input type="button" onclick="location.href='../portfolio/register.php'" value="新規登録">

    </div>
 </form>

</body>
</html>
