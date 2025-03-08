<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Learning English</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif; /* Chọn font mặc định cho trang */
        }
        .section-title {
            margin-top: 30px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php 
session_start();
include('../src/font/learn_english/header_english.php'); // Bao gồm header
include('../config/conn.php'); // Kết nối cơ sở dữ liệu

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.id AS document_id, d.title, d.file_path, u.username 
                             FROM documents d 
                             JOIN users u ON d.user_id = u.user_id");
?>
<div class="container mt-5">
    <h1 class="text-center">Tài Liệu Tiếng Anh</h1>
    <p class="text-center text-muted">Dưới đây là danh sách tài liệu học tiếng Anh.</p>

    <div class="section">
        <h2 class="section-title">Danh Sách Tài Liệu</h2>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>