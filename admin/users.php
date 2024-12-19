<?php
$pageTitle = "Users";
include "includes/header.php";

// Handle deletion request
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $userId = $_GET['id'];

// Check if the user ID is valid
if ($userId) {
    // Fetch the user's image filename
    $user = $db->read("users", "WHERE id='$userId'");
    if ($user) {
        $imagePath = '../public/uploads/' . $user['image'];

        // Delete the image file if it exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the user from the database
        $db->delete("users", "id='$userId'");

        $_SESSION['success'] = "User and profile image deleted successfully.";
        
    } else {
        $_SESSION['success'] = "User not found.";
        
    }
} 


}

// Fetch users from the database
$users = $db->readAll("users"); // Assuming you have a users table

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> User Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Users
        <a href="add-user.php" class="btn btn-primary float-end">
          <i class="bx bx-plus"></i> Add New User</a>
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
        <table id="userTable" class="datatables-users table border-top">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>image</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><img src="../public/uploads/<?php echo htmlspecialchars($user['image']) ?>" class="w-px-40 h-auto rounded-circle" ></td>
                <td><?php echo htmlspecialchars($user['status']); ?></td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="viewUser(<?php echo $user['id']; ?>)">View</button>
                  <a href="?delete&id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
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
      $('#userTable').DataTable();
    });

    function viewUser(userId) {
      window.location.href = 'view-user.php?id=' + userId;
    }
  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>