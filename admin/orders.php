<?php
$pageTitle = "Orders";
include "includes/header.php";

// Handle deletion request
if (isset($_GET['delete']) && isset($_GET['id'])) {
  $orderId = $_GET['id'];

  // Check if the order ID is valid
  if ($orderId) {
      // Delete the order from the database
      $db->delete("orders", "id='$orderId'");

      $_SESSION['success'] = "Order deleted successfully.";
  } else {
      $_SESSION['success'] = "Order not found.";
  }
}

$columns = "o.*, u.fullname AS fullname, u.address AS address, p.name AS product_name";
$condition = "";

$orders = $db->fetchOrderDetails($columns, $condition);

?>

<link rel="stylesheet" href="assets/css/datatables.bootstrap5.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="assets/css/buttons.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Order Management
    </h4>

    <div class="card mb-4">
      <h5 class="card-header border-bottom">Orders
      </h5>
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?php
          echo $_SESSION['success'];
          unset($_SESSION['success']); // Destroy the session message after showing it
          ?>
        </div>
      <?php endif; ?>

      <div class="card-datatable table-responsive">
        <table id="orderTable" class="datatables-orders table border-top">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Product Name</th>
              <th>User Name</th>
              <th>Quantity</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?php echo htmlspecialchars($order['id']); ?></td>
                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                <td><?php echo htmlspecialchars($order['date']); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="viewOrder(<?php echo $order['id']; ?>)">View</button>
                  <a href="?delete&id=<?php echo $order['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include "includes/footer.php"; ?>

  <script>
    $(document).ready(function() {
      $('#orderTable').DataTable();
    });

    function viewOrder(orderId) {
      window.location.href = 'view-order.php?id=' + orderId;
    }
  </script>

  <script src="assets/js/datatables-bootstrap5.js"></script>