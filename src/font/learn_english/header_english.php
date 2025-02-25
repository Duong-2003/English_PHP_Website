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
            font-family: 'Arial', sans-serif; /* Đặt font chữ cho toàn bộ trang */
        }
        .nav-link {
            color: #38a169; /* Màu chữ cho nav-link */
            transition: color 0.3s, box-shadow 0.3s; /* Hiệu ứng chuyển màu và shadow */
            padding: 10px 15px; /* Thêm padding cho nav-link */
            border-radius: 5px; /* Bo góc cho nav-link */
        }
        .nav-link:hover {
            color: #2f855a; /* Màu khi hover */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); /* Hiệu ứng shadow khi hover */
            background-color: rgba(56, 161, 105, 0.1); /* Màu nền khi hover */
        }
        .language-button {
            margin-left: 20px; /* Khoảng cách giữa nút dịch và các phần khác */
        }
        .dropdown-menu {
            display: none; /* Ẩn dropdown mặc định */
            position: absolute; /* Để đặt vị trí */
        }
        .dropdown-item {
            color: #38a169; /* Màu chữ cho dropdown-item */
            transition: color 0.3s, background-color 0.3s; /* Hiệu ứng chuyển màu cho dropdown-item */
            padding: 10px 15px; /* Thêm padding cho dropdown-item */
            border-radius: 5px; /* Bo góc cho dropdown-item */
        }
        .dropdown-item:hover {
            color: white; /* Màu chữ khi hover */
            background-color: #38a169; /* Màu nền khi hover */
        }
        .dropdown:hover .dropdown-menu {
            display: block; /* Hiển thị dropdown khi hover */
        }
    </style>
</head>

<body>

    <header class="w-100 border-bottom shadow-lg bg-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <a href="/" class="d-flex align-items-center">
                <img src="<?= '../public/images/icons/dino.png' ?>" alt="Logo" class="h-12 mr-1">
                <img src="<?= '../public/images/icons/dino_name.png' ?>" alt="Logo" class="h-12">
            </a>

            <nav class="d-none d-lg-flex gap-3">
            <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="otherDropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Khác">
                    Start
                    </a>
                    <div class="dropdown-menu" aria-labelledby="otherDropdown">
                        <a class="dropdown-item" href="../project/learn_english.php" title="Learn Vocabulary">Learning Vocabulary</a>
                        <a class="dropdown-item" href="../project/video_collection_page.php" title="Singing and Videos">Singing and Videos</a>
                        <es class="dropdown-item" href="" title="Singing and Videos">Games Learning English</a>
                        
                        
                    </div>
                </div>
                <!-- <a href="../project/learn_english.php" class="nav-link" title="Bắt đầu">Start</a> -->

                <a href="../project/profile_english.php" class="nav-link" title="Hồ sơ">Profile</a>
                <a href="../project/setting_english.php" class="nav-link" title="Cài đặt">Setting</a>
                <a href="../project/document_english.php" class="nav-link" title="Tài liệu">Document</a>
                <!-- <a href="../project/video_collection_page.php" class="nav-link" title="Tài liệu">Singing and Videos</a> -->
                <!-- Dropdown cho "Other" -->
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="otherDropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Khác">
                        Other
                    </a>
                    <div class="dropdown-menu" aria-labelledby="otherDropdown">
                        <a class="dropdown-item" href="../project/translate_english.php" title="Translate">Translate</a>
                        <a class="dropdown-item" href="#" title="Saved Word">Saved Word</a>
                    </div>
                </div>
            </nav>

            <div class="d-lg-none">
                <button id="menu-btn" class="btn text-success">
                    <i class="fas fa-bars"></i>
                </button>
                <div id="mobile-menu" class="dropdown-menu position-absolute bg-white shadow-lg mt-2" style="display: none;">
                    <a class="dropdown-item" href="http://localhost/Learning%20English/project/website.php">Start</a>
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">Setting</a>
                    <a class="dropdown-item" href="#">Other</a>
                </div>
            </div>

            <!-- Phần Dịch Tiếng Anh -->
            <a href="../project/login.php"><button class="btn btn-outline-success language-button"> Login/Register</button></a>
        </div>
    </header>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>