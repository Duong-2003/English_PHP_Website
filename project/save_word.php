<?php
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');

// Xử lý lưu từ mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['original']) && isset($_POST['translated'])) {
    $originalText = $_POST['original'];
    $translatedText = $_POST['translated'];

    // Thực hiện việc lưu từ vào database
    $query = "INSERT INTO saved_words (original, translated) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $originalText, $translatedText);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Từ đã được lưu thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Có lỗi khi lưu từ!']);
    }

    // Đóng statement
    $stmt->close();
}



// Lấy danh sách từ đã lưu
$query = "SELECT id, original, translated FROM saved_words ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dino English Translate</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="container mt-10">
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-xl mx-auto">
        <h2 class="text-center text-2xl font-semibold text-gray-700">📚 Danh sách từ đã lưu</h2>

        <!-- Ô tìm kiếm từ đã lưu -->
        <div class="mt-4">
            <input id="searchInput" type="text" class="w-full border rounded-lg p-2 text-lg" placeholder="🔍 Nhập từ cần tìm...">
        </div>

        <!-- Danh sách từ đã lưu -->
        <div class="mt-4 p-3 bg-white rounded-lg shadow-md">
            <ul id="wordList" class="list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="list-group-item flex justify-between">
                        <span class="font-semibold"><?php echo $row['original']; ?></span>
                        <span class="text-gray-600"><?php echo $row['translated']; ?></span>
                        <button class="btn btn-danger btn-sm" onclick="deleteWord(<?php echo $row['id']; ?>)">Xóa</button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Nút quay lại -->
        <div class="mt-4 text-center">
            <a href="../project/translate_english.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">🔙 Quay lại</a>
        </div>
    </div>
</div>

<script>
function deleteWord(id) {
    if (confirm("Bạn có chắc muốn xóa từ này?")) {
        fetch('../project/delete_word.php', { // Đảm bảo đường dẫn đúng
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `delete_id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("✅ Từ đã được xóa thành công!");
                location.reload(); // Tải lại trang sau khi xóa
            } else {
                alert("⚠️ Có lỗi khi xóa từ!");
            }
        })
        .catch(error => {
            alert("⚠️ Không thể kết nối đến máy chủ!");
            console.error('Error:', error); // Hiển thị lỗi chi tiết
        });
    }
}
</script>

</body>
</html>
