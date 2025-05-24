<?php
// Kết nối CSDL
include('db1.php');

// Lấy dữ liệu sản phẩm theo ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM san_pham WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Nếu có sản phẩm
    if ($product) {
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Sản phẩm không tồn tại']);
    }
}
?>
