<?php
include '../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm video
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $video_url = $_POST['video_url'];
    $lyrics = $_POST['lyrics'];

    $stmt = $conn->prepare("INSERT INTO videos (title, artist, video_url, lyrics) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $artist, $video_url, $lyrics);
    $stmt->execute();
}

// Lấy danh sách video
$videos = $conn->query("SELECT * FROM videos");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Quản Trị Video Âm Nhạc</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Quản Trị Video Âm Nhạc</h2>
    <button>
    <a href="../../admin/includes/logic/add_videos_manager.php#" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
    </button>
   
  

    <hr>

    <!-- Danh sách video -->
    <h3>Danh Sách Video</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Ca Sĩ</th>
                <th>URL Video</th>
                <th>Lời Bài Hát</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($video = $videos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $video['video_id']; ?></td>
                    <td><?php echo $video['title']; ?></td>
                    <td><?php echo $video['artist']; ?></td>
                    <td><a href="<?php echo $video['video_url']; ?>" target="_blank">Xem</a></td>
                    <td><?php echo nl2br($video['lyrics']); ?></td>
                    <td>
                    <a href="../../admin/includes/logic/add_videos_manager.php" class="btn btn-success" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
                        <a href="../../admin/includes/logic/edit_videos_manager.php" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Sửa</a>
                        <a href="../../admin/includes/logic/delete_user_manager.php?key=user_id&table=users&datakey=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
                       
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>