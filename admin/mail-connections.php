<?php
$pageTitle = "Settings";
include "includes/header.php";

// Assuming $site_setting is already populated with current settings
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $mail_register = $_POST['mail_register'];
  $mail_password_reset = $_POST['mail_password_reset'];
  $mail_account_disabled = $_POST['mail_account_disabled'];
  $mail_general = $_POST['mail_general'];

  // If no errors, update settings in the database
  if (empty($errors)) {
    // Assuming $db is your database connection instance
    $data = [
      'mail_register' => $mail_register,
      'mail_password_reset' => $mail_password_reset,
      'mail_account_disabled' => $mail_account_disabled,
      'mail_general' => $mail_general
    ];

    // $emailTemplate = file_get_contents('ckeditor_content.html'); // Load from CKEditor
    // $emailTemplate = str_replace('{{username}}', htmlspecialchars($username), $emailTemplate);
    // $emailTemplate = str_replace('{{email}}', htmlspecialchars($email), $emailTemplate);
    // $emailTemplate = str_replace('{{verificationUrl}}', htmlspecialchars($verificationUrl), $emailTemplate);
    // $emailTemplate = str_replace('{{currentYear}}', date('Y'), $emailTemplate);

    $db->update("settings", $data, "id = 1"); // Assuming the settings table has an id column
    $success = true;
    $_SESSION['success'] = 'Settings updated successfully';
  }
}

$site_setting = $db->read("settings", "WHERE id=1");
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Settings</h4>

    <div class="card mb-4">
      <h5 class="card-header">Theme Settings</h5>

      <div class="card-body">
        <!-- Nav pills -->
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link" href="settings.php"><i class="bx bx-user me-1"></i> General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="themes.php"><i class="bx bx-palette me-1"></i> Themes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="mail-connections.php"><i class="bx bx-link-alt me-1"></i> Mail & Connections</a>
          </li>
        </ul>

        <!-- Success message -->
        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']); // Destroy the session message after showing it
            ?>
          </div>
        <?php endif; ?>
        <hr>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">

          <!-- Mail Templates Section -->
          <h5 class="mt-4">Mail Templates</h5>

          <div class="form-group">
            <label for="mail_register">Mail Register</label>
            <textarea id="mail_register" name="mail_register" class="form-control"><?php echo $site_setting['mail_register']; ?></textarea>
          </div>

          <div class="form-group mt-3">
            <label for="mail_password_reset">Mail Password Reset</label>
            <textarea id="mail_password_reset" name="mail_password_reset" class="form-control"><?php echo $site_setting['mail_password_reset']; ?></textarea>
          </div>

          <div class="form-group mt-3">
            <label for="mail_account_disabled">Mail Account Disabled</label>
            <textarea id="mail_account_disabled" name="mail_account_disabled" class="form-control"><?php echo $site_setting['mail_account_disabled']; ?></textarea>
          </div>

          <div class="form-group mt-3">
            <label for="mail_general">Mail General</label>
            <textarea id="mail_general" name="mail_general" class="form-control"><?php echo $site_setting['mail_general']; ?></textarea>
          </div>

          <!-- Submit Button -->
          <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
          </div>
        </form>

        <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
        <script>
          CKEDITOR.replace('mail_register');
          CKEDITOR.replace('mail_password_reset');
          CKEDITOR.replace('mail_account_disabled');
          CKEDITOR.replace('mail_general');
        </script>
        <?php include "includes/footer.php"; ?>