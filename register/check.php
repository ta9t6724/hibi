<?php  
    session_start();

    if (!isset($_SESSION["register"])) {
        header("Location: signup.php");
        exit();
    }
?>
<?php
    $name = $_SESSION['register']['name'];
    $account_name = $_SESSION['register']['account_name'];
    $password = $_SESSION['register']['password'];
    $graduation_date = $_SESSION['register']['graduation_date'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>日々</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">

</head>
<body  style="background-color:ivory" style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">あなたの日々の情報確認</h2>
        <div class="row">
          <div class="col-xs-4">
            <!-- ① -->
          </div>
          <div class="col-xs-8">
            <div>
              <span>名前</span>
              <p class="lead"><?php echo htmlspecialchars($name); ?></p>
            </div>
            <div>
              <span>アカウント名</span>
              <p class="lead"><?php echo htmlspecialchars($account_name); ?></p>
            </div>
            <div>
              <span>パスワード</span>
              <!-- ② -->
              <p class="lead">●●●●●●●●</p>
            </div>
            <div>
              <span>卒業日</span>
              <p class="lead"><?php echo htmlspecialchars($graduation_date); ?></p>
            </div>
            <!-- ③ -->
            <form method="POST" action="">
              <!-- ④ -->
              <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> 
              <!-- ⑤ -->
              <input type="hidden" name="action" value="submit">

              <a href="signin.php" class="btn2">日々を投稿する</a>
              

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>
</body>
</html>