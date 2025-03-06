<?php
include '../../config/conn.php'; // Bao gồm file kết nối

// Lấy tất cả tài liệu từ cơ sở dữ liệu
$sql = "SELECT * FROM documents ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Liệu</title>
</head>
<body>
    <h1>Danh Sách Tài Liệu</h1>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Tên File</th>
                <th>Đường Dẫn</th>
                <th>Ngày Tải Lên</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['file_name'] . "</td>
                            <td><a href='" . $row['file_path'] . "'>Tải về</a></td>
                            <td>" . $row['uploaded_at'] . "</td>
                            <td>
                                <a href='edit.php?id=" . $row['id'] . "'>Sửa</a> | 
                                <a href='delete.php?id=" . $row['id'] . "'>Xóa</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Không có tài liệu nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="upload.php">Tải tài liệu lên</a>
</body>
</html>
