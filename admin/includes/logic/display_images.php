<?php
// Đường dẫn đến thư mục chứa hình ảnh
$imageDirectory = 'C:/xampp/htdocs/Learning English/admin/assets/images/'; // Sử dụng gạch chéo

// Kiểm tra xem thư mục có tồn tại không
if (is_dir($imageDirectory)) {
    // Lấy tất cả các tệp trong thư mục
    $images = scandir($imageDirectory);
    if ($images === false) {
        echo "Không thể mở thư mục.";
        $images = []; // Đặt mảng hình ảnh về rỗng nếu thư mục không mở được
    }
} else {
    echo "Thư mục không tồn tại.";
    $images = []; // Đặt mảng hình ảnh về rỗng nếu thư mục không tồn tại
}

// Lọc chỉ lấy các tệp hình ảnh
$imageFiles = array_filter($images, function($file) use ($imageDirectory) {
    return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file) && is_file($imageDirectory . $file);
});
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hiển Thị Hình Ảnh</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .image-container {
            display: flex;
            flex-wrap: wrap;
        }
        .image-container img {
            width: 100px; /* Kích thước cố định cho hình ảnh */
            height: 100px; /* Kích thước cố định cho hình ảnh */
            object-fit: cover; /* Đảm bảo hình ảnh không bị biến dạng */
            margin: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Hình Ảnh</h2>
    <div class="image-container">
        <?php if (!empty($imageFiles)): ?>
            <?php foreach ($imageFiles as $image): ?>
                <?php $imgSrc = '../../../admin/assets/images/' . htmlspecialchars($image); ?> <!-- Đường dẫn tương đối -->
                <img src="<?php echo $imgSrc; ?>" alt="Hình ảnh">
                <!-- <p><?php echo $imgSrc; ?></p>  -->
                <!-- Hiển thị đường dẫn hình ảnh -->
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có hình ảnh nào trong thư mục này.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>