<?php
$pageTitle = "Complaints";
include "includes/header.php";
$errors = [];
$success = false;

// Handle deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $complaintId = (int)$_GET['id'];
  try {
    $db->delete("complaints", "id = '$complaintId'");
    $success = true;
  } catch (Exception $e) {
    $errors[] = "Failed to delete complaint.";
  }
}

// Fetch all complaints
$complaints = $db->readAll("complaints");

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Complaint Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Complaints

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
        <table id="complaintTable" class="datatables-complaints table border-top">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Subject</th>
              <th>Status</th>
              <th>Tracking Code</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($complaints as $complaint): ?>
              <?php
               $user = $db->read("users", "WHERE id = '{$complaint['user_id']}'");
               $userName = $user ? $user['fullname'] : 'Unknown';
              ?>
              <tr>
                <td class=""><?php echo $complaint['id']; ?></td>
                <td><?php echo htmlspecialchars($userName); ?></td>
                <td><?php echo htmlspecialchars(implode(' ', array_slice(explode(' ', trim($complaint['subject'])), 0, 2))); ?>...</td>
                <td><?php echo htmlspecialchars($complaint['status']); ?></td>
                <td><?php echo htmlspecialchars($complaint['tracking_code']); ?></td>
                <td class="text-center">
                  <a href="view-complaint.php?id=<?php echo $complaint['id']; ?>" class="btn btn-info btn-sm">View</a>
                  <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $complaint['id']; ?>)">Delete</button>
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
      $('#complaintTable').DataTable();
    });

    function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this complaint?')) {
        window.location.href = '?delete&id=' + id;
    }
}
  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>