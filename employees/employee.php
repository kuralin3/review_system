<?php
// ログインだけでOK？
require_once("DB.php");

class Emp extends DB {
  // ログイン
  public function login($arr) {
    $sql = 'SELECT * FROM employees WHERE email = :email AND password = :password';
    $stmt = $this->connect->prepare($sql);
    $params = array(':email'=>$arr['email'],':password' =>$arr['password']);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  // ハッシュ化のやつ
  // public function login($arr,$hash) {
  //   $sql = 'SELECT * FROM employees WHERE email = :email AND password = :password';
  //   $stmt = $this->connect->prepare($sql);
  //   $params = array(':email'=>$arr['email'],':password' =>$hash);
  //   $stmt->execute($params);
  //   $result = $stmt->fetch();
  //   return $result;
  // }

  // // role=1の全従業員のデータ参照
  // public function findAll() {
  //   $sql = 'SELECT * from employees WHERE role = 1';
  //   $stmt = $this->connect->prepare($sql);
  //   $stmt->execute();
  //   $result = $stmt->fetchAll();
  //   return $result;
  // }
  // // 編集
  // public function edit($arr) {
  //   $sql = "UPDATE employees SET name = :name, email = :email, average_point = :average_point, total = :total WHERE id = :id";
  //   $stmt = $this->connect->prepare($sql);
  //   $params = array(
  //     ':id'=>$arr['id'],
  //     ':name'=>$arr['name'],
  //     ':email'=>$arr['email'],
  //     ':average_point'=>$arr['average_point'],
  //     ':total'=>$arr['total'],
  //   );
  //   $stmt->execute($params);
  // }
  // // 参照 （条件付き）
  // public function findById($id) {
  //   $sql= 'SELECT * FROM employees WHERE id = :id';
  //   $stmt = $this->connect->prepare($sql);
  //   $params = array(':id'=>$id);
  //   $stmt->execute($params);
  //   $result = $stmt->fetch();// PDO::FETCH_ASSOC
  //   return $result;
  // }
  // // 削除
  // public function delete($id) {
  //   if (isset($id)) {
  //     $sql = 'DELETE FROM employees WHERE id = :id';
  //     $stmt= $this->connect->prepare($sql);
  //     $params= array(':id'=>$id);
  //     $stmt->execute($params);
  //   }
  // }
  // // 登録 insert
  // public function add($arr) {
  //   // print_r($arr);
  //   $sql = "INSERT INTO employees(name,password,email,role,created_at)VALUES(:name,:password,:email,:role,:created_at)";
  //   $stmt = $this->connect->prepare($sql);
  //   // :user_namとか代用してるものに再代入するための配列
  //   $params = array(
  //     ':name'=>$arr['name'],
  //     ':password'=>$arr['password'],
  //     ':email'=>$arr['email'],
  //     ':role'=>1,
  //     ':created_at'=>date('Y-m-d H:i:s')
  //   );
  //   $stmt->execute($params);
  // }

  // 画像パスの登録
  // これだとテーブルemployeesでNOT NULLのカラムが入力されないから登録できない!

  // public function addImage($arr) {
  //   // print_r($arr);
  //   $sql = "INSERT INTO employees(image)VALUES(:image)";
  //   $stmt = $this->connect->prepare($sql);
  //   $params = array(':image'=>$arr['image']['name']);
  //   $stmt->execute($params);
  // }
}
