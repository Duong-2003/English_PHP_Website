<?php
include '../../../config/conn.php'; // Bao gồm file kết nối



// Xử lý xóa người dùng
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Xử lý cập nhật người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $username, $email, $role, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Thông tin người dùng đã được cập nhật thành công.'); window.location.href='form_user_manager.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật thông tin người dùng.');</script>";
    }
}

// Lấy danh sách người dùng
$result = $conn->query("SELECT user_id, username, email, role FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <h2>Quản Lý Người Dùng</h2>
   
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
                        <button class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Sửa</button>
                        <a href="?delete=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Sửa Người Dùng -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Sửa Tài Khoản Người Dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" action="">
                    <input type="hidden" name="user_id" id="editUserId">
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Tên Người Dùng</label>
                        <input type="text" name="username" id="editUsername" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Vai Trò</label>
                        <select name="role" id="editRole" class="form-control" required>
                            <option value="student">Học Sinh</option>
                            <option value="teacher">Giáo Viên</option>
                        </select>
                    </div>
                    <button type="submit" name="update_user" class="btn btn-primary">Cập Nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

