<?php
session_start();
require_once("../config/config.php");
require_once("../model/Review.php");
require_once("../model/Admin.php");

// print_r($_SESSION);
// ログアウト
if (isset($_GET['logout'])) {
  // セッション情報
  $_SESSION = array();
  session_destroy();
}

// ログイン画面を経由しているかどうかセッションで確認
if(!isset($_SESSION['Employee'])) {
  // リダイレクト
  header('Location: /review_system/employees/login.php');
  exit;// 後続の処理が続いてしまう
}

try {
  $review = new Review($host,$dbname,$user,$pass);
  $admin = new Admin($host,$dbname,$user,$pass);
  $review->connectDb();
  $admin->connectDb();
  // どのページでも必要
  if (isset($_SESSION['Employee'])) {
    $employees = $admin->findEmployee();// role=1の全従業員の名前とID
  }

  // POSTなし・検索All以外
  if ($_POST && $_POST['id'] !== "all") {
    $id_result = $review->findAllReviewById($_POST);// ID別にその人のレビュー一覧（公開/非公開関係なく）
  }else{
    $result = $review->findAll();
  }

} catch (\Exception $e) {
  print "エラー！！！:".$e->getMessage();
  // print($e->getMessage());
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
  <link rel="stylesheet" href="../css/admin.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
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
    <div class="container">

        <p>レビュー一覧</p>

        <!-- 従業員ごとに検索form -->
        <form  action="" method="post" style="text-align:left;margin-left:50px">
          <select name="id">
            <option value="all">All</option>
            <?php foreach ($employees as $employee): ?>
              <option value="<?php echo $employee['id'] ?>"><?php echo $employee['name'];?></option>
            <?php endforeach; ?>
          </select>
          <div class="button" style="display:inline">
            <button class="btn" type="submit">検索</button>
          </div>
        </form>
        <!-- 従業員ごとに検索form終わり -->

        <div class="container">
          <div class="">
            <table class="table table-wrapper-scroll-y scrollbar">


              <!-- テーブル表示条件分岐① -->
              <!-- すべてを表示する時-->
              <?php if ($_POST && $_POST['id'] == "all" || !$_POST):?>
                <?php foreach ($result as $row): ?>
                <tr style="vertical-align:middle">
                  <td style="width:20%;text-align:center;vertical-align:middle;border-right: 1px solid grey"><?php echo $row['user_name']; ?><br>
                    <span style="color:gold">
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
                    </td>
                    <td style="width:60%;text-align:left"><?php echo $row['title']; ?><br>
                      <?php echo $row['content']; ?><br>
                      <?php echo $row['stayed_at'] ?>
                    </td>

                    <td id="id_status button" class="button">
                      <button class="open-close-btn btn" type="button" name="button" value="<?php echo $row['id']?>">
                        <!-- 0.公開/1.非公開 -->
                        <?php
                        if($row['status'] == 1) {
                          echo "公開";
                        }elseif($row['status'] == 0){
                          echo "非公開";
                        }?>
                        <input type="hidden" id="status" value="<?php echo $row['status']?>">
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <!-- テーブル表示条件分岐①終わり -->


                <!-- テーブル表示条件分岐② -->
                <!-- ＄＿POST、個別の検索結果 -->
              <?php elseif($_POST && $_POST['id'] !== "all"):?>

                <?php foreach ($id_result as $row): ?>
                <tr style="vertical-align:middle">
                  <td style="width:20%;text-align:center;vertical-align:middle;border-right: 1px solid grey"><?php echo $row['user_name']; ?><br>
                    <span style="color:gold">
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
                    </td>
                    <td style="width:60%;text-align:left"><<?php echo $row['title']; ?>><br>
                      <?php echo $row['content']; ?><br>
                      <?php echo $row['stayed_at'] ?>
                    </td>

                    <td id="id_status button" class="button">
                      <button class="open-close-btn btn" type="button" name="button" value="<?php echo $row['id']?>">
                        <?php
                        if($row['status'] == 1) {
                          echo "公開";
                        }elseif($row['status'] == 0){
                          echo "非公開";
                        }?>
                        <input type="hidden" id="status" value="<?php echo $row['status']?>">
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              <!-- テーブル表示条件分岐②終わり -->
            </table>


          </div><!-- /.table -->
          <div class="button right mt-20">
            <a class="btn" href="admin.php">戻る</a>
          </div>
        </div><!-- /.container -->
      </div><!-- /.bg-mask -->
    </div><!-- /.container -->
  </main>
  <!-- フッター -->
  <footer>
    <p>Copyright © 2020</p>
  </footer>





  <script type="text/javascript" src="../js/jquery.js"></script>
  <script>
  // ================ajaxスタート============
  $(function(){
    $('.open-close-btn').on("click",function(){
      // id="status"の要素を取得
      const input1 = document.getElementById("status");
      const value1 = input1.value;
      // id="id"の要素を取得
      // const input2 = document.getElementById("id");
      // const value2 = input2.value;
      // コールバック関数内でthisが使えないから変数に定義する？
      // refers to the ajax request rather than the thing that issued the event.
      var element = this;
      console.log(value1);
      $.ajax({
        url : '../ajax/ajax.php',
        type: 'POST',
        // jsonというデータタイプでjs-php間をやり取りする利点は多く、例えばクロスサイトスクリプティングを防げる
        datatype: 'json',
        data:{
          'status' : value1,
          'id': $(this).val()
        }
      }).done(function(data){
        // var status = $(element).parents('#id_status').find('#status').val();
        // console.log(status);
        // もし１.非公開だったら、ajaxによってDBが０.非公開に更新されるので
        // id="status"のinput(hidden)の値を０に変更して表記も変える（非同期通信なので、html上の情報は変わらない為（状態の管理））
        // 0.公開/1.非公開

        if ($('#status').val() == 1) {
          $('#status').attr('value',0);
          $(element).html('非公開');
        }else if ($('#status').val() == 0) {
          $('#status').attr('value',1);
          $(element).html('公開');
        };
        alert('success!');
        // $(element).html($('#status').val());
      }).fail(function(data){
        alert('fail!');
      });
    });
  });
  </script>
  <!-- ================ajax終わり============ -->


</body>
</html>
