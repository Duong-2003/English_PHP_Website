<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm video
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $video_url = $_POST['video_url'];
    $lyrics = $_POST['lyrics'];

    $stmt = $conn->prepare("INSERT INTO videos (title, artist, video_url, lyrics) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $artist, $video_url, $lyrics);
    
    if ($stmt->execute()) {
        echo "<script>alert('Video đã được thêm thành công.'); window.location.href='your_dashboard.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi thêm video.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Video</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Thêm Video Âm Nhạc</h2>

    <!-- Form thêm video -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Tiêu Đề:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="artist">Ca Sĩ:</label>
            <input type="text" class="form-control" id="artist" name="artist" required>
        </div>
        <div class="form-group">
            <label for="video_url">URL Video:</label>
            <input type="text" class="form-control" id="video_url" name="video_url" required>
        </div>
        <div class="form-group">
            <label for="lyrics">Lời Bài Hát:</label>
            <textarea class="form-control" id="lyrics" name="lyrics" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Video</button>
    </form>

    <a href="your_dashboard.php" class="btn btn-secondary mt-3">Trở Về</a>
</div>
</body>
</html>