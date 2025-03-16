<?php
session_start();
include '../../config/conn.php'; // Đảm bảo đường dẫn đúng đến file kết nối

// Thêm bài hát
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_song'])) {
    $title = $_POST['song_title'];
    $lyrics = $_POST['song_lyrics'];
    $audio_file = $_POST['audio_file'];

    $stmt = $conn->prepare("INSERT INTO songs (title, lyrics, audio_file) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $lyrics, $audio_file);
    $stmt->execute();
    $stmt->close();
}

// Xóa bài hát
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM songs WHERE id=$id");
}

// Cập nhật bài hát
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_song'])) {
    $id = $_POST['song_id'];
    $title = $_POST['song_title'];
    $lyrics = $_POST['song_lyrics'];
    $audio_file = $_POST['audio_file'];

    $stmt = $conn->prepare("UPDATE songs SET title=?, lyrics=?, audio_file=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $lyrics, $audio_file, $id);
    $stmt->execute();
    $stmt->close();
    
    header('Location: manage_songs.php'); // Chuyển hướng về trang quản lý
    exit;
}

// Lấy danh sách bài hát
$songs = $conn->query("SELECT * FROM songs");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Bài Hát</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mt-4">Quản Lý Bài Hát</h2>
        
        <form method="POST">
            <input type="text" name="song_title" placeholder="Tên bài hát" required class="border p-2 mb-2 w-full">
            <textarea name="song_lyrics" placeholder="Lời bài hát" required class="border p-2 mb-2 w-full"></textarea>
            <input type="text" name="audio_file" placeholder="Link audio" required class="border p-2 mb-2 w-full">
            <button type="submit" name="add_song" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm Bài Hát</button>
        </form>

        <table class="min-w-full bg-white rounded-lg shadow-md mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Tên bài hát</th>
                    <th class="py-2 px-4 border-b">Audio</th>
                    <th class="py-2 px-4 border-b">Lời bài hát</th>
                    <th class="py-2 px-4 border-b">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($song = $songs->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?php echo $song['id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($song['title']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <audio controls>
                                <source src="<?php echo htmlspecialchars($song['audio_file']); ?>" type="audio/mpeg">
                                Your browser does not support the audio tag.
                            </audio>
                            
                        </td>
                        <td class="py-2 px-4 border-b"><?php echo nl2br(htmlspecialchars($song['lyrics'])); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="?delete=<?php echo $song['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                            <a href="edit_song.php?id=<?php echo $song['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Sửa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>