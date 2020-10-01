<?php
require_once("DB.php");


class Room extends DB {
  // 参照（部屋番号一覧）
  public function findAll() {
    $sql = 'SELECT room_number FROM rooms';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  // 参照（部屋番号・日付から担当者の名前と写真のパス）
  public function findEmployee ($arr) {
    $sql = 'SELECT room_employee_history.stayed_at,room_employee_history.room_id,employees.name,employees.image FROM employees JOIN room_employee_history on room_employee_history.employee_id = employees.id WHERE room_id = :room_id AND stayed_at = :stayed_at';
    $stmt = $this->connect->prepare($sql);
    $params = array(':room_id'=>$arr['room'],':stayed_at'=>$arr['date']);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
}

?>
