<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <div class="row d-flex justify-content-center">

    <div class="col-10 col-md-8 col-lg-6 mt-3 bg-white rounded shadow" style="max-width: 400px;">

      <h3 class="text-center mt-3 mb-3">Sign in to Farm Stand</h3>

      <form action="" method="post" class="needs-validation" novalidate>
        <!-- <form action="<?= URL ?>/handleLogin" method="post" class="needs-validation" novalidate> -->

        <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>" />

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" value="<?php repopulate('email') ?>" autofocus required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="d-grid gap-2 mt-5 mb-3">
          <button type="submit" class="btn btn-dark mb-2">Sign in</button>
          <a href="<?= URL ?>/register" class="btn btn-outline-secondary">New to Farm Stand? Create an account.</a>
        </div>

        <a href="<?= URL ?>/pw-forgot" class="float-end mb-4"><small>Forgot Password?</small></a>

      </form>
    </div>
  </div>
</div>

<?php
if (is_post_request() && is_csrf_safe()) {
  AuthController::handleLogin();
}
?>

<!-- SCRIPTS -->
<?php include("app/views/partials/scripts-bs5.php") ?>
<?php include("app/views/partials/scripts-form-validate.php"); ?>

<script>
document.querySelector("#nav-item-login").classList.add("active");
</script>