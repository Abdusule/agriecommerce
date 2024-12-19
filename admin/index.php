<?php
$pageTitle = "Dashboard";
include "includes/header.php";


$userCount = count($db->readAll("users"));

?>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Welcome Admin! 🎉</h5>
                <p class="mb-4">
                  You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                  your profile.
                </p>

                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="assets/img/illustrations/man-with-laptop-light.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
    
    </div>

    <div class="row g-6 mb-6">
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span class="text-heading">Users</span>
                <div class="d-flex align-items-center my-1">
                  <h4 class="mb-0 me-2"><?php echo $userCount ?></h4>
                  <p class="text-success mb-0">(+29%)</p>
                </div>
                <small class="mb-0">Total Users</small>
              </div>
              <div class="avatar">
                <span class="avatar-initial rounded bg-label-primary">
                  <i class="bx bx-group bx-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span class="text-heading">Celebrities</span>
                <div class="d-flex align-items-center my-1">
                  <h4 class="mb-0 me-2"><?php echo 0 ?></h4>
                  <p class="text-success mb-0">(+18%)</p>
                </div>
                <small class="mb-0">Total Celebrities </small>
              </div>
              <div class="avatar">
                <span class="avatar-initial rounded bg-label-danger">
                  <i class="bx bx-user-plus bx-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span class="text-heading">Active Packages</span>
                <div class="d-flex align-items-center my-1">
                  <h4 class="mb-0 me-2"><?php echo 13 ?></h4>
                  <p class="text-danger mb-0">(-14%)</p>
                </div>
                <small class="mb-0">Latest analytics</small>
              </div>
              <div class="avatar">
                <span class="avatar-initial rounded bg-label-success">
                  <i class="bx bx-user-check bx-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span class="text-heading">Documents</span>
                <div class="d-flex align-items-center my-1">
                  <h4 class="mb-0 me-2">10</h4>
                  <p class="text-success mb-0">(+42%)</p>
                </div>
                <small class="mb-0">Uploaded credentials</small>
              </div>
              <div class="avatar">
                <span class="avatar-initial rounded bg-label-warning">
                  <i class="bx bx-user-voice bx-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- / Content -->

  <?php include "includes/footer.php"; ?>