<?php

class FarmController {

  private static $db;

  public static function __constructStatic() {
    require_once "app/config/config.php";
    require_once "app/models/Farm.php";
    self::$db = $db;
  }


  /**
   * Show edit page
   *
   * @return void
   */
  public static function edit() {

    checkLoggedIn();

    // Get data
    $farmId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $farm = Farm::find($farmId);

    if (count($farm) == 0) {
      if (isset_user()) {
        redirect("/myfarms?msg=notfound", 3000);
        return;
      } else {
        redirect("/home?msg=notfound", 3000);
        return;
      }
    } else if (count($farm) > 0) {
      $farm = $farm[0];
      // Gebruiker mag enkel zijn eigen producten bewerken
      if (!ownsFarm($farm) && isset_user()) {
        redirect("/myfarms");
      } elseif (!ownsFarm($farm) && !isset_user()) {
        redirect("/");
      }
    }

    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/farms/edit.php");
    include("app/views/partials/end.php");
  }


  /**
   * Update
   *
   * @return void
   */
  public static function update() {

    checkLoggedIn();

    // Handle form submit
    if (is_post_request() && is_csrf_safe()) {

      $farmId = filter_var($_POST['farmId'], FILTER_SANITIZE_NUMBER_INT);
      $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

      $values = array(
        "name"      => $name,
        "city"      => $city,
        "email"     => $email,
      );
      // dd($values);
      Farm::update($farmId, $values);

      if (!self::$db->error) {
        unset($_SESSION['csrfToken']);
        redirect("/myfarms");
      } else {
        unset($_SESSION['csrfToken']);
        echo ("Error: " . self::$db->errorInfo);
      }
    }
  }


  /**
   * Show page to add a new farm
   *
   * @return void
   */
  public static function new() {
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/farms/new.php");
    include("app/views/partials/end.php");
  }


  /**
   * Save the new farm
   *
   * @return void
   */
  public static function store() {

    checkLoggedIn();

    // Handle form submit
    if (is_post_request() && is_csrf_safe()) {

      $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

      $values = array(
        "name"      => $name,
        "city"      => $city,
        "email"     => $email,
        "user_id"   => $_SESSION["user"]["id"]
      );
      $newFarmId = Farm::insert($values);
      // dd($newFarmId);

      if ($newFarmId) {
        unset($_SESSION['csrfToken']);
        redirect("/myfarms");
      } else {
        unset($_SESSION['csrfToken']);
        echo ("Error: " . var_dump(self::$db->errorInfo));
      }
    }
  }


  /**
   * Delete a farm
   *
   * @return void
   */
  public static function delete() {

    checkLoggedIn();

    if (is_post_request() && is_csrf_safe()) {

      $farmId = filter_var($_POST['farmId'], FILTER_SANITIZE_NUMBER_INT);

      if ($farmId && $farmId !== "") {

        Farm::delete($farmId);

        if (!self::$db->error) {
          redirect("/myfarms");
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

FarmController::__constructStatic();
