<?php
ob_start(); // Start output buffering
$pageTitle = "Packages";
include "includes/header.php";

// Assume $db is your database connection object
$packageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize variables and error messages
$name = $amount = $status = "";
$nameErr = $amountErr = $statusErr = "";

// Fetch package details
if ($packageId) {
  $package = $db->read("packages", "WHERE id='$packageId'");
  if ($package) {
    $name = $package['name'];
    $amount = $package['amount'];
    $status = $package['status'];
  } else {
    $_SESSION['success'] = "Package not found.";
    header("Location: packages.php");
    exit();
  }
} else {
  header("Location: ../");
}

// Handle form submission for updating package details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate and update fields
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $isValid = false;
  } else {
    $name = $_POST["name"];
  }

  if (empty($_POST["amount"])) {
    $amountErr = "Amount is required";
    $isValid = false;
  } else {
    $amount = $_POST["amount"];
  }

  if (empty($_POST["status"])) {
    $statusErr = "Status is required";
    $isValid = false;
  } else {
    $status = $_POST["status"];
  }

  // If all validations pass, update the package
  if ($isValid) {
    $db->update("packages", [
      'name' => $name,
      'amount' => $amount,
      'status' => $status
    ], "id = '$packageId'");

    $_SESSION['success'] = "Package updated successfully.";
    header("Location: view-package.php?id=$packageId");
    exit();
  }
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> View Package</h4>

    <div class="card mb-4">
      <h5 class="card-header">Package Details
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
              <label for="amount" class="form-label">Amount</label>
              <input type="text" class="form-control" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>" />
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
            <button type="submit" class="btn btn-primary me-2">Update Package</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>