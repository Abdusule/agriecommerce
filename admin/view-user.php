<?php
ob_start(); // Start output buffering
$pageTitle = "Users";
include "includes/header.php";



// Assume $db is your database connection object
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize variables and error messages
$email = $fullname = $gender = $phone = $state = $country = $address = $status = "";
$emailErr = $fullnameErr = $genderErr = $phoneErr = $stateErr = $countryErr = $addressErr = $statusErr = "";

// Fetch user details
if ($userId) {
  $user = $db->read("users", "WHERE id='$userId'");
  if ($user) {
    $email = $user['email'];
    $fullname = $user['fullname'];
    $gender = $user['gender'];
    $phone = $user['phone'];
    $state = $user['state'];
    $address = $user['address'];
    $country = $user['country'];
    $status = $user['status'];
    $profilePicture = $user['image'];
  } else {
    $_SESSION['success'] = "User not found.";
    header("Location: users.php");
    exit();
  }
} else {
  header("Location: ../");
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate and update fields
  if (empty($_POST["fullname"])) {
    $fullnameErr = "Full name is required";
    $isValid = false;
  } else {
    $fullname = $_POST["fullname"];
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
    $isValid = false;
  } else {
    $gender = $_POST["gender"];
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "Phone number is required";
    $isValid = false;
  } else {
    $phone = $_POST["phone"];
  }

  if (empty($_POST["state"])) {
    $stateErr = "State is required";
    $isValid = false;
  } else {
    $state = $_POST["state"];
  }

  if (empty($_POST["country"])) {
    $countryErr = "Country is required";
    $isValid = false;
  } else {
    $country = $_POST["country"];
  }

  if (empty($_POST["status"])) {
    $statusErr = "Status is required";
    $isValid = false;
  } else {
    $status = $_POST["status"];
  }

  if (empty($_POST["address"])) {
    $addressErr = "Address is required";
    $isValid = false;
  } else {
    $address = $_POST["address"];
  }

  // Handle profile picture upload
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../public/uploads/';
    $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
    $newFileName = "user-".$userId . '.jpg';
    $destPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
      $profilePicture = $newFileName;

      header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
      header("Pragma: no-cache"); // HTTP 1.0.
      header("Expires: 0"); // Proxies.

    } else {
      $profilePictureErr = "There was an error uploading the file.";
      $isValid = false;
    }
  }

  // If all validations pass, update the user
  if ($isValid) {
    $db->update("users", [
      'fullname' => $fullname,
      'gender' => $gender,
      'phone' => $phone,
      'state' => $state,
      'country' => $country,
      'status' => $status,
      'address' => $address,
      'image' => $profilePicture
    ], "id = '$userId'");

    $_SESSION['success'] = "User updated successfully.";
    header("Location: view-user.php?id=$userId");
    exit();
  }
}

?>


<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">


<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> View User</h4>

    <div class="card mb-4">
      <h5 class="card-header">User Details
        <a href="users.php" class="btn btn-primary float-end">
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

        <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img src="../public/uploads/<?php echo htmlspecialchars($profilePicture); ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
              <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                  <span class="d-none d-sm-block">Upload new photo</span>
                  <i class="bx bx-upload d-block d-sm-none"></i>
                  <input type="file" id="upload" name="profile_picture" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                </label>
                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                  <i class="bx bx-reset d-block d-sm-none"></i>
                  <span class="d-none d-sm-block">Reset</span>
                </button>
                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
              </div>
            </div>

            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled />
            </div>
            <div class="mb-3 col-md-6">
              <label for="fullname" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" />
              <span class="text-danger"><?php echo $fullnameErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-control" id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
              </select>
              <span class="text-danger"><?php echo $genderErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" />
              <span class="text-danger"><?php echo $phoneErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="state" class="form-label">State</label>
              <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($state); ?>" />
              <span class="text-danger"><?php echo $stateErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="country" class="form-label">Country</label>
              <input type="text" class="form-control" id="country" name="country" value="<?php echo htmlspecialchars($country); ?>" />
              <span class="text-danger"><?php echo $countryErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" />
              <span class="text-danger"><?php echo $addressErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="status" class="form-label">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
                <option value="block" <?php if ($status == 'block') echo 'selected'; ?>>Block</option>
              </select>
              <span class="text-danger"><?php echo $statusErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Update User</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>


<script src="assets/js/datatables-bootstrap5.js"></script>