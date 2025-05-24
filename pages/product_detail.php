<?php
include_once 'header.php';
include('db.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Nếu không có id hoặc id không hợp lệ, chuyển hướng về trang danh sách sản phẩm
    header('Location: products.php');
    exit;
}

$product_id = intval($_GET['id']);

// Lấy thông tin chi tiết sản phẩm
$query = "SELECT * FROM san_pham WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Nếu không tìm thấy sản phẩm
    echo "<div class='max-w-4xl mx-auto mt-10 p-4 bg-white shadow rounded text-center'>Sản phẩm không tồn tại.</div>";
    require 'pages/footerindex.php';
    exit;
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($product['ten_san_pham']) ?> - Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">

<div class="max-w-5xl mx-auto mt-10 bg-white shadow rounded p-6">
    <?php
$product = $result->fetch_assoc();
$discountPercent = $product['giam_gia'] > 0 ? round(($product['giam_gia'] / $product['gia']) * 100) : 0;

?>
    <a href="all_products.php" class="text-[#f15a24] hover:underline mb-6 inline-block">&larr; Quay lại danh sách sản phẩm</a>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Ảnh sản phẩm -->
        <div class="md:w-1/2">
            <img src="<?= htmlspecialchars($product['anh_dai_dien']) ?>" alt="<?= htmlspecialchars($product['ten_san_pham']) ?>" class="w-full rounded object-cover max-h-[400px]" />
            <?php if ($discountPercent > 0): ?>
                <div class="absolute top-4 left-4 bg-[#f15a24] text-white px-3 py-1 font-bold rounded-md mt-2">
                    Giảm <?= $discountPercent ?>%
                </div>
            <?php endif; ?>
        </div>
<!-- Sau phần ảnh đại diện, thêm ảnh chi tiết nếu có -->
<?php if (!empty($product['anh_chi_tiet'])): ?>
    <div class="mt-4 grid grid-cols-3 gap-2">
        <?php 
        // Nếu anh_chi_tiet lưu json array link ảnh, decode ra mảng
        $images = json_decode($product['anh_chi_tiet'], true);
        if (!$images) $images = [$product['anh_chi_tiet']]; // nếu chỉ 1 link
        foreach ($images as $img): ?>
            <img src="<?= htmlspecialchars($img) ?>" alt="Ảnh chi tiết" class="rounded cursor-pointer hover:opacity-80 transition" />
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Phần đánh giá giả lập -->
<div class="mt-8 border-t pt-4">
    <h2 class="text-xl font-semibold mb-3">Đánh giá khách hàng</h2>
    <div class="space-y-4">
        <div>
            <p class="font-semibold">Nguyễn Văn A <span class="text-yellow-400">★★★★★</span></p>
            <p>Chất lượng sản phẩm rất tốt, giao hàng nhanh!</p>
        </div>
        <div>
            <p class="font-semibold">Trần Thị B <span class="text-yellow-400">★★★★☆</span></p>
            <p>Hài lòng với giá cả, sản phẩm đẹp.</p>
        </div>
    </div>
</div>

<!-- Thông tin liên hệ -->
<div class="mt-8 border-t pt-4 text-gray-700">
    <h2 class="text-xl font-semibold mb-3">Thông tin liên hệ</h2>
    <p>Hotline: <a href="tel:0909123456" class="text-[#f15a24] font-semibold">0909 123 456</a></p>
    <p>Email: <a href="mailto:support@f1genz.vn" class="text-[#f15a24] font-semibold">support@f1genz.vn</a></p>
    <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. HCM</p>
</div>

        <!-- Thông tin sản phẩm -->
        <div class="md:w-1/2 flex flex-col justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#f15a24] mb-4"><?= htmlspecialchars($product['ten_san_pham']) ?></h1>
              <div class="mb-2">
    <span class="text-2xl font-bold text-[#f15a24]">
        <?= number_format($product['gia'], 0, ',', '.') ?>₫
    </span>
    <?php if ($product['giam_gia'] > 0): ?>
        <span class="text-base text-gray-500 ml-3">
            <?= number_format($product['gia'] - $product['giam_gia'], 0, ',', '.') ?>₫
        </span>
    <?php endif; ?>
</div>

                <p class="text-gray-700 mb-6"><?= nl2br(htmlspecialchars($product['mo_ta'] ?? 'Chưa có mô tả.')) ?></p>
            </div>

            <!-- Form đặt hàng -->
            <form action="process_order.php" method="POST" class="space-y-4">
                <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                
                <label for="quantity" class="block font-semibold">Số lượng:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="100" class="border border-gray-300 rounded p-2 w-24" required />

               <!-- Nút mở popup -->
<button type="button" id="openOrderPopup" class="bg-[#f15a24] text-white px-6 py-2 rounded hover:bg-[#d0491e] transition">
    Đặt hàng
</button>
<!-- Popup Overlay -->
<div class="popup-overlay" id="popupOverlay"></div>

<!-- Popup Form -->
<div class="popup-form" id="popupForm">
    <h2 class="text-2xl font-bold mb-4">Thông tin đặt hàng</h2>
    <form action="process_order.php" method="POST" class="space-y-4">
        <input type="hidden" name="product_id" value="<?= $product_id ?>" />
        <input type="hidden" name="price" value="<?= $product['gia'] ?>" />
        
        <div>
            <label for="quantity" class="block font-semibold">Số lượng:</label>
            <input type="number" name="quantity" id="popupQuantity" value="1" min="1" max="100" class="border border-gray-300 rounded p-2 w-full" required />
        </div>

        <div>
            <label for="address" class="block font-semibold">Địa chỉ giao hàng:</label>
            <textarea name="address" id="address" class="border border-gray-300 rounded p-2 w-full" rows="3" required></textarea>
        </div>

        <div class="flex justify-between mt-4">
            <button type="submit" class="bg-[#f15a24] text-white px-4 py-2 rounded hover:bg-[#d0491e]">Xác nhận</button>
            <button type="button" id="closePopup" class="text-gray-500 hover:underline">Hủy</button>
        </div>
    </form>
</div>
<script>
    const openBtn = document.getElementById('openOrderPopup');
    const popupOverlay = document.getElementById('popupOverlay');
    const popupForm = document.getElementById('popupForm');
    const closeBtn = document.getElementById('closePopup');

    openBtn.addEventListener('click', () => {
        popupOverlay.style.display = 'block';
        popupForm.style.display = 'block';
    });

    closeBtn.addEventListener('click', () => {
        popupOverlay.style.display = 'none';
        popupForm.style.display = 'none';
    });

    popupOverlay.addEventListener('click', () => {
        popupOverlay.style.display = 'none';
        popupForm.style.display = 'none';
    });
</script>

            </form>
        </div>
    </div>
</div>
<style>
.popup-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 40;
}

.popup-form {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    z-index: 50;
    padding: 30px;
    border-radius: 8px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
}
</style>


<?php require 'footerindex.php'; ?>
</body>
</html>
