<?php
session_start();
require_once("../config/config.php");
require_once("../model/Admin.php");

print_r($_POST);
// ログイン画面を経由しているかどうかセッションで確認
if(!isset($_SESSION['Employee'])) {
  // リダイレクト
  header('Location: /review_system/employees/login.php');
  exit;// 後続の処理が続いてしまう
}

try {
  $admin = new Admin($host,$dbname,$user,$pass);
  $admin->connectDb();

  if ($_SESSION['Employee']['role'] == 0) {
    if ($_POST['status'] == 1) {
      $_POST['status'] = 0;
      $result = $admin->editStatus($_POST);
    }elseif ($_POST['status'] == 0) {
      $_POST['status'] = 1;
      $result = $admin->editStatus($_POST);
    }
    echo $result;
  }

} catch (\Exception $e) {
  print "エラー！！！:".$e->getMessage();
  // print($e->getMessage());
  die();
}

?>
