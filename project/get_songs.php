<?php

include('../config/conn.php'); // Kết nối cơ sở dữ liệu

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn tất cả bài hát
$sql = "SELECT * FROM songs";
$result = $conn->query($sql);

// Kiểm tra lỗi truy vấn SQL
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}

$songs = [];
if ($result->num_rows > 0) {
    // Lấy dữ liệu bài hát
    while($row = $result->fetch_assoc()) {
        // Đảm bảo trả về các trường cần thiết
        $songs[] = [
            'title' => $row['title'], 
            'audio_file' => $row['audio_file']
        ];
    }
} else {
    echo "Không có bài hát nào.";
    exit;
}

// Đóng kết nối
$conn->close();

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($songs);
?>
