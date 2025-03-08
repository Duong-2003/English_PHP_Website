<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dino English Translate</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php 
session_start(); // Bắt đầu session
ob_start(); // Start output buffering
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.id AS document_id, d.title, d.file_path, u.username 
                             FROM documents d 
                             JOIN users u ON d.user_id = u.user_id");
?>
<body>

<div class="container mt-5">
    <h1 class="text-center">Tài Liệu Tiếng Anh</h1>
    <p class="text-center text-muted">Dưới đây là danh sách tài liệu học tiếng Anh.</p>

    <div class="section">
      
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($documents->num_rows > 0): ?>
                    <?php while($doc = $documents->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($doc['document_id']); ?></td>
                            <td><?php echo htmlspecialchars($doc['title']); ?></td>
                            <td>
                                <a href="../admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=view" target="_blank" class="btn btn-info btn-sm">Xem</a>
                                <a href="../admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=download" class="btn btn-success btn-sm">Tải Về</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Không có tài liệu nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>