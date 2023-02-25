<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <h2>Add a farm</h2>

  <form action="<?= URL ?>/farm-store" method="post" class="needs-validation" novalidate>

    <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>" />

    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" class="form-control" autofocus>

    <br>
    <label for="city" class="form-label">City</label>
    <input type="text" name="city" id="city" class="form-control">

    <br>
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control">

    <br>
    <button type="submit" class="btn btn-success">Add farm</button>
    <a href="<?= URL ?>/myfarms" class="btn btn-warning">Cancel</a>

  </form>


</div>

<!-- SCRIPTS -->
<?php include('app/views/partials/scripts-bs5.php') ?>
<?php include('app/views/partials/scripts-form-validate.php'); ?>

<script>
window.onload = () => {
  // Add class 'active' to current menu item
  document.querySelector("#nav-item-myfarms").classList.add("active");
}
</script>