<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <title>Admin Dashboard - Website Learning English</title>
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            min-width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            border-right: 1px solid #ddd;
            position: fixed;
            height: 100%;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
        }
        p {
            font-size: 1.2rem;
            color: #666;
        }
        .nav-link {
            font-size: 1.1rem;
            color: white;
        }
        .nav-link:hover {
            background-color: #495057;
        }
        .nav-link.active {
            background-color: #007bff;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h5>Quản Lý</h5>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="#" onclick="showContent('home')">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('userManagement')">
                <i class="fas fa-user"></i> Quản lý người dùng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('videoManagement')">
                <i class="fas fa-video"></i> Quản lý video
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('documentManagement')">
                <i class="fas fa-file-alt"></i> Quản lý tài liệu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showContent('settings')">
                <i class="fas fa-cog"></i> Cài đặt
            </a>
        </li>
    </ul>
</div>

<div class="content" id="content-area">
    <h2 class="text-center">Chào mừng đến với trang quản lý admin!</h2>
    <p>Vui lòng chọn một mục từ menu bên trái để bắt đầu.</p>
</div>

<script>
    function showContent(section) {
        const contentArea = document.getElementById('content-area');
        let content = '';

        switch (section) {
            case 'userManagement':
                content = `
                    <h2>Quản lý người dùng</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nguyễn Văn A</td>
                                <td>a@example.com</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Chỉnh sửa</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Trần Thị B</td>
                                <td>b@example.com</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Chỉnh sửa</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `;
                break;
            case 'videoManagement':
                content = `
                    <h2>Quản lý video</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Video</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Video Học 1</td>
                                <td>10:00</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Chỉnh sửa</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Video Học 2</td>
                                <td>20:00</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Chỉnh sửa</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `;
                break;
            case 'documentManagement':
                content = '<h2>Quản lý tài liệu</h2><p>Thông tin tài liệu sẽ được hiển thị ở đây.</p>';
                break;
            case 'settings':
                content = '<h2>Cài đặt</h2><p>Các tùy chọn cài đặt sẽ được hiển thị ở đây.</p>';
                break;
            case 'home': // Thêm trường hợp cho "Trang chủ"
                content = '<h2>Chào mừng đến với trang quản lý admin!</h2><p>Vui lòng chọn một mục từ menu bên trái để bắt đầu.</p>';
                break;
            default:
                content = '<h2>Chào mừng đến với trang quản lý admin!</h2><p>Vui lòng chọn một mục từ menu bên trái để bắt đầu.</p>';
        }

        contentArea.innerHTML = content;
    }
</script>

</body>
</html>