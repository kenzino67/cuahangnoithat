<?php
$host = 'localhost';
$dbname = 'quanlynoithat';
$username = 'root';
$password = ''; // hoặc mật khẩu của bạn

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
