<?php
$orderCode = $_GET['code'] ?? 'Không xác định';
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Đặt hàng thành công</title></head>
<body class="bg-gray-100 text-center py-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-[#f15a24] mb-4">🎉 Đặt hàng thành công!</h1>
        <p>Mã đơn hàng của bạn: <strong><?= htmlspecialchars($orderCode) ?></strong></p>
        <a href="all_products.php" class="inline-block mt-4 text-[#f15a24] hover:underline">Tiếp tục mua sắm</a>
    </div>
</body>
</html>
