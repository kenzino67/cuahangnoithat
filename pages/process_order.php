<?php
session_start();
include('db.php'); // Kết nối mysqli

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vui lòng đăng nhập trước khi đặt hàng!'); window.location.href='login.php';</script>";
    exit;
}

$user = $_SESSION['user'];

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);
$address = trim($_POST['address']);
$price = floatval($_POST['price']);
$total_price = $quantity * $price;
$nguoi_dung_id = $user['id'];  // Giả sử trong session lưu trường id của user

// Sinh mã đơn hàng tự động (ví dụ: DH + timestamp + random)
$ma_don_hang = 'DH' . date('ymdHis') . rand(100, 999);

$stmt = $conn->prepare("INSERT INTO don_hang (ma_don_hang, nguoi_dung_id, tong_tien, trang_thai, dia_chi_giao_hang, ngay_dat) VALUES (?, ?, ?, 'cho_xu_ly', ?, NOW())");
$stmt->bind_param("sids", $ma_don_hang, $nguoi_dung_id, $total_price, $address);

if ($stmt->execute()) {
    echo "<script>alert('Đặt hàng thành công!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Lỗi khi đặt hàng. Vui lòng thử lại!'); window.history.back();</script>";
}
