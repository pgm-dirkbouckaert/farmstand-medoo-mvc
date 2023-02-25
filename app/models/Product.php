<?php

class Product {

  private static $db;
  private static $table = "products";

  public static function __constructStatic() {
    include("app/config/config.php");
    self::$db = $db;
  }

  public static function all() {
    return self::$db->select(self::$table, "*");
  }

  public static function find($id) {

    $join = array(
      "[>]farms" => ["farm_id" => "id"],
      "[>]categories" => ["category_id" => "id"]
    );

    $columns = array(
      "products.id",
      "products.name",
      "products.price",
      "products.category_id",
      "products.user_id",
      "categories.id(category_id)",
      "categories.name(category_name)",
      "farms.id(farm_id)",
      "farms.name(farm_name)",
      "farms.city(farm_city)",
      "farms.email(farm_email)"
    );

    $where = array("products.id" => $id);

    return self::$db->select(self::$table, $join, $columns, $where);
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

Product::__constructStatic();