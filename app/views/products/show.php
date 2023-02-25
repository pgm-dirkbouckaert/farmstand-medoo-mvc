<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <?php if ($product) : ?>

  <h2><?= $product["name"] ?> </h2>
  <div class="list-group-item">Price: $<?= $product["price"] ?> </div>
  <div class="list-group-item">Category: <?= $product["category_name"] ?> </div>
  <div class="list-group-item">Farm: <?= $product["farm_name"] ?> (<?= $product["farm_city"] ?>) - <a
      href="mailto:<?= $product["farm_email"] ?>"><?= $product["farm_email"] ?></a> </div>

  <br>
  <form action="<?= URL ?>/delete" method="post">

    <?php if (isset_user()) : ?>
    <a href="<?= URL ?>/myproducts" class="btn btn-dark">Show My Products</a>
    <?php endif; ?>
    <a href="<?= URL ?>/" class="btn btn-primary">Show All Products</a>

    <?php if (isset_user() && ownsProduct($product)) : ?>

    <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>" />
    <!-- <input type="text" class="visually-hidden" name="id" value="<?= $product["id"] ?>"> -->
    <input type="hidden" name="id" value="<?= $product["id"] ?>">

    <a href="<?= URL ?>/edit?id=<?= $product['id'] ?>" class="btn btn-warning">Edit</a>
    <button type="button" class="btn btn-danger" id="btnDeleteShowModal">Delete</button>

    <div class="modal" tabindex="-1" id="modalDelete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this product?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" id="btnDelete">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <script>
    // Ask confirmation before deleting product submit input
    document.getElementById("btnDeleteShowModal").addEventListener("click", function() {
      const modalDelete = new bootstrap.Modal(document.getElementById('modalDelete'));
      modalDelete.show();
    });
    </script>

    <?php endif; ?>

  </form>

  <?php endif; ?>

</div>

<!-- SCRIPTS -->
<?php include('app/views/partials/scripts-bs5.php') ?>

<script>
// Add class 'active' to current menu item
document.querySelector("#nav-item-myproducts").classList.add("active");
</script>