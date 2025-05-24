<?php
session_start();
$is_logged_in = isset($_SESSION['user']); // kiểm tra đã đăng nhập

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Furniture Premium Header</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
    .menu-danh-muc li a {
      display: block;
      padding: 0.5rem 1rem;
      color: #1F2937;
      text-decoration: none;
    }
    .menu-danh-muc li:hover {
      background-color: #f3f4f6;
    }
    .menu-danh-muc li a {
  display: block;
  padding: 0.5rem 1rem;
  transition: background-color 0.2s;
}
.menu-danh-muc li a:hover {
  background-color: #f3f4f6; /* Tailwind's gray-100 */
}
  .active-tab {
    background-color: #f3f4f6; /* Tailwind gray-100 */
    font-weight: 600;          /* Đậm chữ */
    border-left: 4px solid #1f2937; /* Tailwind gray-800 */
  }
.menu-danh-muc li a {
  display: block;
  padding: 0.5rem 1rem;
  transition: background-color 0.2s;
}
.menu-danh-muc li a:hover {
  background-color: #f3f4f6;
}

  </style>
</head>
<body class="bg-white">

<!-- Top header -->
<header class="w-full">
  <div class="flex items-center justify-between max-w-7xl mx-auto px-4 py-3">
    <!-- Logo -->
    <div class="flex items-center space-x-2">
      <a href="index.php">
      <img alt="Furniture Premium logo" class="w-10 h-10 object-contain" src="https://storage.googleapis.com/a1aa/image/4db1a02d-9aa2-4a1c-be40-f9de2dd2c624.jpg"/>
      </a>
      <div class="font-montserrat text-gray-800 font-semibold text-lg leading-none select-none">
        FURNITURE
        <div class="text-xs font-light tracking-widest">PREMIUM</div>
      </div>
    </div>

    <!-- Search input -->
    <div class="flex items-center border border-gray-300 rounded-md max-w-md w-full px-3 py-1">
      <input class="flex-grow outline-none text-gray-700 text-sm placeholder-gray-400" placeholder="Nhập tên sản phẩm cần tìm ..." type="text"/>
      <button aria-label="Search" class="text-gray-700 ml-2">
        <i class="fas fa-search"></i>
      </button>
    </div>

    <!-- Hotline and icons -->
    <div class="flex items-center space-x-6 text-gray-700">
      <div class="flex items-center space-x-2">
        <i class="fas fa-phone-alt text-lg"></i>
        <div class="text-right text-xs leading-none select-none">
          <div>Hotline</div>
          <div class="text-orange-600 font-semibold text-base leading-none">1800.67.50</div>
        </div>
      </div>
  <!-- User Account -->
<?php if ($is_logged_in): ?>
  <div class="flex items-center space-x-4 text-sm text-gray-700">
    <span>👋 Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['ho_ten']) ?></strong></span>

    <?php if ($_SESSION['user']['vai_tro'] === 'admin'): ?>
      <a href="http://localhost/phpadmin/btnhom/includes/dashboard.php" class="text-blue-600 hover:underline">Quản lý</a>
    <?php endif; ?>

    <form method="post" action="logout.php">
      <button class="text-red-600 hover:underline" type="submit">Đăng xuất</button>
    </form>
  </div>
<?php else: ?>
  <button onclick="openAuthPopup()" aria-label="Login/Register" class="text-gray-700 hover:text-gray-900">
    <i class="far fa-user text-lg"></i>
  </button>
<?php endif; ?>
 
    </div>
  </div>


