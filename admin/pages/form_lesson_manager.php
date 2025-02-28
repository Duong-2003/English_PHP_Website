<?php
session_start();
include '../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm bài học
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
    }

    // Chèn bài học vào cơ sở dữ liệu
    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO lessons (title, content, image_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $image_url);
        $stmt->execute();
    }
}

// Lấy danh sách bài học
$lessons = $conn->query("SELECT id, title, content, image_url FROM lessons");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Bài Học</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Quản Lý Bài Học</h2>
    <button>
        <a href="../../admin/includes/logic/add_lesson_manager.php" class="btn btn-warning">Thêm Bài Học</a>
    </button>

    <hr>

    <!-- Danh sách bài học -->
    <h3>Danh Sách Bài Học</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Nội Dung</th>
                <th>Hình Ảnh</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($lesson = $lessons->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $lesson['id']; ?></td>
                    <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                    <td><?php echo htmlspecialchars($lesson['content']); ?></td>
                    <td>
                        <?php if ($lesson['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($lesson['image_url']); ?>" alt="Hình ảnh" style="width: 100px; height: auto;">
                        <?php endif; ?>
                    </td>
                    <td>
                    <a href="../../admin/includes/logic/add_lesson_php.php" class="btn btn-success" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
                        <a href="../../admin/includes/logic/edit_lesson_manager.php" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Sửa</a>
                        <a href="../../admin/includes/logic/delete_user_manager.php?key=user_id&table=users&datakey=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
                       
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>