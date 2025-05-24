<?php
// Kết nối CSDL
include('db1.php');
// Xử lý thêm, sửa, xóa đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Kiểm tra hành động là thêm đơn hàng
    if ($_POST['action'] == 'add') {
        $order_code = $_POST['ma_don_hang'];
        $user_id = $_POST['nguoi_dung_id']; 
        $total_price = $_POST['tong_tien']; 
        $status = $_POST['trang_thai'];  // Lấy giá trị trạng thái từ combobox
        $shipping_address = $_POST['dia_chi_giao_hang']; // Địa chỉ giao hàng
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO don_hang (ma_don_hang, nguoi_dung_id, tong_tien, trang_thai, dia_chi_giao_hang, ngay_dat) 
                  VALUES (:order_code, :user_id, :total_price, :status, :shipping_address, :created_at)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':order_code' => $order_code,
            ':user_id' => $user_id,
            ':total_price' => $total_price,
            ':status' => $status,
            ':shipping_address' => $shipping_address,
            ':created_at' => $created_at
        ]);
    }

    // Kiểm tra hành động là chỉnh sửa đơn hàng
    if ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $order_code = $_POST['ma_don_hang'];
        $user_id = $_POST['nguoi_dung_id'];
        $total_price = $_POST['tong_tien']; 
        $status = $_POST['trang_thai'];  // Trạng thái từ combobox
        $shipping_address = $_POST['dia_chi_giao_hang'];
        $updated_at = date('Y-m-d H:i:s');

        $query = "UPDATE don_hang SET ma_don_hang = :order_code, nguoi_dung_id = :user_id, tong_tien = :total_price, 
                  trang_thai = :status, dia_chi_giao_hang = :shipping_address, ngay_dat = :updated_at WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':order_code' => $order_code,
            ':user_id' => $user_id,
            ':total_price' => $total_price,
            ':status' => $status,
            ':shipping_address' => $shipping_address,
            ':updated_at' => $updated_at
        ]);
    }

    // Kiểm tra hành động là xóa đơn hàng
    if ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $query = "DELETE FROM don_hang WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $id]);
    }
}


// Lấy danh sách đơn hàng từ bảng don_hang
$query = "SELECT don_hang.*, nguoi_dung.ho_ten AS ten_nguoi_dung 
          FROM don_hang 
          LEFT JOIN nguoi_dung ON don_hang.nguoi_dung_id = nguoi_dung.id";

$stmt = $pdo->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
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
        /* Cải thiện bảng để trông gọn gàng hơn */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ddd;
    font-size: 14px;
    word-wrap: break-word; /* Đảm bảo văn bản không bị tràn */
}

table th {
    background-color: #34495e;
    color: white;
}

