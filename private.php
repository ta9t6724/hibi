<?php 

    session_start();

    require('dbconnect.php');
    require('function.php');

    // ログインチェック
    check_signin($_SESSION['id']);

    // サインインしているユーザーの情報を取得
    $signin_user = get_signin_user($dbh, $_SESSION['id']);

    // サインインしているユーザーの卒業日を取得する処理
    $thisday = date("Y-m-d");
    $target_day = $signin_user['graduation_date'];

    // お題の取得処理
    // 今日の日付の取得
    $day = date('j');
    // str型からint型へ変換
    $today = intval($day);
    // それぞれのお題の取得
    if (1 <= $today && $today <= 7) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 1';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 1;
    }elseif (8 <= $today && $today <= 14) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 2';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 2;
    }elseif (15 <= $today && $today <= 21) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 3';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 3;
    }elseif (22 <= $today && $today <= 28) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 4';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 4;
    }elseif (29 <= $today && $today <= 31) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 5';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 5;
    }
    // お題の取得処理終了

    // 卒業日と現在日の差分取得（リマインド用）
    $sql = "SELECT DATEDIFF(`graduation_date`,NOW()) AS `date_gap` FROM `users` WHERE `id`=?";
    $data = array($_SESSION["id"]);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $date_gap = $rec["date_gap"];

    // 日々のINSERT処理
    $photo = '';
    $comment = '';
    $category = '';
    $errors = array();

    if(!empty($_POST['hibi'])){
       if (!empty($_POST['input_comment']) && (isset($_FILES['input_image']['name']) && !empty($_FILES['input_image']['name']))) {
           $photo = $_FILES['input_image'];
           $comment = $_POST['input_comment'];
           $category = $_POST['category'];

           $input_theme_id = -1;
            if ($_POST['category'] != 4){
               $input_theme_id = 0;
            }else{
             $input_theme_id = $theme_id;
            }
               $file_name = ''; // ①
               if (!isset($_REQUEST['action'])) { // ②
               $file_name = $_FILES['input_image'];
               }
               // エラーがなかった時の処理
               if (empty($errors)) {

                   date_default_timezone_set('Asia/Manila');
                   $date_str = date('YmdHis'); // YmdHisを指定することで取得フォーマットを指定
                   $submit_file_name = $date_str . $file_name['name'];
                   move_uploaded_file($_FILES['input_image']['tmp_name'], 'assets/img/' . $submit_file_name);
               }
               $sql = 'INSERT INTO `feeds` SET `user_id`=?, `theme_id`= ?, `comment`=?, `picture`=?, `category`=?, `created`=NOW()';
               $data = array($signin_user['id'], $input_theme_id, $comment, $submit_file_name, $category);
               $stmt = $dbh->prepare($sql);
               $stmt->execute($data);

               // unset()で入れるの中身を削除する
               // unset()文は指定した変数もしくは配列を破棄することができる
               header('Location: private.php');
               exit();
       }else{
           $errors['failed'] = 'failed';
       }
    }
    // 日々のINSERT処理終了

    // poemのINSERT処理
    if (!empty($_POST['input_poem'])) {

      $poem = $_POST['input_poem'];

      if ($poem != ''){
        $poem_sql = 'INSERT INTO `poems` SET `user_id`=?, `content`=?, `created`=NOW()';
        $poem_data = array($signin_user['id'], $poem);
        $poem_stmt = $dbh->prepare($poem_sql);
        $poem_stmt->execute($poem_data);

        header('Location: private.php');

      }
    }else if(isset($_POST['input_poem']) && $_POST['input_poem'] == ''){
        // $_POST['input_comment'] = '';
        $errors['feed'] = 'blank';
    }
    // poemのINSERT処理終了


    // ページネーション
    $page = ''; //ページ番号が入る変数
    $page_row_number = 5; //1ページあたりに表示するデータの数

    if (isset($_GET['page'])){
      $page = $_GET['page'];
    }else{
      // GET送信されてるページ数がない場合、1ページ目とみなす
      $page = 1;
    }

    // max: カンマ区切りで羅列された数字の中から最大の数を返す
    // 第一引数に入っている値を見て、第二引数と比較。もし第二引数の方が大きければ第二引数の値を返す
    $page = max($page, 1);

    $count_sql = 'SELECT COUNT(*) AS `cnt` FROM `poems` WHERE `user_id`=?';
    $count_data = array($signin_user['id']);
    $count_stmt = $dbh->prepare($count_sql);
    $count_stmt->execute($count_data);
    $feed_cnt = $count_stmt->fetch(PDO::FETCH_ASSOC);

    if ($feed_cnt['cnt'] <= 0) {
      $feed_cnt['cnt'] = 1;
      $errors['poem'] = 'blank';
    }

    // ceil: 切り上げ
    $max_page = ceil($feed_cnt['cnt'] / $page_row_number);


    // 第一引数と第二引数を比較し、第二引数の方が小さければ、第二引数の値を返す
    $page = min($page, $max_page);

    // データを取得する開始番号を計算
    $start = ($page -1)*$page_row_number;

    // poemのSELECT処理
    $sql = "SELECT * FROM `poems` WHERE `user_id`=? ORDER BY `id` DESC LIMIT $start, $page_row_number";
    $data = array($signin_user['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // 表示用の配列を初期化
    $poems = array();

    // poemのfetch処理
    while (true) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC); 
        if ($record == false) {
            break;
        }
        $poems[] = $record;
    }
    // poemのfetch処理終了

 ?>

