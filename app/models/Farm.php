<?php

class Farm {

  private static $db;
  private static $table = "farms";

  public static function __constructStatic() {
    include("app/config/config.php");
    self::$db = $db;
  }

  public static function all() {
    return self::$db->select(self::$table, "*");
  }

  public static function find($id) {
    $where = array("id" => $id);
    return self::$db->select(self::$table, "*", $where);
  }

  public static function update($id, $values) {
    $where = array(
      "id" => $id
    );
    return self::$db->update(self::$table, $values, $where);
  }

  public static function insert($values) {
    self::$db->insert(self::$table, $values);
    if (self::$db->error) {
      unset($_SESSION['csrfToken']);
      echo ("Error: " . var_dump(self::$db->errorInfo));
    } else {
      return self::$db->id();
    }
  }

  public static function delete($id) {
    return self::$db->delete(self::$table, ["id" => $id]); //delete($table, $where);
  }
}

Farm::__constructStatic();