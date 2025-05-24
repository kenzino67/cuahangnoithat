<?php
session_start();
include('db.php');

$email = $_POST['email'];
$mat_khau = $_POST['mat_khau'];

$stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($mat_khau, $user['mat_khau'])) {
    $_SESSION['user'] = $user;
    header("Location:  index.php");
    exit;
} else {
    echo "Sai tài khoản hoặc mật khẩu!";
}
