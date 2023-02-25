<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PasswordController {

  private static $db;

  public static function __constructStatic() {
    require_once "app/config/config.php";
    require_once "app/models/User.php";
    require_once "app/models/PasswordReset.php";
    self::$db = $db;
  }

  /**
   * Show forgot password form
   *
   * @return void
   */
  public static function showForgotPasswordForm() {
    checkLoggedOut();
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/users/pw-forgot.php");
    include("app/views/partials/end.php");
  }


  /**
   * Send password reset link
   *
   * @return void
   */
  public static function sendPassWordResetLink() {

    // GET EMAIL & USER
    // ----------------
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $user = User::findByEmail($email);

    if (count($user) == 0) {
      flash("Sorry, you are not registered.", "alert-warning");
      return;
    } else {
      $user = $user[0];
    }

    // CHECK PREVIOUS REQUEST (PREVENT SPAM)
    // -------------------------------------
    $userId = $user["id"];
    $previous = PasswordReset::getLastPasswordResetRequest($userId);
    $now = strtotime("now");
    if (count($previous) != 0) {
      $previous = $previous[0];
      $expire = strtotime($previous["reset_time"]) + 300; // Password reset is valid for 300 seconds
      if ($now < $expire) {
        flash("Please try again later", "alert-warning", 5000);
        return;
      }
    }

    // CREATE NEW REQUEST
    // ------------------
    $hash = md5($user["email"] . $now); // random hash
    $values = array(
      "user_id"  => $user["id"],
      "reset_hash"  => $hash,
      "reset_time"  => date("Y-m-d H:i:s"),
    );
    $updateResetRequest = PasswordReset::updateResetRequest($userId, $values);
    if ($updateResetRequest->rowCount() == 0) {
      PasswordReset::insertResetRequest($values);
    }

    // Flash database errors
    if (self::$db->error) {
      flash("Database error", "alert-danger");
      return;
    }

    // SEND EMAIL - PHP MAILER + mailtrap
    //-----------------------------------
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = MAILTRAP_USERNAME;
    $phpmailer->Password = MAILTRAP_PASSWORD;

    $phpmailer->setFrom('info@farmstand.com', 'Farm Stand');
    $phpmailer->addReplyTo('info@farmstand.com', 'Farm Stand');
    $phpmailer->addAddress($user["email"], $user["username"]);
    $phpmailer->Subject = 'Farm Stand Password Reset';
    $phpmailer->isHTML(true);
    $resetlink = "http:" . URL . "user-pw-reset.php?i=" . $user["id"] . "&h=" . $hash;
    $htmlBody = getResetPasswordHtml($resetlink);
    $phpmailer->Body = $htmlBody;

    if ($phpmailer->send()) {
      flash("If you are registered with us, you will receive an email.", "alert-success", 5000);
      redirectWithTimeout("index", 5000);
    } else {
      flash("Message could not be sent!", "alert-danger", 5000);
      echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
    }
  }


  /**
   * Show password reset form
   *
   * @return void
   */
  public static function showPasswordResetForm() {
    checkLoggedOut();
    // Show content
    include("app/views/partials/head.php");
    include("app/views/partials/navbar.php");
    include("app/views/users/pw-reset.php");
    include("app/views/partials/end.php");
  }


  /**
   * Get email from requeset
   *
   * @return void
   */
  public static function getEmailFromRequest() {
    $userId = filter_var($_GET["i"], FILTER_SANITIZE_NUMBER_INT);
    $user = User::findById($userId);
    if (count($user) > 0) {
      $user = $user[0];
      return $user['email'];
    }
  }


  /**
   * Check reset request
   *
   * @return void
   */
  public static function checkResetRequest() {

    // Get request in DB
    $userId = filter_var($_GET["i"], FILTER_SANITIZE_NUMBER_INT);
    $hash = $_GET["h"];
    $requestInDB = PasswordReset::getLastPasswordResetRequest($userId);
    if (count($requestInDB) == 0) {
      flash("Invalid request", "alert-warning");
      redirectWithTimeout("/", 2000);
      return;
    }
    $requestInDB = $requestInDB[0];

    // Check validity
    if ($requestInDB["reset_hash"] != $hash) {
      flash("Invalid request", "alert-warning");
      redirectWithTimeout("/", 2000);
      return;
    }

    // Check expired
    $now = strtotime("now");
    $expire = strtotime($requestInDB["reset_time"]) + 300; // Password reset is valid for 300 seconds
    if ($now >= $expire) {
      flash("Request expired", "alert-warning");
      redirectWithTimeout("/", 2000);
      return;
    }
  }


  /**
   * Reset password
   *
   * @return void
   */
  public static function resetPassword() {

    // Confirm password match
    // -------------------------
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    if ($password != $password_confirm) {
      flash("Passwords do not match", "alert-danger");
      return;
    }

    // Get user from database
    // ----------------------
    if (!isset_user()) {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $user = User::findByEmail($email);
      if (count($user) == 0) {
        flash("Sorry, something went wrong.", "alert-danger");
        return;
      }
      $user = $user[0];
    } else {
      $user = $_SESSION['user'];
    }

    // Write new password to database
    //-------------------------------
    $values = array(
      "password"  => password_hash($password, PASSWORD_DEFAULT)
    );
    $update = User::update($user["id"], $values);

    // Flash error
    // -----------
    if ($update->rowCount() == 0) {
      flash("Sorry, something went wrong.", "alert-danger");
      return;
    }

    // Flash success & redirect
    // ------------------------
    flash("Your password was reset", "alert-success");
    redirectWithTimeout("/login", 2000);
  }
}

PasswordController::__constructStatic();
