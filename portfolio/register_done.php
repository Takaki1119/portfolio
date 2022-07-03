<DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>メンバー登録実行</title>
    </head>
<body>

<?php

 require_once('function.php');

 
    $member_name = $_POST['name'];
    $member_pass = $_POST['pass'];

    $member_name = htmlspecialchars($member_name,ENT_QUOTES,'UTF-8');
    $member_pass = htmlspecialchars($member_pass,ENT_QUOTES,'UTF-8');

    $dbh = DBconect();
    
    //名前とパスワードをデータベースへ登録
    $sql = 'INSERT INTO member(name,password) VALUE (?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $member_name;
    $data[] = $member_pass;
    $stmt -> execute($data);

    $dbh = null;

    print $member_name.'さんを追加しました。</br>';

 
?>

<a href="member_login.php">ログイン画面</a>

</body>
</html>
