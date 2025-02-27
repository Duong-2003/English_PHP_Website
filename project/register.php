<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php 
include('../src/font/learn_english/header_english.php');
session_start();

// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['txtUsername'];
    $password = password_hash($_POST['txtPassword'], PASSWORD_BCRYPT);
    $email = $_POST['txtEmail'];
    
    // Mặc định vai trò là student
    $role = 'student';
    
    // Nếu người dùng đã đăng nhập là admin, cho phép chọn vai trò
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        $role = $_POST['role'];
    }

    // Kết nối đến cơ sở dữ liệu
    include('../config/conn.php');

    // Kiểm tra xem tên đăng nhập đã tồn tại hay chưa
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Tên đăng nhập đã tồn tại.";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $role);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Đăng ký thành công! Bạn có thể đăng nhập.";
            header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
            exit();
        } else {
            $error_message = "Có lỗi trong quá trình đăng ký.";
        }
    }
}
?>

<body>
<div class="container mt-5">
    <h2>Đăng Ký Tài Khoản</h2>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="txtUsername" class="form-label">Tên đăng nhập:</label>
            <input type="text" id="txtUsername" name="txtUsername" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="txtPassword" class="form-label">Mật khẩu:</label>
            <input type="password" id="txtPassword" name="txtPassword" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="txtEmail" class="form-label">Email:</label>
            <input type="email" id="txtEmail" name="txtEmail" class="form-control" required>
        </div>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <div class="mb-3">
                <label for="role" class="form-label">Vai trò:</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="student" selected>Học Sinh</option>
                    <option value="teacher">Giáo Viên</option>
                </select>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Đăng Ký</button>
    </form>
    <p class="mt-3">Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
</div>
</body>
</html>