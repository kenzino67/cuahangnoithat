<?php

include_once 'header.php'; 
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   F1GENZ Furniture
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    textarea::-webkit-scrollbar-thumb {
      background-color: #cbd5e1;
      border-radius: 10px;
    }
  </style>
 </head>
 <body class="bg-white font-sans text-[13px] text-[#666666] leading-[1.4]">
  <div class="max-w-[1200px] mx-auto px-4 py-10">
   <!-- Top Section: About and Contact -->
   <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-10 lg:gap-0">
    <!-- Left: About -->
    <div class="lg:w-1/2">
     <h2 class="flex items-center text-[#d46a47] font-semibold text-[14px] mb-3">
      <i class="fas fa-pencil-alt mr-2">
      </i>
      VỀ CHÚNG TÔI
     </h2>
     <p class="text-[12px] leading-[1.5]">
      F1GENZ FURNITURE là một thương hiệu chuyên cung cấp các dịch vụ thiết kế
          đến thi công nội thất trọn gói cho căn hộ. Chúng tôi là một công ty liên doanh
          giữa Việt Nam và Hong Kong. Với mục tiêu mang lại cho bạn không gian lý tưởng,
          sản phẩm nội thất sáng tạo, dịch vụ chuyên nghiệp. Chúng tôi luôn xây dựng một
          mối quan hệ chặt chẽ với khách hàng và tiếp cận trực tiếp với các dự án. Các
          thiết kế của F1GENZ FURNITURE luôn độc đáo và phù hợp theo không gian của bạn.
          Chúng tôi luôn phát triển các gói nội thất mang tính đặc trưng, hấp dẫn và luôn
          đảm bảo chất lượng tốt.
     </p>
    </div>
    <!-- Right: Illustration -->
    <div class="lg:w-1/2 flex justify-center lg:justify-end">
     <img alt="Illustration of two people working at a desk with a large blue lamp, plants, and a light bulb in the background" class="max-w-full h-auto" height="250" src="https://storage.googleapis.com/a1aa/image/fd4009a3-6bc1-4044-0cf0-c919b602b64b.jpg" width="400"/>
    </div>
   </div>
   <!-- Middle Section: Contact Illustration and Contact Text -->
   <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mt-20 gap-10 lg:gap-0">
    <!-- Left: Cartoon character with Contact Us sign -->
    <div class="lg:w-1/2 flex justify-center lg:justify-start">
     <img alt="Cartoon character with orange hair holding a large orange sign that says CONTACT US" class="max-w-full h-auto" height="300" src="https://storage.googleapis.com/a1aa/image/a742b331-b5b4-4349-5535-f3e42b98b3fd.jpg" width="250"/>
    </div>
    <!-- Right: Contact text -->
    <div class="lg:w-1/2">
     <h2 class="flex items-center text-[#d46a47] font-semibold text-[14px] mb-3">
      <i class="fas fa-pencil-alt mr-2">
      </i>
      LIÊN HỆ
     </h2>
     <p class="text-[12px] leading-[1.5]">
      F1GENZ FURNITURE tự hào cung cấp đến bạn những thiết kế đầy sáng tạo của đội ngũ
          chuyên nghiệp và là địa chỉ khóa thành công của công ty chúng tôi. Luôn lắng nghe
          những cảm hứng và ý tưởng của khách hàng và giúp những ước mơ của mỗi cá nhân trở
          thành hiện thực, điều này tạo thêm sự tin tưởng và thân thiện khi khách hàng làm
          việc với F1GENZ FURNITURE.
     </p>
    </div>
   </div>
   <!-- Bottom Section: Form and Map -->
   <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start mt-20 gap-10 lg:gap-0">
    <!-- Left: Form -->
    <div class="lg:w-1/2">
     <h2 class="flex items-center text-[#d46a47] font-semibold text-[14px] mb-3">
      <i class="fas fa-pencil-alt mr-2">
      </i>
      KẾT NỐI NGAY VỚI CHÚNG TÔI
     </h2>
<form class="space-y-3 text-[12px]" method="POST" action="lienhe_xuly.php">
  <input name="ten" class="w-full border border-[#ccc] px-3 py-2" placeholder="Tên của bạn" required />
  <input name="sdt" class="w-full border border-[#ccc] px-3 py-2" placeholder="Số điện thoại của bạn" required />
  <input name="email" type="email" class="w-full border border-[#ccc] px-3 py-2" placeholder="Email của bạn" required />
  <div class="flex">
    <textarea name="noi_dung" class="resize-none border border-[#ccc] px-3 py-2 w-full" placeholder="Viết bình luận" required rows="2"></textarea>
    <button type="submit" class="bg-[#1a1a1a] text-white text-[12px] px-5 py-2 ml-2">GỬI THÔNG TIN</button>
  </div>
</form>

     <div class="flex space-x-4 mt-4 text-[#1a1a1a] text-[14px]">
      <a aria-label="Facebook" class="hover:text-[#d46a47]" href="#">
       <i class="fab fa-facebook-f">
       </i>
      </a>
      <a aria-label="Pinterest" class="hover:text-[#d46a47]" href="#">
       <i class="fab fa-pinterest-p">
       </i>
      </a>
      <a aria-label="YouTube" class="hover:text-[#d46a47]" href="#">
       <i class="fab fa-youtube">
       </i>
      </a>
      <a aria-label="TikTok" class="hover:text-[#d46a47]" href="#">
       <i class="fab fa-tiktok">
       </i>
      </a>
      <a aria-label="Instagram" class="hover:text-[#d46a47]" href="#">
       <i class="fab fa-instagram">
       </i>
      </a>
     </div>
    </div>
    <!-- Right: Map -->
    <div class="lg:w-1/2">
     <iframe allowfullscreen="" height="300" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.927927927927!2d106.6762083152603!3d10.76262299232609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f2b1a1a1a1a%3A0x1a1a1a1a1a1a1a1a!2zMTgyIMSQ4bqhaSDEkOG6oWkgSGFuaA!5e0!3m2!1sen!2s!4v1698192000000!5m2!1sen!2s" style="border:0;" title="Google map showing location at 182 D. Lê Đại Hành" width="100%">
     </iframe>
    </div>
   </div>
  </div>
 </body>
</html>

<?php require 'footerindex.php'; ?>