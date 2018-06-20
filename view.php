<?php 
    session_start();

    require('dbconnect.php');

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
      $_SESSION['theme_id'] = $theme_id;
    }elseif (8 <= $today && $today <= 14) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 2';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 2;
      $_SESSION['theme_id'] = $theme_id;
    }elseif (15 <= $today && $today <= 21) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 3';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 3;
      $_SESSION['theme_id'] = $theme_id;
    }elseif (22 <= $today && $today <= 28) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 4';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 4;
      $_SESSION['theme_id'] = $theme_id;
    }elseif (29 <= $today && $today <= 31) {
      $sql = 'SELECT * FROM `themes` WHERE `id`= 5';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $theme = $stmt->fetch(PDO::FETCH_ASSOC);
      $theme_id = 5;
      $_SESSION['theme_id'] = $theme_id;
    }
    // お題の取得処理終了

    // お題でない画像の取得
    $sql = "SELECT * FROM `feeds` WHERE `category`!= 4 ORDER BY `id` DESC LIMIT 3";
    $data = array();
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

    // お題の画像の取得
    $sql = "SELECT * FROM `feeds` WHERE `category`= 4 AND `theme_id` = ? ORDER BY `id` DESC LIMIT 3";
    $data = array($theme_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $theme_feeds = array();

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }
      $theme_feeds[] = $rec;
    }

    // echo $theme_id . "<br>";

    // echo "<pre>";
    // var_dump($feeds);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($theme_feeds);
    // echo "</pre>";


 ?>


<!doctype html>
<html lang="ja">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> 
<!--      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">    
 -->    <link rel="stylesheet" type="text/css" href="assets/css/hibi.css">
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/private.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
    <link href="assets/img/hibilogo.ico" rel="shortcut icon">
    <title>日々</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
       <?php include("navbar.php"); ?>
        <div class="col-md-2"></div>
        <div class="col-md-10 main-content">
          <div class="row">
            <div class="col-md-12 top">
              <a href="private.php" style="font-weight: bold;"><i class="hibi_button"></i>日々を投稿する</a>
            </div>
          </div>
          <div class="row concept">
            <div class="col-md-12">
              <h1 class="hibi mainconcept" style="font-weight: bold;">毎日をちょっとだけ楽しく</h1>
              <p>ネクシード生がセブ留学の「日々」を写真と言葉に</p>
              <p class="hibi subconcept">大切な「日々」の思い出を<span style="font-weight: bold;">カタチ</span>にできるサービスです。</p>
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-md-offset-1 col-md-10"> -->
              <div class="col-md-1"></div>
              <div class="col-md-10 explain">
              <div class="row">
                
                <div class="col-md-6 hibi explain_text">
                <h4>日々とは<hr></h4>
                <p>ネクシード生たちによるセブ留学の「日々」を写真と言葉にして投稿ができ、卒業日には、今まで投稿してきた写真たちがアルバムとしてプレゼントされます。<br>より日常にフォーカス、セブ留学にネクシード生に特化した、そんなサービスです。</p>
                </div>
                
                <div class="col-md-6">
                <!-- <p>写真が入る</p> -->
                <img src="assets/img/LRG_DSC04991.jpg" class="hibi explain_pic">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <!-- <p>写真が入る</p> -->
                  <img src="assets/img/LRG_DSC04987.jpg" class="hibi explain_pic">

                </div>
                <div class="col-md-6 hibi explain_text"><br>
                <h4>お題について<hr></h4>
                <p>「人」「食」「道」そして毎週の「お題」。<br>
                投稿をする際にはカテゴリーを選択します。毎週のお題はその都度確認することができます</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 today_hibi">
              <h3 class="today_hibi_title">
              みんなの「日々」
              </h3>

              <div class="row">
                <?php foreach($feeds as $feed){ ?>
                  <div class="col-md-4">
                    <a href="my_page.php?user_id=<?php echo $feed["user_id"]; ?>"><img src="assets/img/<?php echo $feed['picture']; ?>" class="hibi_pic"></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 topic_hibi">
              <h3>
              今週のお題
              </h3>

              <h5 style="font-weight: bold;">「<?php echo $theme['title']; ?>」</h5>
              <div class="row">
                <?php foreach($theme_feeds as $theme_feed){ ?>
                  <div class="col-md-4">
                     <a href="my_page.php?user_id=<?php echo $theme_feed["user_id"]; ?>"><img src="assets/img/<?php echo $theme_feed['picture']; ?>" class="hibi_pic"></a>
                  </div>
                <?php } ?>
              </div>
            </div>
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