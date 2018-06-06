<!doctype html>
<html lang="ja">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="private.css">
    


    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 sidebar1">
          <div class="logo">
            <img src="img/hibi3.png" class="hibilogo" alt="Logo">
          </div>
            <br>
          <div class="left-navigation">
            <ul class="list">
                <li>はじめに</li>
                <li>サインイン</li>
                <li>ネクシード生の日々</li>
                <li>卒業生の日々</li>
                <li>今週のお題</li>
                <!-- <li>マイページ</li> -->
            </ul>
          </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-10 main-content">
          <div class="row">
            <div class="col-md-1">
              
            </div>
            <div class="col-md-10">
              <h1 class="hibi_titile">日々を投稿しよう！</h1>
            </div>
            <div class="col-md-1">
              
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-12">
              <a href="#" class="cross_line">
              マイページへ
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
              <a href="#hibipic" class="cross_line">
              日々を投稿する
              </a>
            </div>
            <div class="col-md-5">
              <a href="#hibipoem" class="cross_line">
              ポエムを投稿する
              </a>
            </div>
            <div class="col-md-1"></div>
          </div>
          <div class="row" id="hibipic">
            <div class="col-md-1"></div>
            <div class="col-md-10 box17">
              <div class="row">
                <div class="col-md-4">
                  <p class="hibi_setumei">写真</p>
                  <br>
               <div class="uploadButton">
                <p>ファイルを選択</p>
                <input type="file" onchange="uv.style.display='inline-block'; uv.value = this.value;" />
                <input type="text" id="uv" class="uploadValue" disabled />
               </div>

                </div>
                <div class="col-md-8">
                <p class="hibi_setumei">コメント</p>
                <!-- <textarea name="feed" class="hibi_text_upload form-control" rows="2" placeholder="投稿内容を入力する" style="font-size: 15px;"></textarea> -->
                <input type="text" name="" class="box1" rows="2">
                <!-- <textarea class="box1 hibi_text_upload" rows="2" placeholder="ここにテキストを入力してね" style="font-size: 15px;" > -->
                <!-- </textarea> -->
                <div class="week_topic">
                <input type="radio" name="topic" value="0"> バナナ 
                <input type="radio" name="topic" value="1"> 昼飯 
                <input type="radio" name="topic" value="2"> ネクシード生 
                <input type="radio" name="topic" value="3"> 鼻毛 
                <input type="radio" name="topic" value="4"> 朝飯 
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                <a href="#" class="square_btn">投稿する</a>
                </div>
              </div>
              <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                <a href="#"><p class="hibi_delate">過去の投稿を削除する→</p></a>
                </div>
              </div>
            </div>
            <div class="col-md-1"></div>
          </div>


          <div class="row" id="hibipoem">
            <div class="col-md-1"></div>
            <div class="col-md-10 box17">
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8"><p class="hibi_setumei">ポエムを投稿しよう！</p></div>
                <!-- <input type="text" name="" class="box1" rows="2"> -->

                <div class="col-md-2"></div>
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <input type="text" name="" class="box1 ">

                  <!-- <div class="feed_form thumbnail">
                    <form method="POST" action="">
                  <div class="form-group">
                  <textarea name="feed" class="form-control" rows="3" placeholder="Happy Hacking!" style="font-size: 24px;"></textarea><br>
                  </div>
                  <input type="submit" value="投稿する" class="btn btn-primary">
                  </form>
                  </div>
 -->
                </div>
                <div class="col-md-1"></div>
              </div>
              <div class="row">
                <div class="col-md-12">
                <a href="#" class="square_btn btn2">投稿する</a>
                </div>
              </div>
            </div>
            <div class="col-md-1"></div>
          </div>

          <!-- <div class="row"> -->
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-12 box3">
                    <div class="hibi_poem">
                      <p class="hibi_poem_date">4月1日</p>
                      <p class="hibi_poem_content">今日のポエムが実際に表示される</p>
                    </div>
                    <div class="hibi_poem">
                      <p class="hibi_poem_date">4月1日</p>
                      <p class="hibi_poem_content">今日のポエムが実際に表示される</p>
                    </div>
                    <div class="hibi_poem">
                      <p class="hibi_poem_date">4月1日</p>
                      <p class="hibi_poem_content">今日のポエムが実際に表示される</p>
                    </div>
                    <div class="hibi_poem">
                      <p class="hibi_poem_date">4月1日</p>
                      <p class="hibi_poem_content">今日のポエムが実際に表示される</p>
                    </div>
                </div>
                </div>
                <div class="row">
                  <!-- <div class="col-md-12">今日のポエムが実際に表示される</div> -->
                </div>
              </div>
              <div class="col-md-1"></div>
            </div>
          <!-- </div> -->
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