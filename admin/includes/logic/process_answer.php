<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vocabulary = $conn->query("SELECT id FROM vocabulary");
    while ($word = $vocabulary->fetch_assoc()) {
        $id = $word['id'];
        $correct_choice = isset($_POST['correct_choice_' . $id]) ? $_POST['correct_choice_' . $id] : null;

        if ($correct_choice !== null) {
            $stmt = $conn->prepare("UPDATE vocabulary SET correct_choice = ? WHERE id = ?");
            $stmt->bind_param("si", $correct_choice, $id);
            $stmt->execute();
        }
    }
    header("Location: ../../../admin/pages/admin_website.php"); // Thay thế bằng trang của bạn
    exit();
}
?>