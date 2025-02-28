<?php
include '../../../config/conn.php'; // Bao gồm file kết nối

$class_id = $_POST['class_id'];
$class_name = $_POST['class_name'];
$description = $_POST['description'];

$query = "UPDATE classes SET class_name = ?, description = ? WHERE class_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $class_name, $description, $class_id);
$stmt->execute();

$stmt->close();
$conn->close();
?>