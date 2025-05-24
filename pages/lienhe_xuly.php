<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = trim($_POST['ten']);
    $sdt = trim($_POST['sdt']);
    $email = trim($_POST['email']);
    $noi_dung = trim($_POST['noi_dung']);

    if (empty($ten) || empty($sdt) || empty($email) || empty($noi_dung)) {
        die("Vui lòng điền đầy đủ thông tin.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email không hợp lệ.");
    }

    // Ghép họ tên + SĐT thành tiêu đề
    $tieu_de = "Liên hệ từ $ten - $sdt";

    // Chèn vào các cột đúng như trong database
    $sql = "INSERT INTO lien_he (ho_ten, email, tieu_de, noi_dung, ngay_gui) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Lỗi prepare(): " . $conn->error); // Thêm dòng này để kiểm tra lỗi
    }

    $stmt->bind_param("ssss", $ten, $email, $tieu_de, $noi_dung);

    if ($stmt->execute()) {
        echo "<div style='padding: 20px; text-align: center; font-family: sans-serif'>
                <h2>Cảm ơn bạn đã liên hệ!</h2>
                <p>Chúng tôi sẽ phản hồi sớm nhất có thể.</p>
                <a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#d46a47; color:white; text-decoration:none; border-radius:5px;'>Quay lại trang chủ</a>
              </div>";
    } else {
        echo "Lỗi khi lưu dữ liệu: " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit;
}
?>
