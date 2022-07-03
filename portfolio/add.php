<!DOCTYPE html>
<html lang="ja" class="h-100">
    <?php $title='予定の追加';
        require_once('config.php');
        require_once('function.php');
        hijack();


        $err = [];
        $start_datetime = '';
        $end_datetime = '';
        $task = '';
        $color = '';
        $name = $_SESSION['member_name'];
        
        
        
        
        //受け取ったデータがPOSTであるならその各要素を変数に格納していく
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
           
            $start_datetime = $_POST['start_datetime'];
            $end_datetime = $_POST['end_datetime'];
            $task = $_POST['task'];
            $color = $_POST['color'];
            
           
            //入力された各要素に不備がないか
            if($start_datetime == ''){
                $err['start_datetime'] = '開始日時を入力してください。';
            }
            if($end_datetime == ''){
                $err['end_datetime'] = '終了日時を入力してください。';
            }
            if($task == ''){
                $err['task'] = '予定を入力してください。';
            }else if(mb_strlen($task,'UTF-8')>128){
                $err['task'] = '文字数制限を超えています。';
            }
            if($color == ''){
                $err['color'] = 'カラーを選択してください。';
            }

            
            
        
        //不備がなければ実行
        if(empty($err)){
   

        $dbh = DBconect();
        
        //ログイン者のコードを抽出
        $stmt2 = $dbh->prepare("SELECT code FROM member WHERE name = :name");
        $stmt2->bindValue(':name',$name,PDO::PARAM_STR);
        $stmt2->execute();
        $result = $stmt2;
        foreach($result as $val){}
        $usercode = $val['code'];
        
        //追加する予定の各要素をデータベースに登録する
        $sql = 'INSERT INTO schedule(start_datetime, end_datetime, task, color, create_at, modified_at,usercode)
        VALUES(:start_datetime, :end_datetime, :task, :color, now(), now(),:usercode)';
        
        $stmt = $dbh->prepare($sql);


        $stmt->bindValue(':start_datetime',$start_datetime,PDO::PARAM_STR);
        $stmt->bindValue(':end_datetime',$end_datetime,PDO::PARAM_STR);
        $stmt->bindValue(':task',$task,PDO::PARAM_STR);
        $stmt->bindValue(':color',$color,PDO::PARAM_STR);
        $stmt->bindValue(':usercode',$usercode,PDO::PARAM_STR);
        
        

        $stmt->execute();
        
        //開始時刻をY-m-dの形式に変換して詳細画面に飛ぶ
        header('Location:detail.php?ymd='.date('Y-m-d',strtotime($start_datetime)));
        exit();
         }
        }

    ?>
<head>
<?php require_once('elements/head.php');?>
</head>
<body class="d-flex flex-column h-100">
<header>
<?php require_once('elements/navbar.php');?>
</header>


<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h4 class="text-center">予定の追加</h4>

            <form method="post">
                
                <!--開始日時のテキストボックス-->
                <div class="mb-4 dp-parent">
                  <label for="inputStartDateTime" class="form-label">開始日時</label>
                 <input type="text" name="start_datetime" id="inputStartDateTime" 
                   class="form-control task-datetime <?php if (!empty($err['start_datetime'])) echo 'is-invalid'; ?>" 
                   placeholder="開始日時を選択して下さい。" value="<?= h($start_datetime);?>">
                 <?php if (!empty($err['start_datetime'])): ?>
                   <div id="inputStartDateTimeFeedback" class="invalid-feedback">
                    * <?= $err['start_datetime']; ?>
                   </div>
                 <?php endif; ?>
                </div>
    
                <!--終了日時のテキストボックス-->
                <div class="mb-4 dp-parent">
                   <label for="inputEndDateTime" class="form-label">終了日時</label>
                   <input type="text" name="end_datetime" id="inputEndDateTime" 
                      class="form-control task-datetime <?php if (!empty($err['end_datetime'])) echo 'is-invalid'; ?>" 
                      placeholder="終了日時を選択して下さい。" value="<?= h($end_datetime); ?>">
                   <?php if (!empty($err['end_datetime'])): ?>
                    <div id="inputEndDateTimeFeedback" class="invalid-feedback">
                       * <?= $err['end_datetime']; ?>
                    </div>
                   <?php endif; ?>
                </div>
    
                <!--予定のテキストボックス-->
                <div class="mb-4">
                    <label for="inputTask" class="form-label">予定</label>
                    <input type="text" name="task" id="inputTask" class="form-control <?php if (!empty($err['task'])) echo 'is-invalid'; ?>" placeholder="予定を入力して下さい。" value="<?= h($task); ?>">
                    <?php if (!empty($err['task'])): ?>
                     <div id="inputTaskFeedback" class="invalid-feedback">
                       * <?= $err['task']; ?>
                    </div>
                    <?php endif; ?>
                </div>
    
                <!--カラー設定-->
                <div class="mb-5">
                    <label for="selectColor" class="form-label">カラー</label>
                    <select name="color" id="selectColor" class="form-select bg-light">
                       <option value="bg-light" selected>デフォルト</option>
                       <option value="bg-danger">赤</option>
                       <option value="bg-warning">オレンジ</option>
                       <option value="bg-primary">青</option>
                       <option value="bg-info">水色</option>                            <option value="bg-success">緑</option>
                       <option value="bg-dark">黒</option>
                       <option value="bg-secondary">グレー</option>
                    </select>
                        <?php if (!empty($err['color'])): ?>
                          <div id="selectColorFeedback" class="invalid-feedback">
                            * <?= $err['color']; ?>
                          </div>
                        <?php endif; ?>
                </div>
                    
                <!--登録ボタン-->
                 <div class="d-grid">
                        <button type="submit" class="btn btn-primary">登録</button>
                 </div>

             </form>

            </div>
        </div>
    </div>
</main>

<?php require_once('elements/footer.php');?>

</body>
</html>