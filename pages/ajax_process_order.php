<?php
session_start();
header('Content-Type: application/json');

include('db.php');

$data = json_decode(file_get_contents("php://input"), true);
$product_id = intval($data['product_id'] ?? 0);
$quantity = intval($data['quantity'] ?? 0);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Bạn chưa đăng nhập.']);
    exit;
}

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'error' => 'Dữ liệu không hợp lệ.']);
    exit;
}

$stmt = $conn->prepare("SELECT ten_san_pham, gia, giam_gia, so_luong FROM san_pham WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Sản phẩm không tồn tại.']);
    exit;
}
$product = $result->fetch_assoc();

if ($quantity > $product['so_luong']) {
    echo json_encode(['success' => false, 'error' => 'Số lượng vượt quá tồn kho.']);
    exit;
}

$unit_price = $product['gia'] - $product['giam_gia'];
$total_price = $unit_price * $quantity;
$user_id = $_SESSION['user_id'];

$conn->begin_transaction();
try {
    $stmtOrder = $conn->prepare("INSERT INTO don_hang (nguoi_dung_id, tong_tien, ngay_dat, trang_thai) VALUES (?, ?, NOW(), ?)");
    $status = 'cho_xu_ly';
    $stmtOrder->bind_param("ids", $user_id, $total_price, $status);
    $stmtOrder->execute();
    $order_id = $stmtOrder->insert_id;

    $stmtItem = $conn->prepare("INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia) VALUES (?, ?, ?, ?)");
    $stmtItem->bind_param("iiid", $order_id, $product_id, $quantity, $unit_price);
    $stmtItem->execute();

    $new_stock = $product['so_luong'] - $quantity;
    $stmtUpdate = $conn->prepare("UPDATE san_pham SET so_luong = ? WHERE id = ?");
    $stmtUpdate->bind_param("ii", $new_stock, $product_id);
    $stmtUpdate->execute();

    $conn->commit();

    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => 'Lỗi xử lý đơn hàng: ' . $e->getMessage()]);
}
