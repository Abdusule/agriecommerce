<?php
ob_start(); // Start output buffering

$pageTitle = "Messages";
include "includes/header.php";

// Handle deletion request
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $messageId = $_GET['id'];

  // Check if the message ID is valid
  if ($messageId) {
    // Delete the message from the database
    $db->delete("bookings", "id='$messageId'");

    $_SESSION['success'] = "Message deleted successfully.";
    header('location: messages.php');
  } else {
    $_SESSION['success'] = "Message not found.";
  }
}

// Fetch messages from the database
$messages = $db->readAll("bookings", "ORDER BY id DESC"); // Assuming you have a bookings table

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Message Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Messages</h5>
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?php
          echo $_SESSION['success'];
          unset($_SESSION['success']); // Destroy the session message after showing it
          ?>
        </div>
      <?php endif; ?>

      <div class="card-datatable table-responsive">
        <table id="messageTable" class="datatables-messages table border-top">
          <thead>
            <tr>
              <th>ID</th>
              <th>Email</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messages as $message): ?>
              <tr>
                <td><?php echo htmlspecialchars($message['id']); ?></td>
                <td><?php echo htmlspecialchars($message['email']); ?></td>
                <td><?php echo htmlspecialchars($message['status']); ?></td>
                <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                <td>
                <button class="btn btn-info btn-sm" onclick="viewMessage(<?php echo $message['id']; ?>)">View</button>
                
                  <a href="?delete&id=<?php echo $message['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include "includes/footer.php";
  ob_end_flush(); // End output buffering and flush the output
  ?>

  <script>
    $(document).ready(function() {
      $('#messageTable').DataTable();
    });

    function viewMessage(messageId) {
      window.location.href = 'view-message.php?id=' + messageId;
    }

  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>