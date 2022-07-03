
<!--navbar-expand-md ブレイクポイント768px-->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

        <div class="container-fluid">
            <!--トップ画面遷移-->
            <a class="navbar-brand" href="top.php">スケジュール</a>

            <!--メニュー展開-->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--追加-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="add.php"><i class="fa fa-plus"></i> 追加</a>
                    </li>
                    
                </ul>
                
                <!--日付検索-->
                <form class="d-flex" action="top.php">
                     <!--id=ymPickerに対しDatetimepckerをセットする-->
                    <input type="text" name="ym" class="form-control me-2" placeholder="年月を選択" id="ymPicker">
                    <button class="btn btn-outline-light text-nowrap" type="submit">表示</button>
                </form>
            </div>
        </div>
    </nav>