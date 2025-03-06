

<?php
session_start();
include '../../config/conn.php'; // Bao gồm file kết nối

// Lấy danh sách audio từ CSDL
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
    <div class="container">
        <h2 class="mt-4">Quản lý Audio</h2>



        <hr>

        <!-- Danh sách Audio -->
        <h3>Danh sách bài hát</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên bài hát</th>
                    <th>Nghe</th>
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
                <?php if (!empty($song['audio_file'])): ?>
                    <!-- Nếu có tệp âm thanh, phát tệp audio -->
                    <audio controls>
    <source src="../../../admin/assets/uploads/<?php echo $song['audio_file']; ?>" type="audio/mp3">
    Trình duyệt không hỗ trợ audio.
</audio>

                <?php elseif (!empty($song['video_file'])): ?>
                    <!-- Nếu có tệp video, phát tệp video -->
                    <video controls width="500">
                        <source src="../../../admin/assets/uploads/<?php echo $song['video_file']; ?>" type="video/mp4">
                        Trình duyệt không hỗ trợ video.
                    </video>
                <?php endif; ?>
            </td>
            <td><?php echo nl2br(htmlspecialchars($song['lyrics'])); ?></td>
            <td>
            <a href="../../admin/includes/logic/add_audio_manager.php" class="btn btn-success" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
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

</html>
