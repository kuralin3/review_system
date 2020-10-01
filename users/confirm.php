<?php
session_start();
// REQUEST_METHOD = HTTPリクエストメソッド（お願いの種類）
// webサーバにリクエストのPOSTがあったら
// print_r($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $rating = htmlspecialchars($_POST["rating"], ENT_QUOTES,'UTF-8');
  $user_name = htmlspecialchars($_POST["user_name"], ENT_QUOTES,'UTF-8');
  $title = htmlspecialchars($_POST["title"], ENT_QUOTES,'UTF-8');
  $date = htmlspecialchars($_POST["date"], ENT_QUOTES,'UTF-8');
  $room = htmlspecialchars($_POST["room"], ENT_QUOTES,'UTF-8');
  $content = htmlspecialchars($_POST["content"], ENT_QUOTES,'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <!-- bootstrapのCSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/confirm.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
  <header>
    <div id="title">
      <h1><a href="user.php">Review Me</a></h1>
    </div>
  </header>

  <main>
    <div class="bg-mask">
      <p>こちらの内容でよろしいですか？</p>
      <div class="container">

        <!-- =======================================================================================================
        最後に修正
        ========================================================================================================= -->


        <div class="rating">
          <!-- POST送信の内容によって表示を分ける -->
          <?php if ($rating == '1'):?>
            <p id="star1"><label for="star1"></label></p>
            <!-- <input type="radio" name="rating" value="star5" id="star5" disabled><label for="star5"></label>
            <input type="radio" name="rating" value="star4" id="star4" disabled><label for="star4"></label>
            <input type="radio" name="rating" value="star3" id="star3" disabled><label for="star3"></label>
            <input type="radio" name="rating" value="star2" id="star2" disabled><label for="star2"></label>
            <input type="radio" name="rating" value="star1" id="star1" checked><label for="star1"></label> -->
          <?php elseif ($rating == '2'):?>
            <p id="star1"><label for="star1"></label></p>
            <p id="star2"><label for="star1"></label></p>
            <!-- <input type="radio" name="rating" value="star5" id="star5" disabled><label for="star5"></label>
            <input type="radio" name="rating" value="star4" id="star4" disabled><label for="star4"></label>
            <input type="radio" name="rating" value="star3" id="star3" disabled><label for="star3"></label>
            <input type="radio" name="rating" value="star2" id="star2" checked><label for="star2"></label>
            <input type="radio" name="rating" value="star1" id="star1" disabled><label for="star1"></label> -->
          <?php elseif ($rating == '3'):?>
            <p id="star1"><label for="star1"></label></p>
            <p id="star2"><label for="star2"></label></p>
            <p id="star3"><label for="star3"></label></p>
            <!-- <input type="radio" name="rating" value="star5" id="star5" disabled><label for="star5"></label>
            <input type="radio" name="rating" value="star4" id="star4" disabled><label for="star4"></label>
            <input type="radio" name="rating" value="star3" id="star3" checked><label for="star3"></label>
            <input type="radio" name="rating" value="star2" id="star2" disabled><label for="star2"></label>
            <input type="radio" name="rating" value="star1" id="star1" disabled><label for="star1"></label> -->
          <?php elseif ($rating == '4'):?>
            <p id="star1"><label for="star1"></label></p>
            <p id="star1"><label for="star1"></label></p>
            <p id="star1"><label for="star1"></label></p>
            <p id="star1"><label for="star1"></label></p>
            <!-- <input type="radio" name="rating" value="star5" id="star5" disabled><label for="star5"></label>
            <input type="radio" name="rating" value="star4" id="star4" checked><label for="star4"></label>
            <input type="radio" name="rating" value="star3" id="star3" disabled><label for="star3"></label>
            <input type="radio" name="rating" value="star2" id="star2" disabled><label for="star2"></label>
            <input type="radio" name="rating" value="star1" id="star1" disabled><label for="star1"></label> -->
          <?php elseif ($rating == '5'):?>
            <label></label>
            <label></label>
            <label></label>
            <label></label>
            <label></label>
            <!-- <label for="star1">
            <label for="star2">
            <label for="star3">
            <label for="star4">
            <label for="star4"> -->
            <!-- <p id="star1"><label for="star1"></label></p>
            <p id="star1"><label for="star1"></label></p>
            <p id="star1"><label for="star1"></label></p>
            <p id="star1"><label for="star1"></label></p>
            <p id="star1"><label for="star1"></label></p> -->
            <!-- <input type="radio" name="rating" value="star5" id="star5" checked><label for="star5"></label>
            <input type="radio" name="rating" value="star4" id="star4" disabled><label for="star4"></label>
            <input type="radio" name="rating" value="star3" id="star3" disabled><label for="star3"></label>
            <input type="radio" name="rating" value="star2" id="star2" disabled><label for="star2"></label>
            <input type="radio" name="rating" value="star1" id="star1" disabled><label for="star1"></label> -->

            <!-- =======================================================================================================
            最後に修正
            ========================================================================================================= -->


          <?php endif; ?>
        </div>
        <div id="table-wrapper">
          <table class="table">
            <tr>
              <th>ユーザ名</th>
              <td class="center"><?php echo $user_name ?></td>
            </tr>
            <tr>
              <th>タイトル</th>
              <td class="center"><?php echo $title ?></td>
            </tr>
            <tr>
              <th>日付</th>
              <td class="center"><?php echo $date ?></td>
            </tr>
            <tr>
              <th>レビュー内容</th>
              <td><?php echo $content ?></td>
            </tr>
          </table>
        </div>

      </div>

      <!-- hiddenでデータを送信 -->
      <form action="complete.php" method="post">
        <input type="hidden" name="rating" value="<?php echo $rating; ?>">
        <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
        <input type="hidden" name="title" value="<?php echo $title; ?>">
        <input type="hidden" name="date" value="<?php echo $date; ?>">
        <input type="hidden" name="room" value="<?php echo $room; ?>">
        <input type="hidden" name="content" value="<?php echo $content; ?>">
        <div class="submit">
          <input type="submit" name="rewrite" formaction="review.php" value="修正">
          <input type="submit" name="send" value="送信">
        </div>
      </form><!-- form終わり -->
    </div><!-- bg-mask -->
  </main>
  <footer>
    <p>Copyright © 2020</p>
  </footer>
</body>
</html>
