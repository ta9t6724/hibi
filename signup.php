<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>日々</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">日々<br><br>
        サインアップ</h2>
        <form method="POST" action="check.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nickname">ニックネーム</label><br>
            <input type="nickname" name="input_nickname" class="form-control" id="nickname" placeholder="">
            <p class="text-danger">ニックネームを入力してください</p>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード"><?php if(isset($errors['password'])&& $errors['password']=='blank'){ ?>
            <p class="text-danger">パスワードを入力してください</p>
            <?php } ?>
            <?php if(isset($errors['password'])&& $errors['password']=='length'){ ?>
            <p class="text-danger">パスワードは4~16文字で入力してください</p>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="password">卒業日</label><br>
            <input type="date" name="example1">
            <p class="text-danger">卒業日を入力してください</p>
          </div>
          <div class="form-group">
            <label for="img_name">プロフィール画像</label>
            <input type="file" name="input_img_name" id="img_name" accept="image/*">
            <?php if(isset($errors['img_name'])&& $errors['img_name']=='blank'){ ?>
            <p class="text-danger">画像を選択してください</p>
            <?php } ?>
            <?php if(isset($errors['img_name'])&& $errors['img_name']=='type'){ ?>
            <p class="text-danger">拡張子が「jpg」「jpeg」「png」「gif」の画像を選択してください</p>
            <?php } ?>
          </div>
          <input type="submit" class="btn btn-info" value="サインアップ">
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
