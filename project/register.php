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
</head>
<?php 
include('../src/font/learn_english/header_english.php');
?>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        .res_box {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .yellow_title_box {
            background-color: #f1c40f;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }
        .yellow_title_left {
            font-size: 18px;
            font-weight: bold;
        }
        .formLogin h3 {
            margin-bottom: 15px;
        }
        .link-rf {
            display: block;
            margin-top: 5px;
            font-size: 12px;
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
        }
        .submit-lg:hover {
            background-color: #2980b9;
        }
        .icon-gg {
            width: 30px;
            height: 30px;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg');
            background-size: cover;
        }
    </style>
<div class="yellow_title_box">
        <div class="yellow_title_left">ĐĂNG KÝ THÀNH VIÊN</div>
    </div>
    <div class="formLogin">
        <h3>Đăng ký</h3>
        <div class="row-input">
            <label for="register_username" class="title-lgu">Tên đăng nhập:</label>
            <input type="text" id="register_username" name="registerUsername" class="form-control" placeholder="">
        </div>
        <div class="row-input">
            <label for="register_email" class="title-lgp">Email:</label>
            <input type="email" id="register_email" name="registerEmail" class="form-control" placeholder="">
        </div>
        <div class="row-input">
            <label for="register_password" class="title-lgp">Mật khẩu:</label>
            <input type="password" id="register_password" name="registerPassword" class="form-control" placeholder="">
        </div>
        <div class="row-input">
            <input type="button" id="register_submit" class="submit-lg" onclick="return register();" value="Đăng ký">
        </div>
        <div class="row-input">
            <a href="https://www.tienganh123.com/login" class="link-rf" title="Đã có tài khoản?">Đã có tài khoản? Đăng nhập ngay!</a>
        </div>
    </div>
</div>

<script>
   

    function register() {
        // Thêm logic đăng ký ở đây
        alert("Đăng ký thành công!");
        return false; // Ngăn chặn hành động mặc định
    }
</script>