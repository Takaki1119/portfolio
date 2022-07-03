<?php

//データベースへ接続
function DBconect(){

    try{

        $dbn = 'mysql:dbname=management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';

        $dbh = new PDO($dbn,$user,$password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }
    catch(Exception $e){
        
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit($e->getMessage());

    }
}


//そのログイン者のユーザーコードと一致する予定を取り出す
function getSchedulesByDate($dbh,$date,$usercode){

   

    $sql = 'SELECT * FROM schedule WHERE CAST(start_datetime AS DATE) = :start_datetime AND usercode = :usercode  ORDER BY start_datetime ASC';
    $stmt = $dbh -> prepare($sql);
    $stmt -> bindValue(':start_datetime',$date,PDO::PARAM_STR);
    $stmt -> bindValue(':usercode',$usercode,PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();

}

//エスケープ処理
function  h($string){
    return htmlspecialchars($string,ENT_QUOTES);
}

//セッションハイジャック対策
function hijack(){
session_start();
session_regenerate_id(true); 
if(isset($_SESSION['login'])==false){
    print 'ログインされていません。<br/>';
    print'<a href="../portfolio/member_login.php">ログイン画面へ</a>';
    exit();
}
else{
    
    print $_SESSION['member_name'];
    print 'さんログイン中<br/>';
    print '<br/>';
}
}
?>