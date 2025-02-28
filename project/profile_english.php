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
session_start();
include('../src/font/learn_english/header_english.php');
?>
<body>
<?php

include('../config/conn.php'); // Kết nối cơ sở dữ liệu

$user = null; // Khởi tạo biến người dùng

if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = ?"; // Sử dụng username để lấy thông tin người dùng
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Lấy dữ liệu người dùng
    }
}
?>
<body>

<div class="container mt-4 lg:mt-10">
    <div class="flex flex-col lg:flex-row lg:justify-between lg:gap-20 items-start">
        <div class="w-full lg:basis-1/4 shrink-0 mb-6 lg:mb-0 flex flex-col items-center pt-8">
            <div class="relative mb-4">
                <div class="h-24 w-24 rounded-full overflow-hidden">
                    <img alt="User Avatar" src='../public/images/icons/ic_default_ava_male.png'>
                </div>
            </div>
            <div class="font-normal text-lg text-center text-gray-600 mb-3">
                <?php if (isset($user)): ?>
                    Chào, <?php echo htmlspecialchars($user['username']); ?>! Bạn đã đăng nhập.
                <?php else: ?>
                    Hãy đăng nhập để lưu tiến trình học của bạn.
                <?php endif; ?>
            </div>
        </div>

        <div class="overflow-hidden w-full lg:w-auto flex flex-col lg:grow">
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Gần đây</h3>
                <div class="w-full flex flex-nowrap gap-3 my-4 overflow-auto profile-recent-scrollbar">
                    <div class="h-18 w-18 mb-2 aspect-square shrink-0 relative cursor-pointer">
                        <!-- Nội dung gần đây -->
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Tiến độ học</h3>
                <div class="text-xl flex justify-between items-center my-4">
                    <h4 class="font-medium">Tổng kinh nghiệm</h4>
                    <div class="text-yellow-500"><?php echo isset($user) ? '0 exp' : 'Chưa có'; ?></div>
                </div>
                <div class="h-px bg-gray-300"></div>
                <div class="text-xl flex justify-between items-center my-4">
                    <h4 class="font-medium">Chủ đề đã hoàn thành</h4>
                    <div class="text-blue-500"><?php echo isset($user) ? '0/30' : 'Chưa có'; ?></div>
                </div>
                <div class="h-px bg-gray-300"></div>
                <div class="text-xl flex justify-between items-center my-4">
                    <h4 class="font-medium">Bài kiểm tra đã hoàn thành</h4>
                    <div class="text-red-500"><?php echo isset($user) ? '0/3' : 'Chưa có'; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>