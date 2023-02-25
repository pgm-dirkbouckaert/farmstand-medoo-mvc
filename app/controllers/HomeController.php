<?php

class HomeController {

  private static $db;

  public static function __constructStatic() {
    require_once "app/config/config.php";
    require_once "app/models/Product.php";
    require_once "app/models/Category.php";
    require_once "app/models/Farm.php";
    self::$db = $db;
  }


  /**
   * Show home page
   *
   * @return void
   */
  public static function home() {
    // Get data
    $products = Product::all();
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/home.php");
    include("app/views/partials/end.php");
  }


  /**
   * Show 'my products'
   *
   * @return void
   */
  public static function myproducts() {
    checkLoggedIn();
    // Get data
    $products = Product::all();
    $myproducts = array_filter($products, function ($product) {
      return $product["user_id"] == $_SESSION["user"]["id"];
    });
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/products/myproducts.php");
    include("app/views/partials/end.php");
  }


  /**
   * Show 'my farms'
   *
   * @return void
   */
  public static function myfarms() {
    checkLoggedIn();
    // Get data
    $farms = Farm::all();
    $myfarms = array_filter($farms, function ($farm) {
      return $farm["user_id"] == $_SESSION["user"]["id"];
    });
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/farms/myfarms.php");
    include("app/views/partials/end.php");
  }
}

HomeController::__constructStatic();