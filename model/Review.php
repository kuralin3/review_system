<?php
session_start();
// print_r($_GET);

require_once("../config/config.php");
require_once("../model/Room.php");

// 前ページでバリデーションをしてセッションで送った
$name = $_SESSION['name'];
$image = $_SESSION['image'];
$room = $_SESSION['room_id'];
$date = $_SESSION['stayed_at'];


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/review.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script>
  $(function(){
    $("#submit").on('click', function(){
      // チェックボックスのチェックされた数を数える
      var check_count = $('.rating :checked').length;
      // ユーザ名の長さ
      var name_length = $('#name').val().length;
      if (check_count == 0){
        alert('星を選んでください!');
        // returnしないと次の画面に進む
        return false;
      }
      // ユーザ名の長さをバリデーションする
      if (name_length >= 10) {
        alert('ユーザ名は10文字以内で入力してください');
        return false;
      }
    });
  });

</script>
</head>
<body>
  <header>
    <div id="title">
      <a href="user.php">Review Me</a>
    </div>
  </header>
  <main>
    <div class="bg-mask">
      <div class="container">
        <p style="font-size:30px;padding-top:20px"> 担当スタッフ:<?php if (isset($name))echo $name;?></p>
        <!-- flexbox start-->
        <div id="wrapper" class="row">
          <div id="image">
            <img src="../image/<?php if(isset($image))echo $image ?>">
          </div>

          <div id="table-wrapeer" class="col-sm-12 col-lg-7">
            <table class="table table-wrapper-scroll-y scrollbar">
                <tr>
                  <th>クリックして評価してください</th>
                  <td>
                    <div class="rating">
                      <form action="confirm.php" method="post" style="margin-top:0"><!-- フォーム内容 -->
                        <input class="rate" type="radio" name="rating" value="5" id="star5"><label for="star5"></label>
                        <input class="rate" type="radio" name="rating" value="4" id="star4"><label for="star4"></label>
                        <input class="rate" type="radio" name="rating" value="3" id="star3"><label for="star3"></label>
                        <input class="rate" type="radio" name="rating" value="2" id="star2"><label for="star2"></label>
                        <input class="rate" type="radio" name="rating" value="1" id="star1"><label for="star1"></label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>ユーザ名</th>
                    <td><input id="name" class="name" type="text" name="user_name" value="<?php if(!empty($_POST['user_name'])){echo $_POST['user_name'];} ?>"></td>
                  </tr>
                  <tr>
                    <th>タイトル</th>
                    <td><input type="text" name="title" value="<?php if(!empty($_POST['title'])){echo $_POST['title'];} ?>"></td>
                  </tr>
                  <tr>
                    <th>日付</th>
                    <td><?php echo $date ?></td>
                    <input type="hidden" name="date" value="<?php echo $date ?>">
                    <input type="hidden" name="room" value="<?php echo $room ?>">
                  </tr>
                  <tr>
                    <th>レビュー内容</th>
                    <td><textarea name="content" rows="8" cols="60"><?php if(!empty($_POST['content'])){echo $_POST['content'];} ?></textarea></td>
                  </tr>
              </table>
            </div><!-- table-wrapper -->
          </div><!-- wrapper -->
          <!-- flexbox end-->
          <div id="submit">
            <input class="submit" type="submit" value="投稿する">
          </div>
        </form><!-- フォーム終わり -->
      </div><!-- container -->
    </div><!-- bg-mask -->
  </main>
  <footer>
    <p>Copyright © 2020</p>
  </footer>
</body>
</html>
