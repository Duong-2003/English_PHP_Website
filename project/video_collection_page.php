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












<?php
// Giả sử danh sách video được lưu trong một mảng
$videos = [
    ['id' => 1, 'title' => 'Video 1', 'url' => 'https://www.youtube.com/watch?v=plKgTyPXCAc'],
    ['id' => 2, 'title' => 'Video 2', 'url' => 'videos/video2.mp4'],
    ['id' => 3, 'title' => 'Video 3', 'url' => 'videos/video3.mp4'],
    ['id' => 1, 'title' => 'Video 1', 'url' => 'https://www.youtube.com/watch?v=plKgTyPXCAc'],
    ['id' => 2, 'title' => 'Video 2', 'url' => 'videos/video2.mp4'],
    ['id' => 3, 'title' => 'Video 3', 'url' => 'videos/video3.mp4'],
    ['id' => 1, 'title' => 'Video 1', 'url' => 'https://www.youtube.com/watch?v=plKgTyPXCAc'],
    ['id' => 2, 'title' => 'Video 2', 'url' => 'videos/video2.mp4'],
    ['id' => 3, 'title' => 'Video 3', 'url' => 'videos/video3.mp4'],
    // Thêm video khác ở đây
];
?>


<div class="container mt-4">
    <h2 class="text-center">Chọn Video để Hát</h2>
    <div class="row">
        <?php foreach ($videos as $video): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($video['title']) ?></h5>
                        <video width="100%" controls>
                            <source src="<?= htmlspecialchars($video['https://www.youtube.com/watch?v=plKgTyPXCAc']) ?>" type="video/mp4">
                            Trình duyệt của bạn không hỗ trợ video.
                        </video>
                        <a href="sing_and_score.php?video_id=<?= $video['id'] ?>" class="btn btn-primary mt-2">Hát</a>
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