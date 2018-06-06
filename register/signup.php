<?php
    session_start();

    $name = "";
    $account_name = "";
    $graduation_date = "";
    $errors = array();

    if (isset($_GET["action"]) && $_GET["action"] == "rewrite") {
        $_POST['input_name'] = $_SESSION['register']['name'];
        $_POST['input_account_name'] = $_SESSION['register']['account_name'];
        $_POST['input_password'] = $_SESSION['register']['password'];
        $_POST['input_graduation_date'] = $_SESSION['register']['graduation_date'];

        $errors["rewrite"] = true;
    }

    if (!empty($_POST)) {
        $name = $_POST["input_name"];
        $account_name = $_POST["input_account_name"];
        $password = $_POST["input_password"];
        $graduation_date = $_POST["input_graduation_date"];

        $count_account_name = strlen($account_name);
        $count_password = strlen($password);

        // 名前の空チェック
        if ($name == "") {
            $errors["name"] = "blank";
        }

        // アカウント名の空チェック
        // 文字数チェック
        // 半角英数字のみかのチェック
        // 重複チェック
        if ($account_name == "") {
            $errors["account_name"] = "blank";
        }elseif ($count_account_name < 4 || $count_account_name > 15) {
            $errors["account_name"] = "length";
        }elseif (!preg_match("/^[a-zA-Z0-9]+$/", $account_name)) {
            $errors["account_name"] = "character";
        }else{
            // DB接続
            require("../dbconnect.php");

            // SQL
            $sql = "SELECT COUNT(*) as `cnt` FROM `users` WHERE `account_name`=?";
            $data = array($account_name);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            // DB切断
            $dbh = null;

            // 取り出し
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec["cnt"] > 0) {
                $errors["account_name"] = "duplicate";
            }
        }

        // パスワードの空チェック
        if ($password == "") {
            $errors["password"] = "blank";
        }elseif ($count_password < 4 || 8 < $count_password) {
            $errors["password"] = "length";
        } 

        // 卒業日の空チェック
        // すでに卒業済みの場合は登録不可
        if ($graduation_date == "") {
            $errors["graduation_date"] = "blank";
        }elseif (strtotime($graduation_date) < strtotime(date("Y/m/d"))) {

          //var_dump($graduation_date,)
            $errors["graduation_date"] = "date";
        }

        // エラーがなかった時の処理
        if (empty($errors)) {
            $_SESSION["register"]["name"] = $_POST["input_name"];
            $_SESSION["register"]["account_name"] = $_POST["input_account_name"];
            $_SESSION["register"]["password"] = $_POST["input_password"];
            $_SESSION["register"]["graduation_date"] = $_POST["input_graduation_date"];

            header("Location:check.php");
            exit();
            
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
</head>
<body style="background-color:ivory" style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">日々<br><br>
        サインアップ</h2>
        <form method="POST" action="signup.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">名前</label><br>
            <input type="name" name="input_name" class="form-control" id="name" placeholder="" value="<?php echo htmlspecialchars($name); ?>">
            <?php if (isset($errors["name"]) && $errors["name"] == "blank") { ?>
            <p class="text-danger">名前を入力してください</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="account_name">アカウント名</label><br>
            <input type="account_name" name="input_account_name" class="form-control" id="account_name" placeholder="" value="<?php echo htmlspecialchars($account_name); ?>">
            <?php if (isset($errors["account_name"]) && $errors["account_name"] == "blank") { ?>
              <p class="text-danger"> アカウント名を入力してください</p>
            <?php } ?>
            <?php if (isset($errors["account_name"]) && $errors["account_name"] == "length") { ?>
              <p class="text-danger">アカウント名は４〜１５文字で入力してください</p>  
            <?php } ?>
            <?php if (isset($errors["account_name"]) && $errors["account_name"] == "character") { ?>
              <p class="text-danger">使用できるのは半角英数字のみです</p>
            <?php } ?>
            <?php if (isset($errors["account_name"]) && $errors["account_name"] == "duplicate") { ?>
              <p class="text-danger">すでに登録されているアカウント名です</p>
            <?php } ?>
          </div> 
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="４〜８文字のパスワード">
            <?php if(isset($errors['password']) && $errors['password'] =='blank') { ?>
              <p class="text-danger">パスワードを入力してください</p>
            <?php } ?>
            <?php if(isset($errors['password']) && $errors['password'] == 'length') { ?>
              <p class="text-danger">パスワードは４〜８文字で入力してください</p>
            <?php } ?>
            <?php if (!empty($errors["rewrite"])) { ?>
            <p class="text-danger">パスワードを再度入力してください</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="date">卒業日</label><br>
            <input type="date" name="input_graduation_date" value="<?php echo htmlspecialchars($graduation_date); ?>">
            <?php if (isset($errors["graduation_date"]) && $errors["graduation_date"] == "blank") { ?>
              <p class="text-danger">卒業日を選択してください</p>
            <?php } ?>
            <?php if (isset($errors["graduation_date"]) && $errors["graduation_date"] == "date") { ?>
              <p class="text-danger">すでに卒業済みの場合は登録できません</p>
            <?php } ?>
          </div>
          <input type="submit" class="btn btn-default" value="確認">
          <a href="signin.php" class="btn2">サインイン</a>
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
