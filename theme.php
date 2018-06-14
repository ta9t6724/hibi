<?php 

session_start();
require('dbconnect.php');
require('function.php');

// サインインしているユーザーの情報を取得
$signin_user = get_signin_user($dbh, $_SESSION['id']);

$sql = 'SELECT `f`.*,`t`.* FROM `themes` AS `t` LEFT OUTER JOIN `feeds` AS `f` ON `f`.`theme_id`=`t`.`id` WHERE `t`.`id` = 1 ORDER BY `f`.`id` DESC';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$themes_1 = array();
while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
        break;
    }
    $themes_1[] = $rec;
}
$sql = 'SELECT `f`.*,`t`.* FROM `themes` AS `t` LEFT OUTER JOIN `feeds` AS `f` ON `f`.`theme_id`=`t`.`id` WHERE `t`.`id` = 2 ORDER BY `f`.`id` DESC';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$themes_2 = array();
while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
        break;
    }
    $themes_2[] = $rec;
}
$sql = 'SELECT `f`.*,`t`.* FROM `themes` AS `t` LEFT OUTER JOIN `feeds` AS `f` ON `f`.`theme_id`=`t`.`id` WHERE `t`.`id` = 3 ORDER BY `f`.`id` DESC';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$themes_3 = array();
while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
        break;
    }
    $themes_3[] = $rec;
}
$sql = 'SELECT `f`.*,`t`.* FROM `themes` AS `t` LEFT OUTER JOIN `feeds` AS `f` ON `f`.`theme_id`=`t`.`id` WHERE `t`.`id` = 4 ORDER BY `f`.`id` DESC';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$themes_4 = array();
while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
        break;
    }
    $themes_4[] = $rec;
}
$sql = 'SELECT `f`.*,`t`.* FROM `themes` AS `t` LEFT OUTER JOIN `feeds` AS `f` ON `f`.`theme_id`=`t`.`id` WHERE `t`.`id` = 5 ORDER BY `f`.`id` DESC';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$themes_5 = array();
while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
        break;
    }
    $themes_5[] = $rec;
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
<!--     <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
 -->
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/alumnus.css">
    <link rel="stylesheet" type="text/css" href="assets/css/private.css"> 
    <link rel="stylesheet" type="text/css" href="assets/css/page.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
    <link href="assets/img/hibilogo.ico" rel="shortcut icon">

    <title>今週のお題</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
       <?php include("navbar.php"); ?>
        <div class="col-md-2"></div>
        <div class="col-md-10 main-content">
<!--           <div class="row">
            <div class="col-md-12 ">
            </div>
          </div> -->

        <div class="col-md-10 main-content">
          <div class="row"></div>
          <h1 class="hibi_title h1" align="center" align="center" style="font-weight: bold;">みんなのお題</h1>

          <h2 align="left" align="left" style="font-weight: bold; margin-top: 40px;">＃<?php echo $themes_1[0]['title']?></h2>
          <div class="row">
            <?php if(!empty($themes_1[0]['picture'])){ ?>
              <?php foreach($themes_1 as $theme_1){ ?>
                <div class="col-md-4">
                  <a href="my_page.php?user_id=<?php echo $theme_1["user_id"]; ?>"><img src="assets/img/<?php echo $theme_1["picture"]; ?>" class="hibi_pic theme_pic"></a>
                </div>
              <?php } ?>
            <?php }else{ ?>
                <div class="col-md-4">
                  <h5>まだ投稿がありません</h5>
                </div>
            <?php } ?>
          </div>

          <h2 align="left" align="left" style="font-weight: bold; margin-top: 40px;">＃<?php echo $themes_2[0]['title']?></h2>
          <div class="row">
            <?php if(!empty($themes_2[0]['picture'])){ ?>
              <?php foreach($themes_2 as $theme_2){ ?>
                <div class="col-md-4">
                  <a href="my_page.php?user_id=<?php echo $theme_2["user_id"]; ?>"><img src="assets/img/<?php echo $theme_2["picture"]; ?>" class="hibi_pic theme_pic"></a>
                </div>
              <?php } ?>
            <?php }else{ ?>
                <div class="col-md-4">
                  <h5>まだ投稿がありません</h5>
                </div>
            <?php } ?>
          </div>

          <h2 align="left" align="left" style="font-weight: bold; margin-top: 40px;">＃<?php echo $themes_3[0]['title']?></h2>
          <div class="row">
            <?php if(!empty($themes_3[0]['picture'])){ ?>
              <?php foreach($themes_3 as $theme_3){ ?>
                <div class="col-md-4">
                  <a href="my_page.php?user_id=<?php echo $theme_3["user_id"]; ?>"><img src="assets/img/<?php echo $theme_3["picture"]; ?>" class="hibi_pic theme_pic"></a>
                </div>
              <?php } ?>
            <?php }else{ ?>
                <div class="col-md-4">
                  <h5>まだ投稿がありません</h5>
                </div>
            <?php } ?>
          </div>

          <h2 align="left" align="left" style="font-weight: bold; margin-top: 40px;">＃<?php echo $themes_4[0]['title']?></h2>
          <div class="row">
            <?php if(!empty($themes_4[0]['picture'])){ ?>
              <?php foreach($themes_4 as $theme_4){ ?>
                <div class="col-md-4">
                  <a href="my_page.php?user_id=<?php echo $theme_4["user_id"]; ?>"><img src="assets/img/<?php echo $theme_4["picture"]; ?>" class="hibi_pic theme_pic"></a>
                </div>
              <?php } ?>
            <?php }else{ ?>
                <div class="col-md-4">
                  <h5>まだ投稿がありません</h5>
                </div>
            <?php } ?>
          </div>

          <h2 align="left" align="left" style="font-weight: bold; margin-top: 40px;">＃<?php echo $themes_5[0]['title']?></h2>
          <div class="row">
            <?php if(!empty($themes_5[0]['picture'])){ ?>
              <?php foreach($themes_5 as $theme_5){ ?>
                <div class="col-md-4">
                  <a href="my_page.php?user_id=<?php echo $theme_5["user_id"]; ?>"><img src="assets/img/<?php echo $theme_5["picture"]; ?>" class="hibi_pic theme_pic"></a>
                </div>
              <?php } ?>
            <?php }else{ ?>
                <div class="col-md-4">
                  <h5>まだ投稿がありません</h5>
                </div>
            <?php } ?>
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