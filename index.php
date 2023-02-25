<?php

require_once "app/config/config.php";
require_once "app/controllers/HomeController.php";
require_once "app/controllers/ProductController.php";
require_once "app/controllers/FarmController.php";
require_once "app/controllers/AuthController.php";
require_once "app/controllers/PasswordController.php";

$request = $_SERVER["REQUEST_URI"];

// To use the 'match' statement you need PHP v8+
//-----------------------------------------------
match ((string) explode("?", $request)[0]) {

  // HOME ROUTES  
  //------------
  // Home (all products)
  URL_SUB_FOLDER . ""               => HomeController::home(),
  URL_SUB_FOLDER . "/"              => HomeController::home(),
  URL_SUB_FOLDER . "/home"          => HomeController::home(),

  // My stuff
  URL_SUB_FOLDER . "/myproducts"    => HomeController::myproducts(),
  URL_SUB_FOLDER . "/myfarms"       => HomeController::myfarms(),

  // PRODUCTS ROUTES
  //----------------
  URL_SUB_FOLDER . "/show"          => ProductController::show(),
  URL_SUB_FOLDER . "/edit"          => ProductController::edit(),
  URL_SUB_FOLDER . "/update"        => ProductController::update(),
  URL_SUB_FOLDER . "/new"           => ProductController::new(),
  URL_SUB_FOLDER . "/store"         => ProductController::store(),
  URL_SUB_FOLDER . "/delete"        => ProductController::delete(),

  // FARM ROUTES
  //------------ 
  URL_SUB_FOLDER . "/farm-edit"     => FarmController::edit(),
  URL_SUB_FOLDER . "/farm-update"   => FarmController::update(),
  URL_SUB_FOLDER . "/farm-new"      => FarmController::new(),
  URL_SUB_FOLDER . "/farm-store"    => FarmController::store(),
  URL_SUB_FOLDER . "/farm-delete"   => FarmController::delete(),

  // AUTH ROUTES  
  // -----------
  URL_SUB_FOLDER . "/login"         => AuthController::showLoginForm(),
  URL_SUB_FOLDER . "/register"      => AuthController::showRegisterForm(),
  URL_SUB_FOLDER . "/logout"        => AuthController::logout(),
  URL_SUB_FOLDER . "/pw-forgot"     => PasswordController::showForgotPasswordForm(),
  URL_SUB_FOLDER . "/pw-reset"      => PasswordController::showPasswordResetForm(),
  URL_SUB_FOLDER . "/account"       => AuthController::showAccount(),

    // NOT FOUND
    // ---------
  default       =>  require __DIR__ . "/app/views/404.php",
};


// If you don't have PHP v8, you can use the 'switch' statement
//------------------------------------------------------------- 
// switch ($request) {

//     // HOME ROUTES  
//     //------------
//   case URL_SUB_FOLDER . "":
//     HomeController::home();
//     break;
//   case URL_SUB_FOLDER . "/":
//     HomeController::home();
//     break;
//   case strpos($request, "/home") == true:
//     HomeController::home();
//     break;
//   case URL_SUB_FOLDER . "/myproducts":
//     HomeController::myproducts();
//     break;
//   case URL_SUB_FOLDER . "/myfarms":
//     HomeController::myfarms();
//     break;

//     // PRODUCT ROUTES
//     // --------------
//     // Show
//   case strpos($request, "/show") == true:
//     ProductController::show();
//     break;
//     // Edit
//   case strpos($request, "/edit") == true:
//     ProductController::edit();
//     break;
//     // Update
//   case strpos($request, "/update") == true:
//     ProductController::update();
//     break;
//     // New
//   case strpos($request, "/new") == true:
//     ProductController::new();
//     break;
//   case strpos($request, "/store") == true:
//     ProductController::new();
//     break;
//     // Delete
//   case strpos($request, "/delete") == true:
//     ProductController::delete();
//     break;

//     //   // FARM ROUTES
//     //   //------------ 
//   case strpos($request, "/farm-edit") == true:
//     FarmController::edit();
//     break;
//   case strpos($request, "/farm-update") == true:
//     FarmController::update();
//     break;
//   case strpos($request, "/farm-new") == true:
//     FarmController::new();
//     break;
//   case strpos($request, "/farm-store") == true:
//     FarmController::store();
//     break;
//   case strpos($request, "/farm-delete") == true:
//     FarmController::delete();
//     break;

//     // AUTH ROUTES  
//     // -----------
//   case URL_SUB_FOLDER . "/login":
//     AuthController::showLoginForm();
//     break;
//   case URL_SUB_FOLDER . "/register":
//     AuthController::showRegisterForm();
//     break;
//   case URL_SUB_FOLDER . "/logout":
//     AuthController::logout();
//     break;
//   case URL_SUB_FOLDER . "/pw-forgot":
//     PasswordController::showForgotPasswordForm();
//     break;
//   case strpos($request, "/pw-reset") == true:
//     PasswordController::showPasswordResetForm();
//     break;
//   case URL_SUB_FOLDER . "/account":
//     AuthController::showAccount();
//     break;

//     // NOT FOUND
//   default:
//     http_response_code(404);
//     require __DIR__ . "/app/views/404.php";
//     break;
// }