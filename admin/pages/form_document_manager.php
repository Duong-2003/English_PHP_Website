<?php
session_start();
include '../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm tài liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $title = $_POST['title'];
    $file_url = '';
    
    // Kiểm tra nếu người dùng tải lên file
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Thư mục lưu trữ file
        $target_file = $target_dir . basename($_FILES["file_upload"]["name"]);

        // Di chuyển file từ thư mục tạm đến thư mục uploads
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
            $file_url = $target_file; // Gán URL file đã tải lên
        }
    } else {
        // Nếu không tải lên file, sử dụng URL
        $file_url = $_POST['file_url'];
    }

    if (!empty($file_url)) {
        $stmt = $conn->prepare("INSERT INTO documents (class_id, title, file_url) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $class_id, $title, $file_url);
        $stmt->execute();
    }
}

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.document_id, d.title, d.file_url, c.class_name 
                             FROM documents d 
                             JOIN classes c ON d.class_id = c.class_id");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tài Liệu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Quản Lý Tài Liệu Tiếng Anh</h2>
    <button>
    <a href="../../admin/includes/logic/add_document_manager.php#" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
    </button>

    <hr>

    <!-- Danh sách tài liệu -->
    <h3>Danh Sách Tài Liệu</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Lớp</th>
                <th>Tài Liệu</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($doc = $documents->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $doc['document_id']; ?></td>
                    <td><?php echo $doc['title']; ?></td>
                    <td><?php echo $doc['class_name']; ?></td>
                    <td><a href="<?php echo $doc['file_url']; ?>" target="_blank">Xem</a></td>
                    <td>
                    <a href="../../admin/includes/logic/add_document_manager.php" class="btn btn-success" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
                        <a href="../../admin/includes/logic/edit_document_manager.php" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Sửa</a>
                        <a href="../../admin/includes/logic/delete_user_manager.php?key=user_id&table=users&datakey=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
                       
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>