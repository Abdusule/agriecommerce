<?php
ob_start(); // Start output buffering
$pageTitle = "Products";
include "includes/header.php";

// Assume $db is your database connection object
$productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Initialize variables and error messages
$name = $description = $category_id = $price = $weight = $unit_of_measure = $quantity_in_stock = $image_url = $status = "";
$nameErr = $descriptionErr = $categoryErr = $priceErr = $weightErr = $unitErr = $quantityErr = $imageErr = $statusErr = "";

// Fetch product details
if ($productId) {
  $product = $db->read("products", "WHERE id='$productId'");
  if ($product) {
    $name = $product['name'];
    $description = $product['description'];
    $category_id = $product['category_id'];
    $price = $product['price'];
    $weight = $product['weight'];
    $unit_of_measure = $product['unit_of_measure'];
    $quantity_in_stock = $product['quantity_in_stock'];
    $image_url = $product['image_url'];
    $status = $product['status'];
  } else {
    $_SESSION['success'] = "Product not found.";
    header("Location: products.php");
    exit();
  }
} else {
  header("Location: ../");
}

// Handle form submission for updating product details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;

  // Validate and update fields
  if (empty($_POST["name"])) {
    $nameErr = "Product name is required";
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

  if (empty($_POST["category_id"])) {
    $categoryErr = "Category is required";
    $isValid = false;
  } else {
    $category_id = $_POST["category_id"];
  }

  if (empty($_POST["price"])) {
    $priceErr = "Price is required";
    $isValid = false;
  } else {
    $price = $_POST["price"];
  }

  if (empty($_POST["weight"])) {
    $weightErr = "Weight is required";
    $isValid = false;
  } else {
    $weight = $_POST["weight"];
  }

  if (empty($_POST["unit_of_measure"])) {
    $unitErr = "Unit of measure is required";
    $isValid = false;
  } else {
    $unit_of_measure = $_POST["unit_of_measure"];
  }

  if (empty($_POST["quantity_in_stock"])) {
    $quantityErr = "Quantity in stock is required";
    $isValid = false;
  } else {
    $quantity_in_stock = $_POST["quantity_in_stock"];
  }

  if (!isset($_POST["status"])) {
    $statusErr = "Status is required";
    $isValid = false;
  } else {
    $status = $_POST["status"];
  }


  // Handle product image upload
  if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../public/uploads/';
    $fileTmpPath = $_FILES['product_image']['tmp_name'];
    $newFileName = "product-".$productId . '.jpg';
    $destPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
      $image_url = $newFileName;

      header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
      header("Pragma: no-cache"); // HTTP 1.0.
      header("Expires: 0"); // Proxies.

    } else {
      $imageErr = "There was an error uploading the file.";
      $isValid = false;
    }
  }

  // If all validations pass, update the product
  if ($isValid) {
    $db->update("products", [
      'name' => $name,
      'description' => $description,
      'category_id' => $category_id,
      'price' => $price,
      'weight' => $weight,
      'unit_of_measure' => $unit_of_measure,
      'quantity_in_stock' => $quantity_in_stock,
      'image_url' => $image_url,
      'status' => $status
    ], "id = '$productId'");

    $_SESSION['success'] = "Product updated successfully.";
    header("Location: view-product.php?id=$productId");
    exit();
  }
}

$categories = $db->readAll("category");



?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> View Product</h4>

    <div class="card mb-4">
      <h5 class="card-header">Product Details
        <a href="products.php" class="btn btn-primary float-end">
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
              <img src="../public/uploads/<?php echo htmlspecialchars($image_url); ?>" alt="product-image"
                class="d-block rounded" height="100" width="100" id="uploadedImage">
              <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                  <span class="d-none d-sm-block">Upload new image</span>
                  <i class="bx bx-upload d-block d-sm-none"></i>
                  <input type="file" id="upload" name="product_image" class="account-file-input" hidden=""
                    accept="image/png, image/jpeg">
                </label>
                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                  <i class="bx bx-reset d-block d-sm-none"></i>
                  <span class="d-none d-sm-block">Reset</span>
                </button>
                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
              </div>
            </div>

            <div class="mb-3 col-md-6 mt-2">
              <label for="name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="name" name="name"
                value="<?php echo htmlspecialchars($name); ?>" />
              <span class="text-danger"><?php echo $nameErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description"
                name="description"><?php echo htmlspecialchars($description); ?></textarea>
              <span class="text-danger"><?php echo $descriptionErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="parent_id" class="form-label">Category</label>
              <select class="form-control" id="category_id" name="category_id">
                <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category['id']; ?>" <?php echo ($category_id == $category['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="text-danger"><?php echo $categoryErr; ?></span>
            </div>
          <div class="mb-3 col-md-6">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price"
              value="<?php echo htmlspecialchars($price); ?>" />
            <span class="text-danger"><?php echo $priceErr; ?></span>
          </div>
          <div class="mb-3 col-md-6">
            <label for="weight" class="form-label">Weight</label>
            <input type="text" class="form-control" id="weight" name="weight"
              value="<?php echo htmlspecialchars($weight); ?>" />
            <span class="text-danger"><?php echo $weightErr; ?></span>
          </div>
          <div class="mb-3 col-md-6">
            <label for="unit_of_measure" class="form-label">Unit of Measure</label>
            <input type="text" class="form-control" id="unit_of_measure" name="unit_of_measure"
              value="<?php echo htmlspecialchars($unit_of_measure); ?>" />
            <span class="text-danger"><?php echo $unitErr; ?></span>
          </div>

          <div class="mb-3 col-md-6">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
              <option value="active" <?php echo ($status == 'active') ? 'selected' : ''; ?>>Active</option>
              <option value="inactive" <?php echo ($status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
            <span class="text-danger"><?php echo $statusErr; ?></span>
          </div>


          <div class="mb-3 col-md-6">
            <label for="quantity_in_stock" class="form-label">Quantity in Stock</label>
            <input type="text" class="form-control" id="quantity_in_stock" name="quantity_in_stock"
              value="<?php echo htmlspecialchars($quantity_in_stock); ?>" />
            <span class="text-danger"><?php echo $quantityErr; ?></span>
          </div>
      </div>
      <div class="mt-2">
        <button type="submit" class="btn btn-primary me-2">Update Product</button>
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