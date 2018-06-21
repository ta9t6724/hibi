<?php

    $sql = "SELECT `u`.`account_name`, `u`.`id` AS `id`, `u`.`graduation_date`,`f`.`user_id`,`f`.`picture`,`f`.`created` FROM `users` `u` LEFT JOIN (SELECT `f`.`user_id`,`f`.`picture`,`f`.`created` FROM `feeds` `f` GROUP BY `f`.`user_id` ORDER BY `created` DESC) AS `f` ON `u`.`id` = `f`.`user_id` WHERE `graduation_date` > CURRENT_DATE() ORDER BY `id` DESC LIMIT $start, $page_row_number";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $cur_students = array();

    while (true) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
        break;
      }
      $cur_students[] = $rec;
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
      <link rel="stylesheet" type="text/css" href="assets/css/hibi.css">
      <link rel="stylesheet" type="text/css" href="assets/css/alumnus.css">
      <link rel="stylesheet" type="text/css" href="assets/css/cur_students.css">
      <link rel="stylesheet" type="text/css" href="assets/css/private.css"> 
      <link rel="stylesheet" type="text/css" href="assets/css/page.css">
      <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
      <link href="assets/img/hibilogo.ico" rel="shortcut icon">

      <title>在校生の日々</title>
    </head>
    <body>
  <div class="container-fluid">
    <div class="row">
     <?php include("navbar.php"); ?>
     <div class="col-md-2"></div>

     <div class="col-md-10 main-content">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <h1 class="h1 hibi_title" style="text-align: center; font-weight: bold;">在校生の日々をのぞいてみよう</h1>
          <div class="row mypage-content">
            <?php foreach($cur_students as $cur_student){ ?>
            <?php if(!empty($cur_student['picture'])){ ?>
            <div class="col-md-4">
              <div class="hibi_flame">
                <a href="my_page.php?user_id=<?php echo $cur_student["id"]; ?>"><img src="assets/img/<?php echo $cur_student["picture"]; ?>" class="mypage-content-pic"></a>
                <p class="hibi_username"><?php echo $cur_student["account_name"]; ?></p>
              </div>
            </div>
            <?php }else{ ?>
            <div class="col-md-4">
              <div class="hibi_flame">
                <a href="my_page.php?user_id=<?php echo $cur_student["id"]; ?>"><img src="assets/img/hibilog.png" class="mypage-content-pic"></a>
                <p class="hibi_username"><?php echo $cur_student["account_name"]; ?></p>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
          </div>
          <div aria-label="Page navigation">
           <ul class="pager">
            <?php if ($page == 1){ ?>
            <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> 次へ</a></li>
            <?php }else{ ?>
            <li class="previous"><a href="cur_student.php?page=<?php echo $page - 1; ?>"><span aria-hidden="true">&larr;</span> 次へ</a></li>
            <?php } ?>
            <?php if ($page == $all_page_number){ ?>
            <li class="next disabled"><a href="#">前へ <span aria-hidden="true">&rarr;</span></a></li>
            <?php }else{ ?>
            <li class="next"><a href="cur_student.php?page=<?php echo $page + 1; ?>">前へ <span aria-hidden="true">&rarr;</span></a></li>
            <?php } ?>

          </ul>
        </div>
      </div>
    </div>
  </div>

         

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</div>
</div>
      <!-- footer -->
      <?php include("footer.php"); ?>

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    </body>
    </html>

