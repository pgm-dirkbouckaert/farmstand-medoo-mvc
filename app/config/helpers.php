<?php

// General
//--------
function dd($data) {
  echo '<pre>';
  die(var_dump($data));
  echo '</pre>';
}

function flash($message, $class, $time = 3000) {
  echo '<script>
    const divAlertContainer = document.querySelector("#divAlertContainer");
    divAlertContainer.classList.toggle("d-none");
    const divAlert = document.querySelector("#divAlert");
    divAlert.classList.toggle("' . $class . '");
    divAlert.innerHTML = "' . $message . '";
    setTimeout(function() { divAlertContainer.classList.toggle("d-none");}, ' . $time . ');
    </script>';
}

function redirect($path) {
  // header("Location: " . $path . ".php");
  header("Location: " . URL . $path);
}

function redirectWithTimeout($path, $time = 2000) {
  // echo '<script> setTimeout(function() { window.location = "' . $path . '.php" }, ' . $time . '); </script>';
  echo '<script> setTimeout(function() { window.location = "' . URL . $path . '"  }, ' . $time . '); </script>';
}

// Forms
//------
function is_csrf_safe(): bool {
  return  hash_equals($_SESSION['csrfToken'], $_POST['csrfToken']);
}

function is_post_request(): bool {
  return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function is_get_request(): bool {
  return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

function repopulate($field) {
  if (isset($_POST[$field])) {
    echo htmlspecialchars($_POST[$field]);
  }
  if (isset($_GET[$field])) {
    echo htmlspecialchars($_GET[$field]);
  }
  if (isset($inputs[$field])) {
    echo htmlspecialchars($inputs[$field]);
  }
}

// Session
//--------
function isset_user() {
  return isset($_SESSION["user"]);
}

function is_admin() {
  return $_SESSION["user"]["is_admin"] == true;
}

function checkLoggedIn() {
  if (!isset($_SESSION["user"])) {
    // header("Location: index.php");
    redirect("/");
  }
}

function checkLoggedOut() {
  if (isset($_SESSION["user"])) {
    // header("Location: index.php");
    redirect("/");
  }
}

function ownsProduct($product) {
  return $_SESSION["user"]["id"] == $product["user_id"];
}

function ownsFarm($farm) {
  return $_SESSION["user"]["id"] == $farm["user_id"];
}

// Registration
//-------------
function registrationAllowed($email) {

  // Set url
  $base_url = "https://script.google.com/macros/s/AKfycbyH0yYrQg6LOE9dp30EF7d-cmBRir6hNd2_5r765TKb1cw1W3WT/exec";
  $url = $base_url . "?email=" . $email;

  // Initialize a curl session
  $curl = curl_init();

  // Set options for CURLOPT_URL
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

  // Execute the curl session
  $data = curl_exec($curl);

  // Close the curl session
  curl_close($curl);

  // Get json
  $json = json_decode($data, true);

  // Return isMember (boolean)
  return $json["isMember"];
}

function getResetPasswordHtml($resetlink) {
  return '
    <html>
    <head>
      <style>
        body {
          font-size: 16px;
          font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
      </style>
    </head>
    <body>
      <div>
        <a href="' . $resetlink . '" target="_blank">Click here to reset your password</a>
      </div>
    </body>
    </html>
  ';
}