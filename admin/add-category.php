<?php
ob_start(); // Start output buffering
$pageTitle = "Category";
include "includes/header.php";

// Initialize variables and error messages
$name = $description = $parent_id = "";
$nameErr = $descriptionErr = $parent_idErr = "";

// Fetch existing categories for the parent_id dropdown
$categories = $db->readAll("category"); // Assuming a method to fetch all categories

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate name
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $isValid = false;
  } else {
    $name = $_POST["name"];
  }

  // Validate description
  if (empty($_POST["description"])) {
    $descriptionErr = "Description is required";
    $isValid = false;
  } else {
    $description = $_POST["description"];
  }

  // Validate parent_id
  $parent_id = $_POST["parent_id"]; // Optional, so no error if empty

  // If all validations pass, insert the category
  if ($isValid) {
    $created_at = date('Y-m-d H:i:s');
    $updated_at = $created_at;

    $db->create("category", [
      'name' => $name,
      'description' => $description,
      'parent_id' => $parent_id,
      'created_at' => $created_at,
      'updated_at' => $updated_at
    ]);

    $_SESSION['success'] = "Category added successfully.";
    header("Location: category.php");
    exit();
  }
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Add Category</h4>

    <div class="card mb-4">
      <h5 class="card-header">Add New Category
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
              <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>" />
              <span class="text-danger"><?php echo $descriptionErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="parent_id" class="form-label">Parent Category</label>
              <select class="form-control" id="parent_id" name="parent_id">
                <option value="0">-- Select Parent Category --</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category['id']; ?>" <?php echo ($parent_id == $category['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="text-danger"><?php echo $parent_idErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Add Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>