<!-- Navigation bar -->
<!-- Navigation bar -->
<nav class="bg-gray-900 text-white text-sm relative z-40">
  <div class="max-w-7xl mx-auto px-4">
    <ul class="flex items-center space-x-6 h-10 relative">

      <!-- Danh mục sản phẩm -->
      <li id="productMenu" class="relative cursor-pointer select-none">
        <span class="flex items-center space-x-2">
          <i class="fas fa-bars"></i>
          <span>Danh mục sản phẩm</span>
          <i class="fas fa-chevron-down text-xs"></i>
        </span>
        <ul id="productDropdown" class="absolute top-full left-0 bg-white text-gray-800 shadow-lg border border-gray-200 mt-2 w-56 hidden z-50 menu-danh-muc">
          <?php
          $conn = new mysqli("localhost", "root", "", "quanlynoithat");
          if ($conn->connect_error) die("Kết nối thất bại: " . $conn->connect_error);
          $sql = "SELECT id, ten_danh_muc FROM danh_muc ORDER BY ten_danh_muc ASC";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<li><a href='all_products.php?danh_muc_id=" . $row["id"] . "&page=1'>" . htmlspecialchars($row["ten_danh_muc"]) . "</a></li>";
              }
          } else {
              echo "<li><span class='block px-4 py-2 text-gray-500'>Không có danh mục</span></li>";
          }
          $conn->close();
          ?>
        </ul>
      </li>

      <!-- Các mục khác -->
      <a href="all_products.php"><li class="cursor-pointer select-none">Tất cả sản phẩm</li></a>
      <a href="http://localhost/phpadmin/btnhom/pages/product_detail.php?id=31">
        <li class="relative cursor-pointer select-none">Chi tiết sản phẩm</li>
      </a>
      <a href="articles.php"><li class="cursor-pointer select-none">Blogs</li></a>
      <a href="contact.php"><li class="cursor-pointer select-none">Liên hệ</li></a>
      
      <li class="ml-auto border border-red-600 text-red-600 px-3 rounded-sm flex items-center space-x-1 select-none text-sm">
        <span class="text-xs">●</span>
        <a href="https://www.youtube.com/watch?v=zvkN-cIphMQ" data-fancybox title="Video">Video Hot</a>
      </li>
    </ul>
  </div>
</nav>


</header>
<!-- Overlay -->
<div id="authOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="bg-white max-w-4xl w-full mx-4 sm:mx-auto mt-10 border border-gray-200 flex flex-col sm:flex-row relative rounded-lg overflow-hidden">
    
    <!-- Close Button -->
    <button onclick="closeAuthPopup()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl z-10">&times;</button>

    <!-- Left Navigation -->
    <nav class="w-full sm:w-48 bg-white border-r border-gray-200">
      <div class="flex items-center justify-center py-6 px-4 border-b border-gray-200">
        <img src="https://storage.googleapis.com/a1aa/image/4db1a02d-9aa2-4a1c-be40-f9de2dd2c624.jpg" alt="Logo" class="w-20 h-auto" />
      </div>
      <ul class="text-gray-700 text-base">
  <li>
    <button id="tab-login" onclick="switchTab('login')" class="w-full text-left px-4 py-3 hover:bg-gray-50 hover:text-gray-900">Đăng nhập</button>
  </li>
  <li>
    <button id="tab-register" onclick="switchTab('register')" class="w-full text-left px-4 py-3 hover:bg-gray-50 hover:text-gray-900">Đăng ký</button>
  </li>
