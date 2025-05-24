<?php
session_start();
include('db.php'); // file kết nối mysqli

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mat_khau_hash = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO nguoi_dung (ho_ten, email, so_dien_thoai, dia_chi, vai_tro, mat_khau) 
        VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Lỗi prepare: " . $conn->error);
    }

    $stmt->bind_param("ssssss",
        $_POST['ho_ten'],
        $_POST['email'],
        $_POST['so_dien_thoai'],
        $_POST['dia_chi'],
        $_POST['vai_tro'],
        $mat_khau_hash
    );

    if ($stmt->execute()) {
        header("Location: index.php"); // Sửa lỗi dòng này
        exit;
    } else {
        die("Lỗi execute: " . $stmt->error);
    }
}
?>
