<?php
// Kết nối đến CSDL
include('db.php');
// Lấy slug từ URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Truy vấn bài viết dựa trên slug
$sql = "SELECT * FROM bai_viet WHERE duong_dan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

$post = null;
if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
} else {
    echo "Bài viết không tồn tại.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['tieu_de']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", 
            Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }
    </style>
</head>
<body class="bg-[#fafafa]">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <!-- Tiêu đề bài viết -->
            <h1 class="text-3xl font-semibold text-[#1a1a1a] mb-4 leading-tight"><?php echo htmlspecialchars($post['tieu_de']); ?></h1>
            <p class="text-xs text-[#d35400] mb-4 font-semibold">
                <?php echo date("d/m/Y", strtotime($post['ngay_dang'])); ?> / Nội Thất
            </p>

            <!-- Ảnh đại diện -->
            <img src="uploads/<?php echo $post['anh_dai_dien']; ?>" alt="<?php echo htmlspecialchars($post['tieu_de']); ?>" class="w-full h-[400px] object-cover rounded-lg mb-6">

            <!-- Nội dung bài viết -->
            <div class="text-lg text-[#1a1a1a] leading-relaxed">
                <?php echo nl2br(htmlspecialchars($post['noi_dung'])); ?>
            </div>
        </div>

        <!-- Quay lại trang chủ -->
        <div class="mt-6">
            <a href="index.php" class="text-orange-500 hover:underline font-medium text-lg">Quay lại trang chủ ›</a>
        </div>
    </div>
</body>
</html>
