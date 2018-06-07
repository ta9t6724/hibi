<?php 

    session_start();

    // サインインしているユーザーの情報を取得
    require('dbconnect.php');
    $sql = 'SELECT * FROM `users` WHERE `id`=?';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    $photo = '';
    $comment = '';
    $category = '';
    $errors = array();

     // 「投稿する」ボタンが押された時のみ処理するif文
     // fileを選択するときは$_FILES
    if (!empty($_POST['input_comment']) && !empty($_FILES['input_image']) && ($_POST['category'] == 0 || $_POST['category'] == 1 || $_POST['category'] == 2)) {
        $photo = $_FILES['input_image'];
        $comment = $_POST['input_comment'];
        $category = $_POST['category'];
        $topic = $_POST['topic'];

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
        $sql = 'INSERT INTO `feeds` SET `user_id`=?, `theme_id`= 0, `comment`=?, `picture`=?, `category`=?, `created`=NOW()';
        $data = array($signin_user['id'], $comment, $submit_file_name, $category);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // unset()で入れるの中身を削除する
        // unset()文は指定した変数もしくは配列を破棄することができる
        header('Location: private.php');
        exit();
    }else if (!empty($_POST['input_comment']) && !empty($_FILES['input_image']) && !empty($_POST['topic']) && ($_POST['category'] == 3)) {
        $photo = $_FILES['input_image'];
        $comment = $_POST['input_comment'];
        $category = $_POST['category'];
        $topic = $_POST['topic'];

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
        $sql = 'INSERT INTO `feeds` SET `user_id`=?, `theme_id`=?, `comment`=?, `picture`=?, `category`=?, `created`=NOW()';
        $data = array($signin_user['id'], $topic, $comment, $submit_file_name, $category);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // unset()で入れるの中身を削除する
        // unset()文は指定した変数もしくは配列を破棄することができる
        header('Location: private.php');
        exit();
    }else{
      $errors['failed'] = 'failed';
    }

    if (!empty($_POST['input_poem'])) {

      $poem = $_POST['input_poem'];

      if ($poem != ''){
        $poem_sql = 'INSERT INTO `poems` SET `user_id`=?, `content`=?, `created`=NOW()';
        $poem_data = array($signin_user['id'], $poem);
        $poem_stmt = $dbh->prepare($poem_sql);
        $poem_stmt->execute($poem_data);

        header('Location: private.php');

      }else{
        $errors['feed'] = 'blank';
      }
    }

    $sql = 'SELECT * FROM `poems` WHERE `user_id`=? ORDER BY `id` DESC';
    $data = array($signin_user['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // 表示用の配列を初期化
    $poems = array();
    // $arr = array();

    while (true) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC); //  ここより上でfetchしてない？
        if ($record == false) {
            break;
        }
        $poems[] = $record;
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
    <link rel="stylesheet" type="text/css" href="assets/css/private.css">
    


    <title>日々</title>
  </head>
  <body>
<!--     <?php 
    echo $_SESSION['id'];
    echo "<pre>";
    var_dump($signin_user);
    var_dump($_POST);
    echo "</pre>";
    ?> -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 sidebar1">
          <div class="logo">
            <img src="assets/img/hibi3.png" class="hibilogo" alt="Logo">
          </div>
            <br>
          <div class="left-navigation">
            <ul class="list">
                <a href="viwe.php"><li>はじめに</li></a>
                <a href="register/signin.php"><li>サインイン</li></a>
                <a href="cur_student.php"><li>ネクシード生の日々</li></a>
                <a href="alumnus.php"><li>卒業生の日々</li></a>
                <a href="theme.php"><li>今週のお題</li></a>
                <a href="private.php"><li>マイページ</li></a>
                <!-- <li>マイページ</li> -->
            </ul>
          </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-10 main-content">
          <div class="row">
            <div class="col-md-1">
              
            </div>
            <div class="col-md-10">
              <h1 class="hibi_titile">日々を投稿しよう！</h1>
            </div>
            <div class="col-md-1">
              
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-12">
              <a href="#" class="cross_line">
              マイページへ
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
              <a href="#hibipic" class="cross_line">
              日々を投稿する
              </a>
            </div>
            <div class="col-md-5">
              <a href="#hibipoem" class="cross_line">
              ポエムを投稿する
              </a>
            </div>
            <div class="col-md-1"></div>
          </div>
          <div class="row" id="hibipic">
            <div class="col-md-1"></div>
            <div class="col-md-10 box17">
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
                      <label class="btn btn-secondary active">
                            <input type="radio" name="category" id="category1" autocomplete="off" value="1" checked> 食
                      </label>
                      <label class="btn btn-secondary">
                            <input type="radio" name="category" id="category2" autocomplete="off" value="2"> 道
                      </label>
                      <label class="btn btn-secondary">
                            <input type="radio" name="category" id="category3" autocomplete="off" value=="3"> 人
                      </label>
                      <label class="btn btn-secondary">
                            <input type="radio" name="category" id="category4" autocomplete="off" value="4"> お題
                      </label>
                  </div>
                  <div class="week_topic">
                      <input type="radio" name="topic" value="1"> バナナ 
                      <input type="radio" name="topic" value="2"> 昼飯 
                      <input type="radio" name="topic" value="3"> ネクシード生 
                      <input type="radio" name="topic" value="4"> 鼻毛 
                      <input type="radio" name="topic" value="5"> 朝飯 
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" class="square_btn" value="投稿する">
                  <?php if (!empty($errors["failed"])) { ?>
                    <p class="text-danger">投稿に失敗しました</p>
                  <?php } ?>
                </div>
              </div>
            </form>
              <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                <a href="edit.php"><p class="hibi_delate">過去の投稿を削除する→</p></a>
                </div>
              </div>
            </div>
            <div class="col-md-1"></div>
          </div>


          <div class="row" id="hibipoem">
            <div class="col-md-1"></div>
            <div class="col-md-10 box17">
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
                  <?php if ($errors['feed'] == 'blank') { ?>
                    <p class="text-danger">文字を入力してください</p>
                  <?php } ?>
                </div>
              </div>
             </form>
            </div>
            <div class="col-md-1"></div>
           </div>
          <!-- <div class="row"> -->
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
          <!-- </div> -->
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