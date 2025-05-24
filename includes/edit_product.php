<?php
include('db1.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $name = $_POST['ten_san_pham'];
    $slug = $_POST['duong_dan'];
    $description = $_POST['mo_ta'];
    $price = $_POST['gia'];
    $discount = $_POST['giam_gia'];
    $quantity = $_POST['so_luong'];
    $category_id = $_POST['danh_muc_id'];
    $image = $_POST['anh_dai_dien'];
    $updated_at = date('Y-m-d H:i:s');

    $sql = "UPDATE san_pham SET ten_san_pham = ?, duong_dan = ?, mo_ta = ?, gia = ?, giam_gia = ?, so_luong = ?, danh_muc_id = ?, anh_dai_dien = ?, ngay_cap_nhat = ? 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, $slug, $description, $price, $discount, $quantity, $category_id, $image, $updated_at, $id
    ]);

    // Chuyển hướng lại trang danh sách sản phẩm sau khi cập nhật
    header("Location: index.php");
    exit();
}
?>
