<?php
ob_start(); // Start output buffering
$pageTitle = "Category";
include "includes/header.php";

// Assume $db is your database connection object
$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize variables and error messages
$name = $description = $parent_id = $status = "";
$nameErr = $descriptionErr = $parent_idErr = $statusErr = "";

// Fetch category details
if ($categoryId) {
  $category = $db->read("category", "WHERE id='$categoryId'");
  if ($category) {
    $name = $category['name'];
    $description = $category['description'];
    $parent_id = $category['parent_id'];
    $status = $category['status'];
  } else {
    $_SESSION['success'] = "Category not found.";
    header("Location: category.php");
    exit();
  }
} else {
  header("Location: ../");
}

// Fetch all categories for the parent category dropdown
$categories = $db->readAll("category", "WHERE id != '$categoryId'");

// Handle form submission for updating category details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate and update fields
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $isValid = false;
  } else {
    $name = $_POST["name"];
  }

  if (empty($_POST["description"])) {
    $descriptionErr = "Description is required";
    $isValid = false;
  } else {
    $description = $_POST["description"];
  }

  if (!isset($_POST["parent_id"])) {
    $parent_idErr = "Parent category is required";
    $isValid = false;
  } else {
    $parent_id = $_POST["parent_id"];
  }

  if (!isset($_POST["status"])) {
    $statusErr = "Status is required";
    $isValid = false;
  } else {
    $status = $_POST["status"];
  }

  // If all validations pass, update the category
  if ($isValid) {
    $db->update("category", [
      'name' => $name,
      'description' => $description,
      'parent_id' => $parent_id,
      'status' => $status
    ], "id = '$categoryId'");

    $_SESSION['success'] = "Category updated successfully.";
    header("Location: view-category.php?id=$categoryId");
    exit();
  }
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> View Category</h4>

    <div class="card mb-4">
      <h5 class="card-header">Category Details
        <a href="category.php" class="btn btn-primary float-end">
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

        <form method="POST">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" />
              <span class="text-danger"><?php echo $nameErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>
              <span class="text-danger"><?php echo $descriptionErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="parent_id" class="form-label">Parent Category</label>
              <select class="form-control" id="parent_id" name="parent_id">
                <option value="0">-- Select Parent Category --</option>
                <?php foreach ($categories as $cat):  ?>
                  <option value="<?php echo $cat['id']; ?>" <?php echo ($parent_id == $cat['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="text-danger"><?php echo $parent_idErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="status" class="form-label">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="active" <?php echo ($status == 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo ($status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
              </select>
              <span class="text-danger"><?php echo $statusErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Update Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>