<?php
// Kết nối tới cơ sở dữ liệu qua tệp db.php
include('db1.php');

// Thêm người dùng mới vào cơ sở dữ liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    if (isset($_POST['ho_ten'], $_POST['email'], $_POST['so_dien_thoai'], $_POST['dia_chi'], $_POST['vai_tro'], $_POST['mat_khau'])) {
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $so_dien_thoai = $_POST['so_dien_thoai'];
        $dia_chi = $_POST['dia_chi'];
        $vai_tro = $_POST['vai_tro'];
        $mat_khau = $_POST['mat_khau']; // Không mã hóa mật khẩu

        // Câu truy vấn để thêm người dùng
        $query = "INSERT INTO nguoi_dung (ho_ten, email, so_dien_thoai, dia_chi, vai_tro, mat_khau) 
                  VALUES (:ho_ten, :email, :so_dien_thoai, :dia_chi, :vai_tro, :mat_khau)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':ho_ten', $ho_ten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':so_dien_thoai', $so_dien_thoai);
        $stmt->bindParam(':dia_chi', $dia_chi);
        $stmt->bindParam(':vai_tro', $vai_tro);
        $stmt->bindParam(':mat_khau', $mat_khau); // Lưu mật khẩu trực tiếp
        $stmt->execute();
    }
}

// Cập nhật người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $dia_chi = $_POST['dia_chi'];
    $vai_tro = $_POST['vai_tro'];
    $mat_khau = isset($_POST['mat_khau']) ? $_POST['mat_khau'] : null;

    // Nếu có mật khẩu mới, cập nhật mật khẩu
    if ($mat_khau) {
        $query = "UPDATE nguoi_dung SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai, 
                  dia_chi = :dia_chi, vai_tro = :vai_tro, mat_khau = :mat_khau WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':mat_khau', $mat_khau); // Cập nhật mật khẩu mới nếu có
    } else {
        $query = "UPDATE nguoi_dung SET ho_ten = :ho_ten, email = :email, so_dien_thoai = :so_dien_thoai, 
                  dia_chi = :dia_chi, vai_tro = :vai_tro WHERE id = :id";
        $stmt = $pdo->prepare($query);
    }

    // Ràng buộc các tham số khác
    $stmt->bindParam(':ho_ten', $ho_ten);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':so_dien_thoai', $so_dien_thoai);
    $stmt->bindParam(':dia_chi', $dia_chi);
    $stmt->bindParam(':vai_tro', $vai_tro);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Xử lý xóa người dùng
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM nguoi_dung WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    header("Location: users.php");
    exit;
}

