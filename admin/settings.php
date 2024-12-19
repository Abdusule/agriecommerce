<?php
$pageTitle = "Settings";
include "includes/header.php";

// Assuming $site_setting is already populated with current settings
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $symbol = trim($_POST['symbol']);
  $site_name = trim($_POST['site_name']);
  $site_email = trim($_POST['site_email']);
  $livechat = trim($_POST['livechat']);
  $phone = trim($_POST['phone']);
  $website = trim($_POST['website']);
  $address = trim($_POST['address']);
  $owner = trim($_POST['owner']);
  $account_name = trim($_POST['account_name']);
  $account_number = trim($_POST['account_number']);
  $bank_name = trim($_POST['bank_name']);
  $shipping_fee = trim($_POST['shipping_fee']);

  // Validate inputs
  if (empty($symbol))
    $errors['symbol'] = "Currency symbol is required.";
  if (empty($site_name))
    $errors['site_name'] = "Site name is required.";
  if (empty($account_name))
    $errors['account_name'] = "Account name is required.";
  if (empty($account_number))
    $errors['account_number'] = "Account number is required.";
  if (empty($bank_name))
    $errors['bank_name'] = "Bank name is required.";
  if (!is_numeric($shipping_fee))
    $errors['shipping_fee'] = "Shipping fee must be a number.";
  if (!filter_var($site_email, FILTER_VALIDATE_EMAIL))
    $errors['site_email'] = "Invalid email format.";
  if (!filter_var($website, FILTER_VALIDATE_URL))
    $errors['website'] = "Invalid URL format.";

  if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $logoPath = '../public/uploads/logo.png';
    move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath);
  }

  if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
    $faviconPath = '../public/uploads/favicon.png';
    move_uploaded_file($_FILES['favicon']['tmp_name'], $faviconPath);
  }

  // If no errors, update settings in the database
  if (empty($errors)) {
    $data = [
      'symbol' => $symbol,
      'site_name' => $site_name,
      'site_email' => $site_email,
      'livechat' => $livechat,
      'phone' => $phone,
      'website' => $website,
      'address' => $address,
      'owner' => $owner,
      'account_name' => $account_name,
      'account_number' => $account_number,
      'bank_name' => $bank_name,
      'shipping_fee' => $shipping_fee
    ];

    $db->update("settings", $data, "id = 1");
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
      <h5 class="card-header">Site Settings</h5>

      <div class="card-body">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link active" href="settings.php"><i class="bx bx-user me-1"></i> General</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="mail-connections.php"><i class="bx bx-link-alt me-1"></i> Mail & Connections</a>
          </li>
        </ul>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
          </div>
        <?php endif; ?>

        <hr>

        <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="symbol" class="form-label">Currency Symbol</label>
              <input type="text" class="form-control" id="symbol" name="symbol"
                value="<?php echo htmlspecialchars($site_setting['symbol']); ?>" />
              <?php if (!empty($errors['symbol'])): ?>
                <span class="text-danger"><?php echo $errors['symbol']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="site_name" class="form-label">Site Name</label>
              <input type="text" class="form-control" id="site_name" name="site_name"
                value="<?php echo htmlspecialchars($site_setting['site_name']); ?>" />
              <?php if (!empty($errors['site_name'])): ?>
                <span class="text-danger"><?php echo $errors['site_name']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="site_email" class="form-label">Site Email</label>
              <input type="email" class="form-control" id="site_email" name="site_email"
                value="<?php echo htmlspecialchars($site_setting['site_email']); ?>" />
              <?php if (!empty($errors['site_email'])): ?>
                <span class="text-danger"><?php echo $errors['site_email']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="livechat" class="form-label">Live Chat</label>
              <input type="text" class="form-control" id="livechat" name="livechat"
                value="<?php echo htmlspecialchars($site_setting['livechat']); ?>" />
              <?php if (!empty($errors['livechat'])): ?>
                <span class="text-danger"><?php echo $errors['livechat']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone"
                value="<?php echo htmlspecialchars($site_setting['phone']); ?>" />
              <?php if (!empty($errors['phone'])): ?>
                <span class="text-danger"><?php echo $errors['phone']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="website" class="form-label">Website URL</label>
              <input type="url" class="form-control" id="website" name="website"
                value="<?php echo htmlspecialchars($site_setting['website']); ?>" />
              <?php if (!empty($errors['website'])): ?>
                <span class="text-danger"><?php echo $errors['website']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address"
                value="<?php echo htmlspecialchars($site_setting['address']); ?>" />
              <?php if (!empty($errors['address'])): ?>
                <span class="text-danger"><?php echo $errors['address']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="owner" class="form-label">Owner</label>
              <input type="text" class="form-control" id="owner" name="owner"
                value="<?php echo htmlspecialchars($site_setting['owner']); ?>" />
              <?php if (!empty($errors['owner'])): ?>
                <span class="text-danger"><?php echo $errors['owner']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="account_name" class="form-label">Account Name</label>
              <input type="text" class="form-control" id="account_name" name="account_name"
                value="<?php echo htmlspecialchars($site_setting['account_name']); ?>" />
              <?php if (!empty($errors['account_name'])): ?>
                <span class="text-danger"><?php echo $errors['account_name']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="account_number" class="form-label">Account Number</label>
              <input type="text" class="form-control" id="account_number" name="account_number"
                value="<?php echo htmlspecialchars($site_setting['account_number']); ?>" />
              <?php if (!empty($errors['account_number'])): ?>
                <span class="text-danger"><?php echo $errors['account_number']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="bank_name" class="form-label">Bank Name</label>
              <input type="text" class="form-control" id="bank_name" name="bank_name"
                value="<?php echo htmlspecialchars($site_setting['bank_name']); ?>" />
              <?php if (!empty($errors['bank_name'])): ?>
                <span class="text-danger"><?php echo $errors['bank_name']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="shipping_fee" class="form-label">Shipping Fee</label>
              <input type="text" class="form-control" id="shipping_fee" name="shipping_fee"
                value="<?php echo htmlspecialchars($site_setting['shipping_fee']); ?>" />
              <?php if (!empty($errors['shipping_fee'])): ?>
                <span class="text-danger"><?php echo $errors['shipping_fee']; ?></span>
              <?php endif; ?>
            </div>
            <div class="mb-3 col-md-6">
              <label for="logo" class="form-label">Logo</label>
              <input type="file" class="form-control" id="logo" name="logo" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="favicon" class="form-label">Favicon</label>
              <input type="file" class="form-control" id="favicon" name="favicon" />
            </div>

          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>