<?php
// Kết nối CSDL
include('db1.php');
// Xử lý thêm, sửa, xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $name = $_POST['ten_san_pham'];
        $slug = $_POST['duong_dan'];
        $description = $_POST['mo_ta'];
        $price = $_POST['gia'];
        $discount = $_POST['giam_gia'];
        $quantity = $_POST['so_luong'];
        $category_id = $_POST['danh_muc_id'];
        $image = $_POST['anh_dai_dien'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO san_pham (ten_san_pham, duong_dan, mo_ta, gia, giam_gia, so_luong, danh_muc_id, anh_dai_dien, ngay_tao, ngay_cap_nhat) 
                  VALUES (:name, :slug, :description, :price, :discount, :quantity, :category_id, :image, :created_at, :updated_at)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':name' => $name,
            ':slug' => $slug,
            ':description' => $description,
            ':price' => $price,
            ':discount' => $discount,
            ':quantity' => $quantity,
            ':category_id' => $category_id,
            ':image' => $image,
            ':created_at' => $created_at,
            ':updated_at' => $updated_at
        ]);
    }

    if ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $name = $_POST['ten_san_pham'];
        $slug = $_POST['duong_dan'];
        $description = $_POST['mo_ta'];
        $price = $_POST['gia'];
        $discount = $_POST['giam_gia'];
        $quantity = $_POST['so_luong'];
        $category_id = $_POST['danh_muc_id'];
        $image = $_POST['anh_dai_dien'];
        $updated_at = date('Y-m-d H:i:s');

        $query = "UPDATE san_pham SET ten_san_pham = :name, duong_dan = :slug, mo_ta = :description, gia = :price, giam_gia = :discount, 
                  so_luong = :quantity, danh_muc_id = :category_id, anh_dai_dien = :image, ngay_cap_nhat = :updated_at WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':slug' => $slug,
            ':description' => $description,
            ':price' => $price,
            ':discount' => $discount,
            ':quantity' => $quantity,
            ':category_id' => $category_id,
            ':image' => $image,
            ':updated_at' => $updated_at
        ]);
    }

    if ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $query = "DELETE FROM san_pham WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $id]);
    }
}

// Lấy danh sách sản phẩm từ bảng san_pham
$query = "SELECT * FROM san_pham";
$stmt = $pdo->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Số sản phẩm trên mỗi trang
$products_per_page = 8;

// Xác định trang hiện tại
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1; // Nếu trang nhỏ hơn 1, đặt lại về trang 1
}

// Tính toán OFFSET cho truy vấn
$offset = ($page - 1) * $products_per_page;

// Truy vấn lấy danh sách sản phẩm với phân trang
$query = "SELECT * FROM san_pham LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':limit', $products_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Truy vấn lấy tổng số sản phẩm để tính toán số trang
$query = "SELECT COUNT(*) FROM san_pham";
$stmt = $pdo->prepare($query);
$stmt->execute();
$total_products = $stmt->fetchColumn();

// Tính số trang
$total_pages = ceil($total_products / $products_per_page);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Giao diện cơ bản */
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

        .actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            background-color: #ffffff;
        }

        .action-buttons button {
            padding: 5px 10px;
            background-color: #f39c12;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .action-buttons button:hover {
            background-color: #e67e22;
        }

        /* Popup styles */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 30px;
            width: 50%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        .popup-form input, .popup-form textarea, .popup-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .popup-form button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .popup-form button:hover {
            background-color: #2980b9;
        }

        /* Style close button */
        .popup-form button[type="button"] {
            background-color: #e74c3c;
        }

        .popup-form button[type="button"]:hover {
            background-color: #c0392b;
        }

        /* Media queries for responsive */
        @media (max-width: 768px) {
            .popup-form {
                width: 90%;
            }

            table th, table td {
                padding: 8px;
            }
        }
        .pagination {
    text-align: center;
    margin-top: 20px;
}

.pagination a {
    color: #3498db;
    padding: 10px 20px;
    text-decoration: none;
    margin: 0 5px;
    border-radius: 5px;
    background-color: #ecf0f1;
    transition: background-color 0.3s;
}

.pagination a:hover {
    background-color: #3498db;
    color: white;
}

.pagination a:active {
    background-color: #2980b9;
}

    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <img src="https://cdn-icons-png.flaticon.com/512/702/702797.png" alt="Logo" class="logo">
    <h1>Quản Lý Sản Phẩm</h1>
</header>

<!-- NAVIGATION -->
<nav>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> 📊 Dashboard</a>
    <a href="#"><i class="fas fa-couch"></i> 🛋️ Sản phẩm</a>
    <a href="orders.php"><i class="fas fa-box"></i> 📦 Đơn hàng</a>
    <a href="users.php"><i class="fas fa-user"></i> 👤 Người dùng</a>
    <a href="lienhe.php"><i class="fas fa-envelope"></i> ✉️ Liên hệ</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> 🚪 Đăng xuất</a>
</nav>

