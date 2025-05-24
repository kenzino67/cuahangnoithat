<?php
include_once 'header.php';
include('db.php');

// Thiết lập phân trang
$limit = 8;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Xử lý lọc sản phẩm
$whereClauses = [];
$params = [];
$types = "";

// Lọc theo danh mục
if (!empty($_GET['danh_muc_id'])) {
    $whereClauses[] = "danh_muc_id = ?";
    $params[] = $_GET['danh_muc_id'];
    $types .= "i";
}

// Lọc theo khoảng giá
if (!empty($_GET['price'])) {
    switch ($_GET['price']) {
        case 'under-1000000':
            $whereClauses[] = "gia < 1000000";
            break;
        case '1000000-3000000':
            $whereClauses[] = "gia BETWEEN 1000000 AND 3000000";
            break;
        case '3000000-5000000':
            $whereClauses[] = "gia BETWEEN 3000000 AND 5000000";
            break;
        case '5000000-10000000':
            $whereClauses[] = "gia BETWEEN 5000000 AND 10000000";
            break;
        case 'above-10000000':
            $whereClauses[] = "gia > 10000000";
            break;
    }
}

// Tìm kiếm từ khóa
if (!empty($_GET['keyword'])) {
    $whereClauses[] = "ten_san_pham LIKE ?";
    $params[] = '%' . $_GET['keyword'] . '%';
    $types .= "s";
}

$whereSQL = count($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

// Đếm tổng sản phẩm sau khi lọc
$countQuery = "SELECT COUNT(*) as total FROM san_pham $whereSQL";
$countStmt = $conn->prepare($countQuery);
if ($types) $countStmt->bind_param($types, ...$params);
$countStmt->execute();
$total_result = $countStmt->get_result()->fetch_assoc();
$total_products = $total_result['total'];
$total_pages = ceil($total_products / $limit);

// Lấy dữ liệu sản phẩm
$query = "SELECT * FROM san_pham $whereSQL ORDER BY ngay_tao DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$params[] = $start;
$params[] = $limit;
$types .= "ii";
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tất cả sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto mt-8">
    <div class="grid grid-cols-12 gap-6">
        <!-- Bộ lọc -->
       <div class="col-span-12 md:col-span-3 bg-white p-4 shadow-sm rounded">
    <h2 class="text-lg font-bold mb-4 text-[#f15a24]">Lọc sản phẩm</h2>
    <form method="GET" id="filterForm" class="space-y-4">

        <!-- Tìm kiếm từ khóa -->
        <input type="text" name="keyword" placeholder="Tìm tên sản phẩm..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" class="w-full border border-gray-300 p-2 rounded text-sm" onchange="this.form.submit()">

        <!-- Danh mục sản phẩm -->
        <div>
            <p class="text-sm font-semibold mb-2">Danh mục:</p>
            <ul class="space-y-1 text-sm">
                <?php
                $danh_muc = [
                    1 => 'Ghế',
                    2 => 'Bàn',
                    3 => 'Giá treo',
                    4 => 'Kệ treo tường',
                    5 => 'Đèn',
                ];
                foreach ($danh_muc as $id => $ten):
                    $active = (isset($_GET['danh_muc_id']) && $_GET['danh_muc_id'] == $id);
                    $link = '?' . http_build_query(array_merge($_GET, ['danh_muc_id' => $id, 'page' => 1]));
                ?>
                    <li>
                        <a href="<?= $link ?>" class="<?= $active ? 'text-[#f15a24] font-bold' : 'text-gray-700 hover:text-[#f15a24]' ?>">
                            <?= $ten ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <!-- Xóa lọc danh mục -->
                <?php if (isset($_GET['danh_muc_id'])): ?>
                    <li>
                        <a href="<?= '?' . http_build_query(array_diff_key($_GET, ['danh_muc_id' => ''])) ?>" class="text-red-500 hover:underline">Xóa lọc danh mục</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Mức giá -->
        <div>
            <p class="text-sm font-semibold mb-2">Khoảng giá:</p>
            <ul class="space-y-1 text-sm">
                <?php
                $price_ranges = [
                    'under-1000000' => 'Dưới 1.000.000₫',
                    '1000000-3000000' => '1.000.000₫ - 3.000.000₫',
                    '3000000-5000000' => '3.000.000₫ - 5.000.000₫',
                    '5000000-10000000' => '5.000.000₫ - 10.000.000₫',
                    'above-10000000' => 'Trên 10.000.000₫',
                ];
                foreach ($price_ranges as $key => $label):
                    $active = (isset($_GET['price']) && $_GET['price'] == $key);
                    $link = '?' . http_build_query(array_merge($_GET, ['price' => $key, 'page' => 1]));
                ?>
                    <li>
                        <a href="<?= $link ?>" class="<?= $active ? 'text-[#f15a24] font-bold' : 'text-gray-700 hover:text-[#f15a24]' ?>">
                            <?= $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <!-- Xóa lọc mức giá -->
                <?php if (isset($_GET['price'])): ?>
                    <li>
                        <a href="<?= '?' . http_build_query(array_diff_key($_GET, ['price' => ''])) ?>" class="text-red-500 hover:underline">Xóa lọc giá</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </form>
</div>


        <!-- Danh sách sản phẩm -->
        <div class="col-span-12 md:col-span-9 bg-white shadow-md p-6">
            <h1 class="text-2xl font-bold text-[#f15a24] mb-4">TẤT CẢ SẢN PHẨM</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php while ($row = $result->fetch_assoc()): 
                    $discountPercent = $row['giam_gia'] > 0 ? round(($row['giam_gia'] / $row['gia']) * 100) : 0;
                ?>
                <a href="product_detail.php?id=<?= $row['id'] ?>">
    <div class="border border-gray-300 bg-white relative p-2 shadow-sm cursor-pointer hover:shadow-lg transition rounded">
        <?php if ($discountPercent > 0): ?>
            <div class="absolute top-2 left-2 bg-[#f15a24] text-white text-[10px] font-semibold px-2 py-[2px] z-10">
                -<?= $discountPercent ?>%
            </div>
        <?php endif; ?>
        <img src="<?= $row['anh_dai_dien'] ?>" alt="<?= htmlspecialchars($row['ten_san_pham']) ?>" class="w-full h-44 object-cover rounded">
        <div class="mt-2 text-[11px] text-gray-500 font-semibold">
            F1GENZ <span class="text-[#f15a24]">Sale</span>
        </div>
        <div class="text-sm font-medium mt-1">
            <?= htmlspecialchars($row['ten_san_pham']) ?>
        </div>
        <div class="text-[#f15a24] font-bold text-sm mt-1">
                <?= number_format($row['gia'], 0, ',', '.') ?>₫
            <?php if ($row['giam_gia'] > 0): ?>
            <span class="line-through text-gray-400 text-xs ml-1">
              <?= number_format($row['gia'] - $row['giam_gia'], 0, ',', '.') ?>₫
            </span>
            <?php endif; ?>
        </div>
    </div>
</a>
                <?php endwhile; ?>
            </div>

            <!-- Phân trang -->
            <div class="mt-6 flex justify-center space-x-2">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="px-3 py-1 border <?= $i == $page ? 'bg-[#f15a24] text-white' : 'bg-white text-[#f15a24]' ?> border-[#f15a24] rounded-sm hover:bg-[#f15a24] hover:text-white transition">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<?php require 'footerindex.php'; ?>
</body>
</html>
