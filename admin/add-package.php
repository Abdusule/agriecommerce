<?php
ob_start(); // Start output buffering
$pageTitle = "Packages";
include "includes/header.php";

// Initialize variables and error messages
$name = $amount = $status = "";
$nameErr = $amountErr = $statusErr = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate name
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $isValid = false;
  } else {
    $name = $_POST["name"];
  }

  // Validate amount
  if (empty($_POST["amount"])) {
    $amountErr = "Amount is required";
    $isValid = false;
  } else {
    $amount = $_POST["amount"];
  }

  // Validate status
  if (empty($_POST["status"])) {
    $statusErr = "Status is required";
    $isValid = false;
  } else {
    $status = $_POST["status"];
  }

  // If all validations pass, insert the package
  if ($isValid) {
    $created_at = date('Y-m-d H:i:s');

    $db->create("packages", [
      'name' => $name,
      'amount' => $amount,
      'status' => $status,
      'created_at' => $created_at
    ]);

    $_SESSION['success'] = "Package added successfully.";
    header("Location: packages.php");
    exit();
  }
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Add Package</h4>

    <div class="card mb-4">
      <h5 class="card-header">Add New Package
        <a href="packages.php" class="btn btn-primary float-end">
          <i class="bx bx-arrow-back"> </i>&nbsp; Back</a>
      </h5>

      <div class="card-body">
        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" />
              <span class="text-danger"><?php echo $nameErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="amount" class="form-label">Amount(<?php echo $site_setting['symbol'] ?>)</label>
              <input type="number" min='1' class="form-control" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>" />
              <span class="text-danger"><?php echo $amountErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="status" class="form-label">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>Inactive</option>
              </select>
              <span class="text-danger"><?php echo $statusErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Add Package</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>