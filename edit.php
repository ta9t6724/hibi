<?php 
    session_start();

    require('dbconnect.php');
    require('function.php');

    // ログインチェック
    check_signin($_SESSION['id']);

    // サインインしているユーザーの情報を取得
    $signin_user = get_signin_user($dbh, $_SESSION['id']);

      // ページネーション
    $page = ''; //ページ番号が入る変数
    $page_row_number = 12; //1ページあたりに表示するデータの数

    if (isset($_GET['page'])){
      $page = $_GET['page'];
    }else{
      // GET送信されてるページ数がない場合、1ページ目とみなす
      $page = 1;
    }

    // max: カンマ区切りで羅列された数字の中から最大の数を返す
    // 第一引数に入っている値を見て、第二引数と比較。もし第二引数の方が大きければ第二引数の値を返す
    $page = max($page, 1);
    $errors = array();

    $count_sql = 'SELECT COUNT(*) AS `cnt` FROM `feeds` WHERE `user_id`=?';
    $count_data = array($signin_user['id']);
    $count_stmt = $dbh->prepare($count_sql);
    $count_stmt->execute($count_data);
    $feed_cnt = $count_stmt->fetch(PDO::FETCH_ASSOC);

    if ($feed_cnt['cnt'] <= 0) {
      $feed_cnt['cnt'] = 1;
      $errors['feed'] = 'blank';
    }

    // ceil: 切り上げ
    $max_page = ceil($feed_cnt['cnt'] / $page_row_number);


    // 第一引数と第二引数を比較し、第二引数の方が小さければ、第二引数の値を返す
    $page = min($page, $max_page);

    // データを取得する開始番号を計算
    $start = ($page -1)*$page_row_number;

    $sql = "SELECT * FROM `feeds` WHERE `user_id`= ? ORDER BY `created` DESC LIMIT $start, $page_row_number";
    $data = array($signin_user['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $feeds = array();

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }
      $feeds[] = $rec;
    }
 ?>

<!doctype html>
<html lang="ja">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> 
    <link rel="stylesheet" type="text/css" href="assets/css/alumnus.css">
    <link rel="stylesheet" type="text/css" href="assets/css/page.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
    <link href="assets/img/hibilogo.ico" rel="shortcut icon">



<title>編集画面</title>
</head>
<body>
<div class="container-fluid">
<div class="row">
  <?php include("navbar.php"); ?>


     <div class="col-md-2"></div>
     <div class="col-md-10 main-content">
     <div class="row">
     <div class="col-md-12 ">
     </div>
     </div>

          <div class="row concept">
          <div class="col-md-12">
          <h1 class="h1">編集画面</h1><br><br>
          </div>
          </div>
          

        <div class="row">
          <?php if(isset($errors['feed'])){ ?>
            <p>画像の投稿がありません</p>
          <?php }else{ ?>
            <?php foreach($feeds as $feed){ ?>
             <div class="col-md-4">
                <img src="assets/img/<?php echo $feed['picture'] ?>" class="hibi_pic">
                <a onclick="return confirm('削除してよろしいですか？')" href="delete.php?feed_id=<?php echo $feed["id"] ?>" class="btn btn-danger " style="margin: 10px 0px 10px 0px;">削除</a>
             </div>
            <?php } ?>
          <?php } ?>
        </div>
          <div aria-label="Page navigation">
           <ul class="pager">
              <?php if ($page == 1){ ?>
                 <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> 次へ</a></li>
             <?php }else{ ?>
                <li class="previous"><a href="edit.php?page=<?php echo $page - 1; ?>"><span aria-hidden="true">&larr;</span> 次へ</a></li>
             <?php } ?>
              <?php if ($page == $max_page){ ?>
                <li class="next disabled"><a href="#">前へ <span aria-hidden="true">&rarr;</span></a></li>
              <?php }else{ ?>
                <li class="next"><a href="edit.php?page=<?php echo $page + 1; ?>">前へ <span aria-hidden="true">&rarr;</span></a></li>
              <?php } ?>
            </ul>
          </div>
      </div>
     </div>
    <!-- footer -->
    <?php include("footer.php"); ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>