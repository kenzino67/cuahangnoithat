<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Footer Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
      body {
        font-family: 'Roboto', sans-serif;
      }
    </style>
  </head>
  <body class="bg-white">
    <footer class="bg-white border-t border-gray-200">
      <!-- Top Footer -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative">
        <!-- Background Image -->
        <div class="absolute inset-0 -z-10 opacity-10">
          <img
            src="https://storage.googleapis.com/a1aa/image/a1fd9b71-6ef1-4842-7d19-d7537fca30a0.jpg"
            alt="Background"
            class="w-full h-full object-cover object-center"
          />
        </div>

        <!-- Footer Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8">
          <!-- Column 1 -->
          <div>
            <h3 class="text-sm font-bold text-gray-900 uppercase mb-4">Dịch vụ khách hàng</h3>
            <ul class="space-y-2 text-sm text-gray-700">
              <li><a href="#" class="hover:text-orange-500 transition">Giới thiệu</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Chính sách đổi trả</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Chính sách bảo mật</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Chính sách khiếu nại</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Điều khoản dịch vụ</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Liên hệ</a></li>
            </ul>
          </div>

          <!-- Column 2 -->
          <div>
            <h3 class="text-sm font-bold text-gray-900 uppercase mb-4">Thông tin</h3>
            <ul class="space-y-2 text-sm text-gray-700">
              <li><a href="#" class="hover:text-orange-500 transition">Tất cả sản phẩm</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Nội thất phòng khách</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Nội thất phòng ngủ</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Nội thất phòng bếp</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Nội thất thông minh</a></li>
            </ul>
          </div>

          <!-- Column 3 -->
          <div>
            <h3 class="text-sm font-bold text-gray-900 uppercase mb-4">Về chúng tôi</h3>
            <ul class="space-y-2 text-sm text-gray-700">
              <li><a href="#" class="hover:text-orange-500 transition">Giới thiệu</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Chính sách đổi trả</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Chính sách bảo mật</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Chính sách khiếu nại</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Điều khoản dịch vụ</a></li>
              <li><a href="#" class="hover:text-orange-500 transition">Liên hệ</a></li>
            </ul>
          </div>

          <!-- Column 4 (Contact Info) -->
          <div class="md:col-span-2">
            <h3 class="text-sm font-bold text-gray-900 uppercase mb-4">Liên hệ</h3>
            <p class="text-sm text-gray-700 leading-relaxed">
              Chúng tôi hướng tới sự khác biệt trong từng chi tiết, tạo nên ngôn ngữ riêng cho
              bày trí nội thất, đem đến một không gian tinh tế trong từng đường nét. Trên hết, sự
              tin tưởng của khách hàng là điều F1GENZ FURNITURE đề cao nhất.
            </p>
          </div>
        </div>
      </div>

      <!-- Bottom Footer -->
      <div class="bg-gray-50 border-t border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500">
          <div class="flex items-center space-x-2">
            <img
              src="https://storage.googleapis.com/a1aa/image/cfb0c5f3-fb47-47e0-2e4e-a3350f9f7b3a.jpg"
              alt="Logo"
              class="h-8 w-auto"
            />
            <span>© 2025 F1GENZ TECHNOLOGY CO., LTD.</span>
          </div>
          <span class="mt-2 sm:mt-0">Powered by Sapo</span>
        </div>
      </div>
    </footer>
  </body>
</html>
