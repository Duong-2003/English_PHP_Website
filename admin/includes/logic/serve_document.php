<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

if (isset($_GET['file_id']) && isset($_GET['action'])) {
    $file_id = intval($_GET['file_id']);
    $action = $_GET['action']; // Lấy hành động từ tham số

    // Lấy thông tin tài liệu từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT file_path, file_name FROM documents WHERE id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($file_path, $file_name);
    
    if ($stmt->fetch()) {
        // Kiểm tra xem file có tồn tại không
        if (file_exists($file_path)) {
            // Thiết lập tiêu đề cho việc xem hoặc tải về
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: ' . ($action === 'view' ? 'inline' : 'attachment') . '; filename="' . basename($file_name) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            echo "Tài liệu không tồn tại.";
        }
    } else {
        echo "Không tìm thấy tài liệu.";
    }
} else {
    echo "ID tài liệu hoặc hành động không hợp lệ.";
}
?>