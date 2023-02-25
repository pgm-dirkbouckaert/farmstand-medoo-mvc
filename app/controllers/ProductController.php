<?php

class ProductController {

  private static $db;

  public static function __constructStatic() {
    require_once "app/config/config.php";
    require_once "app/models/Product.php";
    require_once "app/models/Category.php";
    require_once "app/models/Farm.php";
    self::$db = $db;
  }


  /**
   * Show product page
   *
   * @return void
   */
  public static function show() {
    // Get data
    $productId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $product = Product::find($productId);
    if (count($product) == 0) {
      redirect("/home?msg=notfound");
    } else if (count($product) > 0) {
      $product = $product[0];
    }
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/products/show.php");
    include("app/views/partials/end.php");
  }


  /**
   * Show edit page
   *
   * @return void
   */
  public static function edit() {

    checkLoggedIn();

    // Get data
    $farms = Farm::all();
    $categories = Category::all();
    $productId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $product = Product::find($productId);

    if (count($product) == 0) {
      if (isset_user()) {
        redirect("/myproducts?msg=notfound", 3000);
        return;
      } else {
        redirect("/home?msg=notfound", 3000);
        return;
      }
    } else if (count($product) > 0) {
      $product = $product[0];
      // Gebruiker mag enkel zijn eigen producten bewerken
      if (!ownsProduct($product) && isset_user()) {
        redirect("/myproducts");
      } elseif (!ownsProduct($product) && !isset_user()) {
        redirect("/");
      }
    }

    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/products/edit.php");
    include("app/views/partials/end.php");
  }


  /**
   * Update a product
   *
   * @return void
   */
  public static function update() {

    checkLoggedIn();

    // Handle form submit
    if (is_post_request() && is_csrf_safe()) {

      $productId = filter_var($_POST['productId'], FILTER_SANITIZE_NUMBER_INT);
      $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT);
      $category_id = filter_input(INPUT_POST, "category_id", FILTER_SANITIZE_NUMBER_INT);
      $farm_id = filter_input(INPUT_POST, "farm_id", FILTER_SANITIZE_NUMBER_INT);

      $values = array(
        "name"          => $name,
        "price"         => $price,
        "category_id"   => $category_id,
        "farm_id"       => $farm_id
      );
      Product::update($productId, $values);

      if (!self::$db->error) {
        unset($_SESSION['csrfToken']);
        redirect("/show?id=" . $productId);
      } else {
        unset($_SESSION['csrfToken']);
        echo ("Error: " . self::$db->errorInfo);
      }
    }
  }


  /**
   * Show page to add a new product
   *
   * @return void
   */
  public static function new() {

    checkLoggedIn();

    // Get data
    $farms = Farm::all();
    $categories = Category::all();

    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/products/new.php");
    include("app/views/partials/end.php");
  }


  /**
   * Save the new product
   *
   * @return void
   */
  public static function store() {

    checkLoggedIn();

    // Handle form submit
    if (is_post_request() && is_csrf_safe()) {

      $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT);
      $category_id = filter_input(INPUT_POST, "category_id", FILTER_SANITIZE_NUMBER_INT);
      $farm_id = filter_input(INPUT_POST, "farm_id", FILTER_SANITIZE_NUMBER_INT);

      $values = array(
        "name"          => $name,
        "price"         => $price,
        "category_id"   => $category_id,
        "farm_id"       => $farm_id,
        "user_id"       => $_SESSION["user"]["id"]
      );
      $newProductId = Product::insert($values);
      // dd($newProductId);

      if ($newProductId) {
        unset($_SESSION['csrfToken']);
        redirect("/show?id=" . $newProductId);
      } else {
        unset($_SESSION['csrfToken']);
        echo ("Error: " . var_dump(self::$db->errorInfo));
      }
    }
  }


  /**
   * Delete a product
   *
   * @return void
   */
  public static function delete() {

    checkLoggedIn();

    if (is_post_request() && is_csrf_safe()) {

      $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
      // dd($id);

      if ($id && $id !== "") {

        Product::delete($id);

        if (!self::$db->error) {
          if (isset_user()) {
            redirect("/myproducts");
            return;
          } else {
            redirect("/");
            return;
          }
        } else {
          $html = '<div class= "container mt-3 mb-3">';
          $html .= '<div class="alert alert-danger" role="alert">';
          $html .= 'Error: ' . self::$db->errorInfo;
          $html .= '</div>';
          $html .= '</div>';
          echo ($html);
        }
      }
    }
  }
}

ProductController::__constructStatic();
