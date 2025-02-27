<?php
include '../../../config/conn.php'; // Bao gồm file kết nối



// Xử lý cập nhật tài liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_document'])) {
    $document_id = $_POST['document_id'];
    $class_id = $_POST['class_id'];
    $title = $_POST['title'];
    $file_url = $_POST['file_url'];

    $stmt = $conn->prepare("UPDATE documents SET class_id = ?, title = ?, file_url = ? WHERE document_id = ?");
    $stmt->bind_param("issi", $class_id, $title, $file_url, $document_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Thông tin tài liệu đã được cập nhật thành công.'); window.location.reload();</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật thông tin tài liệu.');</script>";
    }
}

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.document_id, d.title, d.file_url, c.class_name, u.username 
                             FROM documents d 
                             JOIN classes c ON d.class_id = c.class_id
                             JOIN users u ON d.user_id = u.user_id");

// Lấy danh sách người dùng
$users = $conn->query("SELECT user_id, username FROM users");
?>

<div class="container">
    

    <!-- Danh sách tài liệu -->
    <h3>Danh Sách Tài Liệu</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Lớp</th>
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
                    <td><?php echo $doc['class_name']; ?></td>
                    <td><a href="<?php echo $doc['file_url']; ?>" target="_blank">Xem</a></td>
                    <td><?php echo $doc['username']; ?></td>
                    <td>
                        <button class="btn btn-warning" onclick="editDocument(<?php echo $doc['document_id']; ?>)">Sửa</button>
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

<!-- Modal Sửa Tài Liệu -->
<div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDocumentModalLabel">Sửa Tài Liệu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDocumentForm" method="POST" action="">
                    <input type="hidden" name="document_id" id="editDocumentId">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Tiêu Đề</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFileUrl" class="form-label">URL Tài Liệu</label>
                        <input type="text" name="file_url" id="editFileUrl" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editClassId" class="form-label">Lớp</label>
                        <select name="class_id" id="editClassId" class="form-control" required>
                            <?php
                            // Lấy danh sách lớp
                            $classes = $conn->query("SELECT * FROM classes");
                            while ($class = $classes->fetch_assoc()) {
                                echo "<option value='{$class['class_id']}'>{$class['class_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="update_document" class="btn btn-primary">Cập Nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editDocument(documentId) {
    // Gọi AJAX để lấy thông tin tài liệu
    $.ajax({
        url: 'get_document_info.php',
        method: 'GET',
        data: { id: documentId },
        success: function(data) {
            const doc = JSON.parse(data);
            document.getElementById('editDocumentId').value = doc.document_id;
            document.getElementById('editTitle').value = doc.title;
            document.getElementById('editFileUrl').value = doc.file_url;
            document.getElementById('editClassId').value = doc.class_id;
            $('#editDocumentModal').modal('show'); // Hiển thị modal
        },
        error: function() {
            alert('Không thể tải thông tin tài liệu.');
        }
    });
}
</script>