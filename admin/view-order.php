<?php
ob_start(); // Start output buffering
$pageTitle = "Products";
include "includes/header.php";

// Assume $db is your database connection object
$orderId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch order details
if ($orderId) {
  $order = $db->read("orders", "WHERE id='$orderId'");
  if ($order) {

    $name = $order['name'];
    $description = $order['description'];
    $category_id = $order['category_id'];
    $price = $order['price'];
    $weight = $order['weight'];
    $unit_of_measure = $order['unit_of_measure'];
    $quantity_in_stock = $order['quantity_in_stock'];
    $image_url = $order['image_url'];
    $status = $order['status'];
    
  } else {
    $_SESSION['success'] = "Order not found.";
    header("Location: orders.php");
    exit();
  }
} else {
  header("Location: ../");
}



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
        <a href="orders.php" class="btn btn-primary float-end">
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

        <div class="container">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title"><strong>Order Summary</strong></h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xs-12">
                  <div class="invoice-title">
                    <h3>Order #<?php echo htmlspecialchars($data['order_id']); ?></h3>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-xs-6">
                      <address>
                        <strong>Billed To:</strong><br>
                        <?php echo htmlspecialchars($data['username']); ?><br>
                        <?php echo htmlspecialchars($data['address']); ?>
                      </address>
                    </div>
                    <div class="col-xs-6 text-right">
                      <address>
                        <strong>Shipped To:</strong><br>
                        <?php echo htmlspecialchars($data['username']); ?><br>
                        <?php echo htmlspecialchars($data['address']); ?>
                      </address>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6">
                      <address>
                        <strong>Payment Details:</strong><br>
                        Bank Name: <?php echo htmlspecialchars($site_setting['bank_name']); ?><br>
                        Account Number: <?php echo htmlspecialchars($site_setting['account_number']); ?><br>
                        Company Name: <?php echo htmlspecialchars($site_setting['site_name']); ?>
                      </address>
                    </div>
                    <div class="col-xs-6 text-right">
                      <address>
                        <strong>Order Date:</strong><br>
                        <?php echo htmlspecialchars($data['order_date']); ?><br><br>
                      </address>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-condensed">
                      <thead>
                        <tr>
                          <td><strong>Product Name</strong></td>
                          <td class="text-center"><strong>Price</strong></td>
                          <td class="text-center"><strong>Quantity</strong></td>
                          <td class="text-right"><strong>Totals</strong></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($description as $item): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($item['order_name']); ?></td>
                            <td class="text-center"><?php echo $site_setting['symbol'];?><?php echo htmlspecialchars($item['price']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td class="text-right"><?php echo $site_setting['symbol'];?><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                        <tr>
                          <td class="thick-line"></td>
                          <td class="thick-line"></td>
                          <td class="thick-line text-center"><strong>Subtotal</strong></td>
                          <td class="thick-line text-right"><?php echo $site_setting['symbol'];?><?php echo htmlspecialchars($data['sub_total']); ?></td>
                        </tr>
                        <tr>
                          <td class="no-line"></td>
                          <td class="no-line"></td>
                          <td class="no-line text-center"><strong>Shipping</strong></td>
                          <td class="no-line text-right"><?php echo $site_setting['symbol'];?><?php echo htmlspecialchars($data['shipping_fee']); ?></td>
                        </tr>
                        <tr>
                          <td class="no-line"></td>
                          <td class="no-line"></td>
                          <td class="no-line text-center"><strong>Total</strong></td>
                          <td class="no-line text-right"><?php echo $site_setting['symbol'];?><?php echo htmlspecialchars($data['total']); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<?php include "includes/footer.php";
ob_end_flush(); // End output buffering and flush the output
?>

<script src="assets/js/datatables-bootstrap5.js"></script>