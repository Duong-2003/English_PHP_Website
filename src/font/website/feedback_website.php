<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-control {
            border-radius: 10px; /* Bo góc cho ô nhập liệu */
            transition: box-shadow 0.3s ease; /* Hiệu ứng chuyển động cho ô nhập liệu */
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5); /* Hiệu ứng khi ô được chọn */
            border-color: #4caf50; /* Màu viền khi focus */
        }
        .btn-success {
            border-radius: 10px; /* Bo góc cho nút */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Hiệu ứng cho nút */
            font-size: 1.25rem; /* Kích thước chữ lớn hơn */
            padding: 10px 20px; /* Padding để nút lớn hơn */
        }
        .btn-success:hover {
            background-color: #45a049; /* Màu nền khi hover */
            transform: scale(1.05); /* Tăng kích thước khi hover */
        }
        .section {
            max-width: 750px; /* Giới hạn chiều rộng */
            margin: 0 auto; /* Căn giữa */
        }
        .textarea-custom {
            resize: none; /* Không cho phép thay đổi kích thước */
            height: 180px; /* Đặt chiều cao */
            width: 100%; /* Đảm bảo chiều rộng 100% */
            max-width: 100%; /* Đảm bảo chiều rộng không vượt quá 100% */
        }
    </style>
</head>

<body>

<section class="py-5">
    <div class="text-center font-weight-bold">
        <h2 class="display-4 mb-4">
            <span class="text-success">Liên hệ</span>
            <span class="font-weight-bold"> với chúng tôi</span>
        </h2>
        <p class="text-muted mx-auto mb-4" style="max-width: 750px;">
            Đặt câu hỏi với chúng tôi nếu bạn có thắc mắc hay không hiểu về English.
        </p>
    </div>
    <form class="section d-flex flex-column align-items-center">
        <textarea class="form-control mb-3 textarea-custom" placeholder="Đặt câu hỏi hoặc góp ý cho chúng tôi" name="msg"></textarea>
        <input class="form-control mb-3" type="text" placeholder="Nhập email của bạn tại đây" name="email">
        
        <button class="landing-hover-btn font-semibold outline-none text-white bg-gradient-to-r from-green-400 to-green-700 hover:from-green-300 hover:to-green-600 rounded-lg w-full lg:w-auto h-12 px-6 text-sm transition duration-300">
        GỬI
                </button>
    </form>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>