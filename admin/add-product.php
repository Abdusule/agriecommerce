<?php
ob_start();
$pageTitle = "Products";
include "includes/header.php";

$pageTitle = "Add Product";

// Initialize variables and error messages
$name = $description = $category_id = $price = $weight = $unit_of_measure = $quantity_in_stock = $image_url = $status = "";
$nameErr = $priceErr = $categoryErr = $imageErr = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Product name is required";
        $isValid = false;
    } else {
        $name = $_POST["name"];
    }

    // Validate price
    if (empty($_POST["price"])) {
        $priceErr = "Price is required";
        $isValid = false;
    } elseif (!is_numeric($_POST["price"])) {
        $priceErr = "Price must be a number";
        $isValid = false;
    } else {
        $price = $_POST["price"];
    }

    // Validate category
    if (empty($_POST["category_id"])) {
        $categoryErr = "Category is required";
        $isValid = false;
    } else {
        $category_id = $_POST["category_id"];
    }

    // Handle image upload
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../public/uploads/';
        $fileTmpPath = $_FILES['image_url']['tmp_name'];
        $fileName = time() . '_' . $_FILES['image_url']['name'];
        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $image_url = $fileName;
        } else {
            $imageErr = "There was an error uploading the image.";
            $isValid = false;
        }
    } else {
        $imageErr = "Product image is required.";
        $isValid = false;
    }

    // If all validations pass, insert the product
    if ($isValid) {
        $status = 'active';
        $created_at = date('Y-m-d H:i:s');

        $productId = $db->create("products", [
            'name' => $name,
            'description' => $_POST['description'],
            'category_id' => $category_id,
            'price' => $price,
            'weight' => $_POST['weight'],
            'unit_of_measure' => $_POST['unit_of_measure'],
            'quantity_in_stock' => $_POST['quantity_in_stock'],
            'image_url' => $image_url,
            'status' => $status,
            'created_at' => $created_at
        ]);

        if ($productId) {
            $_SESSION['success'] = "Product added successfully.";
            header("Location: products.php");
            exit();
        } else {
            $imageErr = "There was an error creating the product.";
        }
    }
}

$categories = $db->readAll("category");

?>

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Add Product</h4>

    <div class="card mb-4">
      <h5 class="card-header">Add New Product
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
            <div class="mb-3 col-md-6">
              <label for="name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" />
              <span class="text-danger"><?php echo $nameErr; ?></span>
            </div>
            <div class="mb-3 col-md-6">
              <label for="price" class="form-label">Price</label>
              <input type="number" min="0" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" />
              <span class="text-danger"><?php echo $priceErr; ?></span>
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
          </div>
            <div class="mb-3 col-md-6">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="mb-3 col-md-6">
              <label for="weight" class="form-label">Weight</label>
              <input type="text" class="form-control" id="weight" name="weight" value="<?php echo htmlspecialchars($weight); ?>" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="unit_of_measure" class="form-label">Unit of Measure</label>
              <input type="text" class="form-control" id="unit_of_measure" name="unit_of_measure" value="<?php echo htmlspecialchars($unit_of_measure); ?>" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="quantity_in_stock" class="form-label">Quantity in Stock</label>
              <input type="number" min="0" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="<?php echo htmlspecialchars($quantity_in_stock); ?>" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="image_url" class="form-label">Product Image</label>
              <input type="file" class="form-control" id="image_url" name="image_url" />
              <span class="text-danger"><?php echo $imageErr; ?></span>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Add Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; 
ob_end_flush();
?>