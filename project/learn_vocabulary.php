<?php 
include('../config/conn.php'); // Kết nối database
// include('../src/font/learn_english/header_english.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: flex-start;
            min-height: 100vh;
            background-color: #f4f4f4;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 350px;
            background-color: white;
            border-right: 2px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease, opacity 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 50px;
            opacity: 0.9;
        }

        .sidebar-header {
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile {
            display: flex;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-name {
            font-size: 14px;
            color: #333;
        }

        .exp {
            display: flex;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .exp-box {
            display: flex;
            align-items: center;
            background-color: #FFBF00;
            border-radius: 20px;
            padding: 5px 10px;
        }

        .exp-icon {
            color: #FFBF00;
            background-color: white;
            border-radius: 50%;
            padding: 8px;
            margin-right: 5px;
            font-weight: bold;
        }

        .exp-number {
            color: white;
            font-size: 16px;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .menu {
            margin-top: 20px;
            overflow-y: auto;
            height: calc(100% - 120px);
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .menu-item:hover {
            background-color: #f0f0f0;
        }

        .menu-item h3 {
            font-size: 18px;
            color: #333;
        }

        .menu-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .sidebar.collapsed .profile,
        .sidebar.collapsed .exp {
            display: none;
        }

        .sidebar.collapsed .menu-item h3 {
            opacity: 0;
        }

        .sidebar.collapsed .menu-item img {
            width: 35px;
            height: 35px;
        }

        /* Ẩn thanh cuộn dọc của sidebar */
        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .main-content {
            margin-left: 350px;
            padding: 20px;
            width: calc(100% - 350px);
            overflow-y: scroll;
            height: 100vh;
            transition: margin-left 0.3s ease, width 0.3s ease; /* Thêm hiệu ứng chuyển tiếp */
        }

        .main-content.scrollable {
            margin-left: 50px;
            width: calc(100% - 50px);
        }
    </style>
</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <button class="toggle-btn" id="toggle-btn">&#9665;</button>
        <div class="profile" id="profile">
            <img class="profile-img" src="../public/images/icons/greeting.png" alt="Avatar">
            <span class="profile-name">Guest</span>
        </div>
        <div class="exp" id="exp">
            <div class="exp-box">
                <span class="exp-icon">E</span>
                <span class="exp-number">45</span>
            </div>
        </div>
    </div>
    <div class="menu">
        <div class="menu-item">
            <img src="../public/images/icons/greeting.png" alt="Item">
            <h3>Item 1</h3>
        </div>
        <div class="menu-item">
            <img src="https://via.placeholder.com/50" alt="Item">
            <h3>Item 2</h3>
        </div>
        <!-- Thêm các mục menu khác -->
    </div>
</div>

<div class="main-content" id="main-content">
    <h1>Welcome to the Page!</h1>
    <p>Scroll this content while the sidebar is fixed on the left.</p>
    <p>Scroll down to test the functionality of the sidebar and content scrolling.</p>
</div>

<script>
    // Handle the sidebar toggle (expand/collapse)
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('scrollable');

        // Change the button icon based on the state
        toggleBtn.innerHTML = sidebar.classList.contains('collapsed') ? '&#9655;' : '&#9665;';
    });
</script>

</body>
</html>