<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ứng Dụng Học Tiếng Anh</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
       
    body {
        font-family: 'Arial', sans-serif;
    }

    .nav-link {
        color: #38a169; /* Màu chữ cho nav-link */
        transition: color 0.3s, box-shadow 0.3s;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .nav-link:hover {
        color: #ffffff; /* Màu chữ khi hover */
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        background-color:rgb(89, 209, 149); /* Màu nền khi hover */
    }

    .dropdown-item {
        color: #38a169; /* Màu chữ cho dropdown-item */
        transition: color 0.3s, background-color 0.3s;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .dropdown-item:hover {
        color: #ffffff; /* Màu chữ khi hover */
        background-color: rgb(89, 209, 149); /* Màu nền khi hover */
    }

    .dropdown:hover .dropdown-menu {
        display: block; /* Hiển thị dropdown khi hover */
    }
</style>
    </style>
</head>
<?php
include("../config/conn.php"); // Kết nối cơ sở dữ liệu

$user = null; // Khởi tạo biến người dùng

if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = ?"; // Sử dụng username để lấy thông tin người dùng
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Lấy dữ liệu người dùng
    }
}
?>

<body>

    <header class="w-100 border-bottom shadow-lg bg-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <a href="../project/website.php" class="d-flex align-items-center">
                <img src="<?= '../public/images/icons/dino.png' ?>" alt="Logo" class="h-12 mr-1">
                <img src="<?= '../public/images/icons/dino_name.png' ?>" alt="Logo" class="h-12">
            </a>

            <nav class="d-none d-lg-flex gap-3">
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="otherDropdown" role="button" aria-haspopup="true"
                        aria-expanded="false" title="Khác">
                        Start Learn English
                    </a>
                    <div class="dropdown-menu" aria-labelledby="otherDropdown">
                        <a class="dropdown-item" href="../project/learn_english.php" title="Learn Vocabulary">Learning
                            Vocabulary</a>
                            <es class="dropdown-item" href="" title="Singing and Videos">Games Learning English</a>



                    </div>
                </div>
                <!-- <a href="../project/learn_english.php" class="nav-link" title="Bắt đầu">Start</a> -->


             
                <a class="dropdown-item" href="../project/audio_collection_page.php"
                title="Singing and Videos">Singing With Videos</a>

                <a href="../project/document_english.php" class="nav-link" title="Tài liệu">Document</a>


                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" id="otherDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" title="Khác">
                        Other
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="otherDropdown">
                        <li><a class="dropdown-item" href="../project/translate_english.php"
                                title="Translate">Translate</a></li>
                        <li><a class="dropdown-item" href="../project/save_word.php" title="Saved Word">Saved Word</a></li>
                        <!-- Thêm các mục khác nếu cần -->
                    </ul>
                </div>
               
             
            </nav>

            <div class="d-lg-none">
                <button id="menu-btn" class="btn text-success">
                    <i class="fas fa-bars"></i>
                </button>
                <div id="mobile-menu" class="dropdown-menu position-absolute bg-white shadow-lg mt-2"
                    style="display: none;">
                    <a class="dropdown-item" href="http://localhost/Learning%20English/project/website.php">Start</a>

                    <a class="dropdown-item" href="#">Setting</a>
                    <a class="dropdown-item" href="#">Other</a>
                </div>
            </div>

            <?php if (isset($user)): ?>
                <!-- Nếu người dùng đã đăng nhập, hiển thị icon người dùng -->
                <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="../public/images/icons/ic_default_ava_male.png" alt="User Avatar" class="h-10 ">
                    <?php echo htmlspecialchars($user['username']); ?>
                </a>
                <!-- Dropdown menu -->
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="../project/profile_english.php">Profile</a></li>
                    <li><a class="dropdown-item" href="../project/setting_english.php">Settings</a></li>
                    <li><a class="dropdown-item" href="../project/reset_pass.php">Reset Password</a></li>
                    <li><a class="dropdown-item" href="../project/logout.php">Logout</a></li>
                </ul>

            <?php else: ?>
                <!-- Nếu người dùng chưa đăng nhập, hiển thị các nút đăng nhập và đăng ký -->
                <a href="../project/login.php">

                    <a href="../project/login.php"><button class="btn btn-outline-success language-button">
                            Login/Register</button></a>

                </a>
            <?php endif; ?>
        </div>
    </header>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>