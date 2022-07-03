<?php
require_once('config.php');
require_once('function.php');
hijack();

// ymdの存在・形式チェック　パラメータが空 or 無効な文字列でないか
if (!isset($_GET['ymd']) || strtotime($_GET['ymd']) === false) {

  header('Location:index.php');
  exit();
}

$ymd = $_GET['ymd'];

$ymd_formatted = date('Y年n月j日', strtotime($ymd));
$title = $ymd_formatted . 'の予定 | ' ;

$name = $_SESSION['member_name'];

$dbh = DBconect();

//ログイン者のコードを抽出
$stmt2 = $dbh->prepare("SELECT code FROM member WHERE name = :name");
$stmt2->bindValue(':name',$name,PDO::PARAM_STR);
$stmt2->execute();
$result = $stmt2;
foreach($result as $val){}
$usercode = $val['code'];

$rows = getSchedulesByDate($dbh, $ymd,$usercode);
?>

<!DOCTYPE html>
<html lang="ja" class="h-100">
<head>
    <?php require_once('elements/head.php'); ?>
</head>
<body class="d-flex flex-column h-100">

    <?php require_once('elements/navbar.php'); ?>

<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">

                <!--日付の見出し-->
                <h4 class="text-center"><?= $ymd_formatted; ?></h4>
               
                <!--予定があるか-->
                <?php if (!empty($rows)):?>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 3%;"></th>
                                <th style="width: 25%;"><i class="far fa-clock"></i></th>
                                <th style="width: 50%;"><i class="fas fa-list"></i></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <!--追加されている予定の各要素を受け取り、各要素を変数に格納していく-->
                            <?php foreach ($rows as $row): ?>
                                <?php
                                    $color = str_replace('bg', 'text', $row['color']);
                                    $start = date('H:i', strtotime($row['start_datetime']));

                                    $start_date = date('Y-m-d', strtotime($row['start_datetime']));
                                    $end_date = date('Y-m-d', strtotime($row['end_datetime']));

                                    //予定の開始と終了が一緒なら終了の表示を○時○分に、違ければ月日を付け加える
                                    if ($start_date == $end_date) {
                                        $end = date('H:i', strtotime($row['end_datetime']));
                                    } else {
                                        $end = date('n/j H:i', strtotime($row['end_datetime']));
                                    }
                                ?>
                                
                                <!--変数を表示させていく-->
                                <tr>
                                    <td><i class="fas fa-square <?= $color; ?>"></i></td>
                                    <td><?= $start; ?> ~ <?= $end; ?></td>
                                    <td><?= $row['task']; ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= $row['schedule_id']; ?>" class="btn btn-sm btn-link">編集</a>
                                        <a href="javascript:void(0);"
                                         onclick="var ok=confirm('この予定を削除してもよろしいですか？'); if(ok) location.href='delete.php?id=<?= $row['schedule_id']; ?>'" 
                                         class="btn btn-sm btn-link">削除</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                <!--予定がない場合-->
                <?php else: ?>
                    <div class="alert alert-dark" role="alert">
                        予定がありません。予定の追加は<a href="add.php" class="alert-link">こちら</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</main>

<?php require_once('elements/footer.php'); ?>
</body>
</html>