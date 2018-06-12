<?php  
    
    require("dbconnect.php");

    $sql = "SELECT `u`.`name`,`u`.`graduation_date`,`f`.`user_id`,`f`.`picture`,`f`.`created` FROM `users` `u` LEFT JOIN (SELECT `f`.`user_id`,`f`.`picture`,`f`.`created` FROM `feeds` `f` GROUP BY `f`.`user_id` ORDER BY `created`) AS `f` ON `u`.`id` = `f`.`user_id` WHERE `graduation_date` > CURRENT_DATE()";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }
      $cur_students[] = $rec;
    }
    echo "<pre>";
    var_dump($cur_students);
    echo "</pre>";

    // ページネーション処理
    $page = ''; //ページ番号が入る変数
    $page_row_number = 16; //1ページあたりに表示するデータの数

    if (isset($_GET['page'])){
      $page = $_GET['page'];
    }else{
      //get送信されてるページ数がない場合、1ページめとみなす
      $page = 1;
    }

    if ($page < 0) {
        $page = 1;
    }

    // max:カンマ区切りで羅列された数字の中から最大の数を返す
    $page = max($page,1);

    // データの件数から、最大ページ数を計算する
    $sql_count = "SELECT COUNT(*) AS `cnt` FROM `feeds`";

    //SQL実行
    $stmt_count = $dbh->prepare($sql_count);
    $stmt_count->execute();
    $record_cnt = $stmt_count->fetch(PDO::FETCH_ASSOC);

    //ページ数計算
    // ceil 小数点の切り上げができる関数 2.1 -> 3に変換できる
    $all_page_number = ceil($record_cnt['cnt'] / $page_row_number);
    

    // min:カンマ区切りの数字の中から最小の数値を取得する関数
    $page = min($page,$all_page_number);

    // データを取得する開始番号を計算
    $start = ($page -1)*$page_row_number;
    // ページネーション処理終了

?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<!--     <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
 -->
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/alumnus.css">
    <link rel="stylesheet" type="text/css" href="assets/css/private.css"> 
    <link rel="stylesheet" type="text/css" href="assets/css/page.css">

    <title>在校生の日々</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
       <?php include("navbar.php"); ?>
        <div class="col-md-2"></div>

        <div class="col-md-10 main-content">
          <div class="row">
            <h1 class="h1 hibi_title" style="text-align: center;">卒業生の日々をのぞいてみよう</h1>
          </div>
          <div class="row">
            <div class="col-md-3">
              <img src="assets/img/LRG_DSC05296.jpg" class="hibi_pic">
              <p>天野たいち</p>
            </div>
            <div class="col-md-3">
              <img src="assets/img/LRG_DSC05227.jpg" class="hibi_pic">
              <p>井出よしたか</p>
            </div>
            <div class="col-md-3">
              <img src="assets/img/LRG_DSC05046.jpg" class="hibi_pic">
              <p>カルディーノ・リサ</p>
            </div>
            <div class="col-md-3">
              <img src="assets/img/LRG_DSC05296.jpg" class="hibi_pic">
              <p>タデラ・タクト</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05296.jpg" class="hibi_pic">
                  <p>天野リサち</p>
                </div>
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05227.jpg" class="hibi_pic">
                  <p>石田スミレ</p>
                </div>
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05046.jpg" class="hibi_pic">
                  <p>池田池ちゃん</p>
                </div>
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05296.jpg" class="hibi_pic">
                  <p>山田仁</p>
                </div>
          </div>
          <div class="row">
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05296.jpg" class="hibi_pic">
                  <p>天野リサち</p>
                </div>
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05227.jpg" class="hibi_pic">
                  <p>石田スミレ</p>
                </div>
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05046.jpg" class="hibi_pic">
                  <p>池田池ちゃん</p>
                </div>
            <div class="col-md-3">
                  <img src="assets/img/LRG_DSC05296.jpg" class="hibi_pic">
                  <p>山田仁</p>
                </div>
          </div>
          

          <div aria-label="Page navigation">
            <ul class="pager">
              <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> 前の日々</a></li>
              <li class="next disabled"><a href="#"><span aria-hidden="true">&rarr;</span>次の日々</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>