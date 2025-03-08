<?php
include '../../config/conn.php'; // Bao gồm file kết nối

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.id AS document_id, d.title, d.file_path, u.username 
                                    FROM documents d 
                                    JOIN users u ON d.user_id = u.user_id");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Liệu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h3 class="text-2xl font-semibold mb-4">Danh Sách Tài Liệu</h3>
        <a href="../../admin/includes/logic/add_document_manager.php" class="mb-4 inline-block">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm tài liệu</button>
        </a>
        <table class="min-w-full bg-white rounded-lg shadow-md mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Tiêu Đề</th>
                    <th class="py-2 px-4 border-b">Tài Liệu</th>
                    <th class="py-2 px-4 border-b">Người Dùng</th>
                    <th class="py-2 px-4 border-b">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($doc = $documents->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($doc['document_id']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($doc['title']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="../../admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=view" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2">Xem</a>
                            <a href="../../admin/includes/logic/serve_document.php?file_id=<?php echo $doc['document_id']; ?>&action=download" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Tải Về</a>
                        </td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($doc['username']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <form method="POST" action="delete_document.php" style="display:inline;">
                                <input type="hidden" name="document_id" value="<?php echo htmlspecialchars($doc['document_id']); ?>">
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>