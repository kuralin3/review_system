<?php
// session_start関数で$_SESSIONのスーパーグローバル変数が使えるようになる
session_start();


require_once('../config/config.php');
require_once('../model/Employee.php');


try {
  $employee = new Emp($host,$dbname,$user,$pass);
  $employee->connectDb();

  // If文で管理者と従業員ページ遷移を分ける
  if ($_POST) {
    // ハッシュ化
    // $hash = md5($_POST['password']);
    // $result = $employee->login($_POST,$hash);
    $result = $employee->login($_POST);
    if (!empty($result)) {
      $_SESSION['Employee'] = $result;
      if ($_SESSION['Employee']['role'] == 0) {
        header('Location: /review_system/employees/admin.php');
        exit();
      }elseif ($_SESSION['Employee']['role'] == 1) {
        header('Location: /review_system/employees/employee.php');
        exit();
      }
    }else{
      $message = "ログインできませんでした。";
    }
  }

} catch (\Exception $e) {
  print "エラー".$e->getMessage();
  die();
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/login.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <title>ログインページ</title>
</head>
<body>
  <header>
    <div id="title">
      <h1><a href="../users/user.php">Review Me</a></h1>
    </div>
  </header>
  <main>
    <div class="bg-mask">
    <div class="container">
      <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <!-- <p id="profile-name" class="profile-name-card">user</p> -->
        <p style="color:red"><?php if(isset($message)) echo $message ?></p>
        <!-- フォームPOST送信 -->
        <form action="" class="form-signin" method="post">
          <span id="reauth-email" class="reauth-email"></span>
          <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" autofocus>
          <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password">
          <!-- required付きのコード -->
          <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
          <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> -->
          <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </form><!-- フォームPOST送信終わり -->
      </div><!-- /card-container -->
    </div><!-- /container -->
    </div>
  </main>
  <footer>
    <p>Copyright © 2020</p>
  </footer>
</body>
</html>