<!-- CONTAINER -->
<div class="container">
    <div class="actions">
        <button class="btn" onclick="openAddPopup()">➕ Thêm sản phẩm mới</button>
    </div>

    <!-- Product Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Mô tả</th>
                <th>Giảm giá</th>
                <th>Số lượng</th>
                <th>Danh mục ID</th>
                <th>Ảnh đại diện</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= $product['ten_san_pham'] ?></td>
                <td><?= number_format($product['gia'], 0, ',', '.') ?> VND</td>
                <td><?= $product['mo_ta'] ?></td>
                <td><?= number_format($product['giam_gia'], 0, ',', '.') ?> VND</td>
                <td><?= $product['so_luong'] ?></td>
                <td><?= $product['danh_muc_id'] ?></td>
                <td><img src="<?= $product['anh_dai_dien'] ?>" alt="Ảnh sản phẩm" style="width: 50px; height: auto;"></td>
                <td class="action-buttons">
                    <button onclick="openEditPopup(<?= $product['id'] ?>)">✏️ Sửa</button>
                    <button onclick="deleteProduct(<?= $product['id'] ?>)">🗑️ Xóa</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=1">&laquo; Trang đầu</a>
        <a href="?page=<?= $page - 1 ?>">❮ Trang trước</a>
    <?php endif; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>">Trang tiếp ❯</a>
        <a href="?page=<?= $total_pages ?>">Trang cuối &raquo;</a>
    <?php endif; ?>
</div>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popupOverlay"></div>

<!-- Add Product Form (Popup) -->
<div id="addForm" class="popup-form">
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <label for="ten_san_pham">Tên sản phẩm:</label>
        <input type="text" name="ten_san_pham" required><br>
        <label for="duong_dan">Đường dẫn:</label>
        <input type="text" name="duong_dan" required><br>
        <label for="mo_ta">Mô tả:</label>
        <textarea name="mo_ta" required></textarea><br>
        <label for="gia">Giá:</label>
        <input type="number" name="gia" required><br>
        <label for="giam_gia">Giảm giá:</label>
        <input type="number" name="giam_gia" required><br>
        <label for="so_luong">Số lượng:</label>
        <input type="number" name="so_luong" required><br>
        <label for="danh_muc_id">Danh mục ID:</label>
        <input type="number" name="danh_muc_id" required><br>
        <label for="anh_dai_dien">Ảnh đại diện:</label>
        <input type="text" name="anh_dai_dien" required><br>
        <button type="submit">Thêm sản phẩm</button>
        <button type="button" onclick="closePopup()">Đóng</button>
    </form>
</div>

<!-- Edit Product Form (Popup) -->
<div id="editForm" class="popup-form">
    <form method="POST" action="">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="editId">
        <label for="editTenSanPham">Tên sản phẩm:</label>
        <input type="text" name="ten_san_pham" id="editTenSanPham" required><br>
        <label for="editDuongDan">Đường dẫn:</label>
        <input type="text" name="duong_dan" id="editDuongDan" required><br>
        <label for="editMoTa">Mô tả:</label>
        <textarea name="mo_ta" id="editMoTa" required></textarea><br>
        <label for="editGia">Giá:</label>
        <input type="number" name="gia" id="editGia" required><br>
        <label for="editGiamGia">Giảm giá:</label>
        <input type="number" name="giam_gia" id="editGiamGia" required><br>
        <label for="editSoLuong">Số lượng:</label>
        <input type="number" name="so_luong" id="editSoLuong" required><br>
        <label for="editDanhMucId">Danh mục ID:</label>
        <input type="number" name="danh_muc_id" id="editDanhMucId" required><br>
        <label for="editAnhDaiDien">Ảnh đại diện:</label>
        <input type="text" name="anh_dai_dien" id="editAnhDaiDien" required><br>
        <button type="submit">Lưu thay đổi</button>
        <button type="button" onclick="closePopup()">Đóng</button>
    </form>
</div>

<script>
    // Open Add Product Popup
    function openAddPopup() {
        document.getElementById('popupOverlay').style.display = 'block';
        document.getElementById('addForm').style.display = 'block';
    }
// Open Edit Product Popup
function openEditPopup(id) {
    console.log("Sửa sản phẩm với ID: " + id); // Debugging

    // Lấy dữ liệu sản phẩm từ server
    fetch(`get_product.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Kiểm tra dữ liệu trả về từ server

            if (data.error) {
                alert('Lỗi khi lấy dữ liệu sản phẩm');
                return;
            }

            // Điền dữ liệu vào form edit
            document.getElementById('editId').value = data.id;
            document.getElementById('editTenSanPham').value = data.ten_san_pham;
            document.getElementById('editDuongDan').value = data.duong_dan;
            document.getElementById('editMoTa').value = data.mo_ta;
            document.getElementById('editGia').value = data.gia;
            document.getElementById('editGiamGia').value = data.giam_gia;
            document.getElementById('editSoLuong').value = data.so_luong;
            document.getElementById('editDanhMucId').value = data.danh_muc_id;
            document.getElementById('editAnhDaiDien').value = data.anh_dai_dien;

            // Mở Popup
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('editForm').style.display = 'block';
        })
        .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
}


    // Close Popup
    function closePopup() {
        document.getElementById('popupOverlay').style.display = 'none';
        document.getElementById('addForm').style.display = 'none';
        document.getElementById('editForm').style.display = 'none';
    }

    // Delete Product
    function deleteProduct(id) {
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'delete';
            form.appendChild(input);
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = id;
            form.appendChild(idInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
</body>
</html>

<!-- Include Footer -->
<?php include 'footer.php'; ?>