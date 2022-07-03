<?php
require_once('config.php');
require_once('function.php');
hijack();

// 存在・形式チェック
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location:index.php');
    exit();
}


$dbh = DBconect();

//指定されたスケジュールIDと一致する予定を削除する
$sql = 'DELETE FROM schedule WHERE schedule_id = :schedule_id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':schedule_id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();

// 前の画面に移動
header('Location:' . $_SERVER['HTTP_REFERER']);
exit();
?>