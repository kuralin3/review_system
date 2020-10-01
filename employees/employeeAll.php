<?php
session_start();
require_once("../config/config.php");
require_once("../model/Admin.php");
// print_r($_FILES);
// print_r($_POST);
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
// print_r($_FILES);
// 画像パスをimageディレクトリに移動する
if (!empty($_FILES)) {
  $tempfile = $_FILES['image']['tmp_name'];
  $fileName = $_FILES['image']['name'];
  if (is_uploaded_file($tempfile)) {
    if (move_uploaded_file($tempfile,"/Applications/MAMP/htdocs/review_system/image/$fileName")) {
    }
  }
}

// ==============================================================================================================
// バリデーションを作る
// ==============================================================================================================
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $name = htmlspecialchars($_POST["name"], ENT_QUOTES,'UTF-8');
//   $email = htmlspecialchars($_POST["email"], ENT_QUOTES,'UTF-8');
//   $password = htmlspecialchars($_POST["password"], ENT_QUOTES,'UTF-8');
// }
//
//
// if ($_POST) {
//   print_r($_POST);
// }
// if (preg_match('/([A-Za-z0-9])+([A-Za-z0-9\-._])*@([A-Za-z0-9-_])+([A-Za-z0-9\-._])/',$email) === 0) {
//   $err = "メールアドレスが正しくありません";
// }




try {
  $admin = new Admin($host,$dbname,$user,$pass);
  $admin->connectDb();


  // 編集処理（GET送信があったら）
  if (isset($_GET['edit'])) {
    // POST送信があったら（submitボタンを押した時）
    if ($_POST) {
      // input type="file"からデータが送信されたときは、それを引数に編集
      if($_FILES['image']['name'] !== ""){
        $admin->edit($_POST,$_FILES);
      }
      // ファイルが選択されていないときは、hiddenで送った$_POST['image']を使って更新する
      elseif ($_POST['image']) {
        // 一度代入して同じ関数で処理しようとしたけど、$_FILES['image']['name']と次元配列が違うので断念
        // $_FILES = $_POST['image'];
        $admin->editPost($_POST);
      }
    }
    // GET送信の情報を表示
    $result['employee'] = $admin->findById($_GET['edit']);
  }



  // 削除処理
  elseif (isset($_GET['del'])) {
    $admin->delete($_GET['del']);
    // 削除したあとに削除クエリを消すためにヘッダー関数で移動
    header('Location: /review_system/employees/employeeAll.php');
    $result = $admin->findSelectEmployees();
  }
  // 登録処理
  else {
    if ($_POST) {
      // 空じゃなかったら
      if (!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['email']) ) {
        $admin->add($_POST,$_FILES);// 引数にPOSTとFILES
      }else{
        $err = "入力してください";
        echo $err;
      }
    }
    $result = $admin->findSelectEmployees();
  }


  // if ($_FILES['image']['name']) {
  //   $image = $admin->addImage($_FILES);
  //   print_r($image);
  // }

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
  <link rel="stylesheet" href="../css/employeeAll.css">
  <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
  <title></title>
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script>

  $(function(){
    $('#show-popup').click(function(){
      // $('.modal').fadeIn();
      $('#add-modal').fadeIn();
    });

    $('.close-btn').click(function(){
      $('#add-modal').fadeOut();
    });


    // $("#submit-btn").on('click', function(){
    //   if ($("input[name='name']").val() == '') {
    //     alert('名前を入力してください');
    //     // returnしないと次の画面に進む
    //     return false;
    //   }else if ($("input[name='email']").val() == '') {
    //     alert('メールアドレスを入力してください');
    //     // returnしないと次の画面に進む
    //     return false;
    //   }else if ($("input[name='password']").val() == '') {
    //     alert('パスワードを入力してください');
    //     // returnしないと次の画面に進む
    //     return false;
    //   }
    //
    // });
  });

  </script>
