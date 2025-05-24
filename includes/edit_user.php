<?php
// Kết nối CSDL
include('db1.php');
// Kiểm tra nếu có dữ liệu POST từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $dia_chi = $_POST['dia_chi'];
    $vai_tro = $_POST['vai_tro'];

    // Truy vấn cập nhật người dùng theo ID
    $query = "UPDATE nguoi_dung 
              SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai, 
                  dia_chi = :dia_chi, vai_tro = :vai_tro 
              WHERE id = :id";
    $stmt = $pdo->prepare($query);
    
    // Bind tham số và thực thi
    $stmt->bindParam(':ho_ten', $ho_ten);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':so_dien_thoai', $so_dien_thoai);
    $stmt->bindParam(':dia_chi', $dia_chi);
    $stmt->bindParam(':vai_tro', $vai_tro);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Cập nhật tài khoản thành công!";
    } else {
        echo "Có lỗi xảy ra khi cập nhật tài khoản.";
    }
}
?>
