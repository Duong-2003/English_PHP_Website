<?php
include('../config/conn.php'); // Kết nối database

// Kiểm tra xem có gửi dữ liệu POST
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Thực hiện câu lệnh SQL xóa từ
    $query = "DELETE FROM saved_words WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // Ràng buộc tham số

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Từ đã được xóa thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Có lỗi khi xóa từ!']);
    }

    // Đóng statement
    $stmt->close();
}

$conn->close();
?>