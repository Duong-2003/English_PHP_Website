
<?php
session_start();
include '../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $role);
    $stmt->execute();
}



// Lấy danh sách người dùng
$result = $conn->query("SELECT user_id, username, email, role FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <h2>Quản Lý Người Dùng</h2>
    <button>
    <a href="../../admin/includes/font/modal_add_user_manager.php#" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
    </button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Vai Trò</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                    <a href="../../admin/includes/logic/add_user_manager.php" class="btn btn-success" onclick="editUser(<?php echo $user['user_id']; ?>)">Thêm</a>
                        <a href="../../admin/includes/logic/edit_user_manager.php" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Sửa</a>
                        <a href="../../admin/includes/logic/delete_user_manager.php?key=user_id&table=users&datakey=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
                       
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>