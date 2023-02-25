<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <h2>My Products</h2>

  <h6>Click on the product name to see details</h6>

  <?php
  // Check if there is a "notfound" message
  if (is_get_request() && count($_GET) > 0) {
    $msg = $_GET["msg"];
    if ($msg == "notfound") {
      flash("Requested product was not found", "alert-warning");
    }
  }

  // Show products
  foreach ($myproducts as $product) : ?>
  <a class="list-group-item" href="<?= URL ?>/show?id=<?= $product["id"] ?>"><?= $product["name"] ?> </a>
  <?php endforeach; ?>

  <?php if (count($myproducts) == 0) : ?>
  <div class="alert alert-danger" role="alert">
    No products found.
  </div>
  <?php endif; ?>

</div>


<!-- SCRIPTS -->
<?php include('partials/scripts-bs5.php') ?>

<script>
document.querySelector("#nav-item-myproducts").classList.add("active");
</script>