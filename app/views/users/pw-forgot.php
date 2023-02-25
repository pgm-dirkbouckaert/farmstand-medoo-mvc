<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <div class="row d-flex justify-content-center">

    <div class="col-10 col-md-8 col-lg-6 mt-3 bg-white rounded shadow" style="max-width: 400px;">

      <h3 class="text-center mt-3 mb-3">Request a password reset link</h3>

      <p>Enter your email address to send the password link.</p>

      <form action="" method="post" class="needs-validation" novalidate>

        <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>" />

        <div class="mb-3">
          <input type="email" name="email" id="email" class="form-control" value="<?php repopulate('email') ?>" autofocus required>
        </div>

        <div class="d-grid gap-2 mt-5 mb-5">
          <button type="submit" class="btn btn-dark mb-2">Send link</button>
          <a href="<?= URL ?>/login" class="btn btn-outline-secondary">Cancel</a>
        </div>

      </form>

    </div>
  </div>
</div>

<?php
if (is_post_request() && is_csrf_safe()) {
  PasswordController::sendPassWordResetLink();
}
?>

<!-- SCRIPTS -->
<?php include('app/views/partials/scripts-bs5.php') ?>
<?php include('app/views/partials/scripts-form-validate.php'); ?>


<script>
document.querySelector("#nav-item-login").classList.add("active");
</script>