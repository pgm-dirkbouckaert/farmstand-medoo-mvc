<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <div class="row d-flex justify-content-center">

    <div class="col-10 col-md-8 col-lg-6 mt-3 bg-white rounded shadow" style="max-width: 400px;">

      <h3 class="text-center mt-3 mb-3">Reset your password</h3>

      <form action="" method="post" class="needs-validation" novalidate>

        <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>" />

        <div class="mb-3">
          <label for="password" class="form-label">New Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password_confirm" class="form-label">Confirm Password</label>
          <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
        </div>

        <div class="d-grid gap-2 mb-5">
          <button type="submit" name="btnResetPassword" class="btn btn-dark mb-2">Submit</button>
          <a href="<?= URL ?>/" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>

    </div>
  </div>
</div>

<?php
if (is_post_request() && is_csrf_safe()) {
  PasswordController::resetPassword();
}
?>

<!-- SCRIPTS -->
<?php include('app/views/partials/scripts-bs5.php') ?>
<?php include('app/views/partials/scripts-form-validate.php'); ?>

<script>
document.querySelector("#nav-item-account").classList.add("active");
</script>

<!-- DOCUMENT END -->
<?php include('app/views/partials/end.php') ?>