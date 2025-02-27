<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm tài liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_document'])) {
    $class_id = $_POST['class_id'];
    $title = $_POST['title'];
    $file_url = $_POST['file_url'];
    $user_id = $_POST['user_id']; // ID người dùng

    $stmt = $conn->prepare("INSERT INTO documents (class_id, title, file_url, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $class_id, $title, $file_url, $user_id);
    $stmt->execute();
}

// Lấy danh sách tài liệu
$documents = $conn->query("SELECT d.document_id, d.title, d.file_url, c.class_name, u.username 
                             FROM documents d 
                             JOIN classes c ON d.class_id = c.class_id
                             JOIN users u ON d.user_id = u.user_id");

// Lấy danh sách người dùng
$users = $conn->query("SELECT user_id, username FROM users");
?>

<div class="container">
    <h2>Quản Lý Tài Liệu</h2>

    <!-- Form thêm tài liệu -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="class_id">Lớp:</label>
            <select class="form-control" id="class_id" name="class_id" required>
                <?php
                // Lấy danh sách lớp
                $classes = $conn->query("SELECT * FROM classes");
                while ($class = $classes->fetch_assoc()) {
                    echo "<option value='{$class['class_id']}'>{$class['class_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Tiêu Đề:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="file_url">URL Tài Liệu:</label>
            <input type="text" class="form-control" id="file_url" name="file_url" required>
        </div>
        <div class="form-group">
            <label for="user_id">Người Dùng:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" name="add_document" class="btn btn-primary">Thêm Tài Liệu</button>
    </form>

    <hr>

    <!-- Danh sách tài liệu -->
    <h3>Danh Sách Tài Liệu</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Lớp</th>
                <th>Tài Liệu</th>
                <th>Người Dùng</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($doc = $documents->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $doc['document_id']; ?></td>
                    <td><?php echo $doc['title']; ?></td>
                    <td><?php echo $doc['class_name']; ?></td>
                    <td><a href="<?php echo $doc['file_url']; ?>" target="_blank">Xem</a></td>
                    <td><?php echo $doc['username']; ?></td>
                    <td>
                        <form method="POST" action="delete_document.php" style="display:inline;">
                            <input type="hidden" name="document_id" value="<?php echo $doc['document_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>