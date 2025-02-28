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

<?php

include('../config/conn.php'); // Kết nối cơ sở dữ liệu

// Lấy danh sách video từ cơ sở dữ liệu
$sql = "SELECT * FROM videos"; // Thay đổi tên bảng nếu cần
$result = $conn->query($sql);

$videos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row; // Thêm video vào mảng
    }
}
?>










<body>
    

    <div class="container mt-4">
        <h2 class="text-center">Chọn Video để Hát</h2>
        <div class="row">
            <?php foreach ($videos as $video): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($video['title']) ?></h5>
                            <video width="100%" controls>
                                <source src="<?= htmlspecialchars($video['video_url']) ?>" type="video/mp4">
                                Trình duyệt của bạn không hỗ trợ video.
                            </video>
                            <a href="sing_and_score.php?video_id=<?= $video['video_id'] ?>" class="btn btn-primary mt-2">Hát</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>