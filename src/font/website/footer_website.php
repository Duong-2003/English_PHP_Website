<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        footer {
            background-color: #f8f9fa;
        }
        .footer-link {
            color: #007bff; /* Màu xanh cho liên kết */
            text-decoration: none; /* Bỏ gạch chân */
        }
        .footer-link:hover {
            text-decoration: underline; /* Gạch chân khi hover */
        }
        .social-icon {
            font-size: 44px;
            margin-right: 15px;
        }
    </style>
</head>

<body>

<footer class="pt-5 pb-5">
    <div class="container d-flex flex-wrap justify-content-between">
        <div class="col-12 col-md-6 col-lg-3 mb-4">
            <div class="d-flex align-items-center mb-4">
                <img src="<?= '../public/images/icons/dino.png' ?>" alt="Logo" class="h-12 mr-1">
                <img src="<?= '../public/images/icons/dino_name.png' ?>" alt="Logo" class="h-12">
            </div>
            <p class="font-weight-bold">Vừa chơi vừa học tiếng Anh ngay với  tiếng Anh miễn phí cho tất cả mọi người</p>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-4">
            <h2 class="h5 font-weight-bold">Chính sách</h2>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-4">
            <h2 class="h5 font-weight-bold">Liên hệ</h2>
            <p>Kết nối với chúng tôi</p>
            <div class="d-flex">
                <a href="https://www.facebook.com/dinoenglishpage" target="_blank" aria-label="Facebook">
                    <i class="fab fa-facebook social-icon" style="color: #3b5998;"></i>
                </a>
                <a href="mailto:dinoenglish.allsoft@gmail.com" aria-label="Email">
                    <i class="fas fa-envelope social-icon" style="color: #EA4335;"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-4">
            <h2 class="h5 font-weight-bold">Download</h2>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
            <div>
                <a href="#" target="_blank" class="footer-link ">Chính sách bảo mật</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>