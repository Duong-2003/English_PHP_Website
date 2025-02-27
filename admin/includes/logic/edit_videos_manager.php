<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

// Lấy thông tin video để chỉnh sửa
if (isset($_GET['id'])) {
    $video_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM videos WHERE video_id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $video = $result->fetch_assoc();
    } else {
        echo "<script>alert('Video không tồn tại.'); window.location.href='your_dashboard.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID video không hợp lệ.'); window.location.href='your_dashboard.php';</script>";
    exit;
}

// Xử lý cập nhật video
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $video_url = $_POST['video_url'];
    $lyrics = $_POST['lyrics'];

    $stmt = $conn->prepare("UPDATE videos SET title = ?, artist = ?, video_url = ?, lyrics = ? WHERE video_id = ?");
    $stmt->bind_param("ssssi", $title, $artist, $video_url, $lyrics, $video_id);

    if ($stmt->execute()) {
        echo "<script>alert('Video đã được cập nhật thành công.'); window.location.href='your_dashboard.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật video.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Video</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Sửa Video Âm Nhạc</h2>

    <!-- Form sửa video -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Tiêu Đề:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($video['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="artist">Ca Sĩ:</label>
            <input type="text" class="form-control" id="artist" name="artist" value="<?php echo htmlspecialchars($video['artist']); ?>" required>
        </div>
        <div class="form-group">
            <label for="video_url">URL Video:</label>
            <input type="text" class="form-control" id="video_url" name="video_url" value="<?php echo htmlspecialchars($video['video_url']); ?>" required>
        </div>
        <div class="form-group">
            <label for="lyrics">Lời Bài Hát:</label>
            <textarea class="form-control" id="lyrics" name="lyrics" rows="4" required><?php echo htmlspecialchars($video['lyrics']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật Video</button>
    </form>

    <a href="your_dashboard.php" class="btn btn-secondary mt-3">Trở Về</a>
</div>
</body>
</html>