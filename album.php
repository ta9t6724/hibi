<?php
    session_start();

    require("dbconnect.php");
    require('function.php');

    $user_id = $_GET['user_id'];

    $feed_user = get_feed_user($dbh, $user_id);

    // 在校生だったらmy_page.phpに飛ばす処理
    $today = date("Y-m-d");
    $target_day = $feed_user['graduation_date'];

    if (strtotime($target_day) > strtotime($today)) {
        header("Location: my_page.php?user_id=".$user_id);
        exit();
    }

    $users = array();

    // 卒業生情報取得
    $sql = "SELECT `u`.`name`,`u`.`graduation_date`,`u`.`created`,`f`.`picture`,`f`.`created` FROM `users` AS `u` LEFT OUTER JOIN `feeds` AS `f` ON `u`.`id`=`f`.`user_id` WHERE `user_id`=? ORDER BY `f`.`created` DESC LIMIT 1";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $users[] = $rec;

    // 登録日と卒業日の差分計算
    $sql = "SELECT DATEDIFF(`graduation_date`,`created`) AS `date_gap` FROM `users` WHERE `id`=?";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $date_gap = $rec["date_gap"];
    
    // 「食」の写真枚数計算
    $sql = "SELECT COUNT(*) AS `foods_count` FROM `feeds` WHERE `user_id`=? AND `category`=1";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $foods_count = $rec["foods_count"];

    // 「道」の写真枚数計算
    $sql = "SELECT COUNT(*) AS `roads_count` FROM `feeds` WHERE `user_id`=? AND `category`=2";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $roads_count = $rec["roads_count"];

    // 「人」の写真枚数計算
    $sql = "SELECT COUNT(*) AS `persons_count` FROM `feeds` WHERE `user_id`=? AND `category`=0";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $persons_count = $rec["persons_count"];

     // 「お題」の写真枚数計算
    $sql = "SELECT COUNT(*) AS `themes_count` FROM `feeds` WHERE `user_id`=? AND `category`=4";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $themes_count = $rec["themes_count"];

    // 合計の投稿数計算
    $sql = "SELECT COUNT(*) AS `feeds_count` FROM `feeds` WHERE `user_id`=?";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $feeds_count = $rec["feeds_count"];

    // 「食」情報取得
    $sql = "SELECT * FROM `feeds` WHERE `user_id`=? AND `category`=1 ORDER BY `feeds`.`created` ASC";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $foods = array();
    while (1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }
        $foods[] = $rec;
    }

    // 「道」情報取得
    $sql = "SELECT * FROM `feeds` WHERE `user_id`=? AND `category`=2 ORDER BY `feeds`.`created` ASC";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $roads = array();
    while (1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }
        $roads[] = $rec;
    }

    // 「人」情報取得
    $sql = "SELECT * FROM `feeds` WHERE `user_id`=? AND `category`=0 ORDER BY `feeds`.`created` ASC";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $persons = array();
    while (1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }
        $persons[] = $rec;
    }

    // 「お題」情報取得
    $sql = "SELECT * FROM `feeds` WHERE `user_id`=? AND `category`=4 ORDER BY `feeds`.`created` ASC";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $themes = array();
    while (1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }
        $themes[] = $rec;
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
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/private.css"> 
    <link rel="stylesheet" type="text/css" href="assets/css/album.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
    <link href="assets/img/hibilogo.ico" rel="shortcut icon">

    <title>日々</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- サイドバー読み込み -->
        <?php include("navbar.php"); ?>
        <div class="col-md-2"></div>
        <div class="col-md-10 main-content">
          <div class="row">
            <?php if (!empty($users)) { ?>
              <?php foreach ($users as $user) { ?>
                <div class="col-md-12 album">
                  <p class="album-top-name"><?php echo $user["name"]; ?>さんの日々</p>
                  <p class="album-top-time">〜NexSeedでの <span><?php echo $date_gap; ?></span>日間〜</p>
                </div>
              <?php } ?>
            <?php } ?>
          </div>
          <div class="row">
            <?php if (!empty($users)) { ?>
              <?php foreach ($users as $user) { ?>
                <div class="col-md-1"></div>
                <div class="col-md-10 album">
                  <div class="row album-top">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                      <?php if (!empty($users[0]["picture"])) { ?>
                      <img class="album-top-pic" src="assets/img/<?php echo $user["picture"]; ?>" class="hibi_pic" style="width: 250px; height: auto; margin: 60px 0 20px 0">
                      <?php } else{ ?>
                        <img src="assets/img/hibilog.png" class="mypage-top-pic" style="width: 250px; height: auto; margin: 60px 0 20px 0">
                      <?php } ?>
                    </div>
                    <div class="col-md-5 album-top-text">
                      <p class="album-top-picnumber"><span><?php echo $date_gap; ?></span>日間で <span><?php echo $feeds_count; ?></span>枚の写真が投稿されました。</p>
                      <p class="album-top-category">「#食」の写真 <span><?php echo $foods_count; ?></span>枚</p>
                      <p class="album-top-category">「#人」の写真 <span><?php echo $roads_count; ?></span>枚</p>
                      <p class="album-top-category">「#道」の写真 <span><?php echo $persons_count; ?></span>枚</p>
                      <p class="album-top-category">「#お題」の写真 <span><?php echo $themes_count; ?></span>枚</p>
                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          </div>

          <!-- 「食」カテゴリーの出力 -->
          <div class="row album-main">
            <div class="col-md-12">
              <h5 class="album-main-category">セブ留学の「#食」</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
              <div class="row">  
                <?php if (!empty($foods[0]["picture"])) { ?>
                  <?php foreach ($foods as $food) { ?>
                    <div class="col-md-3">
                      <div class="sample2">
                        <img class="album-main-pic" src="assets/img/<?php echo $food["picture"]; ?>">
                        <div class="mask2">
                          <div class="caption2"><?php echo $food["comment"]; ?></div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                <?php }else{ ?>
                  <div align="center" class="empty_notice">
                    <h6>投稿がありません</h6>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          
          <!-- 「道」カテゴリーの出力 -->
          <div class="row album-main">
            <div class="col-md-12">
              <h5 class="album-main-category">セブ留学の「#道」</h5>
            </div>
          </div>
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-10">
                <div class="row">
                  <?php if (!empty($roads[0]["picture"])) { ?>
                    <?php foreach ($roads as $road) { ?>
                      <div class="col-md-3">
                        <div class="sample2">
                          <img class="album-main-pic" src="assets/img/<?php echo $road["picture"]; ?>">
                          <div class="mask2">
                            <div class="caption2"><?php echo $road["comment"]; ?></div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  <?php }else{ ?>
                    <div align="center" class="empty_notice">
                      <h6>投稿がありません</h6>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>

          <!-- 「人」カテゴリーの出力 -->
          <div class="row album-main">
            <div class="col-md-12">
              <h5 class="album-main-category">セブ留学の「#人」</h5>
            </div>
          </div>
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-10">
                <div class="row">
                  <?php if (!empty($persons[0]["picture"])) { ?>
                    <?php foreach ($persons as $person) { ?>
                      <div class="col-md-3">
                        <div class="sample2">
                          <img class="album-main-pic" src="assets/img/<?php echo $person["picture"]; ?>">
                          <div class="mask2">
                            <div class="caption2"><?php echo $person["comment"]; ?></div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  <?php }else{ ?>
                    <div align="center" class="empty_notice">
                      <h6>投稿がありません</h6>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>

          <!-- 「お題」カテゴリーの出力 -->
          <div class="row album-main">
            <div class="col-md-12">
              <h5 class="album-main-category">セブ留学の「#お題」</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
              <div class="row">
                <?php if (!empty($themes[0]["picture"])) { ?>
                  <?php foreach ($themes as $theme) { ?>
                <div class="col-md-3">
                  <div class="sample2">
                    <img class="album-main-pic" src="assets/img/<?php echo $theme["picture"]; ?>">
                    <div class="mask2">
                      <div class="caption2"><?php echo $theme["comment"]; ?></div>
                    </div>
                  </div>
                </div>
                  <?php } ?>
                <?php }else{ ?>
                  <div align="center" class="empty_notice">
                    <h6>投稿がありません</h6>
                  </div>
                <?php } ?>
              </div>
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
  </body>
</html>