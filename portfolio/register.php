<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>メンバー登録</title>
        <?php require_once('elements/head.php')?>

    </head>
    <body>
    <h1 class="bg-dark text-center text-white">メンバー登録<br/></h1>
    <br/>
        <br/>
        <form method="POST"  action="register_check.php">
            <div class="CenterFrame">
            名前を入力してください。<br/>
            <input type="text"  name="name"  style="width:200px"><br/>
            パスワードを入力してください。<br />
            <input type="password" name="pass" style="width:100px"><br/>
            パスワードをもう一度入力してください。<br/>
            <input type="password" name="pass2" style="width:100px"><br/>
            <br/>
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="登録">
            </div>
        </form>



    </body>
</html>
