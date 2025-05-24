<?php
header('Content-Type: application/json');
include 'db1.php'; // Kết nối PDO đã chuẩn bị sẵn trong biến $pdo

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM don_hang WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        echo json_encode($order);
    } else {
        echo json_encode(['error' => 'Không tìm thấy đơn hàng']);
    }
} else {
    echo json_encode(['error' => 'Thiếu ID']);
}
?>