table td {
    background-color: #f9f9f9;
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

/* Đảm bảo bảng luôn đẹp khi trên màn hình nhỏ */
@media (max-width: 768px) {
    table th, table td {
        padding: 8px;
    }

    .container {
        padding: 10px;
    }
}
/* Hiệu ứng hover cho hàng trong bảng */
table tr:hover {
    background-color: #f1f1f1;
}

    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <img src="https://cdn-icons-png.flaticon.com/512/702/702797.png" alt="Logo" class="logo">
    <h1>Quản Lý Đơn Hàng</h1>
</header>

<!-- NAVIGATION -->
<nav>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> 📊 Dashboard</a>
    <a href="products.php"><i class="fas fa-couch"></i> 🛋️ Sản phẩm</a>
    <a href="#"><i class="fas fa-box"></i> 📦 Đơn hàng</a>
    <a href="users.php"><i class="fas fa-user"></i> 👤 Người dùng</a>
    <a href="lienhe.php"><i class="fas fa-envelope"></i> ✉️ Liên hệ</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> 🚪 Đăng xuất</a>
</nav>

<!-- CONTAINER -->
<div class="container">
    <div class="actions">
        <button class="btn" onclick="openAddPopup()">➕ Thêm đơn hàng mới</button>
    </div>

    <!-- Order Table -->
  <table>
    <thead>
        <tr>
            <th width="5%">ID</th>
            <th width="20%">Mã đơn hàng</th>
            <th width="15%">Khách hàng ID</th>
            <th width="15%">Tổng giá</th>
            <th width="15%">Trạng thái</th>
            <th width="15%">Ngày tạo</th>
            <th width="15%">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
<td><?= isset($order['id']) ? $order['id'] : 'Không có dữ liệu' ?></td>
<td><?= isset($order['ma_don_hang']) ? $order['ma_don_hang'] : 'Không có dữ liệu' ?></td>
<td><?= isset($order['ten_nguoi_dung']) ? $order['ten_nguoi_dung'] : 'Không có dữ liệu' ?></td>
<td><?= isset($order['tong_tien']) ? number_format($order['tong_tien'], 0, ',', '.') : 'Không có dữ liệu' ?> VND</td>
<td><?= isset($order['trang_thai']) ? $order['trang_thai'] : 'Không có dữ liệu' ?></td>
<td><?= isset($order['ngay_dat']) ? $order['ngay_dat'] : 'Không có dữ liệu' ?></td>

            <td class="action-buttons">
                <button onclick="openEditPopup(<?= $order['id'] ?>)">✏️ Sửa</button>
                <button onclick="deleteProduct(<?= $order['id'] ?>)">🗑️ Xóa</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popupOverlay"></div>
<!-- Add Order Form (Popup) -->
<div id="addForm" class="popup-form">
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">

        <label for="ma_don_hang">Mã đơn hàng:</label>
        <input type="text" name="ma_don_hang" required><br>

        <label for="nguoi_dung_id">Người dùng ID:</label>
        <input type="number" name="nguoi_dung_id" required><br>

        <label for="tong_tien">Tổng tiền:</label>
        <input type="number" name="tong_tien" required><br>

        <label for="trang_thai">Trạng thái:</label>
<select name="trang_thai" id="editTrangThai" required>
    <option value="cho_xu_ly">Đang chờ</option>
    <option value="dang_giao">Đang giao</option>
    <option value="da_giao">Đã giao</option>
    <option value="huy">Đã hủy</option>
</select>


        <label for="dia_chi_giao_hang">Địa chỉ giao hàng:</label>
        <input type="text" name="dia_chi_giao_hang" required><br>

        <button type="submit">Thêm đơn hàng</button>
        <button type="button" onclick="closePopup()">Đóng</button>
    </form>
</div>

<!-- Edit Order Form (Popup) -->
<div id="editForm" class="popup-form">
    <form method="POST" action="">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="editId">

        <label for="ma_don_hang">Mã đơn hàng:</label>
        <input type="text" name="ma_don_hang" id="editMaDonHang" required><br>

        <label for="nguoi_dung_id">Người dùng ID:</label>
        <input type="number" name="nguoi_dung_id" id="editNguoiDungId" required><br>

        <label for="tong_tien">Tổng tiền:</label>
        <input type="number" name="tong_tien" id="editTongTien" required><br>

        <label for="trang_thai">Trạng thái:</label>
<select name="trang_thai" id="editTrangThai" required>
    <option value="cho_xu_ly">Đang chờ</option>
    <option value="dang_giao">Đang giao</option>
    <option value="da_giao">Đã giao</option>
    <option value="huy">Đã hủy</option>
</select>


        <label for="dia_chi_giao_hang">Địa chỉ giao hàng:</label>
        <input type="text" name="dia_chi_giao_hang" id="editDiaChiGiaoHang" required><br>

        <button type="submit">Lưu thay đổi</button>
        <button type="button" onclick="closePopup()">Đóng</button>
    </form>
</div>


<script>
    // Open Add Order Popup
    function openAddPopup() {
        document.getElementById('popupOverlay').style.display = 'block';
        document.getElementById('addForm').style.display = 'block';
    }
// Open Edit Order Popup
function openEditPopup(id) {
    fetch(`get_order.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Lỗi khi lấy dữ liệu đơn hàng');
                return;
            }

            // Gán dữ liệu vào các input của form sửa
            document.getElementById('editId').value = data.id;
            document.getElementById('editMaDonHang').value = data.ma_don_hang;
            document.getElementById('editNguoiDungId').value = data.nguoi_dung_id;
            document.getElementById('editTongTien').value = data.tong_tien;
            document.getElementById('editTrangThai').value = data.trang_thai; // Gán giá trị trạng thái
            document.getElementById('editDiaChiGiaoHang').value = data.dia_chi_giao_hang;

            // Hiện popup
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('editForm').style.display = 'block';
        })
        .catch(error => {
            console.error("Lỗi khi lấy dữ liệu:", error);
            alert('Lỗi hệ thống khi lấy dữ liệu đơn hàng');
        });
}


    // Close Popup
    function closePopup() {
        document.getElementById('popupOverlay').style.display = 'none';
        document.getElementById('addForm').style.display = 'none';
        document.getElementById('editForm').style.display = 'none';
    }

    // Delete Order
    function deleteProduct(id) {
        if (confirm("Bạn có chắc chắn muốn xóa đơn hàng này?")) {
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