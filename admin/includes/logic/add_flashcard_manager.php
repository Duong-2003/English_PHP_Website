<?php
session_start();
include '../../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm flashcard
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_flashcard'])) {
    $word = trim($_POST['word']); // Từ
    $topic = trim($_POST['topic']); // Chủ đề

    // Xử lý tệp tải lên
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];

        $uploadDir = '../../../admin/assets/images/'; // Đường dẫn tuyệt đối
        $imagePath = $uploadDir . basename($imageName);

        // Kiểm tra kích thước tệp (giới hạn 2MB)
        if ($imageSize > 2000000) {
            echo "<script>alert('Kích thước tệp quá lớn!');</script>";
        } else if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Nếu tệp tải lên thành công, lưu vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO flashcards (word, topic, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $word, $topic, $imagePath);
            
            if ($stmt->execute()) {
                header("Location: ../../../admin/pages/admin_website.php"); // Chuyển hướng về trang quản lý
                exit();
            } else {
                echo "<script>alert('Có lỗi khi thêm flashcard!');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Có lỗi khi tải lên tệp!');</script>";
        }
    } else {
        echo "<script>alert('Không có tệp nào được tải lên.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Flashcard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Thêm Flashcard</h1>
        <form method="POST" class="mb-4 bg-white p-4 rounded-lg shadow-md" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="word" class="block text-gray-700 text-sm font-bold mb-2">Từ:</label>
                <input type="text" name="word" id="word" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="topic" class="block text-gray-700 text-sm font-bold mb-2">Chủ Đề:</label>
                <input type="text" name="topic" id="topic" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Tải lên Hình Ảnh:</label>
                <input type="file" name="image" id="image" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <button type="submit" name="add_flashcard" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm Flashcard</button>
        </form>
    </div>
</body>
</html>