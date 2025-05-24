<?php
// Kết nối CSDL
include('db1.php');

// Lấy danh sách liên hệ từ bảng lien_he
$query = "SELECT * FROM lien_he";
$stmt = $pdo->prepare($query);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý thêm, sửa, xóa liên hệ nếu cần thiết (Tùy vào yêu cầu)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $tieu_de = $_POST['tieu_de'];
        $noi_dung = $_POST['noi_dung'];
        $ngay_gui = date('Y-m-d H:i:s');

        $query = "INSERT INTO lien_he (ho_ten, email, tieu_de, noi_dung, ngay_gui) 
                  VALUES (:ho_ten, :email, :tieu_de, :noi_dung, :ngay_gui)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':ho_ten' => $ho_ten,
            ':email' => $email,
            ':tieu_de' => $tieu_de,
            ':noi_dung' => $noi_dung,
            ':ngay_gui' => $ngay_gui
        ]);
    }

    if ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $tieu_de = $_POST['tieu_de'];
        $noi_dung = $_POST['noi_dung'];
        $ngay_gui = date('Y-m-d H:i:s');

        $query = "UPDATE lien_he SET ho_ten = :ho_ten, email = :email, tieu_de = :tieu_de, 
                  noi_dung = :noi_dung, ngay_gui = :ngay_gui WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':ho_ten' => $ho_ten,
            ':email' => $email,
            ':tieu_de' => $tieu_de,
            ':noi_dung' => $noi_dung,
            ':ngay_gui' => $ngay_gui
        ]);
    }

    if ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $query = "DELETE FROM lien_he WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $id]);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Liên Hệ</title>
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
    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <img src="https://cdn-icons-png.flaticon.com/512/702/702797.png" alt="Logo" class="logo">
    <h1>Quản Lý Liên Hệ</h1>
</header>

<!-- NAVIGATION -->
<nav>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> 📊 Dashboard</a>
    <a href="products.php"><i class="fas fa-couch"></i> 🛋️ Sản phẩm</a>
    <a href="orders.php"><i class="fas fa-box"></i> 📦 Đơn hàng</a>
    <a href="users.php"><i class="fas fa-user"></i> 👤 Người dùng</a>
    <a href="#"><i class="fas fa-envelope"></i> ✉️ Liên hệ</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> 🚪 Đăng xuất</a>
</nav>

<!-- CONTAINER -->
<div class="container">
    <div class="actions">
        <button class="btn" onclick="openAddPopup()">➕ Thêm liên hệ mới</button>
    </div>

    <!-- Contact Table -->
  <table>
    <thead>
        <tr>
            <th width="5%">ID</th>
            <th width="25%">Họ Tên</th>
            <th width="25%">Email</th>
            <th width="25%">Tiêu Đề</th>
            <th width="15%">Ngày Gửi</th>
            <th width="10%">Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact): ?>
        <tr>
            <td><?= $contact['id'] ?></td>
            <td><?= $contact['ho_ten'] ?></td>
            <td><?= $contact['email'] ?></td>
            <td><?= $contact['tieu_de'] ?></td>
            <td><?= $contact['ngay_gui'] ?></td>
            <td class="action-buttons">
                <button onclick="deleteContact(<?= $contact['id'] ?>)">🗑️ Xóa</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popupOverlay"></div>

<!-- Add Contact Form (Popup) -->
<div id="addForm" class="popup-form">
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <label for="ho_ten">Họ Tên:</label>
        <input type="text" name="ho_ten" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="tieu_de">Tiêu Đề:</label>
        <input type="text" name="tieu_de" required><br>
        <label for="noi_dung">Nội Dung:</label>
        <textarea name="noi_dung" rows="5" required></textarea><br>
        <button type="submit">Thêm liên hệ</button>
        <button type="button" onclick="closePopup()">Đóng</button>
    </form>
</div>


<script>
    // Open Add Contact Popup
    function openAddPopup() {
        document.getElementById('popupOverlay').style.display = 'block';
        document.getElementById('addForm').style.display = 'block';
    }

    // Open Edit Contact Popup
  

    // Close Popup
    function closePopup() {
        document.getElementById('popupOverlay').style.display = 'none';
        document.getElementById('addForm').style.display = 'none';
        document.getElementById('editForm').style.display = 'none';
    }

    // Delete Contact
    function deleteContact(id) {
        if (confirm('Bạn có chắc chắn muốn xóa liên hệ này?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'delete';
            form.appendChild(input);
            var idInput = document.createElement('input');
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
