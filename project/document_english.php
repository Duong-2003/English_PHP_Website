

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <title>Website Learning English</title>
<body>
<?php
session_start(); // Bắt đầu session
ob_start(); // Start output buffering
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');
// Lấy danh sách tài liệu
$query = "SELECT d.document_id, d.title, d.file_url, c.class_name 
          FROM documents d 
          JOIN classes c ON d.class_id = c.class_id";
$result = $conn->query($query);
?>
<div class="container mt-5">
    <h1 class="text-center">Tài Liệu Tiếng Anh</h1>
    <p class="text-center text-muted">Dưới đây là danh sách tài liệu học tiếng Anh.</p>

    <div class="section">
        <h2 class="section-title">Danh Sách Tài Liệu</h2>
        <ul class="list-group">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($doc = $result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <a href="<?php echo htmlspecialchars($doc['file_url']); ?>" class="text-decoration-none" target="_blank">
                            <?php echo htmlspecialchars($doc['title']); ?>
                        </a>
                        <span class="float-end"><i class="fas fa-download"></i></span>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li class="list-group-item">Không có tài liệu nào.</li>
            <?php endif; ?>
        </ul>
    </div>

    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>