<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lộ Trình Học</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .rounded-3xl {
            border-radius: 1.5rem; /* Bo góc cho các khối */
        }
        .shadow-md {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Hiệu ứng bóng cho hình ảnh */
        }
        .section-title {
            font-weight: bold; /* Đậm cho tiêu đề */
        }
        .icon-container {
            width: 80px;
            height: 80px;
        }
    </style>
</head>

<body>

<section class="py-5">
    <div class="text-center mb-4">
        <h2 class="font-weight-bold display-4">
            <span class="text-success">Lộ trình</span>
            <span class="font-weight-bold"> học</span>
        </h2>
        <p class="text-muted mb-4">
            Ứng dụng Học tiếng Anh online đáp ứng lộ trình học tập rõ ràng phù hợp với trình độ.
        </p>
    </div>

    <div class="d-flex flex-column flex-lg-row justify-content-center gap-4">
        <!-- Sơ cấp -->
        <div class="bg-white rounded-3xl text-center shadow-lg p-4">
            <div class="icon-container bg-white p-2 mx-auto mb-4 shadow-md rounded-circle">
                <img src="<?= '../public/images/icons/ic_beginner.png' ?>" alt="Sơ cấp" class="img-fluid">
            </div>
            <h5 class="section-title mb-3">Sơ cấp</h5>
            <p class="text-muted">Học kiến thức tiếng Anh giao tiếp thông dụng, phù hợp cho người mới bắt đầu.</p>
        </div>
        
        <!-- Trung cấp -->
        <div class="bg-white rounded-3xl text-center shadow-lg p-4">
            <div class="icon-container bg-white p-2 mx-auto mb-4 shadow-md rounded-circle">
                <img src="<?= '../public/images/icons/ic_intermediate.png' ?>" alt="Trung cấp" class="img-fluid">
            </div>
            <h5 class="section-title mb-3">Trung cấp</h5>
            <p class="text-muted">Giúp người học nâng cao trình độ, vượt qua mức căn bản.</p>
        </div>
        
        <!-- Cao cấp -->
        <div class="bg-white rounded-3xl text-center shadow-lg p-4">
            <div class="icon-container bg-white p-2 mx-auto mb-4 shadow-md rounded-circle">
                <img src="<?= '../public/images/icons/ic_advanced.png' ?>" alt="Cao cấp" class="img-fluid">
            </div>
            <h5 class="section-title mb-3">Cao cấp</h5>
            <p class="text-muted">Bài học được thiết kế ở cấp độ cao hơn, giúp người học trở nên thành thạo.</p>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>