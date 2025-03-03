<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <title>Website Learning English</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        #ctn {
            background-image: url(../Assets/img/index/bg_sp_noibat.jpg);
            background-size: cover;
            background-position: center;
            padding: 30px 0;
        }

        .error>p, .success>p {
            font-size: 18px;
            text-align: center;
            font-weight: 600;
        }

        .account-box-shadow {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .auth-block__menu-list {
            list-style: none;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .auth-block__menu-list li a {
            flex: 1;
            text-align: center;
            padding: 10px;
            font-size: 16px;
            color: #999;
            transition: color 0.3s;
        }

        .auth-block__menu-list li.active a {
            font-weight: 600;
            color: #303846;
        }

        .auth-block__menu-list li a:hover {
            color: #9c8350;
        }

        .btn-blues {
            background-color: #9c8350;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-blues:hover {
            background-color: #7a663e;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-shadow: none;
        }

        .form-group label {
            font-weight: 600;
        }

        .login--notes {
            text-align: center;
            color: #999;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>



<?php
session_start(); // Bắt đầu session
ob_start(); // Start output buffering
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Kiểm tra tên đăng nhập đã tồn tại
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Tên đăng nhập đã tồn tại.";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'student')");
        $stmt->bind_param("sss", $username, $password, $email);
        
        if ($stmt->execute()) {
            $success_message = "Đăng ký thành công! Bạn có thể đăng nhập.";
            header("Location: login.php?notifi=" . urlencode($success_message));
            exit();
        } else {
            $error_message = "Có lỗi trong quá trình đăng ký.";
        }
    }
}
?>
<body>
<div class="container py-5" id="ctn">
    <div class="row justify-content-md-center">
        <div class="col-lg-7 col-md-12">
            <div class="page-login account-box-shadow">
                <div id="register" class="row">
                    <div class="error">
                        <?php if (isset($error_message)): ?>
                            <p class="text-danger"><?= htmlspecialchars($error_message) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="success">
                        <?php if (isset($success_message)): ?>
                            <p class="text-success"><?= htmlspecialchars($success_message) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12 col-md-12 account-content">
                        <ul class="auth-block__menu-list">
                            <li>
                                <a href="../project/login.php" title="Đăng nhập">Đăng nhập</a>
                            </li>
                            <li class="active">
                                <a href="../project/register.php" title="Đăng ký">Đăng ký</a>
                            </li>
                        </ul>
                        <form action="" method="post" id="customer_register" accept-charset="UTF-8">
                            <fieldset class="form-group margin-bottom-10">
                                <label>Tên đăng nhập<span style="color: red;">*</span></label>
                                <input id="username" placeholder="Nhập tài khoản" type="text" class="form-control" name="username" required>
                            </fieldset>

                            <fieldset class="form-group margin-bottom-10">
                                <label>Mật khẩu<span style="color: red;">*</span></label>
                                <input type="password" placeholder="Nhập mật khẩu" id="password" class="form-control" name="password" required>
                            </fieldset>

                            <fieldset class="form-group margin-bottom-10">
                                <label>Email<span style="color: red;">*</span></label>
                                <input type="email" placeholder="Nhập email" id="email" class="form-control" name="email" required>
                            </fieldset>
                            <div class="clearfix"></div>
                  <p class="text-right recover">
                    <a href="../project/reset_pass.php" id="link-style" title="Quên mật khẩu?">Quên mật khẩu?</a>
                  </p>

                            <div class="text-center" style="margin-top: 15px;">
                                <button class="btn btn-blues" type="submit" id="registerSubmit" name="submit">Đăng ký</button>
                            </div>

                            <p class="login--notes">Chúng tôi cam kết bảo mật và sẽ không bao giờ chia sẻ thông tin của bạn.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>