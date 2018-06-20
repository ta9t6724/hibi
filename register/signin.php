<?php  

    session_start();

    require('../dbconnect.php');

    $errors = array();

    if (!empty($_POST)) {

        $account_name = $_POST['input_account_name'];
        $password = $_POST['input_password'];

        if ($account_name == '') {
            $errors['account_name'] = 'blank';
        }

        if ($password == '') {
            $errors['password'] = 'blank';
        }

        if( $account_name != '' && $password !='' ) {

            $sql = 'SELECT * FROM `users` WHERE `account_name`=?';
            $data = array($account_name);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($record == false) {
                $errors['signin'] = 'failed';
            }else {
                if (password_verify($password,$record['password'])){
                      $_SESSION['id'] = $record['id'];

                      header("Location: ../private.php");
                      exit();
                }
                else{
                    $errors['signin'] = 'failed';
                }

            }

        }

    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>日々</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/footer.css">
  <link href="../assets/img/hibilogo.ico" rel="shortcut icon">

</head>
<body  style="background-color:ivory" style="margin-top: 60px">
  <div class="container" style="margin: 110px;">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <a href="../view.php"><img src="../assets/img/hibilog.png" style="max-width: 100px; max-height: auto;"></a>
        <h2 class="text-center content_header">サインイン</h2>
        <form method="POST" action="signin.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="account_name">アカウント名</label><br>
            <input type="account_name" name="input_account_name" class="form-control" id="account_name" placeholder="">
            <?php if(isset($errors['account_name']) && $errors['account_name'] == 'blank') { ?>
              <p class="text-danger">アカウント名を入力してください</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="４〜８文字のパスワード">
            <?php if(isset($errors['password']) && $errors['password'] == 'blank') { ?>
              <p class="text-danger">パスワードを入力してください</p>
            <?php } ?>
            <?php if(isset($errors['signin']) && $errors['signin'] == 'failed') { ?>
              <p class="text-danger">サインインに失敗しました</p>
            <?php } ?>
          </div>
         <input type="submit" class="btn btn-default" value="サインイン">
          <a href="signup.php" class="btn btn-secondary" style="float:right;">登録されていない方はこちら</a>
        </form>
      </div>
    </div>
  </div>


  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
