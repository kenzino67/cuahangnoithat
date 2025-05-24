<?php
include('db1.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['ten_san_pham'];
    $slug = $_POST['duong_dan'];
    $description = $_POST['mo_ta'];
    $price = $_POST['gia'];
    $discount = $_POST['giam_gia'];
    $quantity = $_POST['so_luong'];
    $category_id = $_POST['danh_muc_id'];
    $image = $_POST['anh_dai_dien'];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = $created_at;

    $sql = "INSERT INTO san_pham (ten_san_pham, duong_dan, mo_ta, gia, giam_gia, so_luong, danh_muc_id, anh_dai_dien, ngay_tao, ngay_cap_nhat)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([
        $name, $slug, $description, $price, $discount, $quantity, $category_id, $image, $created_at, $updated_at
    ]);

    header("Location: index.php");
}
?>
<!-- HTML form thêm sản phẩm tại đây -->
