<?php
require_once 'db1.php';

// Thống kê nhanh
$totalUsers = $pdo->query("SELECT COUNT(*) FROM nguoi_dung")->fetchColumn();
$totalProducts = $pdo->query("SELECT COUNT(*) FROM san_pham")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM don_hang")->fetchColumn();

$recentOrders = $pdo->query("
    SELECT dh.id, nd.ho_ten AS ten_khach_hang, dh.ngay_dat, dh.tong_tien, dh.trang_thai
    FROM don_hang dh
    JOIN nguoi_dung nd ON dh.nguoi_dung_id = nd.id
    ORDER BY dh.ngay_dat DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
        }

        header {
            display: flex;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding: 15px 30px;
        }

        header img.logo {
            height: 50px;
            margin-right: 20px;
        }

        header h1 {
            font-size: 24px;
            margin: 0;
        }

        nav {
            background-color: #34495e;
            padding: 10px;
            display: flex;
            justify-content: space-around;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #2980b9;
        }

        .container {
            padding: 20px;
        }

        .summary-boxes {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .box {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .box h2 {
            margin: 0;
            font-size: 22px;
            color: #34495e;
        }

        .box p {
            font-size: 28px;
            color: #2c3e50;
            margin: 10px 0 0 0;
        }

        h2.section-title {
            margin-top: 40px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #34495e;
            color: white;
        }

        table td {
            background-color: #f9f9f9;
        }
        
        /* Footer styling */
        footer {
            background-color: #34495e;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }

        footer a {
            color: #2980b9;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
header {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Chia khoảng trống đều giữa các phần tử */
    background-color: #2c3e50;
    color: white;
    padding: 15px 30px;
}

header img.logo {
    height: 50px;
    margin-right: 20px;
}

header h1 {
    font-size: 24px;
    margin: 0;
    flex: 1; /* Chiếm hết không gian còn lại giữa logo và trang chủ */
}

header a.home-link {
    color: white;
    text-decoration: none;
    font-size: 18px;
    padding: 10px 15px;
    background-color: #2980b9;
    border-radius: 5px;
    transition: background-color 0.3s;
}

header a.home-link:hover {
    background-color: #3498db;
}

    </style>
</head>
<body>
<header>
    <img src="https://cdn-icons-png.flaticon.com/512/702/702797.png" alt="Logo" class="logo">
    <h1>Trang Quản Trị</h1>
    <a href="http://localhost/phpadmin/btnhom/pages/index.php" class="home-link" aria-label="Trang Chủ">Trang Chủ</a>

</header>


<nav>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> 📊 Dashboard</a>
    <a href="products.php"><i class="fas fa-couch"></i> 🛋️ Sản phẩm</a>
    <a href="orders.php"><i class="fas fa-box"></i> 📦 Đơn hàng</a>
    <a href="users.php"><i class="fas fa-user"></i> 👤 Người dùng</a>
    <a href="lienhe.php"><i class="fas fa-envelope"></i> ✉️ Liên hệ</a>
</nav>

<div class="container">
    <div class="summary-boxes">
        <div class="box">
            <a href="lienhe.php">
            <h2>Người Dùng</h2></a>
            <p><?= $totalUsers ?></p>
        </div>
        <div class="box">
            <a href="products.php">
            <h2>Sản Phẩm</h2></a>
            <p><?= $totalProducts ?></p>
        </div>
        <div class="box">
            <a href="orders.php">
            <h2>Đơn Hàng</h2></a>
            <p><?= $totalOrders ?></p>
        </div>
    </div>

    <h2 class="section-title">🕒 Đơn Hàng Gần Đây</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách Hàng</th>
                <th>Ngày Đặt</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentOrders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['ten_khach_hang'] ?? 'Không rõ' ?></td>
                <td><?= $order['ngay_dat'] ?></td>
                <td><?= number_format($order['tong_tien'], 0, ',', '.') ?> đ</td>
                <td><?= ucfirst($order['trang_thai']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>© 2025 Quản lý nội thất. Tất cả các quyền được bảo lưu.</p>
    <p>Designed by <a href="https://www.yourwebsite.com" target="_blank">Your Company</a></p>
</footer>
</body>
</html>
