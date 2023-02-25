<?php

class AuthController {

  private static $db;

  public static function __constructStatic() {
    require_once "app/config/config.php";
    require_once "app/models/User.php";
    self::$db = $db;
  }


  /**
   * Show login form
   *
   * @return void
   */
  public static function showLoginForm() {
    checkLoggedOut();
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/users/login.php");
    include("app/views/partials/end.php");
  }


  /**
   * Handle login
   *
   * @return void
   */
  public static function handleLogin() {

    checkLoggedOut();

    // Sanitize & Validate
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if ($email == false || $email == NULL || $email == "") {
      flash("Incorrect email or password!", "alert-danger");
      return;
    }

    // Proceed if sanitized and validated
    $user = User::findByEmail($email);

    if (count($user) > 0) {
      $user = $user[0];
      $hash = $user['password'];
      if (password_verify($password, $hash)) {
        $_SESSION['user'] = $user;
        unset($_SESSION['csrfToken']);
        redirect("/");
      } else {
        flash("Incorrect email or password!", "alert-danger");
      }
    } else {
      flash("Incorrect email or password!", "alert-danger");
    }
  }


  /**
   * Show register form
   *
   * @return void
   */
  public static function showRegisterForm() {
    checkLoggedOut();
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/users/register.php");
    include("app/views/partials/end.php");
  }


  /**
   * Handle registration
   *
   * @return void
   */
  public static function handleRegistration() {

    checkLoggedOut();

    // Sanitize & Validate
    // -------------------
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if ($username == false || $username == NULL || $username == "" || $email == false || $email == NULL || $email == "") {
      flash("Incorrect username, email or password!", "alert-danger");
      return;
    }

    // Set minimum password length
    // ---------------------------
    if (strlen($password) < 8) {
      flash("Password must be at least 8 characters.", "alert-danger");
      return;
    }

    // Proceed if sanitized and validated
    // ----------------------------------
    $user = User::findByEmail($email);
    if (count($user) > 0) {
      flash("Sorry, email or username are already taken!", "alert-danger");
      return;
    } else {
      $values = array(
        "username"  => $username,
        "email"     => $email,
        "password"  => password_hash($password, PASSWORD_DEFAULT)
      );
      $userId = User::insert($values);

      if ($userId) {
        $user = User::findById($userId)[0];
        $_SESSION['user'] = $user;
        unset($_SESSION['csrfToken']);
        redirect("/");
      } else {
        flash("Database error", "alert-danger");
      }
    }
  }


  /**
   * Show page with user account
   *
   * @return void
   */
  public static function showAccount() {
    checkLoggedIn();
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/users/account.php");
    include("app/views/partials/end.php");
  }


  /**
   * Logout
   *
   * @return void
   */
  public static function logout() {
    checkLoggedIn();
    if (!session_id()) @session_start();
    session_unset();
    session_destroy();
    redirect("/");
  }
}

AuthController::__constructStatic();
