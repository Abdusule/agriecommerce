<?php
$pageTitle = "Category";
include "includes/header.php";

// Handle deletion request
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $categoryId = $_GET['id'];

  // Check if the category ID is valid
  if ($categoryId) {
    // Fetch the category
    $category = $db->read("category", "WHERE id='$categoryId'");
    if ($category) {
      
      // Delete subcategories with parent_id equal to the category ID
      $db->delete("category", "parent_id='$categoryId'");

      // Delete the main category from the database
      $db->delete("category", "id='$categoryId'");

      $_SESSION['success'] = "Category and its subcategories deleted successfully.";
      
    } else {
      $_SESSION['success'] = "Category not found.";
    }
  }
}

// Fetch categories from the database
$categories = $db->readAll("category");

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Category Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Categories
        <a href="add-category.php" class="btn btn-primary float-end">
          <i class="bx bx-plus"></i> Add New Category</a>
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
        <table id="categoryTable" class="datatables-category table border-top">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Parent ID</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $category): ?>
              <tr>
                <td><?php echo htmlspecialchars($category['id']); ?></td>
                <td><?php echo htmlspecialchars($category['name']); ?></td>
                <td><?php echo $category['parent_id'] == 0 ? "" : htmlspecialchars($category['parent_id'])  ; ?></td>
                <td><?php echo htmlspecialchars($category['status']); ?></td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="viewCategory(<?php echo $category['id']; ?>)">View</button>
                  <a href="?delete&id=<?php echo $category['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category and its subcategories?')">Delete</a>
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
      $('#categoryTable').DataTable();
    });

    function viewCategory(categoryId) {
      window.location.href = 'view-category.php?id=' + categoryId;
    }
  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>