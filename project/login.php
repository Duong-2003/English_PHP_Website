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

    .error>p {
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

    .line-break {
      text-align: center;
      margin: 20px 0;
    }

    .line-break span {
      display: inline-block;
      font-size: 14px;
      color: #999;
      padding: 5px 10px;
      border-radius: 15px;
      border: 1px solid #eee;
      background-color: #fff;
      position: relative;
      z-index: 1;
    }

    .social-login img {
      max-width: 100%;
      height: auto;
      transition: transform 0.3s;
    }

    .social-login img:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body>

<?php
session_start(); // Bắt đầu session
ob_start(); // Start output buffering
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

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
            $_SESSION['user_role'] = $user['role'];
            
            // Cập nhật thời gian đăng nhập
            $stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
            $stmt->bind_param("i", $user['user_id']);
            $stmt->execute();

            // Chuyển hướng đến trang chính
            header("Location: ../project/learn_english.php");
            exit();
        } else {
            header("Location: ../project/login.php?error=Mật khẩu không đúng.");
            exit();
        }
    } else {
        header("Location: ../project/login.php?error=Tên đăng nhập không tồn tại.");
        exit();
    }
}
?>

  <div class="container py-5" id="ctn">
    <div class="row justify-content-md-center">
      <div class="col-lg-7 col-md-12">
        <div class="page-login account-box-shadow">
          <div id="login" class="row">
          <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
            <div class="error">
              <?php
              $error = isset($_GET["error"]) ? $_GET["error"] : '';
              $notifi = isset($_GET["notifi"]) ? $_GET["notifi"] : '';
              ?>
              <p id="notifi_log" class="text-success"><?= htmlspecialchars($notifi) ?></p>
              <p id="error_log" class="text-danger"><?= htmlspecialchars($error) ?></p>
            </div>
            <div class="col-lg-12 col-md-12 account-content">
              <ul class="auth-block__menu-list">
                <li class="active">
                  <a href="../project/login.php" title="Đăng nhập">Đăng nhập</a>
                </li>
                <li>
                  <a href="../project/register.php" title="Đăng ký">Đăng ký</a>
                </li>
              </ul>
              <div id="nd-login">
              <form action="../project/login.php" method="post" id="customer_login" accept-charset="UTF-8" class="has-validation-callback">
                  <input name="FormType" type="hidden" value="customer_login">
                  <input name="utf8" type="hidden" value="true">
                  <input name="ReturnUrl" type="hidden" value="/username">

                  <fieldset class="form-group margin-bottom-10">
                    <label>Tài khoản<span style="color: red;">*</span></label>
                    <input id="username" placeholder="Nhập tài khoản" type="text" class="form-control" name="username" required>
                  </fieldset>

                  <fieldset class="form-group margin-bottom-0">
                    <label>Mật khẩu<span style="color: red;">*</span></label>
                    <input type="password" placeholder="Nhập mật khẩu" id="password" class="form-control" name="password" required>
                  </fieldset>

                  <div class="clearfix"></div>
                  <p class="text-right recover">
                    <a href="../project/reset_pass.php" id="link-style" title="Quên mật khẩu?">Quên mật khẩu?</a>
                  </p>

                  <div class="text-center" style="margin-top: 15px;">
    <button class="btn btn-blues" type="submit" id="loginSubmit" name="submit">Đăng nhập</button>
</div>
                  <p class="login--notes">Chúng tôi cam kết bảo mật và sẽ không bao giờ chia sẻ thông tin của bạn.</p>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
</body>

</html>