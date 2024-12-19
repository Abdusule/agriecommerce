<?php
ob_start(); // Start output buffering
$pageTitle = "Supports";
include "includes/header.php";


?>

<link rel="stylesheet" href="assets/css/app-chat.css">
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">


        <div class="app-chat card overflow-hidden">
            <div class="row g-0">
                <!-- Sidebar Left -->
                <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
                    <div class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                        <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                            <img src="assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                        </div>
                        <h5 class="mt-4 mb-0">John Doe</h5>
                        <span>Admin</span>
                        <i class="bx bx-x bx-lg cursor-pointer close-sidebar" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left"></i>
                    </div>
                    <div class="sidebar-body px-6 pb-6">
                        <div class="my-6">
                            <label for="chat-sidebar-left-user-about" class="text-uppercase text-muted mb-1">About</label>
                            <textarea id="chat-sidebar-left-user-about" class="form-control chat-sidebar-left-user-about" rows="3" maxlength="120">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</textarea>
                        </div>

                        <div class="d-flex mt-6">
                            <button class="btn btn-primary w-100" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left"><i class='bx bx-log-out bx-sm me-2'></i>Logout</button>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar Left-->

                <!-- Chat & Contacts -->
                <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
                    <div class="sidebar-header px-6 border-bottom d-flex align-items-center">
                        <div class="d-flex align-items-center me-6 me-lg-0">
                            <div class="flex-shrink-0 avatar avatar-online me-4" data-bs-toggle="sidebar" data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                                <img class="user-avatar rounded-circle cursor-pointer" src="assets/img/avatars/1.png" alt="Avatar">
                            </div>
                            <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search bx-sm"></i></span>
                                <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                            </div>
                        </div>
                        <i class="bx bx-x bx-lg cursor-pointer position-absolute top-50 end-0 translate-middle d-lg-none d-block" data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
                    </div>
                    <div class="sidebar-body">

                        <!-- Chats -->
                        <ul class="list-unstyled chat-contact-list py-2 mb-0" id="chat-list">
                            <li class="chat-contact-list-item chat-contact-list-item-title mt-0">
                                <h5 class="text-primary mb-0">Chats</h5>
                            </li>
                            <li class="chat-contact-list-item chat-list-item-0 d-none">
                                <h6 class="text-muted mb-0">No Chats Found</h6>
                            </li>
                            <li class="chat-contact-list-item mb-1">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar avatar-online">
                                        <img src="assets/img/avatars/13.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="chat-contact-name text-truncate m-0 fw-normal">Waldemar Mannering</h6>
                                            <small class="text-muted">5 Minutes</small>
                                        </div>
                                        <small class="chat-contact-status text-truncate">Refer friends. Get rewards.</small>
                                    </div>
                                </a>
                            </li>
                            <li class="chat-contact-list-item active mb-1">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar avatar-offline">
                                        <img src="assets/img/avatars/4.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="chat-contact-name text-truncate fw-normal m-0">Felecia Rower</h6>
                                            <small class="text-muted">30 Minutes</small>
                                        </div>
                                        <small class="chat-contact-status text-truncate">I will purchase it for sure. 👍</small>
                                    </div>
                                </a>
                            </li>
                            <li class="chat-contact-list-item mb-0">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar avatar-busy">
                                        <span class="avatar-initial rounded-circle bg-label-success">CM</span>
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="chat-contact-name text-truncate fw-normal m-0">Calvin Moore</h6>
                                            <small class="text-muted">1 Day</small>
                                        </div>
                                        <small class="chat-contact-status text-truncate">If it takes long you can mail inbox user</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- Contacts -->
                        <ul class="list-unstyled chat-contact-list mb-0 py-2" id="contact-list">
                            <li class="chat-contact-list-item chat-contact-list-item-title mt-0">
                                <h5 class="text-primary mb-0">Contacts</h5>
                            </li>
                            <li class="chat-contact-list-item contact-list-item-0 d-none">
                                <h6 class="text-muted mb-0">No Contacts Found</h6>
                            </li>
                            <li class="chat-contact-list-item">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar">
                                        <img src="assets/img/avatars/4.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <h6 class="chat-contact-name text-truncate m-0 fw-normal">Natalie Maxwell</h6>
                                        <small class="chat-contact-status text-truncate">UI/UX Designer</small>
                                    </div>
                                </a>
                            </li>
                            <li class="chat-contact-list-item">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar">
                                        <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <h6 class="chat-contact-name text-truncate m-0 fw-normal">Jess Cook</h6>
                                        <small class="chat-contact-status text-truncate">Business Analyst</small>
                                    </div>
                                </a>
                            </li>
                            <li class="chat-contact-list-item">
                                <a class="d-flex align-items-center">
                                    <div class="avatar d-block flex-shrink-0">
                                        <span class="avatar-initial rounded-circle bg-label-primary">LM</span>
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <h6 class="chat-contact-name text-truncate m-0 fw-normal">Louie Mason</h6>
                                        <small class="chat-contact-status text-truncate">Resource Manager</small>
                                    </div>
                                </a>
                            </li>
                            <li class="chat-contact-list-item">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar">
                                        <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <h6 class="chat-contact-name text-truncate m-0 fw-normal">Krystal Norton</h6>
                                        <small class="chat-contact-status text-truncate">Business Executive</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Chat contacts -->

                <!-- Chat History -->
                <div class="col app-chat-history">
                    <div class="chat-history-wrapper">
                        <div class="chat-history-header border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex overflow-hidden align-items-center">
                                    <i class="bx bx-menu bx-lg cursor-pointer d-lg-none d-block me-4" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                                    <div class="flex-shrink-0 avatar avatar-online">
                                        <img src="assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-4">
                                        <h6 class="m-0 fw-normal">Felecia Rower</h6>
                                        <small class="user-status text-body">NextJS developer</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <button class="btn btn-icon text-secondary dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="true" id="chat-header-actions"><i class="bx bx-dots-vertical-rounded bx-md"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                                            <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history-body">
                            <ul class="list-unstyled chat-history">
                                <li class="chat-message chat-message-right">
                                    <div class="d-flex overflow-hidden">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <p class="mb-0">How can we help? We're here for you! 😄</p>
                                            </div>
                                            <div class="text-end text-muted mt-1">
                                                <i class='bx bx-check-double bx-16px text-success me-1'></i>
                                                <small>10:00 AM</small>
                                            </div>
                                        </div>
                                        <div class="user-avatar flex-shrink-0 ms-4">
                                            <div class="avatar avatar-sm">
                                                <img src="assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="chat-message">
                                    <div class="d-flex overflow-hidden">
                                        <div class="user-avatar flex-shrink-0 me-4">
                                            <div class="avatar avatar-sm">
                                                <img src="assets/img/avatars/4.png" alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <p class="mb-0">Hey John, I am looking for the best admin template.</p>
                                                <p class="mb-0">Could you please help me to find it out? 🤔</p>
                                            </div>
                                            <div class="chat-message-text mt-2">
                                                <p class="mb-0">It should be Bootstrap 5 compatible.</p>
                                            </div>
                                            <div class="text-muted mt-1">
                                                <small>10:02 AM</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="chat-message chat-message-right">
                                    <div class="d-flex overflow-hidden">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <p class="mb-0">sneat has all the components you'll ever need in a app.</p>
                                            </div>
                                            <div class="text-end text-muted mt-1">
                                                <i class='bx bx-check-double bx-16px text-success me-1'></i>
                                                <small>10:03 AM</small>
                                            </div>
                                        </div>
                                        <div class="user-avatar flex-shrink-0 ms-4">
                                            <div class="avatar avatar-sm">
                                                <img src="assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="chat-message">
                                    <div class="d-flex overflow-hidden">
                                        <div class="user-avatar flex-shrink-0 me-4">
                                            <div class="avatar avatar-sm">
                                                <img src="assets/img/avatars/4.png" alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <p class="mb-0">Looks clean and fresh UI. 😃</p>
                                            </div>
                                            <div class="chat-message-text mt-2">
                                                <p class="mb-0">It's perfect for my next project.</p>
                                            </div>
                                            <div class="chat-message-text mt-2">
                                                <p class="mb-0">How can I purchase it?</p>
                                            </div>
                                            <div class="text-muted mt-1">
                                                <small>10:05 AM</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                          
                            </ul>
                        </div>
                        <!-- Chat message form -->
                        <div class="chat-history-footer shadow-xs">
                            <form class="form-send-message d-flex justify-content-between align-items-center ">
                                <input class="form-control message-input border-0 me-4 shadow-none" placeholder="Type your message here...">
                                <div class="message-actions d-flex align-items-center">
                                    <i class="speech-to-text bx bx-microphone bx-md btn btn-icon cursor-pointer text-heading"></i>
                                    <label for="attach-doc" class="form-label mb-0">
                                        <i class="bx bx-paperclip bx-md cursor-pointer btn btn-icon mx-1 text-heading"></i>
                                        <input type="file" id="attach-doc" hidden>
                                    </label>
                                    <button class="btn btn-primary d-flex send-msg-btn">
                                        <span class="align-middle d-md-inline-block d-none">Send</span>
                                        <i class="bx bx-paper-plane bx-sm ms-md-2 ms-0"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Chat History -->

                <!-- Sidebar Right -->
                <div class="col app-chat-sidebar-right app-sidebar overflow-hidden" id="app-chat-sidebar-right">
                    <div class="sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                        <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                            <img src="assets/img/avatars/4.png" alt="Avatar" class="rounded-circle">
                        </div>
                        <h5 class="mt-4 mb-0">Felecia Rower</h5>
                        <span>NextJS Developer</span>
                        <i class="bx bx-x bx-lg cursor-pointer close-sidebar d-block" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right"></i>
                    </div>
                    <div class="sidebar-body p-6 pt-0">
                        <div class="my-6">
                            <p class="text-uppercase mb-1 text-muted">About</p>
                            <p class="mb-0">It is a long established fact that a reader will be distracted by the readable content .</p>
                        </div>
                        <div class="my-6">
                            <p class="text-uppercase mb-1 text-muted">Personal Information</p>
                            <ul class="list-unstyled d-grid gap-4 mb-0 ms-2 py-2 text-heading">
                                <li class="d-flex align-items-center">
                                    <i class='bx bx-envelope'></i>
                                    <span class="align-middle ms-2">josephGreen@email.com</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class='bx bx-phone-call'></i>
                                    <span class="align-middle ms-2">+1(123) 456 - 7890</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class='bx bx-time-five'></i>
                                    <span class="align-middle ms-2">Mon - Fri 10AM - 8PM</span>
                                </li>
                            </ul>
                        </div>
                       <div class="d-flex mt-6">
                            <button class="btn btn-danger w-100" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right">Delete Contact<i class='bx bx-trash bx-sm ms-2'></i></button>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar Right -->

            </div>
            <?php include "includes/footer.php";
            ob_end_flush(); // End output buffering and flush the output
            ?>

            <script src="assets/js/app-chat.js"></script>