<?php
include('../config/conn.php'); // Kết nối database

// Kiểm tra nếu có class_id trong URL
$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;

// Lấy danh sách tài liệu theo class_id
$queryDocuments = "SELECT d.document_id, d.title 
                   FROM documents d 
                   WHERE d.class_id = ?";
$stmtDocs = $conn->prepare($queryDocuments);
$stmtDocs->bind_param("i", $class_id);
$stmtDocs->execute();
$resultDocs = $stmtDocs->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Liệu và Bài Học - Lớp <?php echo htmlspecialchars($class_id); ?></title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <h1 class="text-center">Tài Liệu và Bài Học - Lớp <?php echo htmlspecialchars($class_id); ?></h1>
    
    <div class="section">
        <h2 class="section-title">Danh Sách Tài Liệu</h2>
        <ul class="list-group">
            <?php if ($resultDocs->num_rows > 0): ?>
                <?php while ($doc = $resultDocs->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($doc['title']); ?></strong>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li class="list-group-item">Không có tài liệu nào cho lớp này.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="section mt-4">
        <h2 class="section-title">Danh Sách Bài Học</h2>
        <ul class="list-group">
            <?php
            // Lấy bài học theo class_id
            $queryLessons = "SELECT l.id, l.title, l.content, l.image_url 
                             FROM lessons l 
                             WHERE l.class_id = ?";
            $stmtLessons = $conn->prepare($queryLessons);
            $stmtLessons->bind_param("i", $class_id);
            $stmtLessons->execute();
            $resultLessons = $stmtLessons->get_result();

            if ($resultLessons->num_rows > 0):
                while ($lesson = $resultLessons->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <h5><?php echo htmlspecialchars($lesson['title']); ?></h5>
                        <p><?php echo htmlspecialchars($lesson['content']); ?></p>
                        <?php if ($lesson['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($lesson['image_url']); ?>" alt="Hình ảnh bài học" style="width: 100px; height: auto;">
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li class="list-group-item">Không có bài học nào cho lớp này.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>