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

include('../config/conn.php'); // Kết nối cơ sở dữ liệu
include('../src/font/learn_english/header_english.php');




$sql = "SELECT * FROM songs"; 
$result = $conn->query($sql);
$songs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}
?>


<body>
    <h1 class="text-center mt-4">Danh sách bài hát</h1>
    <div class="container">
        <ul class="list-group">
            <?php foreach ($songs as $song): ?>
                <li class="list-group-item">
                    <a href="../project/audio_song.php?id=<?php echo $song['id']; ?>">
                        🎤 <?php echo htmlspecialchars($song["title"]); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>