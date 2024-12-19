<?php
$pageTitle = "Products";
include "includes/header.php";

// Handle deletion request
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $productId = $_GET['id'];

  // Check if the product ID is valid
  if ($productId) {
      // Fetch the product's image filename
      $product = $db->read("products", "WHERE id='$productId'");
      if ($product) {
          $imagePath = '../public/uploads/' . $product['image_url'];

          // Delete the image file if it exists
          if (file_exists($imagePath)) {
              unlink($imagePath);
          }

          // Delete the product from the database
          $db->delete("products", "id='$productId'");

          $_SESSION['success'] = "Product and image deleted successfully.";
          
      } else {
          $_SESSION['success'] = "Product not found.";
          
      }
  } 
}

// Fetch products from the database
$products = $db->readAll("products");

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Product Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Products
        <a href="add-product.php" class="btn btn-primary float-end">
          <i class="bx bx-plus"></i> Add New Product</a>
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
        <table id="productTable" class="datatables-products table border-top">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Weight</th>
              <th>Image</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['weight']); ?></td>
                <td><img src="../public/uploads/<?php echo htmlspecialchars($product['image_url']) ?>" class="w-px-40 h-auto rounded-circle" ></td>
                <td><?php echo htmlspecialchars($product['status']); ?></td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="viewProduct(<?php echo $product['id']; ?>)">View</button>
                  <a href="?delete&id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
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
      $('#productTable').DataTable();
    });

    function viewProduct(productId) {
      window.location.href = 'view-product.php?id=' + productId;
    }
  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>