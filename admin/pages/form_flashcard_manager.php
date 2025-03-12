<?php
session_start();
include '../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm flashcard
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_word'])) {
    $word = $_POST['word'];
    $topic = $_POST['topic']; // Chủ đề

    // Xử lý tệp tải lên
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];

        $uploadDir = '../../uploads/'; // Đảm bảo thư mục này tồn tại và có quyền ghi
        $imagePath = $uploadDir . basename($imageName);

        // Kiểm tra kích thước tệp (giới hạn 2MB)
        if ($imageSize > 2000000) {
            echo "Kích thước tệp quá lớn!";
        } else if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Nếu tệp tải lên thành công, lưu vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO flashcards (word, image, topic) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $word, $imagePath, $topic);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Có lỗi khi tải lên tệp!";
        }
    }
}

// Lấy danh sách flashcards
$sql = "SELECT * FROM flashcards"; 
$result = $conn->query($sql);
$flashcards = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flashcards[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Flashcard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Quản Lý Flashcard</h1>
        <a href="../../admin/includes/logic/add_flashcard_manager.php" class="mb-4 inline-block">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm Flashcard</button>
        </a>
        <h2 class="text-xl font-semibold mb-2">Danh Sách Flashcard</h2>
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Từ</th>
                    <th class="py-2 px-4 border-b">Chủ Đề</th>
                    <th class="py-2 px-4 border-b">Hình Ảnh</th>
                    <th class="py-2 px-4 border-b">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flashcards as $flashcard): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($flashcard['id']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($flashcard['word']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($flashcard['topic']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <?php
                            // Đường dẫn tới hình ảnh trong thư mục assets
                            $imageSrc = '../../admin/assets/images/' . basename($flashcard['image']);
                            ?>
                            <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Hình ảnh" class="w-16 h-auto">
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="../../admin/includes/logic/edit_flashcard_manager.php?id=<?php echo $flashcard['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded mr-2">Sửa</a>
                            <a href="../../admin/includes/logic/delete_flashcard_manager.php?id=<?php echo $flashcard['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa flashcard này không?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function deleteWord(id) {
            if (confirm("Bạn có chắc chắn muốn xóa từ này?")) {
                window.location.href = 'delete_flashcard.php?id=' + id; // Chuyển hướng đến trang xóa
            }
        }
    </script>
</body>
</html>