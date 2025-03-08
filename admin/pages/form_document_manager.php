

<?php
include '../../config/conn.php'; // Bao gồm file kết nối

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.id AS document_id, d.title, d.file_path, u.username 
                             FROM documents d 
                             JOIN users u ON d.user_id = u.user_id");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Liệu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
   <h3>Danh Sách Tài Liệu</h3>
   <a href="../../admin/includes/logic/add_document_manager.php">><button>Thm tai lieu</button></a>
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
                    <td><?php echo htmlspecialchars($doc['document_id']); ?></td>
                    <td><?php echo htmlspecialchars($doc['title']); ?></td>
                    <td>
                    <td>
    <a href="../../admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=view" target="_blank" class="btn btn-info btn-sm">Xem</a>
    <a href="../../admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=download" class="btn btn-success btn-sm">Tải Về</a>

                    </td>
                    <td><?php echo htmlspecialchars($doc['username']); ?></td>
                    <td>
                        <form method="POST" action="delete_document.php" style="display:inline;">
                            <input type="hidden" name="document_id" value="<?php echo htmlspecialchars($doc['document_id']); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>