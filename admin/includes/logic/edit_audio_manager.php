<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM songs WHERE id=$id";
    $result = $conn->query($sql);
    $song = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $lyrics = $_POST["lyrics"];

    if ($_FILES["audio"]["name"]) {
        $targetDir = "uploads/";
        $audioFile = $targetDir . basename($_FILES["audio"]["name"]);
        move_uploaded_file($_FILES["audio"]["tmp_name"], $audioFile);
        $sql = "UPDATE songs SET title='$title', audio_file='$audioFile', lyrics='$lyrics' WHERE id=$id";
    } else {
        $sql = "UPDATE songs SET title='$title', lyrics='$lyrics' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_audio.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Bài Hát</title>
</head>
<body>
    <h2>Sửa Bài Hát</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $song['id']; ?>">
        <label>Tên bài hát:</label>
        <input type="text" name="title" value="<?php echo $song['title']; ?>" required><br>
        <label>Audio:</label>
        <input type="file" name="audio"><br>
        <label>Lời bài hát:</label>
        <textarea name="lyrics" required><?php echo $song['lyrics']; ?></textarea><br>
        <button type="submit">Lưu</button>
    </form>
</body>
</html>
