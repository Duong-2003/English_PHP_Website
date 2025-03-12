<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $lyrics = $_POST["lyrics"];
    $audioURL = $_POST["audio_url"];  // Nhận URL tệp audio từ form
    $videoURL = $_POST["video_url"];  // Nhận URL video từ form

    // Lưu URL audio và video vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO songs (title, audio_file, video_file, lyrics) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $audioURL, $videoURL, $lyrics);

    if ($stmt->execute()) {
        header("Location: ../../../admin/pages/form_audio_manager.php");  // Chuyển hướng sau khi thành công
        exit;
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>

<body>
    <!-- Form thêm bài hát với URL tệp MP3 và video -->
    <form action="add_audio_manager.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Tên bài hát</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="audio_url" class="form-label">URL Tệp Audio</label>
            <input type="text" class="form-control" id="audio_url" name="audio_url" placeholder="Nhập URL tệp MP3" required>
        </div>
        <div class="mb-3">
            <label for="video_url" class="form-label">URL Video (Nếu có)</label>
            <input type="text" class="form-control" id="video_url" name="video_url" placeholder="Nhập URL video MP4" optional>
        </div>
        <div class="mb-3">
            <label for="lyrics" class="form-label">Lời bài hát</label>
            <textarea class="form-control" id="lyrics" name="lyrics" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Bài Hát</button>
    </form>
</body>