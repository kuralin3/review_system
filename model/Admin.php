<?php
require_once("DB.php");

class Admin extends DB {

  // role=1の全従業員のデータ参照
  public function findAll() {
    $sql = 'SELECT * from employees WHERE role = 1';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // -------------------------------------------------------------------------------------------------------------------
  // CRUD処理＋写真
  // -------------------------------------------------------------------------------------------------------------------

  // 編集
  public function edit($arr,$img) {
    $sql = "UPDATE employees SET name = :name, email = :email, password = :password ,image =:image WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id'=>$arr['id'],
      ':name'=>$arr['name'],
      ':email'=>$arr['email'],
      ':password'=>$arr['password'],
      ':image'=>$img['image']['name']
    );
    $stmt->execute($params);
  }
  // 編集（引数POSTだけ）
  public function editPost($arr) {
    $sql = "UPDATE employees SET name = :name, email = :email, password = :password ,image =:image WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id'=>$arr['id'],
      ':name'=>$arr['name'],
      ':email'=>$arr['email'],
      ':password'=>$arr['password'],
      ':image'=>$arr['image']
    );
    $stmt->execute($params);
  }
  // 参照 （条件付き）
  public function findById($id) {
    $sql= 'SELECT * FROM employees WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  // 削除
  public function delete($id) {
    if (isset($id)) {
      $sql = 'DELETE FROM employees WHERE id = :id';
      $stmt= $this->connect->prepare($sql);
      $params= array(':id'=>$id);
      $stmt->execute($params);
    }
  }
  // 登録 insert
  public function add($arr,$img) {
    $sql = "INSERT INTO employees(name,password,image,email,role,created_at)VALUES(:name,:password,:image,:email,:role,:created_at)";
    $stmt = $this->connect->prepare($sql);
    // :user_namとか代用してるものに再代入するための配列
    $params = array(
      ':name'=>$arr['name'],
      ':password'=>$arr['password'],
      // ':password'=>md5($arr['password']),ハッシュ
      ':image'=>$img['image']['name'],
      ':email'=>$arr['email'],
      ':role'=>1,
      ':created_at'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }

  // 画像パスの登録
  public function addImage($arr) {
    // print_r($arr);
    $sql = "INSERT INTO employees(image)VALUES(:image)";
    $stmt = $this->connect->prepare($sql);
    $params = array(':image'=>$arr['image']['name']);
    $stmt->execute($params);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  // レビューの平均点
  public function averageStar($arr) {
    $sql = "SELECT ROUND(AVG(star),0) AS average
            FROM reviews
            JOIN room_employee_history
            ON room_employee_history.room_id = reviews.room AND room_employee_history.stayed_at = reviews.stayed_at
            WHERE employee_id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$arr['Employee']['id']);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }


  // -------------------------------------------------------------------------------------------------------------------
  // admin.phpで使う
  // -------------------------------------------------------------------------------------------------------------------

  // 最新のレビュー5件まで
  public function findFive() {
    $sql = 'SELECT * FROM reviews ORDER BY created_at DESC LIMIT 5';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  //role=1の名前、ID、獲得数、レビュー平均点の一覧
  public function findSelect() {
    $sql = "SELECT employees.name,employees.image,employees.id,COUNT(star) AS total,ROUND(AVG(star),1) AS average
            FROM employees
            LEFT JOIN room_employee_history
            ON employees.id = room_employee_history.employee_id
            LEFT JOIN reviews
            ON reviews.room = room_employee_history.room_id
            AND reviews.stayed_at = room_employee_history.stayed_at
            WHERE role =1 AND status = 0
            GROUP BY id";
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  //role=1の名前、ID、獲得数、レビュー平均点の一覧
  public function findSelectEmployees() {
    $sql = "SELECT employees.name,employees.image,employees.id,COUNT(star) AS total,ROUND(AVG(star),1) AS average
            FROM employees
            LEFT JOIN room_employee_history
            ON employees.id = room_employee_history.employee_id
            LEFT JOIN reviews
            ON reviews.room = room_employee_history.room_id
            AND reviews.stayed_at = room_employee_history.stayed_at
            WHERE role =1
            GROUP BY id";
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  // -------------------------------------------------------------------------------------------------------------------
  // reviewAll.phpで使う(ajax)
  // -------------------------------------------------------------------------------------------------------------------

  // 編集
  public function editStatus($arr) {
    $sql = "UPDATE reviews SET status = :status WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':status'=>$arr['status'],':id'=>$arr['id']);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  // role=1の全従業員の名前データ参照
  public function findEmployee() {
    $sql = 'SELECT name,id from employees WHERE role = 1';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

}
?>
