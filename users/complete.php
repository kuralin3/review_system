<?php
session_start();
// print_r($_SESSION);
require_once('../config/config.php');
require_once('../model/Review.php');


try {
  $review = new Review($host,$dbname,$user,$pass);
  $review->connectDb();
  // 追加処理
  $review->add($_POST);
} catch (PDOException $e) {
  print($e->getMessage());
  die();
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/reset.css">
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</head>
<body>
  <header>
    <div id="title">
      <a href="user.php">Review Me</a>
    </div>
  </header>
  <main>
    <div style="line-height:80px" class="bg-mask">
    <div class="container">
          <p style="font-size:35px;font-weight:bold">レビューを投稿しました！</p>
        <div id="text">
          <p>ありがとうございました。<br>
          お客様のご意見をスタッフの教育に活かし、<br>
          よりよいサービスの提供が出来るホテルを目指して参ります。</p>
        </div>
        <div class="button right mt-20">
          <a class="btn" href="user.php">戻る</a>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <p>Copyright © 2020</p>
  </footer>
</body>
</html>
