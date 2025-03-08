<?php
session_start();
include '../../../config/conn.php';

$word = '';
$choices = '';
$correct_choice = '';
$topic = '';
$images = ['', '', '', ''];
$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT word, choices, correct_choice, topic, image FROM vocabulary WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $vocab = $result->fetch_assoc();
        $word = $vocab['word'];
        $choices = $vocab['choices'];
        $correct_choice = $vocab['correct_choice'];
        $topic = $vocab['topic'];
        $images = explode(',', $vocab['image']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $word = $_POST['word'];
    $choices = trim($_POST['choices']); // Loại bỏ khoảng trắng thừa
    $correct_choice = isset($_POST['correct_choice']) ? $_POST['correct_choice'] : '';
    $topic = $_POST['topic'];

    // Kiểm tra tính hợp lệ của dữ liệu choices (ví dụ: kiểm tra định dạng)
    if (empty($choices)) {
        $choices = NULL; // Cho phép giá trị NULL nếu cần
    }

    $uploaded_images = [];
    for ($i = 0; $i < 4; $i++) {
        if (isset($_FILES['image_upload'][$i]) && $_FILES['image_upload'][$i]['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image_upload"][$i]["name"]);
            if (move_uploaded_file($_FILES["image_upload"][$i]["tmp_name"], $target_file)) {
                $uploaded_images[] = $target_file;
            }
        } else {
            if (isset($images[$i]) && !empty($images[$i])) {
                $uploaded_images[] = $images[$i];
            }
        }
    }

    $image_string = implode(',', $uploaded_images);

    if ($id) {
        $stmt = $conn->prepare("UPDATE vocabulary SET word = ?, choices = ?, correct_choice = ?, topic = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $word, $choices, $correct_choice, $topic, $image_string, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO vocabulary (word, choices, correct_choice, topic, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $word, $choices, $correct_choice, $topic, $image_string);
    }

    if ($stmt->execute()) {
        header("Location: ../../../admin/pages/admin_website.php");
        exit();
    } else {
        echo "Lỗi: " . $stmt->error; // Hiển thị lỗi nếu có
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Sửa Từ Vựng' : 'Thêm Từ Vựng'; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2><?php echo $id ? 'Sửa Từ Vựng' : 'Thêm Từ Vựng'; ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="word" class="form-label">Từ</label>
            <input type="text" class="form-control" id="word" name="word" value="<?php echo htmlspecialchars($word); ?>" required>
        </div>
        <div class="mb-3">
            <label for="choices" class="form-label">Lựa Chọn (cách nhau bằng dấu phẩy)</label>
            <input type="text" class="form-control" id="choices" name="choices" value="<?php echo htmlspecialchars($choices); ?>">
        </div>
        <div class="mb-3">
            <label for="topic" class="form-label">Chủ Đề</label>
            <input type="text" class="form-control" id="topic" name="topic" value="<?php echo htmlspecialchars($topic); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình Ảnh (Tối đa 4 hình)</label>
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="mb-2">
                    <input type="file" class="form-control" name="image_upload[]" accept="image/*">
                    <?php if (!empty($images[$i])): ?>
                        <div class="mt-2">
                            <img src="<?php echo htmlspecialchars($images[$i]); ?>" alt="Hình ảnh" style="width: 100px; height: auto;">
                            <label>
                                <input type="radio" name="correct_choice" value="<?php echo htmlspecialchars($images[$i]); ?>" <?php if ($correct_choice == $images[$i]) echo 'checked'; ?>>
                                Đáp án đúng
                            </label>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Cập Nhật' : 'Thêm'; ?></button>
    </form>
    <a href="../../../admin/pages/admin_website.php" class="btn btn-secondary mt-3">Quay lại</a>
</div>
</body>
</html>