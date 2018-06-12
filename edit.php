<?php 
    session_start();

    require('dbconnect.php');
    require('function.php');

    // ログインチェック
    check_signin($_SESSION['id']);

    // サインインしているユーザーの情報を取得
    $signin_user = get_signin_user($dbh, $_SESSION['id']);

    $sql = "SELECT * FROM `feeds` WHERE `user_id`= ?";
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
         <?php foreach($feeds as $feed){ ?>
           <div class="col-md-4">
           <img src="assets/img/<?php $feed['picture'] ?>" class="hibi_pic">
           <a onclick="return confirm('削除してよろしいですか？')" href="delete.php?feed_id=<?php echo $feed["id"] ?>" class="btn btn-danger" style="float: right;">削除</a>
           </div>
         <?php } ?>
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