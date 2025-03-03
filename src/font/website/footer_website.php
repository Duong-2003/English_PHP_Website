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
            background-color: hsl(0, 0%, 100%);
            color: #6c757d;
            padding: 40px 0;
        }
        .contact-item {
        display: flex;
        justify-content: space-between; /* Đảm bảo khoảng cách giữa link và thời gian */
        align-items: center; /* Canh giữa dọc */
        margin-bottom: 10px; /* Khoảng cách giữa các mục */
    }

    .footer-link {
        flex: 1; /* Chiếm không gian còn lại */
        margin-right: 10px; /* Khoảng cách giữa link và thời gian */
    }

        .footer-link:hover {
            text-decoration: underline; /* Gạch chân khi hover */
        }

        .social-icon {
            font-size: 45px;
            margin-right: 15px;
            color: rgb(71, 126, 182); /* Màu cho biểu tượng mạng xã hội */
        }

        .social-icon:hover {
            color: rgb(136, 218, 104); /* Thay đổi màu khi hover */
        }
    </style>
</head>

<body>

<footer class="pt-5 pb-5">
    <div class="container d-flex flex-wrap justify-content-between">
        <div class="col-12 col-md-6 col-lg-3 mb-4">
            <div class="d-flex align-items-center mb-4">
                <img src="../public/images/icons/dino.png" alt="Logo" class="h-12 mr-1">
                <img src="../public/images/icons/dino_name.png" alt="Logo" class="h-12">
            </div>
            <p class="font-weight-bold">Vừa chơi vừa học tiếng Anh ngay với tiếng Anh miễn phí cho tất cả mọi người</p>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-4">
    <h5 class="text-uppercase">Liên hệ</h5>
    <div class="contact-item d-flex justify-content-between mb-2">
        <span class="footer-link">Kỹ thuật: 0123.4567</span>
        <span>(08:30 – 21:30)</span>
    </div>
    <div class="contact-item d-flex justify-content-between mb-2">
        <span class="footer-link">Bảo hành: 0123.4567</span>
        <span>(08:30 – 21:30)</span>
    </div>
    <div class="contact-item d-flex justify-content-between mb-2">
        <span class="footer-link">CSKH: 0123.4567</span>
        <span>(08:30 – 21:30)</span>
    </div>
    <!-- <div class="contact-item d-flex justify-content-between mb-2">
        <span class="footer-link">Mua hàng: 0123.4567</span>
        <span>(08:30 – 21:30)</span>
    </div> -->
</div>
<div class="col-12 col-md-6 col-lg-3 mb-4">
    <h5 class="text-uppercase">Thông tin</h5>
    <p>
        <strong>Trụ sở:</strong> Tầng 6 - Tòa nhà Ladeco - 266 Đội Cấn - TP Hà Nội<br>
        <strong>Tổng đài:</strong> <span class="footer-link">19006750</span><br>
        <strong>Email:</strong> <span class="footer-link">support.vn</span>
    </p>
</div>

     
        <div class="col-12 col-md-6 col-lg-3 mb-4">
            <h5 class="text-uppercase">Kết nối với chúng tôi</h5>
            <div class="d-flex">
                <a href="https://www.facebook.com/dinoenglishpage" target="_blank" aria-label="Facebook">
                    <i class="fab fa-facebook social-icon"></i>
                </a>
                <a href="mailto:dinoenglish.allsoft@gmail.com" aria-label="Email">
                    <i class="fas fa-envelope social-icon"></i>
                </a>
                <a href="https://twitter.com/your_twitter_handle" target="_blank" aria-label="Twitter">
                    <i class="fab fa-twitter social-icon"></i>
                </a>
                <a href="https://www.instagram.com/your_instagram" target="_blank" aria-label="Instagram">
                    <i class="fab fa-instagram social-icon"></i>
                </a>
            </div>
        </div>
    </div>
  
    <div class="text-center">
        <p>&copy; 2025 Công ty Cổ phần Thương mại. Tất cả các quyền được bảo lưu.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>