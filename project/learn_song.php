<?php
include('../config/conn.php');

$song_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM songs WHERE song_id = ?");
$stmt->bind_param("i", $song_id);
$stmt->execute();
$song = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $song['title']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2><?php echo $song['title']; ?></h2>
    <video width="100%" controls>
        <source src="<?php echo $song['video_url']; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <h4>Lời Bài Hát:</h4>
    <pre><?php echo $song['lyrics']; ?></pre>
</div>
</body>
</html>