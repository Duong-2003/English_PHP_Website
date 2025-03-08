<?php
session_start();
include '../../config/conn.php';

$vocabulary = $conn->query("SELECT id, word, choices, correct_choice, topic, image FROM vocabulary");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Từ Vựng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .image-container { display: flex; flex-wrap: wrap; }
        .image-container img { width: 100px; height: 100px; object-fit: cover; margin: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Quản Lý Từ Vựng</h2>
        <a href="../../admin/includes/logic/add_vocabulary_manager.php" class="btn btn-warning">Thêm Từ Vựng</a>
        <hr>
        <h3>Danh Sách Từ Vựng</h3>
        <form method="POST" action="../../admin/includes/logic/process_answer.php">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Từ</th>
                        <th>Lựa Chọn</th>
                        <th>Đáp Án Đúng</th>
                        <th>Chủ Đề</th>
                        <th>Hình Ảnh</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($word = $vocabulary->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $word['id']; ?></td>
                            <td><?php echo htmlspecialchars($word['word']); ?></td>
                            <td><?php echo htmlspecialchars($word['choices']); ?></td>
                            <td><?php echo htmlspecialchars($word['correct_choice']); ?></td>
                            <td><?php echo htmlspecialchars($word['topic']); ?></td>
                            <td>
                                <?php
                                $imageDirectory = '../../admin/assets/images/';
                                if (is_dir($imageDirectory)) {
                                    $images = scandir($imageDirectory);
                                    $imageFiles = array_filter($images, function ($file) use ($imageDirectory) {
                                        return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file) && is_file($imageDirectory . $file);
                                    });
                                    ?>
                                    <div class="image-container">
                                        <?php foreach ($imageFiles as $image): ?>
                                            <?php $imgSrc = '../../admin/assets/images/' . htmlspecialchars($image); ?>
                                            <div style="display: flex; flex-direction: column; align-items: center;">
                                                <img src="<?php echo $imgSrc; ?>" alt="Hình ảnh">
                                                <input type="radio" name="correct_choice_<?php echo $word['id']; ?>" value="<?php echo htmlspecialchars($image); ?>" <?php if ($word['correct_choice'] == $image) echo 'checked'; ?>>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php
                                } else {
                                    echo "Thư mục không tồn tại.";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="../../admin/includes/logic/edit_vocabulary_manager.php?id=<?php echo $word['id']; ?>" class="btn btn-warning">Sửa</a>
                                <a href="../../admin/includes/logic/delete_vocabulary_manager.php?id=<?php echo $word['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa từ vựng này không?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Lưu Đáp Án</button>
        </form>
    </div>
</body>
</html>