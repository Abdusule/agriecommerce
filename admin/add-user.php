<?php
ob_start(); // Start output buffering
$pageTitle = "Users";
include "includes/header.php";

// Initialize variables and error messages
$email = $password = $fullname = $gender = $phone = $state = $country = $address = $profilePicture = "";
$emailErr = $passwordErr = $fullnameErr = $genderErr = $phoneErr = $stateErr = $countryErr = $addressErr = $profilePictureErr = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $isValid = false;
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $isValid = false;
        } else {
            // Check if email already exists
            if ($db->read("users", "WHERE email='$email'")) {
                $emailErr = "Email already exists";
                $isValid = false;
            }
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $isValid = false;
    } else {
        $password = $_POST["password"];
    }

    // Validate fullname
    if (empty($_POST["fullname"])) {
        $fullnameErr = "Full name is required";
        $isValid = false;
    } else {
        $fullname = $_POST["fullname"];
    }

    // Validate gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
        $isValid = false;
    } else {
        $gender = $_POST["gender"];
    }

    // Validate phone
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
        $isValid = false;
    } else {
        $phone = $_POST["phone"];
    }

    // Validate state
    if (empty($_POST["state"])) {
        $stateErr = "State is required";
        $isValid = false;
    } else {
        $state = $_POST["state"];
    }

    // Validate country
    if (empty($_POST["country"])) {
        $countryErr = "Country is required";
        $isValid = false;
    } else {
        $country = $_POST["country"];
    }

    // Validate address
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
        $fileName = time() . '_' . $_FILES['profile_picture']['name'];
        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $profilePicture = $fileName;
        } else {
            $profilePictureErr = "There was an error uploading the file.";
            $isValid = false;
        }
    } else {
        $profilePictureErr = "Profile picture is required.";
        $isValid = false;
    }

    // If all validations pass, insert the user
    // If all validations pass, insert the user
if ($isValid) {
  $status = 'active';
  $created_at = date('Y-m-d H:i:s');
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  // Insert user without profile picture
  $userId = $db->create("users", [
      'email' => $email,
      'password' => $hashedPassword,
      'fullname' => $fullname,
      'gender' => $gender,
      'phone' => $phone,
      'state' => $state,
      'country' => $country,
      'address' => $address,
      'status' => $status,
      'created_at' => $created_at
  ]);

  if ($userId) {
      // Rename the uploaded file to user ID
      $newFileName = $userId . '.jpg';
      $newDestPath = $uploadDir . $newFileName;

      if (rename($destPath, $newDestPath)) {
          // Update user with the new profile picture filename
          $db->update("users", ['image' => $newFileName], "id='$userId'");
      } else {
          $profilePictureErr = "There was an error renaming the file.";
      }

      $_SESSION['success'] = "User added successfully.";
      header("Location: users.php");
      exit();
  } else {
      $profilePictureErr = "There was an error creating the user.";
  }
}
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Add User</h4>

    <div class="card mb-4">
      <h5 class="card-header">Add New User
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
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" />
              <span class="text-danger"><?php echo $emailErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" />
              <span class="text-danger"><?php echo $passwordErr; ?></span>
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
              <label for="profile_picture" class="form-label">Profile Picture</label>
              <input type="file" class="form-control" id="profile_picture" name="profile_picture" />
              <span class="text-danger"><?php echo $profilePictureErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; 
ob_end_flush(); // End output buffering and flush the output
?>