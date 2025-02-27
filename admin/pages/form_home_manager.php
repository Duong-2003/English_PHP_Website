<?php
include '../../config/conn.php'; // Bao gồm file kết nối

// Lấy số lượng người dùng
$userCountResult = $conn->query("SELECT COUNT(*) AS count FROM users");
$userCount = $userCountResult->fetch_assoc()['count'];

// Lấy số lượng video
$videoCountResult = $conn->query("SELECT COUNT(*) AS count FROM videos");
$videoCount = $videoCountResult->fetch_assoc()['count'];

// Lấy số lượng tài liệu
$documentCountResult = $conn->query("SELECT COUNT(*) AS count FROM documents");
$documentCount = $documentCountResult->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Trang Quản Trị</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Dashboard - Trang Quản Trị</h2>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Số Lượng Người Dùng
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($userCount); ?></h3>
                    <p class="card-text">Tổng số tài khoản người dùng hiện có.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Số Lượng Video
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($videoCount); ?></h3>
                    <p class="card-text">Tổng số video đã được thêm vào.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Số Lượng Tài Liệu
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($documentCount); ?></h3>
                    <p class="card-text">Tổng số tài liệu hiện có.</p>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-secondary mt-3">Trở Về</a>
</div>
</body>
</html>