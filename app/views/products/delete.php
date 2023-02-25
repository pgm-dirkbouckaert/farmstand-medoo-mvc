<?php
require_once  "app/config/config.php";
checkLoggedIn();

if ($_SERVER['REQUEST_METHOD']  == 'POST' && hash_equals($_SESSION['csrfToken'], $_POST['csrfToken'])) {

  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

  if ($id && $id !== "") {

    $db->delete("products", ["id" => $id]); //delete($table, $where);

    if (!$db->error) {
      redirect("/");
    } else {
      $html = '<div class= "container mt-3 mb-3">';
      $html .= '<div class="alert alert-danger" role="alert">';
      $html .= 'Error: ' . $db->errorInfo;
      $html .= '</div>';
      $html .= '</div>';
      echo ($html);
    }
  }

  // try {
  //   $db->delete("products", ["id" => $id]); //delete($table, $where);
  //   header("Location: index.php");
  // } catch (Exception $e) {
  //   $html = '<div class= "container mt-3">';
  //   $html .= '<div class="alert alert-danger" role="alert">';
  //   $html .= 'Error: ' . $e->getMessage();
  //   $html .= '</div>';
  //   $html .= '</div>';
  //   echo ($html);
  // }

}