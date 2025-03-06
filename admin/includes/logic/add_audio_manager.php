<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $lyrics = $_POST["lyrics"];

    // Xử lý upload file
    $targetDir = realpath("../../../admin/assets/uploads/") . DIRECTORY_SEPARATOR; // Đảm bảo sử dụng đường dẫn tuyệt đối
    $audioFile = basename($_FILES["audio"]["name"]);
    $targetFilePath = $targetDir . $audioFile;

    // Kiểm tra định dạng file (audio/mp3, wav, ogg)
    $audioFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    if ($audioFileType != "mp3" && $audioFileType != "wav" && $audioFileType != "ogg") {
        echo "Chỉ hỗ trợ các tệp âm thanh với định dạng .mp3, .wav, .ogg!";
        exit;
    }

    // Kiểm tra nếu tệp đã được tải lên thành công
    if (move_uploaded_file($_FILES["audio"]["tmp_name"], $targetFilePath)) {
        // Lưu vào CSDL bằng prepared statement để tránh SQL injection
        $stmt = $conn->prepare("INSERT INTO songs (title, audio_file, lyrics) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $targetFilePath, $lyrics);

        if ($stmt->execute()) {
            header("Location: ../../../admin/pages/form_audio_manager.php");  // Chuyển hướng sau khi thành công
            exit;
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } else {
        echo "Có lỗi khi tải tệp lên!";
    }
}

?>
<body>
    <!-- Form thêm bài hát -->
    <form action="../../admin/includes/logic/add_audio_manager.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Tên bài hát</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="audio" class="form-label">Tệp Audio</label>
            <input type="file" class="form-control" id="audio" name="audio" accept="audio/mp3, audio/wav, audio/ogg" required>
        </div>
        <div class="mb-3">
            <label for="lyrics" class="form-label">Lời bài hát</label>
            <textarea class="form-control" id="lyrics" name="lyrics" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Bài Hát</button>
    </form>
</body>
