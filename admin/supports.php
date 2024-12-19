<?php
ob_start(); // Start output buffering

$pageTitle = "Supports";
include "includes/header.php";

if (array_key_exists('user_id', $_SESSION)) {

    $user_id = $_SESSION['user_id'];

    $msgs = $db->readAll("messages", "WHERE user_id='$user_id'");
    if ($msgs) {

        foreach ($msgs as $msg) {
            $imagePath = '' . $msg['upload'];
            // Delete the image file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }


    $db->delete("messages", "user_id='$user_id'");

    $_SESSION['success'] = "Chats deleted successfully.";

    unset($_SESSION['user_id']);
}
?>
<link rel="stylesheet" href="assets/css/app-chat.css">


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-chat card overflow-hidden">
            <div class="row g-0">
                <!-- Sidebar Left (Admin Profile) -->
                <div class="col app-chat-sidebar-left app-sidebar overflow-hidden data-overlay" id="app-chat-sidebar-left">
                    <div class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                        <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                            <img src="assets/img/avatars/1.png" alt="Admin Avatar" class="rounded-circle">
                        </div>
                        <h5 class="mt-4 mb-0"><?php echo $admin['username'] ?? 'Admin'; ?></h5>
                        <span>Admin Support</span>
                        <i class="bx bx-menu bx-lg cursor-pointer d-lg-none d-block me-4 close-sidebar" data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                    </div>
                </div>

                <!-- Chat Contacts -->
                <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
                    <div class="sidebar-header px-6 border-bottom d-flex align-items-center">
                        <div class="flex-shrink-0 avatar avatar-online me-4" data-bs-toggle="sidebar" data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                            <img class="user-avatar rounded-circle cursor-pointer" src="assets/img/avatars/1.png" alt="Avatar">
                        </div>
                        <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                            <span class="input-group-text"><i class="bx bx-search bx-sm"></i></span>
                            <input type="text" class="form-control chat-search-input" placeholder="Search Users..." id="user-search">
                        </div>
                    </div>
                    <div class="sidebar-body">
                        <ul class="list-unstyled chat-contact-list py-2 mb-0" id="user-contact-list">
                            <?php
                            // Fetch users who have sent messages
                            $usersWithLastMessageTime = $db->getAllUsersWithLastMessageTime();

                            foreach ($usersWithLastMessageTime as $user) {
                                $unread_count = count($db->readAllNew("messages", "user_id = :user_id AND status = 'sent' AND from_admin = 'no'", [':user_id' => $user['id']]));
                            ?>
                                <li class="chat-contact-list-item user-contact" data-user-id="<?php echo $user['id']; ?>">
                                    <a class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar">
                                            <img src="../public/uploads/<?php echo $user['image'] ?? 'assets/img/avatars/default.png'; ?>" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div class="chat-contact-info flex-grow-1 ms-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="chat-contact-name text-truncate m-0 fw-normal"><?php echo $user['fullname']; ?></h6>
                                                <?php if ($unread_count > 0) { ?>
                                                    <span class="badge bg-danger rounded-pill"><?php echo $unread_count; ?></span>
                                                <?php } ?>
                                            </div>
                                            <small class="chat-contact-status text-truncate"><?php echo $user['email']; ?></small>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <!-- Chat History -->
                <div class="col app-chat-history" id="chat-history-section">
                    <div class="chat-history-wrapper">
                        <div class="chat-history-header border-bottom text-center">
                            <div class="d-flex overflow-hidden align-items-center">
                                <i class="bx bx-menu bx-lg cursor-pointer d-lg-none d-block me-4" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                                <div class="flex-shrink-0 avatar avatar-online">
                                    <img src="assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right">
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-4">
                                    <h6 class="m-0 fw-bolder"><?php echo ucfirst($admin['username']) ?>
                                    <div class="row float-end">
                                        <div class="col-6">
                                        <a href="?clearchat" class="btn btn-primary " onclick="return confirm('Are you sure you want to clear chats?')">
                                            <i class="bx bx-trash"></i> Clear chats</a></div>
                                        <div class="col-6"> <a href="mobile-support.php" class="btn btn-success">
                                        <i class="bx bx-phone"></i> Mobile Mode</a></div>
                                    </div>
                                           
                                    </h6>
                                    <small class="user-status text-body">Administrator Chat</small>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history-body">
                            <ul class="list-unstyled chat-history" id="chat-messages">
                                <!-- Messages will be dynamically loaded here -->
                            </ul>
                        </div>
                        <div class="chat-history-footer shadow-xs" id="message-input-section" style="display:none;">
                            <form id="send-message-form" class="form-send-message d-flex justify-content-between align-items-center" enctype="multipart/form-data">
                                <input type="hidden" id="selected-user-id" name="user_id" value="">
                                <input type="text" class="form-control message-input border-0 me-4 shadow-none"
                                    id="message-input" name="message" placeholder="Type your message here..." required>
                                <input type="file" id="image-input" name="image" accept="image/*" class="form-control border-0 shadow-none" placeholder="Attach Image">
                                <div class="message-actions d-flex align-items-center">
                                    <button type="submit" id="send-message" class="btn btn-primary d-flex send-msg-btn">
                                        <span class="align-middle d-md-inline-block d-none">Send</span>
                                        <i class="bx bx-paper-plane bx-sm ms-md-2 ms-0"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php";
    ob_end_flush(); ?>

    <script>
        $(document).ready(function() {
            let activeUserId = null;

            // Function to load chat messages
            function loadChatMessages(userId) {
                $.ajax({
                    url: 'ajax_get_messages.php',
                    method: 'POST',
                    data: {
                        user_id: userId
                    },
                    success: function(response) {
                        $('#chat-messages').html(response);
                    }
                });
            }

            // Function to mark messages as read
            function markMessagesAsRead(userId) {
                $.ajax({
                    url: 'ajax_mark_read.php',
                    method: 'POST',
                    data: {
                        user_id: userId
                    }
                });
            }

            // User contact click to load chat
            $('.user-contact').on('click', function() {
                activeUserId = $(this).data('user-id');
                $('#selected-user-id').val(activeUserId);
                $('#message-input-section').show();

                loadChatMessages(activeUserId);
                markMessagesAsRead(activeUserId);


            });

            // Periodically refresh chat messages
            setInterval(function() {
                if (activeUserId) {
                    loadChatMessages(activeUserId);
                }
            }, 5000); // Refresh every 5 seconds

            // Send message
            $('#send-message').on('click', function(e) {
                const message = $('#message-input').val().trim();
                const activeUserId = $('#selected-user-id').val().trim();
                const imageFile = $('#image-input')[0].files[0];

                if ((message || imageFile) && activeUserId) {
                    const formData = new FormData();
                    formData.append('user_id', activeUserId);
                    formData.append('message', message);
                    if (imageFile) {
                        formData.append('image', imageFile);
                    }

                    $.ajax({
                        url: 'ajax_send_message.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#message-input').val('');
                            $('#image-input').val('');
                            loadChatMessages(activeUserId);
                        }
                    });
                }
            });

            // User search functionality
            $('#user-search').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.user-contact').each(function() {
                    const userName = $(this).find('.chat-contact-name').text().toLowerCase();
                    $(this).toggle(userName.includes(searchTerm));
                });
            });
        });
    </script>
    <script src="assets/js/app-chat.js"></script>