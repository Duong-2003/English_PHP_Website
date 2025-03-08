<?php
session_start();
include '../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm lớp
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];
    $description = $_POST['description'];

    // Kiểm tra xem lớp đã tồn tại chưa
    $stmt = $conn->prepare("SELECT * FROM classes WHERE class_name = ?");
    $stmt->bind_param("s", $class_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Lớp đã tồn tại. Vui lòng chọn tên khác.');</script>";
    } else {
        // Thực hiện thêm lớp
        $stmt = $conn->prepare("INSERT INTO classes (class_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $class_name, $description);
        $stmt->execute();
    }
}

// Xử lý xóa lớp
if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM classes WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
}

// Lấy danh sách lớp
$result = $conn->query("SELECT class_id, class_name, description FROM classes");
$classes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Lớp Học</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-4">Quản Lý Lớp Học</h2>

        <form method="POST" class="mb-4 bg-white p-4 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="class_name" class="block text-gray-700 text-sm font-bold mb-2">Tên Lớp:</label>
                <input type="text" name="class_name" id="class_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô Tả:</label>
                <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <button type="submit" name="add_class" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm Lớp</button>
        </form>

        <table class="min-w-full bg-white rounded-lg shadow-md mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Tên Lớp</th>
                    <th class="py-2 px-4 border-b">Mô Tả</th>
                    <th class="py-2 px-4 border-b">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?php echo $class['class_id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($class['class_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($class['description']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="../../admin/includes/logic/edit_class_manager.php?class_id=<?php echo $class['class_id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded mr-2">Sửa</a>
                            <a href="?delete=<?php echo $class['class_id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa lớp này không?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>