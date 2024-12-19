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