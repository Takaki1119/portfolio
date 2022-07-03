<?php
require_once('config.php');
require_once('function.php');


$title = 'スケジュール';

// 前月・次月リンクが押された場合は、その年月を取得する
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // そうでなければ今月の年月を表示
    $ym = date('Y-m');
}

// １日のタイムスタンプを作成
$timestamp = strtotime($ym . '-01');

//フォーマットが正しくなければ、今月のカレンダーを表示するための変数を作成
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か 1:月 2:火 ... 7:日
$youbi = date('N', $timestamp);

// カレンダーのタイトルを作成　2022年6月といったフォーマットで
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

// 今日の日付を2022-06-01といったフォーマットで作成
$today = date('Y-m-d');

// カレンダーのセルで使用する配列と変数
$weeks = [];
$week = '';

// 初週の曜日から空セルを追加する
// 例）１日が木曜日だった場合、月曜日から水曜日の３つ分の空セルを追加する
$week .= str_repeat('<td></td>', $youbi-1);

$name = $_SESSION['member_name'];



$dbh = DBconect();

//ログイン者のコードを取得
$stmt2 = $dbh->prepare("SELECT code FROM member WHERE name = :name");
$stmt2->bindValue(':name',$name,PDO::PARAM_STR);
$stmt2->execute();
$result = $stmt2;
foreach($result as $val){}
$usercode = $val['code'];

// 1日からその該当月の日数まで日にちと曜日を追加する
for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

    //2022-6-1といったフォーマットで作成
    $date = $ym . '-' . sprintf('%02d', $day);

    // 予定を取得
    $rows = getSchedulesByDate($dbh,$date,$usercode);

    
    // スタートが今日か判定し、そうであれば色をつける
    if ($date == $today) {
        $week .= '<td class="today">';
    } else {
        $week .= '<td>';
    }
    
    //日にちをクリックしてその日にちの詳細ページへ飛べるように設定
    $week .= '<a href="detail.php?ymd=' . $date . '">' . $day;

    //予定が入っているかを調べ、あればその予定を追加する
    if (!empty($rows)) {
        $week .= '<div class="badges">';
            foreach ($rows as $row) {
                //予定の開始時刻と名前を取得
                $task = date('H:i', strtotime($row['start_datetime'])) . ' ' . h($row['task']);
                $week .= '<span class="badge text-wrap ' . $row['color'] . '">' . $task . '</span>';
            }
        $week .= '</div>';
        
        
    }

    $week .= '</a></td>';

    // 日曜日、または、最終日かを判定
    if ($youbi % 7 == 0 || $day == $day_count) {

        //最終日が日曜日ではないの場合、日曜日まで空セルを追加する
        if ($day == $day_count && $youbi % 7 != 0) {
           
            $week .= str_repeat('<td></td>', 7 - $youbi % 7);
        }

       //その１週間分の情報を配列に格納する
        $weeks[] = '<tr>' . $week . '</tr>';

        // weekをリセット
        $week = '';
    }
    

}


?>
<!DOCTYPE html>
<html lang="ja" class="h-100">
<head>
    <?php require_once('elements/head.php'); ?>
</head>
<body class="d-flex flex-column h-100">

    <?php require_once('elements/navbar.php'); 
     print '<br/>';
     print $_SESSION['member_name'].'さんログイン中<br/>';
     print '<br/>';
    ?>

<main>
    <div class="container">
        <table class="table table-bordered calendar">
            <thead>
                <tr class="head-cal fs-4">
                    <!--前月リンク-->
                    <th colspan="1" class="text-start"><a href="top.php?ym=<?= $prev; ?>">&lt;</a></th>
                    <!--今月表示-->
                    <th colspan="5"><?= $html_title; ?></th>
                    <!--次月リンク-->
                    <th colspan="1" class="text-end"><a href="top.php?ym=<?= $next; ?>">&gt;</a></th>
                </tr>
                <tr class="head-week">
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th>土</th>
                    <th>日</th>
                </tr>
            </thead>
            <tbody>
                <!--日付を展開する-->
                <?php foreach ($weeks as $week) { echo $week; } ?>
                 
            </tbody>
        </table>
    </div>
</main>
<a href = "member_logout.php" class="button">ログアウト</a>
<?php require_once('elements/footer.php'); ?>
</body>
</html>