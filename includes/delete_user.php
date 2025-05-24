<?php
// Kết nối CSDL
include('db1.php');

// Kiểm tra nếu có ID trong URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn xóa người dùng theo ID
    $query = "DELETE FROM nguoi_dung WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Xóa tài khoản thành công!";
    } else {
        echo "Có lỗi xảy ra khi xóa tài khoản.";
    }
} else {
    echo "ID không hợp lệ!";
}
?>
