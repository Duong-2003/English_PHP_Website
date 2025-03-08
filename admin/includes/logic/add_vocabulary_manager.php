<?php
session_start();
include '../../../config/conn.php';

$word = '';
$definition = '';
$choices = '';
$correct_choice = '';
$topic = '';
$images = ['', '', '', ''];
$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT word, definition, choices, correct_choice, topic, image FROM vocabulary WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $vocab = $result->fetch_assoc();
        $word = $vocab['word'];
        $definition = $vocab['definition'];
        $choices = $vocab['choices'];
        $correct_choice = $vocab['correct_choice'];
        $topic = $vocab['topic'];
        $images = explode(',', $vocab['image']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $word = $_POST['word'];
    $definition = $_POST['definition'];
    $choices = $_POST['choices']; // Sửa lỗi xử lý choices
    $correct_choice = $_POST['correct_choice'];
    $topic = $_POST['topic'];

    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $uploaded_images = [];
    for ($i = 0; $i < 4; $i++) {
        if (isset($_FILES['image_upload'][$i]) && $_FILES['image_upload'][$i]['error'] === UPLOAD_ERR_OK) {
            $target_file = $target_dir . uniqid() . "_" . basename($_FILES["image_upload"][$i]["name"]);
            if (move_uploaded_file($_FILES["image_upload"][$i]["tmp_name"], $target_file)) {
                $uploaded_images[] = $target_file;
            } else {
                echo "Không thể di chuyển file " . $_FILES["image_upload"][$i]["name"];
            }
        } else {
            if (isset($images[$i]) && !empty($images[$i])) {
                $uploaded_images[] = $images[$i];
            }
        }
    }

    $image_string = implode(',', $uploaded_images);

    if ($id) {
        $stmt = $conn->prepare("UPDATE vocabulary SET word = ?, definition = ?, choices = ?, correct_choice = ?, topic = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $word, $definition, $choices, $correct_choice, $topic, $image_string, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO vocabulary (word, definition, choices, correct_choice, topic, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $word, $definition, $choices, $correct_choice, $topic, $image_string);
    }

    $stmt->execute();
    header("Location: ../../../admin/pages/admin_website.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Sửa Từ Vựng' : 'Thêm Từ Vựng'; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .image-container { display: flex; align-items: center; margin-bottom: 10px; }
        .image-container img { width: 100px; height: auto; margin-left: 10px; }
    </style>
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
            <input type="text" class="form-control" id="choices" name="choices" value="<?php echo htmlspecialchars($choices); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình Ảnh (Tối đa 4 hình)</label>
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="image-container">
                    <input type="file" class="form-control" name="image_upload[]" accept="image/*">
                    <?php if (!empty($images[$i])): ?>
                        <img src="<?php echo htmlspecialchars($images[$i]); ?>" alt="Hình ảnh">
                        <input type="radio" name="correct_choice" value="<?php echo htmlspecialchars($images[$i]); ?>" <?php if ($correct_choice == $images[$i]) echo 'checked'; ?>>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
        <div class="mb-3">
            <label for="topic" class="form-label">Chủ Đề</label>
            <input type="text" class="form-control" id="topic" name="topic" value="<?php echo htmlspecialchars($topic); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Cập Nhật' : 'Thêm'; ?></button>
    </form>
    <a href="../../../admin/pages/admin_website.php" class="btn btn-secondary mt-3">Quay lại</a>
</div>
</body>
</html>