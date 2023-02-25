<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <h2>Add a product</h2>

  <form action="<?= URL ?>/store" method="post" class="needs-validation" novalidate>

    <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>" />

    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" class="form-control" required>

    <br>
    <label for="price" class="form-label">Price</label>
    <input type="number" name="price" id="price" class="form-control" min="0" step="0.1" required>

    <br>
    <label for="category_id" class="form-label">Category</label>
    <select name="category_id" id="category_id" class="form-select" required>
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
    <button type="submit" class="btn btn-success">Add product</button>
    <a href="<?= URL ?>/" class="btn btn-warning">Cancel</a>

  </form>

</div>

<!-- SCRIPTS -->
<?php include('app/views/partials/scripts-bs5.php') ?>
<?php include('app/views/partials/scripts-form-validate.php'); ?>

<script>
document.querySelector("#nav-item-new").classList.add("active");
</script>