</ul>

    </nav>

    <!-- Right Content -->
    <section class="flex-1 p-6 bg-white overflow-y-auto">
      <!-- Login Form -->
      <div id="loginForm">
        <h2 class="text-gray-900 text-lg font-normal mb-4">ĐĂNG NHẬP</h2>
        <form action="login.php" method="post">
          <label class="block text-sm text-gray-900 mb-1" for="email_login">Email*</label>
          <input id="email_login" name="email" type="email" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-4 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" />
          
          <label class="block text-sm text-gray-900 mb-1" for="password_login">Mật khẩu*</label>
          <input id="password_login" name="mat_khau" type="password" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-6 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" />
          
          <button type="submit"
            class="w-full bg-gray-800 text-white text-sm font-normal py-3 rounded mb-6 hover:bg-gray-900 transition-colors">
            ĐĂNG NHẬP
          </button>
        </form>

        <p class="text-gray-900 text-sm font-normal mb-3">Hoặc đăng nhập bằng:</p>
        <div class="flex space-x-2 max-w-xs">
          <button type="button"
            class="flex items-center justify-center space-x-2 bg-blue-700 text-white py-2 px-4 rounded hover:bg-blue-800 text-sm">
            <i class="fab fa-facebook-f"></i><span>Facebook</span>
          </button>
          <button type="button"
            class="flex items-center justify-center space-x-2 bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 text-sm">
            <i class="fab fa-google-plus-g"></i><span>Google</span>
          </button>
        </div>
      </div>

      <!-- Register Form -->
      <div id="registerForm" class="hidden">
        <h2 class="text-gray-900 text-lg font-normal mb-4">ĐĂNG KÝ</h2>
        <form action="register.php" method="post">
          <label class="block text-sm text-gray-900 mb-1">Họ và tên*</label>
          <input name="ho_ten" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-4 text-sm focus:outline-none focus:ring-1 focus:ring-green-500" />

          <label class="block text-sm text-gray-900 mb-1">Email*</label>
          <input type="email" name="email" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-4 text-sm focus:outline-none focus:ring-1 focus:ring-green-500" />

          <label class="block text-sm text-gray-900 mb-1">Số điện thoại*</label>
          <input type="text" name="so_dien_thoai" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-4 text-sm focus:outline-none focus:ring-1 focus:ring-green-500" />

          <label class="block text-sm text-gray-900 mb-1">Địa chỉ*</label>
          <input type="text" name="dia_chi" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-4 text-sm focus:outline-none focus:ring-1 focus:ring-green-500" />

          <label class="block text-sm text-gray-900 mb-1">Mật khẩu*</label>
          <input type="password" name="mat_khau" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-4 text-sm focus:outline-none focus:ring-1 focus:ring-green-500" />

          <label class="block text-sm text-gray-900 mb-1">Vai trò*</label>
          <select name="vai_tro" required
            class="w-full border border-gray-300 rounded px-3 py-2 mb-6 text-sm focus:outline-none focus:ring-1 focus:ring-green-500">
            <option value="khach_hang">Khách hàng</option>
          </select>

          <button type="submit"
            class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700 transition-colors text-sm">
            ĐĂNG KÝ
          </button>
        </form>
      </div>
    </section>
  </div>
</div>

<script>
  function openAuthPopup() {
    document.getElementById('authOverlay').classList.remove('hidden');
    switchTab('login');
  }

  function closeAuthPopup() {
    document.getElementById('authOverlay').classList.add('hidden');
  }

  function switchTab(tab) {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    if (tab === 'login') {
      loginForm.classList.remove('hidden');
      registerForm.classList.add('hidden');
    } else {
      loginForm.classList.add('hidden');
      registerForm.classList.remove('hidden');
    }
  }
</script>
<script>
  const productMenu = document.getElementById('productMenu');
  const dropdown = document.getElementById('productDropdown');

  let hideTimeout;

  // Hover vào thì hiển thị menu
  productMenu.addEventListener('mouseenter', () => {
    clearTimeout(hideTimeout);
    dropdown.classList.remove('hidden');
  });

  // Rời khỏi thì đếm 1 giây rồi ẩn
  productMenu.addEventListener('mouseleave', () => {
    hideTimeout = setTimeout(() => {
      dropdown.classList.add('hidden');
    }, 1000);
  });

  // Click ra ngoài menu thì ẩn sau 1 giây
  document.addEventListener('click', (e) => {
    if (!productMenu.contains(e.target)) {
      hideTimeout = setTimeout(() => {
        dropdown.classList.add('hidden');
      }, 600);
    } else {
      clearTimeout(hideTimeout);
      dropdown.classList.remove('hidden');
    }
  });
</script>

</body>
</html>
