<?php
// Kết nối đến CSDL
include('db.php');

// Truy vấn danh sách bài viết
$sql = "SELECT * FROM bai_viet ORDER BY ngay_dang DESC";
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiến thức mua hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", 
            Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .card-img:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
        .card-text:hover {
            color: #ff6a00;
        }
        .card-link:hover {
            color: #ff6a00;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-[#fafafa]">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            <!-- Left side - Featured article -->
            <div class="lg:w-1/2 mb-8 lg:mb-0">
                <?php if (!empty($posts)): 
                    $featured = array_shift($posts); ?>
                    <h2 class="text-2xl font-semibold text-[#1a1a1a] mb-4 leading-tight">Kiến thức mua hàng</h2>
                    <p class="text-[#999999] text-sm mb-4 leading-relaxed">
                        Cùng tìm hiểu kiến thức về mua hàng: các loại nội thất, kinh nghiệm thiết kế và lựa chọn sản phẩm phù hợp cho không gian sống!
                    </p>
                    <div class="bg-white p-4 rounded-lg shadow-md card">
                        <img src="<?php echo $featured['anh_dai_dien']; ?>" alt="<?php echo htmlspecialchars($featured['tieu_de']); ?>" class="w-full h-[250px] object-cover rounded-lg mb-4 card-img">
                        <h3 class="text-lg text-[#1a1a1a] font-medium leading-tight">
                            <?php echo htmlspecialchars($featured['tieu_de']); ?>
                        </h3>
                        <p class="text-xs text-[#d35400] mt-2 font-semibold leading-tight">
                            <?php echo date("d/m/Y", strtotime($featured['ngay_dang'])); ?> / Nội Thất
                        </p>
                        <p class="text-sm text-[#1a1a1a] mt-2 leading-relaxed">
                            <?php echo mb_substr(strip_tags($featured['noi_dung']), 0, 200) . '...'; ?>
                        </p>
                        <a href="chitiet.php?slug=<?php echo urlencode($featured['duong_dan']); ?>" class="text-orange-500 hover:underline font-medium text-sm inline-block mt-2 card-link">Xem chi tiết ›</a>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">Chưa có bài viết nào.</p>
                <?php endif; ?>
            </div>

            <!-- Right side - Other articles -->
            <div class="lg:w-1/2 space-y-6">
                <?php foreach ($posts as $post): ?>
                    <div class="flex bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300 ease-in-out card">
                        <img src="<?php echo $post['anh_dai_dien']; ?>" alt="<?php echo htmlspecialchars($post['tieu_de']); ?>" class="w-[120px] h-[80px] object-cover rounded-lg card-img">
                        <div class="ml-4 flex flex-col justify-center">
                            <p class="text-sm text-[#1a1a1a] font-medium leading-tight">
                                <?php echo htmlspecialchars($post['tieu_de']); ?>
                            </p>
                            <p class="text-xs text-[#d35400] mt-1 font-semibold">
                                <?php echo date("d/m/Y", strtotime($post['ngay_dang'])); ?> / Nội Thất
                            </p>
                            <a href="chitiet.php?slug=<?php echo urlencode($post['duong_dan']); ?>" class="text-orange-500 hover:underline font-medium text-xs mt-1 card-link">Xem chi tiết ›</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
