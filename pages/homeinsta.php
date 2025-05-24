<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Instagram Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');

      body {
        font-family: 'Inter', sans-serif;
      }

      /* Hiệu ứng di chuyển chuột mượt hơn */
      .hover-scale {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
      }
      .hover-scale:hover {
        transform: scale(1.05);
      }

      /* Nút XEM NGAY: hiệu ứng đổi màu mượt */
      .btn-see-now {
        transition: color 0.4s ease;
        color: #111827; /* text-black */
      }
      .btn-see-now:hover {
        color: #f97316; /* orange-500 */
      }
      .hover-scale:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 15px rgba(0,0,0,0.1);
}
.btn-see-now:hover {
  background-color:rgb(230, 206, 193); /* orange-200 */
  color:rgb(226, 34, 31); /* orange-500 */
}

    </style>
  </head>
  <body class="bg-[#f1f4f3]">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-1 md:grid-cols-11 gap-4">
        <!-- Left Images Column -->
        <div class="md:col-span-4 grid grid-cols-2 gap-4">
          <img class="w-full object-cover hover-scale" src="images/insta1.jpg" width="200" height="200" alt="Image 1"/>
          <img class="w-full object-cover hover-scale" src="images/insta2.jpg" width="200" height="200" alt="Image 2"/>
          <img class="w-full object-cover hover-scale" src="images/insta3.jpg" width="200" height="200" alt="Image 3"/>
          <img class="w-full object-cover hover-scale" src="images/insta4.jpg" width="200" height="200" alt="Image 4"/>
          <img class="w-full object-cover hover-scale" src="images/insta5.jpg" width="200" height="200" alt="Image 5"/>
          <img class="w-full object-cover hover-scale" src="images/insta6.jpg" width="200" height="200" alt="Image 6"/>
        </div>

        <!-- Center Text Column -->
        <div class="md:col-span-3 flex flex-col items-center justify-center text-center px-6 py-12">
          <h2 class="text-gray-900 font-semibold text-xl mb-2">Bộ sưu tập Instagram</h2>
          <p class="text-gray-400 text-sm mb-6 max-w-xs">
            Chúng tôi luôn cập nhật những hình ảnh mới nhất từ các nhà sưu tập trên thế giới về nội thất.
          </p>
          <div class="mb-6">
            <img class="mx-auto" src="images/logoinsta.jpg" width="48" height="48" alt="Instagram logo"/>
          </div>
          <a href="all_products.php" class="border border-gray-300 text-xs font-normal px-8 py-2 transition btn-see-now">
            XEM NGAY ›
          </a>
        </div>

        <!-- Right Images Column -->
        <div class="md:col-span-4 grid grid-cols-2 gap-4">
          <img class="w-full object-cover hover-scale" src="images/insta7.jpg" width="200" height="200" alt="Image 7"/>
          <img class="w-full object-cover hover-scale" src="images/insta8.jpg" width="200" height="200" alt="Image 8"/>
          <img class="w-full object-cover hover-scale" src="images/insta9.jpg" width="200" height="200" alt="Image 9"/>
          <img class="w-full object-cover hover-scale" src="images/insta10.jpg" width="200" height="200" alt="Image 10"/>
          <img class="w-full object-cover hover-scale" src="images/insta11.jpg" width="200" height="200" alt="Image 11"/>
          <img class="w-full object-cover hover-scale" src="images/insta12.jpg" width="200" height="200" alt="Image 12"/>
        </div>
      </div>
    </div>
  </body>
</html>
