 <!-- Menu -->

 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
   <div class="app-brand demo">
     <a href="index.html" class="app-brand-link">
       <span class="app-brand-logo demo">
       
      </span>
       <span class="app-brand-text demo menu-text fw-bolder ms-2"><img src="../public/uploads/logo.png" /></span>
     </a>

     <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
       <i class="bx bx-chevron-left bx-sm align-middle"></i>
     </a>
   </div>

   <div class="menu-inner-shadow"></div>

   <ul class="menu-inner py-1">
     <!-- Dashboard -->
     <li class="menu-item <?php echo $pageTitle == 'Dashboard' ?  'active' : '';?>">
       <a href="index.php" class="menu-link">
         <i class="menu-icon tf-icons bx bx-home-circle"></i>
         <div data-i18n="Analytics">Dashboard</div>
       </a>
     </li>

     <!-- Layouts -->

     <li class="menu-header small text-uppercase">
       <span class="menu-header-text">Pages</span>
     </li>

     <li class="menu-item <?php echo $pageTitle == 'Users' ?  'active' : '';?>">
       <a href="users.php" class="menu-link">
         <i class="menu-icon tf-icons bx bx-user"></i>
         <div data-i18n="Users">Users</div>
       </a>
     </li>

     <li class="menu-item <?php echo $pageTitle == 'Vendors' ?  'active' : '';?>">
       <a href="vendors.php" class="menu-link">
         <i class="menu-icon tf-icons bx bx-user-voice"></i>
         <div data-i18n="Users">Vendors</div>
       </a>
     </li>

     <li class="menu-item <?php echo $pageTitle == 'Products' ?  'active' : '';?>">
       <a href="products.php" class="menu-link">
         <i class="menu-icon tf-icons bx bx-gift"></i>
         <div data-i18n="products">Products</div>
       </a>
     </li>
     <li class="menu-item <?php echo $pageTitle == 'Category' ?  'active' : '';?>">
       <a href="category.php" class="menu-link">
         <i class="menu-icon tf-icons bx bx-collection"></i>
         <div data-i18n="products">Category</div>
       </a>
     </li>

     <li class="menu-item <?php echo $pageTitle == 'Orders' ?  'active' : '';?>">
       <a href="orders.php" class="menu-link">
         <i class="menu-icon tf-icons bx bx-receipt"></i>
         <div data-i18n="products">Orders</div>
       </a>
     </li>
 

     <!-- Misc -->
     <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
     <li class="menu-item <?php echo $pageTitle == 'Settings' ?  'active' : '';?>">
       <a
         href="settings.php"
         class="menu-link">
         <i class="menu-icon tf-icons bx bx-cog"></i>
         <div data-i18n="Support">Settings</div>
       </a>
     </li>
     <li class="menu-item <?php echo $pageTitle == 'Supports' ?  'active' : '';?>">
       <a
         href="supports.php" 
         class="menu-link">
         <i class="menu-icon tf-icons bx bx-support"></i>
         <div data-i18n="Support">Support</div>
       </a>
     </li>
    
     <li class="menu-item">
       <a
         href="?logout=true"
         class="menu-link">
         <i class="menu-icon tf-icons bx bx-log-out"></i>
         <div data-i18n="logout">Logout</div>
       </a>
     </li>
   </ul>
 </aside>
 <!-- / Menu -->