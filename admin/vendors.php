<?php
$pageTitle = "Vendors";
include "includes/header.php";

// Handle deletion request
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $vendorId = $_GET['id'];

  // Check if the vendor ID is valid
  if ($vendorId) {
    // Fetch the vendor's image filename
    $vendor = $db->read("vendors", "WHERE id='$vendorId'");
    if ($vendor) {
      $imagePath = '../public/uploads/' . $vendor['image'];

      // Delete the image file if it exists
      if (file_exists($imagePath)) {
        unlink($imagePath);
      }

      // Delete the vendor from the database
      $db->delete("vendors", "id='$vendorId'");

      $_SESSION['success'] = "Vendor and profile image deleted successfully.";
    } else {
      $_SESSION['success'] = "Vendor not found.";
    }
  }
}

// Fetch vendors from the database
$vendors = $db->readAll("vendors"); // Assuming you have a vendors table

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Vendor Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Vendors
        <a href="add-vendor.php" class="btn btn-primary float-end">
          <i class="bx bx-plus"></i> Add New Vendor</a>
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
        <table id="vendorTable" class="datatables-vendors table border-top">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Image</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($vendors as $vendor): ?>
              <tr>
                <td><?php echo htmlspecialchars($vendor['id']); ?></td>
                <td><?php echo htmlspecialchars($vendor['fullname']); ?></td>
                <td><?php echo htmlspecialchars($vendor['email']); ?></td>
                <td><img src="../public/uploads/<?php echo htmlspecialchars($vendor['image']) ?>" class="w-px-40 h-auto rounded-circle" ></td>
                <td><?php echo htmlspecialchars($vendor['status']); ?></td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="viewVendor(<?php echo $vendor['id']; ?>)">View</button>
                  <a href="?delete&id=<?php echo $vendor['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this vendor?')">Delete</a>
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
      $('#vendorTable').DataTable();
    });

    function viewVendor(vendorId) {
      window.location.href = 'view-vendor.php?id=' + vendorId;
    }
  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>