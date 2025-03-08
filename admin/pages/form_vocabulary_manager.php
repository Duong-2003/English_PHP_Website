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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-4">Quản Lý Từ Vựng</h2>
        <a href="../../admin/includes/logic/add_vocabulary_manager.php" class="mb-4 inline-block">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm Từ Vựng</button>
        </a>
        <hr>
        <h3>Danh Sách Từ Vựng</h3>
        <form method="POST" action="../../admin/includes/logic/process_answer.php">
            <table class="min-w-full bg-white rounded-lg shadow-md mt-4">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Từ</th>
                        <th class="py-2 px-4 border-b">Lựa Chọn</th>
                        <th class="py-2 px-4 border-b">Đáp Án Đúng</th>
                        <th class="py-2 px-4 border-b">Chủ Đề</th>
                        <th class="py-2 px-4 border-b">Hình Ảnh</th>
                        <th class="py-2 px-4 border-b">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($word = $vocabulary->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?php echo $word['id']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($word['word']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($word['choices']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($word['correct_choice']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($word['topic']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <?php
                                $imageDirectory = '../../admin/assets/images/';
                                if (is_dir($imageDirectory)) {
                                    $images = scandir($imageDirectory);
                                    $imageFiles = array_filter($images, function ($file) use ($imageDirectory) {
                                        return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file) && is_file($imageDirectory . $file);
                                    });
                                    ?>
                                    <div class="flex flex-wrap justify-center">
                                        <?php foreach ($imageFiles as $image): ?>
                                            <?php $imgSrc = '../../admin/assets/images/' . htmlspecialchars($image); ?>
                                            <div class="flex flex-col items-center m-2">
                                                <img src="<?php echo $imgSrc; ?>" alt="Hình ảnh" class="w-24 h-24 object-cover rounded-lg">
                                                <input type="radio" name="correct_choice_<?php echo $word['id']; ?>" value="<?php echo htmlspecialchars($image); ?>" <?php if ($word['correct_choice'] == $image) echo 'checked'; ?> class="mt-2">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php
                                } else {
                                    echo "Thư mục không tồn tại.";
                                }
                                ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <a href="../../admin/includes/logic/edit_vocabulary_manager.php?id=<?php echo $word['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded mr-2">Sửa</a>
                                <a href="../../admin/includes/logic/delete_vocabulary_manager.php?id=<?php echo $word['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa từ vựng này không?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4">Lưu Đáp Án</button>
        </form>
    </div>
</body>
</html>