</head>
<body>
  <header>
    <div id="title">
      <a href="../users/user.php">Review Me</a>
      <div class="right">
        <a class="logout" href="?logout=1">ログアウト</a>
      </div>
    </div>
  </header>
  <main>
    <!-- 編集画面 -->
    <?php if (isset($_GET['edit'])):?>
      <div class="bg-mask">
        <div class="container">
          <div id="wrapper">
            <div>
              <form action="" method="post" enctype="multipart/form-data">
                <table class="table">
                  <tr>
                    <th></th><th>ID</th><th>名前</th><th>email</th><th>パスワード</th>
                  </tr>
                  <?php foreach ($result as $row): ?>
                    <tr>
                      <td style="width:100px"><img src="../image/<?php echo $row['image']?>"></td>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['password'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <tr style="height:80px">
                    <!-- セルの結合 -->
                    <td colspan="2"><input type="file" name="image"></td>
                    <input type="hidden" name="image" value="<?php echo $result['employee']['image'] ?>">
                    <input type="hidden" name="id" value="<?php echo $result['employee']['id'] ?>">
                    <td><input type="text" name="name" value="<?php echo $result['employee']['name']?>"></td>
                    <td><input type="email" name="email" value="<?php echo $result['employee']['email']?>"></td>
                    <td><input type="password" name="password" value="<?php echo $result['employee']['password']?>"></td>
                  </tr>
                </table>
                <div class="button right mt-20">
                  <input type="submit" class="btn" value="変更" onclick='return confirm("よろしいですか？");'>
                  <!-- <a class="btn" href="admin.php">戻る</a> -->
                </div>
              </form>
              <div class="button right mt-20">
                <a class="btn" href="employeeAll.php">戻る</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 編集画面終わり -->
      <!-- 従業員一覧画面 -->
    <?php else: ?>
      <div class="bg-mask">
        <p>従業員一覧</p>
        <div class="container">

          <!-- ==============================モーダル========================================== -->
          <!-- Bootstarpを編集するために外にdivを作って編集出来るようにする -->
          <div id="button" class="button">
            <!-- class="btn"はBootstrap -->
            <button id="show-popup" class="btn">新規登録</button>
          </div>

          <div class="add-modal-wrapper" id="add-modal">
            <div class="inner">
              <div class="close-btn">
                <i class="fa fa-2x fa-times"></i>
              </div>

              <div id="add-form">
                <form action="" method="post" enctype="multipart/form-data">
                  <label>名前:<input type="text" name="name" value="" required></label>
                  <p><?php if (isset($err))echo $err; ?></p>
                  <label>メールアドレス:<input type="email" name="email" value="" required></label>
                  <label>パスワード:<input type="password" name="password" value="" required></label>
                  <input type="hidden" name="id" value="<?php if(isset($result['User']))echo $result['User']['id']?>">
                  <label>写真:<input type="file" name="image"></label>
                  <input id="submit-btn" type="submit" value="完 了">
                </form>
              </div>
            </div>
          </div>
          <!-- ==============================モーダル終わり========================================== -->

          <!-- table変更の為のwrapper -->
          <div id="wrapper" class="table">
            <div >
              <table class="table-wrapper-scroll-y scrollbar">
                <tr>
                  <th></th><th>ID</th><th>名前</th><th>総獲得数</th><th>平均レビュー</th><th></th><th></th>
                </tr>
                <?php foreach ($result as $row): ?>
                  <tr>
                    <td style="width:10%"><img src="../image/<?php echo $row['image']; ?>"></td>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['total'] ?>件</td>
                    <td><span class="star">★</span><?php if(isset($row['average'])){echo $row['average'];}else{echo 0;}?></td>
                    <td style="width:100px">
                      <div class="button-table">
                        <a class="btn" href="?del=<?php echo $row['id']?>" onclick="if(!confirm('<?php echo $row['id']?>:<?php echo $row['name']?>さんを削除しますか？')) return false;">削 除</a>
                        </div>
                      </td>
                      <td style="width:100px">
                        <div class="button-table">
                          <a class="btn" href="?edit=<?php echo $row['id']?>">編 集</a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </table>

              </div>
            </div>
            <div class="button right mt-20">
              <a class="btn" href="admin.php">戻る</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>
<!-- 一覧画面終わり -->
</main>
<footer>
  <p>Copyright © 2020</p>
</footer>
</body>
</html>
