<?php
ob_start(); // Start output buffering
$pageTitle = "Settings";
include "includes/header.php";

// Initialize variables and error messages
$currentPassword = $newPassword = $confirmPassword = $username = "";
$currentPasswordErr = $newPasswordErr = $confirmPasswordErr = $usernameErr = $generalErr = "";

$username = $admin['username']; // Get current username

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate username
  if (empty($_POST["username"])) {
    $usernameErr = "Username is required";
    $isValid = false;
  } else {
    $username = trim($_POST["username"]);
  }

  // Validate current password
  if (empty($_POST["current_password"])) {
    $currentPasswordErr = "Current password is required";
    $isValid = false;
  } else {
    $currentPassword = $_POST["current_password"];
    // Check if current password matches the one in the database
    if (!password_verify($currentPassword, $admin['password'])) {
      $currentPasswordErr = "Current password is incorrect";
      $isValid = false;
    }
  }

  // Validate new password
  if (empty($_POST["new_password"])) {
    $newPasswordErr = "New password is required";
    $isValid = false;
  } else {
    $newPassword = $_POST["new_password"];
  }

  // Validate confirm password
  if (empty($_POST["confirm_password"])) {
    $confirmPasswordErr = "Confirm password is required";
    $isValid = false;
  } else {
    $confirmPassword = $_POST["confirm_password"];
    if ($newPassword !== $confirmPassword) {
      $confirmPasswordErr = "Passwords do not match";
      $isValid = false;
    }
  }

  // If all validations pass, update the username and password
  if ($isValid) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $db->update("admins", ['username' => $username, 'password' => $hashedPassword], "id = '$adminId'");

    $_SESSION['success'] = "Profile updated successfully.";
    header("Location: profile.php");
    exit();
  }
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Admin Profile</h4>

    <div class="card mb-4">
      <h5 class="card-header">Modify Profile</h5>

      <div class="card-body">
        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
          </div>
        <?php endif; ?>

        <?php if ($generalErr): ?>
          <div class="alert alert-danger">
            <?php echo $generalErr; ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" />
              <span class="text-danger"><?php echo $usernameErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="current_password" class="form-label">Current Password</label>
              <input type="password" class="form-control" id="current_password" name="current_password" />
              <span class="text-danger"><?php echo $currentPasswordErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="new_password" class="form-label">New Password</label>
              <input type="password" class="form-control" id="new_password" name="new_password" />
              <span class="text-danger"><?php echo $newPasswordErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="confirm_password" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" />
              <span class="text-danger"><?php echo $confirmPasswordErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Update Profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>