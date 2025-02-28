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

<div class="container">
    <h2>Quản Lý Lớp Học</h2>
   

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Lớp</th>
                <th>Mô Tả</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $class): ?>
                <tr>
                    <td><?php echo $class['class_id']; ?></td>
                    <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($class['description']); ?></td>
                    <td>
                    <a href="../../admin/includes/logic/add_class_manager.php" class="btn btn-success" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
                        <a href="../../admin/includes/logic/edit_user_manager.php" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Sửa</a>
                        <a href="../../admin/includes/logic/delete_user_manager.php?key=user_id&table=users&datakey=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
                       
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>