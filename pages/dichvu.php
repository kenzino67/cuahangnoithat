<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Showroom Nội thất F1genz</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    /* Custom gradient fade for the image's left side */
  /* Gradient fade on both left and right sides */
.fade-sides {
  mask-image: linear-gradient(to right, transparent, black 20%, black 80%, transparent);
  -webkit-mask-image: linear-gradient(to right, transparent, black 20%, black 80%, transparent);
}

    /* Adjustments for smaller screens */
    @media (max-width: 768px) {
      .fade-left {
        mask-image: none;
        -webkit-mask-image: none;
      }
      .image-container {
        height: 250px; /* Reduced height for smaller devices */
      }
      .features-section {
        grid-template-columns: 1fr 1fr;
      }
      .text-section h2 {
        font-size: 1.5rem; /* Slightly larger heading */
      }
      .text-section p {
        font-size: 0.875rem; /* Smaller paragraph */
      }
      .button {
        padding: 0.5rem 1.5rem;
      }
    }

    /* Reduce the margin between the features row and the image */
    .features-row {
      margin-top: -1rem; /* Reduced margin to bring it closer */
    }
    /* Improved the space between features */
    .features-section {
      gap: 1rem;
    }
    .features-section div {
      padding: 1rem;
      max-width: 250px; /* Added limit to width */
    }
    /* Adjust header size */
    .text-section h2 {
      font-size: 2rem; /* Increased font size */
    }

    /* Adjust the margin between image and features section */
    .image-container {
      margin-bottom: -20px; /* Reduce space between image and the next section */
    }

    /* Hover effect for buttons and icons */
    .button:hover {
      background-color: #f3f4f6; /* Light gray on hover */
      color: #111;
      transform: translateY(-2px);
      transition: all 0.3s ease;
    }

    .features-section div:hover {
      background-color: #f3f4f6;
      border-radius: 8px;
      transform: scale(1.05);
      transition: all 0.3s ease;
    }

    .features-section i:hover {
      color: #1D4ED8; /* Change icon color on hover */
    }
  </style>
 </head>
 <body class="bg-white text-gray-900 font-sans">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
   <div class="flex flex-col md:flex-row items-center md:items-stretch justify-center min-h-[500px] md:min-h-[600px] space-y-8 md:space-y-0">
    <!-- Left text content -->
    <div class="md:w-1/2 flex flex-col justify-center items-center text-center md:text-left md:items-start py-8 md:py-0 text-section">
     <h2 class="text-xl md:text-2xl font-semibold mb-3 leading-tight max-w-xs">
      Showroom Nội thất F1genz
     </h2>
     <p class="text-gray-400 text-xs md:text-sm max-w-xs mb-6 leading-relaxed">
      Luôn cập nhật những xu hướng mới nhất của thị trường nội thất, mang đến các sản phẩm chất lượng cho người tiêu dùng.
     </p>
     <button class="border border-gray-300 text-xs md:text-sm font-semibold uppercase px-8 py-2 hover:bg-gray-100 transition button" type="button">
      XEM NGAY
     </button>
    </div>
    <!-- Right image with fade on left -->
    <div class="md:w-1/2 relative w-full h-[300px] md:h-[400px] image-container">
<img
  alt="Interior showroom"
  class="w-full h-full object-cover fade-sides"
  height="400"
  loading="lazy"
  src="images/home_store_image.jpg"
  width="800"
/>
    </div>
   </div>
   <!-- Features row with reduced margin-top -->
   <div class="features-row mt-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-center md:text-left max-w-6xl mx-auto features-section">
    <div class="flex flex-col items-center md:items-start px-4">
     <i class="fas fa-plane-departure text-xl mb-2"></i>
     <h3 class="font-semibold text-sm mb-1">
      Giao hàng nhanh, miễn phí
     </h3>
     <p class="text-gray-400 text-xs mb-1 leading-tight max-w-[180px]">
      Đơn hàng &gt; 900k hoặc đăng ký tài khoản được giao hàng miễn phí
     </p>
     <a class="text-xs text-gray-700 hover:underline" href="#">Xem chi tiết</a>
    </div>
    <div class="flex flex-col items-center md:items-start px-4">
     <i class="fas fa-external-link-alt text-xl mb-2"></i>
     <h3 class="font-semibold text-sm mb-1">Trả hàng, Bảo hành</h3>
     <p class="text-gray-400 text-xs mb-1 leading-tight max-w-[180px]">
      Không thích? Trả lại hoặc đổi hàng của bạn miễn phí trong vòng 30 ngày.
     </p>
     <a class="text-xs text-gray-700 hover:underline" href="#">Xem chi tiết</a>
    </div>
    <div class="flex flex-col items-center md:items-start px-4">
     <i class="fas fa-credit-card text-xl mb-2"></i>
     <h3 class="font-semibold text-sm mb-1">Thành viên</h3>
     <p class="text-gray-400 text-xs mb-1 leading-tight max-w-[180px]">
      Ưu đã theo từng cấp bậc hạng thành viên. Sinh nhật quà tặng thành viên
     </p>
     <a class="text-xs text-gray-700 hover:underline" href="#">Xem chi tiết</a>
    </div>
    <div class="flex flex-col items-center md:items-start px-4">
     <i class="fas fa-credit-card text-xl mb-2"></i>
     <h3 class="font-semibold text-sm mb-1">Chính hãng</h3>
     <p class="text-gray-400 text-xs mb-1 leading-tight max-w-[180px]">
      Sản phẩm chính hãng. Được nhập khẩu 100% từ hãng.
     </p>
     <a class="text-xs text-gray-700 hover:underline" href="#">Xem chi tiết</a>
    </div>
   </div>
  </div>
 </body>
</html>