<!doctype html>
<html lang="ja">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/private.css"> 
    <link rel="stylesheet" type="text/css" href="assets/css/page.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
    <link href="assets/img/hibilogo.ico" rel="shortcut icon">



    <title>プライベートページ</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <?php include("navbar.php"); ?>
        <?php if ($date_gap == 1) {
            include("assets/remind/remind.php");
        } ?>
        <!-- ここを消してinclude -->
<!--         <div class="col-md-2 sidebar1">
          <div class="logo">
            <img src="assets/img/hibi3.png" class="hibilogo" alt="Logo">
          </div>
            <br>
          <div class="left-navigation">
            <ul class="list" style="margin-left: 10px;">
                <li><a href="viwe.php" class="btn btn-outline-dark list-group-item" style="margin-top: 15px;">はじめに</a></li>
                <li><a href="register/signin.php" class="btn btn-outline-dark list-group-item">サインイン</a></li>
                <li><a href="cur_student.php" class="btn btn-outline-dark list-group-item">在校生の日々</a></li>
                <li><a href="alumnus.php" class="btn btn-outline-dark list-group-item">卒業生の日々</a></li>
                <li><a href="theme.php" class="btn btn-outline-dark list-group-item">今週のお題</a></li>
                <li><a href="private.php" class="btn btn-outline-dark list-group-item">マイページ</a></li>
            </ul>
          </div>
        </div>  -->
        <!-- ここまでサイドバー
         -->
        <div class="col-md-2"></div>
        <div class="col-md-10 main-content">

          <!-- ここから卒業生のページ -->


    <?php if (strtotime($target_day) < strtotime($thisday)) { ?>
        <div>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 mypage">
              <div class="row">
                <div class="col-md-12">
                  <p class="graduation-name">🎉<?php echo $signin_user["name"]; ?>さん、卒業おめでとう🎉</p>
                  <p class="graduation-date">~<?php echo date('Y年n月j日', strtotime($target_day)); ?>~<!-- <span class="team-tyrk">by スイカと塩</span> --></p>
                  <!-- <p class="team-tyrk">by スイカと塩</p> -->
                  <p class="graduation-share">NexSeedでの「日々」を共有しよう</p>
                  <a href="http://twitter.com/share?url=http://album.php?user_id=<?php echo $signin_user["id"]; ?>" class="isometric">
                  <span class="iconback istw"><i class="fab fa-twitter"></i></span><span class="btnttl">TWEET</span>
                  </a>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=album.php?user_id=<?php echo $signin_user["id"]; ?>" class="isometric">
                  <span class="iconback isfb"><i class="fab fa-facebook-f"></i></span><span class="btnttl">SHARE</span>
                  </a>
                  <div>
                  <p class="graduation-yazi">↓↓↓↓↓↓↓↓↓↓</p>
                  <!-- <p>↓↓↓↓↓↓↓↓↓↓</p> -->
                  <a href="album.php?user_id=<?php echo $signin_user["id"]; ?>" class="square_btn5" style="margin-bottom: 20px;">卒業ページへ</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php }else{?>
          <!-- ここまで -->

          <!-- ここから在校生のページ -->
<!--           <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-10">
              <h1 class="hibi_titile" style="font-weight: bold;"><?php echo $signin_user["name"] ?>さんの日々を投稿しよう！</h1>
            </div>
            <div class="col-md-1">
            </div>
          </div> -->

          <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-10">
              <?php if ($date_gap == 1) { ?>
                <h1 class="hibi_titile"><?php echo $signin_user["name"] ?>さん、明日で卒業ですね<br>最後に<span style="font-weight: bold;">記念の１枚</span>を投稿しよう！</h1>
              <?php }else{ ?>
                <h1 class="hibi_titile" style="font-weight: bold;"><?php echo $signin_user["name"] ?>さんの日々を投稿しよう！</h1>
              <?php } ?>
            </div>
            <div class="col-md-1">
            </div>
          </div>

          <div class="row">
            <div class="col-md-1"></div>

            <div class="col-md-1"></div>
          </div>
          <div class="row" id="hibipic">
            <div class="col-md-1"></div>
            <div class="col-md-10 box3">
              <div class="row">
                <div class="col-md-4">
                  <p class="hibi_setumei">写真</p>
                <br>
              <form method="POST" action="" enctype="multipart/form-data">
               <div class="uploadButton">
                 <p>ファイルを選択</p>
                  <input type="file" name="input_image" accept="assets/img/*" onchange="uv.style.display='inline-block'; uv.value = this.value;" />
                  <input type="text" id="uv" class="uploadValue" disabled />
               </div>
                 </div>
                <div class="col-md-8">
                <p class="hibi_setumei">コメント</p>
                <!-- <textarea name="feed" class="hibi_text_upload form-control" rows="2" placeholder="投稿内容を入力する" style="font-size: 15px;"></textarea> -->
                <input type="text" name="input_comment" class="box1" rows="2">
                <!-- <textarea class="box1 hibi_text_upload" rows="2" placeholder="ここにテキストを入力してね" style="font-size: 15px;" > -->
                <!-- </textarea> -->
                  <div class="btn btn-group btn-group-toggle week_topic" data-toggle="buttons" style="margin-bottom: 20px;">
                      <label class="btn btn-secondary active topic_hide">
                            <input type="radio" name="category" id="category1" autocomplete="off" value="1" checked> 食
                      </label>
                      <label class="btn btn-secondary topic_hide">
                            <input type="radio" name="category" id="category2" autocomplete="off" value="2"> 道
                      </label>
                      <label class="btn btn-secondary topic_hide">
                            <input type="radio" name="category" id="category3" autocomplete="off" value=="3"> 人
                      </label>
                      <label class="btn btn-secondary topic_show">
                            <input type="radio" name="category" id="category4" autocomplete="off" value="4"> お題
                      </label>
                  </div>
                  <div class="week_topic" id='topic'>
                    <p style="font-weight:bold;">今週のテーマ：<?php echo $theme['title']; ?></p>
<!--                       <input type="radio" name="topic" value="1"> バナナ 
                      <input type="radio" name="topic" value="2"> 昼飯 
                      <input type="radio" name="topic" value="3"> ネクシード生 
                      <input type="radio" name="topic" value="4"> 鼻毛 
                      <input type="radio" name="topic" value="5"> 朝飯 --> 
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" class="square_btn" value="投稿する" name="hibi">
                  <?php if (!empty($errors["failed"])) { ?>
                    <p class="text-danger">投稿に失敗しました</p>
                  <?php } ?>
                </div>
              </div>
            </form>
              <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                <a href="my_page.php?user_id=<?php echo $signin_user["id"]; ?>.php"><p class="hibi_delate" style="margin-bottom: 10px;">マイページへいく<i class="fas fa-child"></i></p></a>
                </div>
              </div>
              <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                <a href="edit.php"><p class="hibi_delate">過去の投稿を削除する<i class="fas fa-eraser"></i></p></a>
                </div>
              </div>
            </div>
            <div class="col-md-1"></div>
          </div>


          <div class="row" id="hibipoem">
            <div class="col-md-1"></div>
            <div class="col-md-10 box3">
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8"><p class="hibi_setumei">ポエムを投稿しよう！</p></div>
                <!-- <input type="text" name="" class="box1" rows="2"> -->

                <div class="col-md-2"></div>
              </div>
              <form method="POST" action="">
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <input type="text" name="input_poem" class="box1 ">

                  <!-- <div class="feed_form thumbnail">
                    <form method="POST" action="">
                  <div class="form-group">
                  <textarea name="feed" class="form-control" rows="3" placeholder="Happy Hacking!" style="font-size: 24px;"></textarea><br>
                  </div>
                  <input type="submit" value="投稿する" class="btn btn-primary">
                  </form>
                  </div>
 -->
                </div>
                <div class="col-md-1"></div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" class="square_btn" value="投稿する">
                  <?php if (isset($errors['feed']) && $errors['feed'] == 'blank') { ?>
                    <p class="text-danger">文字を入力してください</p>
                  <?php } ?>
                </div>
              </div>
             </form>
            </div>
            <div class="col-md-1"></div>
           </div>
      <?php } ?>
          <!-- <div class="row"> -->
        <h3 class="hibi_titile" style="font-weight: bold; margin:0 100px 0 100px;">過去のポエム</h3>
        <?php if (isset($errors["poem"])) { ?>
          <p>まだポエムが投稿されていません</p>
        <?php }else{ ?>
          <?php foreach($poems as $poem){ ?>
            <div class="row">
              <div class="col-md-1"></div>
               <div class="col-md-10">
                <div class="row">
                  <div class="col-md-12 box3">
                    <div class="hibi_poem">
                      <p class="hibi_poem_date"><?php echo $poem['created']?></p>
                      <p class="hibi_poem_content"><?php echo $poem['content']?></p>
                    </div>
                  </div>
                 </div>
                <div class="row">
                  <!-- <div class="col-md-12">今日のポエムが実際に表示される</div> -->
                </div>
              </div>
              <div class="col-md-1"></div>
            </div>
          <?php } ?>
        <?php } ?>
          <!-- </div> -->
          <div aria-label="Page navigation">
           <ul class="pager">
              <?php if ($page == 1){ ?>
                 <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> 次へ</a></li>
             <?php }else{ ?>
                <li class="previous"><a href="private.php?page=<?php echo $page - 1; ?>"><span aria-hidden="true">&larr;</span> 次へ</a></li>
             <?php } ?>
              <?php if ($page == $max_page){ ?>
                <li class="next disabled"><a href="#">前へ <span aria-hidden="true">&rarr;</span></a></li>
              <?php }else{ ?>
                <li class="next"><a href="private.php?page=<?php echo $page + 1; ?>">前へ <span aria-hidden="true">&rarr;</span></a></li>
              <?php } ?>
            </ul>
          </div>
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
    <script src="assets/js/common.js"></script>
  </body>
</html>