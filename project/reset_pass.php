<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php 
include('../src/font/learn_english/header_english.php');
session_start();

// Xử lý đặt lại mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['txtEmail'];

    // Kết nối đến cơ sở dữ liệu
    include('../config/conn.php');

    // Kiểm tra xem email có tồn tại không
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Tạo mã token ngẫu nhiên

        // Lưu token vào cơ sở dữ liệu
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Gửi email chứa liên kết đặt lại mật khẩu
        $reset_link = "http://yourwebsite.com/reset_password.php?token=" . $token; // Cập nhật đường dẫn của bạn
        $subject = "Đặt lại mật khẩu";
        $message = "Nhấp vào liên kết sau để đặt lại mật khẩu: " . $reset_link;
        mail($email, $subject, $message); // Gửi email

        $_SESSION['success_message'] = "Đã gửi liên kết đặt lại mật khẩu đến email của bạn.";
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Email không tồn tại.";
    }
}
?>

<body>
<div class="container mt-5">
    <h2>Đặt Lại Mật Khẩu</h2>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="txtEmail" class="form-label">Email:</label>
            <input type="email" id="txtEmail" name="txtEmail" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Gửi liên kết đặt lại mật khẩu</button>
    </form>
    <p class="mt-3">Quay lại <a href="login.php">Đăng nhập</a></p>
</div>
</body>
</html>