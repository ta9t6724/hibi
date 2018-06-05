<?php 
  session_start();
  require('../dbconnect.php');

    // 初期化
  $errors = array();

  if (!empty($_POST)) {
    $account_name = $_POST['input_account_name'];
    $password = $_POST['input_password'];
    if ($account_name != '' && $password != '') {
      // データベースとの照合処理
      $sql = 'SELECT * FROM `users` WHERE `account_name`=?';
      $data = array($account_name);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);


      // メールアドレスでの本人確認

      if ($record == false) {
      $errors['signin'] = 'failed';
      } else {
          if (password_verify($password,$record['password'])){
          //認証成功
          //SESSION変数にIDを保存
          $_SESSION['id'] = $record['id'];

          //timeline.phpに移動
          header("Location: ../private.php");
          exit();

        } else {
            //認証失敗
            $errors['signin'] = 'failed';
        }
      }
    }else{
      $errors['signin'] = 'blank';
    }
  }
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>日々</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body  style="background-color:ivory" style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">日々<br><br>
        サインイン</h2>
        <form method="POST" action="signin.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="account_name">アカウント名</label><br>
            <input type="account_name" name="input_account_name" class="form-control" id="account_name" placeholder="">
            <p class="text-danger">アカウント名を入力してください</p>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード"><?php if(isset($errors['password'])&& $errors['password']=='blank'){ ?>
            <p class="text-danger">パスワードを入力してください</p>
            <?php } ?>
            <?php if(isset($errors['password'])&& $errors['password']=='length'){ ?>
            <p class="text-danger">パスワードは4~16文字で入力してくださいね</p>
            <?php } ?>
          </div>
          <input type="submit" class="btn btn-info" value="サインイン">
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
