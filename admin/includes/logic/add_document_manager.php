<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

// Kiểm tra nếu có yêu cầu thêm tài liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_document'])) {
    $title = $_POST['title'];
    $user_id = $_POST['user_id']; // Lấy user_id từ form
    $file_name = basename($_FILES['file']['name']); // Lấy tên file
    $file_tmp = $_FILES['file']['tmp_name'];
    $upload_dir = '../admin/assets/uploads/'; // Thư mục lưu trữ tài liệu

    // Kiểm tra nếu thư mục tồn tại, nếu không thì tạo
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Di chuyển file từ thư mục tạm tới thư mục lưu trữ
    if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
        $file_path = $upload_dir . $file_name;

        // Thêm tài liệu vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO documents (title, file_name, file_path, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $file_name, $file_path, $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Tài liệu đã được thêm thành công.');</script>";
        } else {
            echo "<div class='alert alert-danger'>Có lỗi xảy ra khi thêm tài liệu: " . $stmt->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra khi tải lên tài liệu: " . error_get_last()['message'] . "</div>";
    }
}

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.id AS document_id, d.title, d.file_path, u.username 
                             FROM documents d 
                             JOIN users u ON d.user_id = u.user_id");

// Lấy danh sách người dùng
$users = $conn->query("SELECT user_id, username FROM users");
?>

<div class="container">
    <h2>Quản Lý Tài Liệu</h2>
    
    <!-- Nút quay lại -->
    <a href="../../../admin/pages/form_document_manager.php" class="btn btn-secondary mb-3">Quay Lại</a>

    <!-- Nút thêm tài liệu -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDocumentModal">Thêm Tài Liệu</button>

    <!-- Modal Thêm Tài Liệu -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">Thêm Tài Liệu Mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Tiêu Đề:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Tải Lên Tài Liệu PDF:</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept=".pdf" required>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Người Dùng:</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <?php while ($user = $users->fetch_assoc()): ?>
                                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" name="add_document" class="btn btn-primary">Thêm Tài Liệu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <hr>

    <!-- Danh sách tài liệu -->
    <h3>Danh Sách Tài Liệu</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Tài Liệu</th>
                <th>Người Dùng</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($doc = $documents->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $doc['document_id']; ?></td>
                    <td><?php echo $doc['title']; ?></td>
                    <td>
                        <a href="admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=view" target="_blank" class="btn btn-info btn-sm">Xem</a>
                        <a href="admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=download" class="btn btn-success btn-sm">Tải Về</a>
                    </td>
                    <td><?php echo $doc['username']; ?></td>
                    <td>
                        <form method="POST" action="delete_document.php" style="display:inline;">
                            <input type="hidden" name="document_id" value="<?php echo $doc['document_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Thêm jQuery và Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>