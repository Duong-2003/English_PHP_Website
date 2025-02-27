<?php
session_start();
include '../../config/conn.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn để lấy thông tin người dùng
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Kiểm tra vai trò
            if ($user['role'] === 'teacher') {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                header("Location: admin_website.php"); // Chuyển hướng đến dashboard
                exit;
            } else {
                $error = "Bạn không có quyền truy cập vào trang quản trị.";
            }
        } else {
            $error = "Mật khẩu không chính xác.";
        }
    } else {
        $error = "Người dùng không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập Quản Trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Đăng Nhập Quản Trị</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên người dùng</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
    </form>
</div>
</body>
</html>