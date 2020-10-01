<?php
session_start();
// print_r($_SESSION);
require_once('../config/config.php');
require_once('../model/Employee.php');
require_once('../model/Review.php');
// ログアウト
if (isset($_GET['logout'])) {
  // セッション情報
  $_SESSION = array();
  session_destroy();
}
// ログイン画面を経由しているかどうかセッションで確認
if(!isset($_SESSION['Employee']) || $_SESSION['Employee']['role'] == 0) {
  // リダイレクト
  header('Location: /review_system/employees/login.php');
  exit;// 後続の処理が続いてしまう
}

try {
  $review = new Review($host,$dbname,$user,$pass);
  $review->connectDb();

  if ($_SESSION['Employee']['role'] == 1) {
    $result = $review->findReviewById($_SESSION);
  } else {
    $err = "不正なログインです";
  }
  // print_r($result);
} catch (\Exception $e) {
  print "エラー！！！:".$e->getMessage();
  print($e->getMessage());
  die();
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/employee_review.css">
  <title></title>
</head>
<body>
  <!-- ヘッダー -->
  <header>
    <div id="title">
      <a href="../users/user.php">Review Me</a>
      <div class="right">
        <a class="logout" href="?logout=1">ログアウト</a>
      </div>
    </div>
  </header>
  <!-- メイン -->
  <main>
    <div class="bg-mask">
      <p style="color:red"><?php if (isset($err)) echo $err;?></p>
      <div class="container">
            <table class="table table-wrapper-scroll-y scrollbar">
              <?php if (isset($result)) foreach ($result as $row):?>
                <tr>
                  <th><?php echo $row['user_name']?><br>
                    <span class="star">
                      <?php if ($row['star'] == 5) {
                        echo "★★★★★";
                      } elseif ($row['star'] == 4) {
                        echo "★★★★";
                      } elseif ($row['star'] == 3) {
                        echo "★★★";
                      } elseif ($row['star'] == 2) {
                        echo "★★";
                      } elseif ($row['star'] == 1) {
                        echo "★";}?>
                      </span>
                    </th>
                    <td><?php echo $row['title']?><br><?php echo $row['content']?><br><?php echo $row['stayed_at']?></td>
                  </tr>
                <?php endforeach; ?>
              </table>


          <div class="button right mt-20">
            <a class="btn" href="employee.php">戻る</a>
          </div>
        </div>
      </div>
    </main>
    <!-- フッター -->
    <footer>
      <p>Copyright © 2020</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
  </html>
