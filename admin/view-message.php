<?php
ob_start(); // Start output buffering
$pageTitle = "View Message";
include "includes/header.php";

// Assume $db is your database connection object
$messageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize variables and error messages
$email = $message = $status = $createdAt = "";
$statusErr = "";

// Fetch message details
if ($messageId) {
  $messageData = $db->read("bookings", "WHERE id='$messageId'");
  if ($messageData) {
    $email = $messageData['email'];
    $message = $messageData['message'];
    $status = $messageData['status'];
    $createdAt = $messageData['created_at'];
  } else {
    $_SESSION['success'] = "Message not found.";
    header("Location: messages.php");
    exit();
  }
} else {
  header("Location: ../");
}

// Handle form submission for updating message status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate and update status
  if (empty($_POST["status"])) {
    $statusErr = "Status is required";
    $isValid = false;
  } else {
    $status = $_POST["status"];
  }

  // If validation passes, update the message status
  if ($isValid) {
    $db->update("bookings", [
      'status' => $status
    ], "id = '$messageId'");

    $_SESSION['success'] = "Message status updated successfully.";
    header("Location: view-message.php?id=$messageId");
    exit();
  }
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> View Message</h4>

    <div class="card mb-4">
      <h5 class="card-header">Message Details
        <a href="messages.php" class="btn btn-primary float-end">
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

        <div class="mb-4">
          <h6>Email: <?php echo htmlspecialchars($email); ?></h6>
          <h6>Created At: <?php echo htmlspecialchars($createdAt); ?></h6>
        </div>

        <div class="card mb-4">
          <div class="card-header">Message Content</div>
          <div class="card-body">
            <?php echo $message; // Assuming the message is in HTML format 
            ?>
          </div>
        </div>

        <form method="POST">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="status" class="form-label">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="pending" <?php if ($status == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="completed" <?php if ($status == 'completed') echo 'selected'; ?>>Completed</option>
              </select>
              <span class="text-danger"><?php echo $statusErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Update Status</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>