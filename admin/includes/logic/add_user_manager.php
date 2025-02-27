<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

// Xử lý thêm người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Kiểm tra xem tên đăng nhập đã tồn tại chưa
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.');</script>";
    } else {
        // Thực hiện thêm người dùng
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $role);
        $stmt->execute();
    }
}

// Xử lý xóa người dùng
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Lấy danh sách người dùng
$result = $conn->query("SELECT user_id, username, email, role FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <h2>Quản Lý Người Dùng</h2>
    <form method="POST" class="mb-4">
        <input type="text" name="username" placeholder="Username" required class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
        <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
        <select name="role" required class="form-control mb-2">
    
    <option value="teacher" selected>Giáo Viên</option>
</select>
        <button type="submit" name="add_user" class="btn btn-primary">Thêm Người Dùng</button>
    </form>

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
                        <a href="#" class="btn btn-warning" onclick="editUser(<?php echo $user['user_id']; ?>)">Sửa</a>
                        <a href="?delete=<?php echo $user['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>