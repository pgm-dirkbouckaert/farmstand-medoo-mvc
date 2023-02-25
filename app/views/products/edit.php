<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <h2>Edit: <?= $product["name"] ?> </h2>

  <form action="<?= URL ?>/update?id=<?= $product["id"] ?>" method="post">

    <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>" />
    <input type="hidden" id="catID" value="<?= $product['category_id']; ?>" />
    <input type="hidden" id="farmID" value="<?= $product['farm_id']; ?>" />
    <input type="hidden" name="productId" value="<?= $product['id']; ?>" />

    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="<?= $product["name"] ?>">

    <br>
    <label for="price" class="form-label">Price</label>
    <input type="number" name="price" id="price" class="form-control" min="0" step="0.1" value="<?= $product["price"] ?>">

    <br>
    <label for="category_id" class="form-label">Category</label>
    <select name="category_id" id="category_id" class="form-select">
      <option value="">--</option>
      <?php foreach ($categories as $category) { ?>
      <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
      <?php } ?>
    </select>

    <br>
    <label for="farm" class="form-label">Farm</label>
    <select name="farm_id" id="farm_id" class="form-select">
      <?php foreach ($farms as $farm) : ?>
      <?php if (ownsFarm($farm)) : ?>
      <option value="<?= $farm["id"] ?>"><?= $farm["name"] ?> (<?= $farm["city"] ?>)</option>
      <?php endif; ?>
      <?php endforeach; ?>
    </select>

    <br>
    <button type="submit" class="btn btn-danger">Update</button>
    <a href="<?= URL ?>/show?id=<?= $productId ?>" class="btn btn-warning">Cancel</a>

  </form>


</div>

<!-- SCRIPTS -->
<?php include('app/views/partials/scripts-bs5.php') ?>
<?php include('app/views/partials/scripts-form-validate.php'); ?>

<script>
window.onload = () => {
  // Set category select value
  const catID = document.getElementById("catID").value;
  const elCategory = document.getElementById("category_id");
  elCategory.value = catID;
  // Set farm select value
  const farmID = document.getElementById("farmID").value;
  const elFarm = document.getElementById("farm_id");
  elFarm.value = farmID;
  // Add class 'active' to current menu item
  document.querySelector("#nav-item-myproducts").classList.add("active");
}
</script>