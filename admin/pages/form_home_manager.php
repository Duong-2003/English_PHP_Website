

<?php
include '../../config/conn.php'; // Bao gồm file kết nối

// Lấy số lượng người dùng
$userCountResult = $conn->query("SELECT COUNT(*) AS count FROM users");
$userCount = $userCountResult->fetch_assoc()['count'];

// Lấy số lượng video
$videoCountResult = $conn->query("SELECT COUNT(*) AS count FROM songs");
$videoCount = $videoCountResult->fetch_assoc()['count'];

// Lấy số lượng tài liệu
$documentCountResult = $conn->query("SELECT COUNT(*) AS count FROM documents");
$documentCount = $documentCountResult->fetch_assoc()['count'];
// Lấy số lượng tài liệu
$vocabularyCountResult = $conn->query("SELECT COUNT(*) AS count FROM vocabulary");
$vocabularyCount = $vocabularyCountResult->fetch_assoc()['count'];
?>


<body>
<div class="container">
    <h2 class="text-center mt-5">Dashboard - Trang Quản Trị</h2>

    <div class="row mt-4 mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Số Lượng Người Dùng
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($userCount); ?></h3>
                    <p class="card-text">Tổng số tài khoản hiện có.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Số Lượng Video
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($videoCount); ?></h3>
                    <p class="card-text">Tổng số video đã được thêm .</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Số Lượng Tài Liệu
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($documentCount); ?></h3>
                    <p class="card-text">Tổng số tài liệu hiện có.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Số Lượng Từ Vựng
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($vocabularyCount); ?></h3>
                    <p class="card-text">Tổng số từ vựng hiện có.</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
