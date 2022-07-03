<?php
 
    require_once('function.php');

 
    $member_name=$_POST['name'];
    $member_pass=$_POST['pass'];

    $member_name=htmlspecialchars($member_name,ENT_QUOTES,'UTF-8');
    $member_pass=htmlspecialchars($member_pass,ENT_QUOTES,'UTF-8');

    //パスワードをハッシュ化
    $member_pass= md5($member_pass);

    $dbh = DBconect();
    
    //データベースにアカウントが登録されている名前とパスワードを取り出す
    $sql = 'SELECT name FROM member WHERE name=? AND password=? ';
    $stmt = $dbh->prepare($sql);
    $data[]=$member_name;
    $data[]=$member_pass;
    $stmt->execute($data);

    $dbh=null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    //入力された名前とパスワードが正しいか
    if($rec===false){
        print '名前かパスワードが間違っています。<br/>';
        print '<a href="member_login.php">戻る</a>';
    }
    //正しければログインの許可
    else{
        session_start();
        $_SESSION['login'] = 1;
        $_SESSION['member_name'] = $member_name;
        
        header("Location:top.php");
        exit();
    }
 
 
?>