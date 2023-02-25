<!-- CONTENT -->

<div class="container">

  <?php include("app/views/partials/flash.php") ?>

  <div class="d-flex">
    <h2>My Farms</h2>
    <a href="<?= URL ?>/farm-new" class="ms-auto"><i class="fas fa-plus-circle text-success fs-3 mt-2"></i></a>
  </div>

  <?php
  // Check if there is a "notfound" message
  if (is_get_request() && count($_GET) > 0) {
    $msg = $_GET["msg"];
    if ($msg == "notfound") {
      flash("Requested farm was not found", "alert-warning");
    }
  }

  // Show products
  foreach ($myfarms as $farm) : ?>
  <div class="list-group-item d-flex">
    <?= $farm["name"] ?>, <?= $farm["city"] ?> - <?= $farm["email"] ?>
    <div class="ms-auto">
      <a class="d-inline me-3 text-warning" href="<?= URL ?>/farm-edit?id=<?= $farm["id"] ?>"><i class="fas fa-pen"></i></a>
      <div class="d-inline text-danger btnDeleteShowModal" data-farmid="<?= $farm["id"] ?>"><i class="fas fa-trash"></i></div>
    </div>
  </div>
  <?php endforeach; ?>

  <?php if (count($myfarms) == 0) : ?>
  <div class="alert alert-danger" role="alert">
    No farms found.
  </div>
  <?php endif; ?>

</div>

<!-- MODAL DELETE FARM -->
<form action="<?= URL ?>/farm-delete" method="post">
  <div class="modal" tabindex="-1" id="modalDelete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Farm</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this farm?</p>
          <input type="hidden" name="csrfToken" value="<?= $_SESSION['csrfToken']; ?>">
          <input type="hidden" name="farmId" id="farmId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="btnDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>

</form>


<!-- SCRIPTS -->
<?php include('app/views/partials/scripts-bs5.php') ?>

<script>
// Set active navbar item
document.querySelector("#nav-item-myfarms").classList.add("active");

// Add event listeners for asking confirmation before deleting farm
const buttons = document.getElementsByClassName("btnDeleteShowModal");
Array.from(buttons).forEach(btn => {
  btn.addEventListener("click", function(e) {
    const modalDelete = new bootstrap.Modal(document.getElementById('modalDelete'));
    modalDelete.show();
    document.getElementById("farmId").value = this.dataset.farmid;
  });
});
</script>