// Lấy danh sách người dùng
$query = "SELECT * FROM nguoi_dung";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Các style giống trang đơn hàng */
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

        .popup-form input, .popup-form select, .popup-form button {
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

        .popup-form button[type="button"] {
            background-color: #e74c3c;
        }

        .popup-form button[type="button"]:hover {
            background-color: #c0392b;
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
    <h1>Quản Lý Tài Khoản</h1>
</header>

<!-- NAVIGATION -->
<nav>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> 📊 Dashboard</a>
    <a href="products.php"><i class="fas fa-couch"></i> 🛋️ Sản phẩm</a>
    <a href="orders.php"><i class="fas fa-box"></i> 📦 Đơn hàng</a>
    <a href="users.php"><i class="fas fa-user"></i> 👤 Người dùng</a>
    <a href="lienhe.php"><i class="fas fa-envelope"></i> ✉️ Liên hệ</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> 🚪 Đăng xuất</a>
</nav>

<!-- CONTAINER -->
<div class="container">
    <div class="actions">
        <button class="btn" onclick="openAddPopup()">➕ Thêm tài khoản mới</button>
    </div>

    <!-- User Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= isset($user['id']) ? $user['id'] : 'Không có dữ liệu' ?></td>
                <td><?= isset($user['ho_ten']) ? $user['ho_ten'] : 'Không có dữ liệu' ?></td>
                <td><?= isset($user['email']) ? $user['email'] : 'Không có dữ liệu' ?></td>
                <td><?= isset($user['so_dien_thoai']) ? $user['so_dien_thoai'] : 'Không có dữ liệu' ?></td>
                <td><?= isset($user['dia_chi']) ? $user['dia_chi'] : 'Không có dữ liệu' ?></td>
                <td><?= isset($user['vai_tro']) ? $user['vai_tro'] : 'Không có dữ liệu' ?></td>
                <td class="action-buttons">
                    <button onclick="openEditPopup(<?= $user['id'] ?>)">✏️ Sửa</button>
                    <button onclick="deleteUser(<?= $user['id'] ?>)">🗑️ Xóa</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popupOverlay"></div>

<!-- Add User Form (Popup) -->
<div id="addForm" class="popup-form">
    <form method="POST" action="">
        <label for="ho_ten">Tên:</label>
        <input type="text" name="ho_ten" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="so_dien_thoai">SĐT:</label>
        <input type="text" name="so_dien_thoai" required><br>

        <label for="dia_chi">Địa chỉ:</label>
        <input type="text" name="dia_chi" required><br>

        <label for="vai_tro">Vai trò:</label>
        <select name="vai_tro" required>
            <option value="admin">Admin</option>
            <option value="khach_hang">Khách hàng</option>
        </select><br>

        <label for="mat_khau">Mật khẩu:</label>
        <input type="password" name="mat_khau" required><br>

        <button type="submit">Thêm tài khoản</button>
        <button type="button" onclick="closePopup()">Đóng</button>
    </form>
</div>

<!-- Edit User Form (Popup) -->
<div id="editForm" class="popup-form">
    <form method="POST" action="">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="editId">

        <label for="editHoTen">Tên:</label>
        <input type="text" name="ho_ten" id="editHoTen" required><br>

        <label for="editEmail">Email:</label>
        <input type="email" name="email" id="editEmail" required><br>

        <label for="editSoDienThoai">SĐT:</label>
        <input type="text" name="so_dien_thoai" id="editSoDienThoai" required><br>

        <label for="editDiaChi">Địa chỉ:</label>
        <input type="text" name="dia_chi" id="editDiaChi" required><br>

        <label for="editVaiTro">Vai trò:</label>
        <select name="vai_tro" id="editVaiTro" required>
            <option value="admin">Admin</option>
            <option value="khach_hang">Khách hàng</option>
        </select><br>

        <label for="editMatKhau">Mật khẩu:</label>
        <input type="password" name="mat_khau" id="editMatKhau"><br>

        <button type="submit">Lưu thay đổi</button>
        <button type="button" onclick="closePopup()">Đóng</button>
    </form>
</div>

<script>
    // Open Add User Popup
    function openAddPopup() {
        document.getElementById('popupOverlay').style.display = 'block';
        document.getElementById('addForm').style.display = 'block';
    }

    // Open Edit User Popup
// Open Edit User Popup
function openEditPopup(id) {
    fetch(`get_user.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Lỗi khi lấy dữ liệu người dùng');
                return;
            }

            // Gán dữ liệu vào các input của form sửa
            document.getElementById('editId').value = data.id;
            document.getElementById('editHoTen').value = data.ho_ten;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editSoDienThoai').value = data.so_dien_thoai;
            document.getElementById('editDiaChi').value = data.dia_chi;
            document.getElementById('editVaiTro').value = data.vai_tro;

            // Hiện popup
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('editForm').style.display = 'block';
        })
        .catch(error => {
            console.error("Lỗi khi lấy dữ liệu:", error);
            alert('Lỗi hệ thống khi lấy dữ liệu người dùng');
        });
}


    // Đóng Popup
    function closePopup() {
        document.getElementById('popupOverlay').style.display = 'none';
        document.getElementById('addForm').style.display = 'none';
        document.getElementById('editForm').style.display = 'none';
    }

    // Xóa người dùng
    function deleteUser(id) {
        if (confirm("Bạn có chắc chắn muốn xóa người dùng này?")) {
            window.location.href = `users.php?id=${id}`;
        }
    }
</script>

</body>
</html>

<!-- Include Footer -->
<?php include 'footer.php'; ?>