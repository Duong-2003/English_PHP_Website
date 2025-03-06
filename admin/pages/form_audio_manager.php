<style>
            .lyrics-container {
            margin-top: 20px;
            font-size: 20px;
            color: gray;
            font-weight: 500;
            max-height: 150px;  /* Giới hạn chiều cao */
            overflow: hidden;
            position: relative;
            transition: max-height 0.3s ease;
        }
        .lyrics-container.expanded {
            max-height: none;
        }
        .show-more {
            display: inline-block;
            margin-top: 10px;
            color: blue;
            cursor: pointer;
            font-size: 16px;
        }
</style>
<?php
session_start();
include '../../config/conn.php'; // Bao gồm file kết nối

// Hàm chuyển đổi URL YouTube thành URL nhúng
function getYoutubeEmbedUrl($url) {
    // Nếu URL chứa "youtu.be"
    if (strpos($url, "youtu.be") !== false) {
        $parts = explode("/", $url);
        $id = end($parts);
        return "https://www.youtube.com/embed/" . $id;
    }
    // Nếu URL chứa "youtube.com/watch?v="
    if (strpos($url, "youtube.com") !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        if (isset($query['v'])) {
            return "https://www.youtube.com/embed/" . $query['v'];
        }
    }
    // Nếu không, trả về URL gốc
    return $url;
}

// Lấy danh sách bài hát từ CSDL
$sql = "SELECT * FROM songs"; 
$result = $conn->query($sql);
$songs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Video</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Quản lý Video</h2>
    <hr>
    
    <!-- Danh sách Video -->
    <h3>Danh sách bài hát và video</h3>
    <a href="../../admin/includes/logic/add_audio_manager.php" class="btn btn-success">Thêm</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên bài hát</th>
                <th>Video</th>
                <th>Lời bài hát</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($songs as $song): ?>
                <tr>
                    <td><?php echo $song['id']; ?></td>
                    <td><?php echo htmlspecialchars($song['title']); ?></td>
                    <td>
                        <?php if (!empty($song['video_file'])): ?>
                            <?php $embedUrl = getYoutubeEmbedUrl($song['video_file']); ?>
                            <iframe width="500" height="281" src="<?php echo $embedUrl; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php else: ?>
                            <p>Không có video</p>
                        <?php endif; ?>
                    </td>
                    
                    <td>
    <?php
    $maxLength = 100; // Số ký tự tối đa muốn hiển thị
    $lyrics = $song['lyrics'];
    if (strlen($lyrics) > $maxLength) {
        $lyrics = substr($lyrics, 0, $maxLength) . '...';
    }
    echo nl2br(htmlspecialchars($lyrics));
    ?>
</td>

                    <td>
                       
                        <a href="../../admin/includes/logic/edit_audio_manager.php?id=<?php echo $song['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="delete_audio.php?id=<?php echo $song['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
