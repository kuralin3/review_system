<?php
session_start();
// 前回のセッションをリセット
$_SESSION = array();
require_once("../config/config.php");
require_once("../model/Room.php");


try {
  $room = new Room($host,$dbname,$user,$pass);
  $room->connectDb();

  $result = $room->findAll();

  if ($_POST) {
    $employee = $room->findEmployee($_POST);
    // print_r($employee);
    // 一度セッションに入れて渡す
    $_SESSION = $employee;
    if(!empty($employee)){
      header('Location: /review_system/users/review.php');
      exit;// 後続の処理が続いてしまう
    }else{
      $message = "該当者がいませんでした";
    }
  }
} catch (\Exception $e) {
  print "エラー";
}


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Review Me</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script>
  $(function(){
    $(".btn").on('click', function(){
      if ($("input[name='date']").val() == '') {
        alert('必須項目を入力してください');
        // returnしないと次の画面に進む
        return false;
      }
    });
  });
</script>
</head>
<body>
  <!-- ヘッダー -->
  <header>
    <div id="title">
      <a href="user.php">Review Me</a>
      <div class="right">
        <a class="login" href="../employees/login.php">ログイン</a>
      </div>
    </div>
  </header>
  <!-- メイン -->
  <main>
    <div class="bg-mask">
      <div class="container">
        <div id="content-wrapper" style="margin-top:100px">

          <div id="sub_title" style="padding-top:20px">
            <p>YOUR REVIEWS WILL GROW OUR STAFF UP↑↑↑</p>
          </div>
          <p style="color:red"><?php if (isset($message))echo $message; ?></p>
          <form action="" method="post" style="letter-spacing: 30px">
            <select name="room" required>
              <option value="">選択してください</option>
              <?php foreach ($result as $row):?>
                <option value="<?php echo $row['room_number']?>"><?php echo $row['room_number']?></option>
              <?php endforeach; ?>
            </select>
            <input type="date" name="date">
            <!-- <input type="text" name="rsv_num">予約番号 -->
            <div id="submit" class="button">
              <input class="btn" type="submit" value="レビューを書く">
            </div>
          </form>

        </div>
      </div>
    </div>
  </main>
  <!-- フッター -->
  <footer>
    <p>Copyright © 2020</p>
  </footer>
</body>
</html>
