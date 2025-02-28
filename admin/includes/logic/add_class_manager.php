<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm lớp
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['class_name'])) {
    $class_name = $_POST['class_name'];
    $description = $_POST['description'];

    // Thêm lớp vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO classes (class_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $class_name, $description);
    $stmt->execute();
}

// Lấy danh sách lớp
$query = "SELECT * FROM classes";
$result = $conn->query($query);
?>

<h3>Quản lý tài liệu theo lớp</h3>

<!-- Form Thêm Lớp -->
<div class="container mt-4">
    <h3>Thêm Lớp Mới</h3>
    <form method="POST" id="add-class-form">
        <div class="mb-3">
            <label for="class_name" class="form-label">Tên Lớp</label>
            <input type="text" class="form-control" id="class_name" name="class_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Lớp</button>
    </form>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên Lớp</th>
            <th>Mô Tả</th>
            <th>Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['class_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editClass(<?php echo $row['class_id']; ?>)">Sửa</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteClass(<?php echo $row['class_id']; ?>)">Xóa</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Không có lớp nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>