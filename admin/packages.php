<?php
$pageTitle = "Packages";
include "includes/header.php";

// Handle deletion request
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $packageId = $_GET['id'];

  // Check if the package ID is valid
  if ($packageId) {
      // Fetch the package
      $package = $db->read("packages", "WHERE id='$packageId'");
      if ($package) {
          // Delete the package from the database
          $db->delete("packages", "id='$packageId'");

          $_SESSION['success'] = "Package deleted successfully.";
          
      } else {
          $_SESSION['success'] = "Package not found.";
          
      }
  } 
}

// Fetch packages from the database
$packages = $db->readAll("packages"); // Assuming you have a packages table

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Package Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Packages
        <a href="add-package.php" class="btn btn-primary float-end">
          <i class="bx bx-plus"></i> Add New Package</a>
      </h5>
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?php
          echo $_SESSION['success'];
          unset($_SESSION['success']); // Destroy the session message after showing it
          ?>
        </div>
      <?php endif; ?>

      <div class="card-datatable table-responsive">
        <table id="packageTable" class="datatables-packages table border-top">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($packages as $package): ?>
              <tr>
                <td><?php echo htmlspecialchars($package['id']); ?></td>
                <td><?php echo htmlspecialchars($package['name']); ?></td>
                <td><?php echo $site_setting['symbol'].number_format($package['amount'], 2); ?></td>
                <td><?php echo htmlspecialchars($package['status']); ?></td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="viewPackage(<?php echo $package['id']; ?>)">View</button>
                  <a href="?delete&id=<?php echo $package['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this package?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include "includes/footer.php"; ?>

  <script>
    $(document).ready(function() {
      $('#packageTable').DataTable();
    });

    function viewPackage(packageId) {
      window.location.href = 'view-package.php?id=' + packageId;
    }
  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>