<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Learning English</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .res_box {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .yellow_title_box {
            background-color: #f1c40f;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .yellow_title_left {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .formLogin h3 {
            margin-bottom: 15px;
            font-weight: bold;
        }
        .link-rf {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #3498db;
        }
        .link-rf:hover {
            text-decoration: underline;
        }
        .row-input {
            margin-bottom: 15px;
        }
        .submit-lg {
            width: 100%;
            background-color: #3498db;
            border: none;
            color: white;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }
        .submit-lg:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<?php 
session_start(); // Bắt đầu session
include('../src/font/learn_english/header_english.php');


// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];

    // Kết nối đến cơ sở dữ liệu
    include('../config/conn.php');

    // Truy vấn để xác thực người dùng
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role']; // Lưu vai trò

            // Chuyển hướng dựa trên vai trò
            if ($user['role'] === 'admin' || $user['role'] === 'teacher') {
               
             
                header("Location: ../../../project/learn_english.php"); // Trang học tiếng Anh
            }
            exit();
        } else {
            $error_message = "Mật khẩu không đúng.";
        }
    } else {
        $error_message = "Tên đăng nhập không tồn tại.";
    }
}
?>

<div class="res_box">
    <div class="yellow_title_box">
        <div class="yellow_title_left">ĐĂNG NHẬP THÀNH VIÊN</div>
    </div>
    <div class="formLogin">
        <h3>Đăng nhập</h3>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="row-input">
                <label for="clogin_username" class="title-lgu">Tên đăng nhập:</label>
                <input type="text" id="clogin_username" name="txtUsername" class="form-control" tabindex="1" required placeholder="">
                <a href="" class="link-rf" title="Tạo một tài khoản?">Tạo một tài khoản?</a>
            </div>
            <div class="row-input">
                <label for="clogin_password" class="title-lgp">Mật khẩu:</label>
                <input type="password" id="clogin_password" name="txtPassword" class="form-control" tabindex="2" required placeholder="">
                <a href="" class="link-rf" title="Quên mật khẩu?">Quên mật khẩu?</a>
            </div>
            <div class="row-input">
                <input type="checkbox" id="clogin_repass" class="repass" alt="true" tabindex="3">
                <label for="clogin_repass">Nhớ tên truy cập</label>
            </div>
            <div class="row-input">
                <input type="submit" class="submit-lg" value="Đăng nhập">
            </div>
        </form>
    </div>
</div>

</body>
</html>