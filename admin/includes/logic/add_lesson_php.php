<?php
session_start();
include '../../../config/conn.php'; // Bao gồm file kết nối

// Khởi tạo biến
$title = '';
$content = '';
$image_url = '';
$id = null;

// Kiểm tra nếu có ID (sửa bài học)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT title, content, image_url FROM lessons WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $lesson = $result->fetch_assoc();
        $title = $lesson['title'];
        $content = $lesson['content'];
        $image_url = $lesson['image_url'];
    }
}

// Xử lý thêm/sửa bài học
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = '';

    // Kiểm tra nếu người dùng tải lên hình ảnh
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Thư mục lưu trữ file
        $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);

        // Di chuyển file từ thư mục tạm đến thư mục uploads
        if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
            $image_url = $target_file; // Gán URL file hình ảnh đã tải lên
        }
    } else {
        $image_url = $image_url; // Giữ nguyên hình ảnh cũ nếu không có hình mới
    }

    // Thực hiện thêm hoặc sửa bài học
    if ($id) {
        // Cập nhật bài học
        $stmt = $conn->prepare("UPDATE lessons SET title = ?, content = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $image_url, $id);
    } else {
        // Thêm bài học mới
        $stmt = $conn->prepare("INSERT INTO lessons (title, content, image_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $image_url);
    }
    
    $stmt->execute();
    header("Location: ../../admin/pages/form_lesson_manager.php"); // Quay lại trang quản lý bài học
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Sửa Bài Học' : 'Thêm Bài Học'; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2><?php echo $id ? 'Sửa Bài Học' : 'Thêm Bài Học'; ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($content); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình Ảnh</label>
            <input type="file" class="form-control" id="image" name="image_upload" accept="image/*">
            <?php if ($image_url): ?>
                <img src="<?php echo htmlspecialchars($image_url); ?>" alt="Hình ảnh" style="width: 100px; height: auto; margin-top: 10px;">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Cập Nhật' : 'Thêm'; ?></button>
    </form>
    <a href="lesson_manager.php" class="btn btn-secondary mt-3">Quay lại</a>
</div>
</body>
</html>