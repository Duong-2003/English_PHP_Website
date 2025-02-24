<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ứng Dụng Học Tiếng Anh</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .nav-link {
            color: #38a169; /* Màu chữ cho nav-link */
            transition: color 0.3s, box-shadow 0.3s; /* Hiệu ứng chuyển màu và shadow */
            padding: 10px 15px; /* Thêm padding cho nav-link */
            border-radius: 5px; /* Bo góc cho nav-link */
        }
        .nav-link:hover {
            color: #2f855a; /* Màu khi hover */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); /* Hiệu ứng shadow khi hover */
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
                <a href="http://localhost/Learning%20English/project/website.php" class="nav-link">HOME</a>
                <a href="#" class="nav-link">DOCUMENT</a>
                <a href="#" class="nav-link">ABOUT</a>
                <a href="#" class="nav-link">BLOG</a>
                <a href="#" class="nav-link">CONTACT</a>
               
            </nav>

            <button class="landing-hover-btn font-semibold outline-none text-white bg-gradient-to-r from-green-400 to-green-700 hover:from-green-300 hover:to-green-600 rounded-lg w-full lg:w-auto h-12 px-6 text-sm transition duration-300">
                   <a href="../project/learn_english.php" style=" text-decoration: none;list-style: none;color:white">BẮT ĐẦU NGAY</a> 
                </button>

            <!-- Menu cho thiết bị di động -->
            <div class="d-lg-none">
                <button id="menu-btn" class="btn text-success">
                    <i class="fas fa-bars"></i>
                </button>
                <div id="mobile-menu" class="dropdown-menu position-absolute bg-white shadow-lg mt-2" style="display: none;">
                    <a class="dropdown-item" href="http://localhost/Learning%20English/project/website.php">Trang chủ</a>
                    <a class="dropdown-item" href="#">Download</a>
                    <a class="dropdown-item" href="#">Giới thiệu</a>
                    <a class="dropdown-item" href="#">Blog</a>
                    <button class="landing-hover-btn font-semibold outline-none text-white bg-gradient-to-r from-green-400 to-green-700 hover:from-green-300 hover:to-green-600 rounded-lg w-full lg:w-auto h-12 px-6 text-sm transition duration-300">
                    BẮT ĐẦU NGAY
                </button>
                </div>
            </div>
        </div>
    </header>

    <script>
        // JavaScript để điều khiển menu di động
        document.getElementById('menu-btn').onclick = function () {
            const menu = document.getElementById('mobile-menu');
            menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
        };
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>