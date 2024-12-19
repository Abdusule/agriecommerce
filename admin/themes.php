<?php
$pageTitle = "Settings";
include "includes/header.php";

// Assuming $site_setting is already populated with current settings
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $theme = trim($_POST['theme']) ?: 'butterfly';



  // If no errors, update settings in the database
  if (empty($errors)) {
    // Assuming $db is your database connection instance
    $data = [
      'theme' => $theme
    ];

    $db->update("settings", $data, "id = 1"); // Assuming the settings table has an id column
    $success = true;
    $_SESSION['success'] = 'Theme updated successfully';
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

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link " href="settings.php"><i class="bx bx-user me-1"></i> General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="themes.php"><i class="bx bx-palette me-1"></i> Themes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mail-connections.php"><i class="bx bx-link-alt me-1"></i> Mail & Connections</a>
          </li>
        </ul>

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
          <div class="row">
          <div class="col-xl-3 col-md-5 col-sm-6 col-12">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="basicPlanMain1">
                  <span class="custom-option-body">
                    <i class="bx bx-palette"></i>
                    <span class="custom-option-title"> Butterfly </span>
                    <img src="../public/uploads/butterfly.png" class="img-fluid"/>
                  </span>
                  <input name="theme" class="form-check-input" type="radio" value="butterfly" id="basicPlanMain1" <?php echo $site_setting['theme'] == 'butterfly' ? 'checked': ' '; ?> />
                </label>
              </div>
            </div>

            <div class="col-xl-3 col-md-5 col-sm-6 col-12">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="basicPlanMain1">
                  <span class="custom-option-body">
                    <i class="bx bx-palette"></i>
                    <span class="custom-option-title"> Darkrose </span>
                    <img src="../public/uploads/darkrose.png" class="img-fluid"/>
                  </span>
                  <input name="theme" class="form-check-input" type="radio" value="darkrose" id="basicPlanMain1"  <?php echo $site_setting['theme'] == 'darkrose' ? 'checked': ' '; ?> />
                </label>
              </div>
            </div>

          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>