<?php
header('Content-Type: application/json');

// Kết nối CSDL
include('db1.php');

// Kiểm tra tham số ID
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Thiếu ID người dùng']);
    exit;
}

$id = $_GET['id'];

// Lấy thông tin người dùng theo ID
$query = "SELECT * FROM nguoi_dung WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'Không tìm thấy người dùng']);
}
?>
