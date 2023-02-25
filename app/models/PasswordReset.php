<?php

class PasswordReset {

  private static $db;
  private static $table = "password_reset";

  public static function __constructStatic() {
    include("app/config/config.php");
    self::$db = $db;
  }

  public static function getLastPasswordResetRequest($userId) {
    return self::$db->select(self::$table, "*", ["user_id" => $userId]); //$db->select($table, $columns, $where)
  }

  public static function updateResetRequest($userId, $values) {
    return self::$db->update(self::$table, $values, ["user_id" => $userId]); //$db->update($table, $values, $where);
  }

  public static function insertResetRequest($values) {
    return self::$db->insert(self::$table, $values); //$db->insert($table, $values);
  }
}

PasswordReset::__constructStatic();