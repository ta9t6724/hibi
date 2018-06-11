<!doctype html>
<html lang="ja">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> 
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/alumnus.css">
    


    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 sidebar1">
          <div class="logo">
            <img src="assets/img/hibilog.png" class="hibilogo" alt="Logo">
          </div>
            <br>
          <div class="left-navigation">
             <ul class="list">
              <li><a href="" >はじめに</a></li>
              <li><a href="cur_student.php" >ネクシード生の日々</a></li>
              <li><a href="alumnus" >卒業生の日々</a></li>
              <li><a href="view.php" >今週のお題</a></li>
              <li><a href="private.php" >マイページ</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-10 main-content">
          <div class="row">
            <div class="col-md-12 ">

            </div>
          </div>
          <div class="row concept">
            <div class="col-md-12">
              <h1 class="h1">編集</h1>
            </div>
          </div>
          
        <div class="container">
        <div class="row">
      <!-- ここにコンテンツ -->
        <div class="col-xs-4 col-xs-offset-4">
        <form class="form-group" method="post">
          <img src="user_profile_img/<?php echo $feed["img_name"]; ?>" width="60">
          <?php echo $feed["name"]; ?><br>
          <?php echo $feed["created"]; ?><br>
          <textarea name="feed" class="form-control" cols="40" rows="8"><?php echo $feed["feed"]; ?></textarea>
          <input type="submit" value="更新" class="btn btn-warning btn-lg">
          <input type="submit" value="削除" class="btn btn-warning btn-lg">
        </form>
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