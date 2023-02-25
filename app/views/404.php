<?php
require_once "app/config/config.php";
?>

<!-- HEAD -->
<?php include('partials/head.php') ?>

<!-- NAVBAR -->
<?php include('partials/navbar.php') ?>

<!-- CONTENT -->
<div class="row d-flex justify-content-center" id="divAlertContainer">

  <div class="col-10 col-md-8 col-lg-6 p-0" style="max-width: 400px;">
    <div class="alert alert-danger" role="alert" id="divAlert">
      Sorry, the requested page was not found.
    </div>
  </div>

</div>

<!-- SCRIPTS -->
<?php include('partials/scripts-bs5.php') ?>

<script>
document.querySelector("#nav-item-home").classList.add("active");
</script>

<!-- DOCUMENT END -->
<?php include('partials/end.php') ?>