<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("Location: admin_login.php"); // Chuyển hướng đến trang đăng nhập
    exit;
}

// Lấy thông tin người dùng
$username = $_SESSION['username'];
$avatar = $_SESSION['avatar'] ?? '../../public/images/icons/ic_default_ava_male.png'; // Đường dẫn đến ảnh đại diện
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <title>Website Learning English</title>
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            /* font-family: 'Arial', sans-serif; */
            background-color: #f8f9fa; /* Màu nền nhẹ */
        }
        .sidebar {
            min-width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            border-right: 1px solid #ddd;
            position: fixed;
            height: 100%;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            text-align: center;
        }
        .top-bar {
            background-color:rgb(63, 124, 189);
            color: white;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            width: calc(100% - 250px);
            top: 0;
            left: 276px;
            z-index: 1000;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
        }
        p {
            font-size: 1.2rem;
            color: #666;
        }
        .nav-link {
            font-size: 1.1rem;
            color: white;
            transition: background-color 0.3s;
        }
        .nav-link:hover {
            background-color: #495057;
        }
        .nav-link.active {
            background-color: #007bff;
        }
        .table {
            margin-top: 20px;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-left: auto;
        }
        /* Cải thiện kiểu chữ */
      
        .nav-item {
            margin-bottom: 10px;
        }
        .sidebar {
    /* Thêm các thuộc tính khác của sidebar nếu cần */
}

.sidebar-title {
    text-align: center; /* Căn giữa văn bản */
    font-size: 1.5rem; /* Thay đổi kích thước chữ */
    margin-bottom: 1rem; /* Khoảng cách dưới tiêu đề */
}
    </style>
</head>
<body>

<div class="sidebar">
    <h5 class="sidebar-title">Quản Lý</h5>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="#" onclick="showContent('home')">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('userManagement')">
                <i class="fas fa-user"></i> Quản lý người dùng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('videoManagement')">
                <i class="fas fa-video"></i> Quản lý video
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('classdocumentManagement')">
                <i class="fas fa-file-alt"></i> Quản lý tài liệu theo lớp
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('documentManagement')">
                <i class="fas fa-file-alt"></i> Quản lý tài liệu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('lessondocumentManagement')">
                <i class="fas fa-file-alt"></i> Nội dung tài liệu
            </a>
        </li>
    </ul>
</div>

<div class="top-bar">
    <div class="user-info">
        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="avatar">
        <span class="text-light"><?php echo htmlspecialchars($username); ?></span>
        <a href="admin_logout.php" class="btn btn-danger btn-sm ms-3" style="margin-right:50px">Đăng xuất</a>
    </div>
</div>

<div class="content" id="content-area" style="margin-top: 60px;">
  <script>
    $.ajax({
                url: '../../admin/pages/form_home_manager.php',
                method: 'GET',
                success: function(data) {
                    contentArea.innerHTML = data;
                },
                error: function() {
                    contentArea.innerHTML = '<p>Không thể tải nội dung.</p>';
                }
            });
  </script>
</div>

<script>
function showContent(section) {
    const contentArea = document.getElementById('content-area');
    const navLinks = document.querySelectorAll('.nav-link');

    // Đặt tất cả các liên kết về trạng thái không hoạt động
    navLinks.forEach(link => link.classList.remove('active'));

    // Đánh dấu liên kết hiện tại là hoạt động
    const activeLink = Array.from(navLinks).find(link => link.textContent.includes(section));
    if (activeLink) {
        activeLink.classList.add('active');
    }

    let content = '';
    switch (section) {
        case 'userManagement':
            $.ajax({
                url: '../../admin/pages/form_user_manager.php',
                method: 'GET',
                success: function(data) {
                    contentArea.innerHTML = data;
                },
                error: function() {
                    contentArea.innerHTML = '<p>Không thể tải nội dung.</p>';
                }
            });
            return;
        case 'videoManagement':
            $.ajax({
                url: '../../admin/pages/form_audio_manager.php',
                method: 'GET',
                success: function(data) {
                    contentArea.innerHTML = data;
                },
                error: function() {
                    contentArea.innerHTML = '<p>Không thể tải nội dung.</p>';
                }
            });
            return;
        case 'classdocumentManagement':
            $.ajax({
                url: '../../admin/pages/form_class_manager.php',
                method: 'GET',
                success: function(data) {
                    contentArea.innerHTML = data;
                },
                error: function() {
                    contentArea.innerHTML = '<p>Không thể tải nội dung.</p>';
                }
            });
            return;
        case 'documentManagement':
            $.ajax({
                url: '../../admin/pages/form_document_manager.php',
                method: 'GET',
                success: function(data) {
                    contentArea.innerHTML = data;
                },
                error: function() {
                    contentArea.innerHTML = '<p>Không thể tải nội dung.</p>';
                }
            });
            return;
        case 'lessondocumentManagement':
            $.ajax({
                url: '../../admin/pages/form_vocabulary_manager.php',
                method: 'GET',
                success: function(data) {
                    contentArea.innerHTML = data;
                },
                error: function() {
                    contentArea.innerHTML = '<p>Không thể tải nội dung.</p>';
                }
            });
            return;
        case 'home':
        default:
            $.ajax({
                url: '../../admin/pages/form_home_manager.php',
                method: 'GET',
                success: function(data) {
                    contentArea.innerHTML = data;
                },
                error: function() {
                    contentArea.innerHTML = '<p>Không thể tải nội dung.</p>';
                }
            });
            return;
    }
}
$(document).ready(function() {
    showContent('home');
});
</script>

</body>
</html>