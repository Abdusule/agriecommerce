<?php
include('../config/auth.php');

//Check if user is logged In
if (!isset($_SESSION['admin'])) {
  header('location: login.php');
  exit();
}

//Logout user
if (array_key_exists('logout', $_GET)) {
  if ($_GET['logout']) {
    unset($_SESSION['admin']);
  }
  header('location: login.php');
  exit();
}

$site_setting = $db->read("settings", "WHERE id=1");

// Assuming the admin ID is stored in the session
$adminId = $_SESSION['admin'];

// Fetch admin information from the database
$admin = $db->read("admins", "WHERE id = '$adminId'");

?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?php echo $site_setting['site_name']; ?> | <?php echo $pageTitle ?></title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../public/uploads/favicon.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="assets/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="assets/css/theme-default-2.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />


  <link rel="stylesheet" href="assets/css/typeahead.css" />
  <link rel="stylesheet" href="assets/css/bootstrap-select.css" />
  <link rel="stylesheet" href="assets/css/select2.css" />
  <link rel="stylesheet" href="assets/css/flatpickr.css" />
  <link rel="stylesheet" href="assets/css/typeahead.css" />
  <link rel="stylesheet" href="assets/css/tagify.css" />
  <link rel="stylesheet" href="assets/css/form-validation.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <?php include "sidebar.php"; ?>

      <!-- Layout container -->
      <div class="layout-page">

        <?php include "navbar.php"; ?>