<?php
include('../../../config/conn.php');

$privateKey = $_GET['key'];
$dataKey = $_GET['datakey'];
$nameTable = $_GET['table'];

// Kiểm tra tính hợp lệ của bảng
$allowedTables = ['users']; // Thêm các bảng hợp lệ
if (!in_array($nameTable, $allowedTables)) {
    die("Bảng không hợp lệ.");
}

// Chuẩn bị câu lệnh xóa
$query = "DELETE FROM $nameTable WHERE $privateKey = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $dataKey); // Giả sử dataKey là chuỗi
    if ($stmt->execute()) {
        session_start();
    $_SESSION['success_message'] = 'Xóa người dùng thành công!';
    header("Location: ../../../admin/pages/admin_website.php");
    } else {
        echo "Lỗi xóa dữ liệu: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Có lỗi trong việc chuẩn bị câu lệnh.";
}

$connect->close();
?>