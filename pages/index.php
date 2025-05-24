<?php

include_once 'header.php'; 
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<!-- Banner Slider -->
<div class="banner-slider w-full max-w-7xl mx-auto">
  <div><img src="images/banner1.jpg" alt="Banner 1" class="w-full h-auto object-cover"></div>
  <div><img src="images/banner2.jpg" alt="Banner 2" class="w-full h-auto object-cover"></div>
  <div><img src="images/banner3.jpg" alt="Banner 3" class="w-full h-auto object-cover"></div>
</div>

<script>
  $(document).ready(function(){
    // Hàm sắp xếp ngẫu nhiên các phần tử trong mảng
    function shuffleArray(arr) {
      for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]]; // Hoán đổi các phần tử
      }
    }

    // Lấy tất cả các phần tử ảnh trong slider
    var images = $('.banner-slider').children('div').toArray();

    // Sắp xếp ngẫu nhiên các ảnh
    shuffleArray(images);

    // Thêm các ảnh đã được sắp xếp lại vào slider
    $('.banner-slider').html(images);

    // Khởi tạo slick slider
    $('.banner-slider').slick({
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: false,
      dots: true,
      fade: true
    });
  });
</script>

<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$current_time = date("H:i:s");


include('db.php');

// Định nghĩa các khung giờ
$hours = ["00:00:00", "07:00:00", "12:00:00", "14:00:00", "20:00:00"];
$hour_labels = ["0:00", "7:00", "12:00", "14:00", "20:00"];

// Xác định khung giờ đang diễn ra
$current_hour_section = '';
foreach ($hours as $index => $time) {
    if ($current_time >= $time && ($index === count($hours) - 1 || $current_time < $hours[$index + 1])) {
        $current_hour_section = $time;
        break;
    }
}

function getDiscountedProducts($conn, $hour) {
    $stmt = $conn->prepare("SELECT * FROM san_pham WHERE khung_gio_flashsale = ? AND giam_gia > 0 ORDER BY ngay_tao DESC");
    $stmt->bind_param("s", $hour);
    $stmt->execute();
    return $stmt->get_result();
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Flash Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
</head>
<style>
   /* Thêm vào CSS của bạn */
.flashsale-container {
    max-width: 7xl; /* Giới hạn chiều rộng tối đa của Flash Sale */
    margin: 0 auto; /* Căn giữa phần Flash Sale */
    padding: 20px; /* Khoảng cách bên trong */
}

.flashsale-section {
    display: none;
    width: 100%; /* Đảm bảo phần flash sale có chiều rộng đầy đủ */
}

#flashsale-hours {
    overflow-x: auto;
}

/* Nếu bạn muốn phần flash sale có chiều cao như banner */
.flashsale-section img {
    height: auto; /* Điều chỉnh chiều cao của ảnh bên trong Flash Sale */
}
/* Thêm vào CSS của bạn */
.product-slider img {
    width: 100%; /* Chiều rộng đầy đủ */
    height: 200px; /* Chiều cao cố định */
    object-fit: cover; /* Căn chỉnh ảnh cho đầy đủ, không bị méo */
}

.product-slider {
    min-height: 300px; /* Đảm bảo rằng slider có chiều cao tối thiểu */
}

.product-slider .slick-slide {
    display: flex;
    justify-content: center;
    align-items: center; /* Căn giữa ảnh nếu cần */
}

.product-slider article {
    width: 100%; /* Đảm bảo mỗi sản phẩm chiếm hết chiều rộng của slider */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-slider img {
    border-radius: 8px; /* Bo góc ảnh */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Thêm bóng đổ cho ảnh */
}
.flash-sale-images-container {
    width: 100%;
    max-width: 900px; /* Căn theo container chính */
    margin: 2rem auto 1rem auto; /* Căn giữa và tạo khoảng cách */
    display: flex;
    justify-content: center;
}

.flash-sale-image img {
    width: 130px; /* Kích thước ảnh lớn hơn và đồng đều */
    height: 130px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.flash-sale-image img:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
}

.flash-sale-images-container .flash-sale-image {
    max-width: 140px;
}
.home-product-pos {
    position: relative;
    width: 100%;
    max-width: 1920px;
    margin: 0 auto;
}

.home-product-pos picture img {
    display: block;
    width: 100%;
    height: auto;
}

.home-product-pos-item {
    position: absolute;
    cursor: pointer;
    z-index: 10;
}

.home-product-pos-item-dots {
    width: 12px;
    height: 12px;
    background: #f15a24;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 5px rgba(0,0,0,0.3);
    display: block;
}

.home-product-pos-item-contents {
    display: none;
    position: absolute;
    top: 20px;
    left: 20px;
    background: white;
    padding: 10px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    width: 180px;
}

.home-product-pos-item:hover .home-product-pos-item-contents {
    display: block;
}

.home-product-pos-item-contents h3 {
    font-size: 14px;
    font-weight: bold;
    margin: 10px 0 4px;
}

.home-product-pos-item-contents span {
    color: #f15a24;
    font-weight: bold;
    font-size: 13px;
}


</style>
<!-- Phần 4 ảnh nhỏ ở trên Flash Sale -->
<div class="flash-sale-images-container w-full mt-8">
    <div class="flex justify-center space-x-4">
        <div class="flash-sale-image">
            <img src="images/banner11.jpg" alt="Image 1" />
        </div>
        <div class="flash-sale-image">
            <img src="images/banner12.jpg" alt="Image 2" />
        </div>
        <div class="flash-sale-image">
            <img src="images/banner13.jpg" alt="Image 3" />
        </div>
        <div class="flash-sale-image">
            <img src="images/banner14.jpg" alt="Image 4" />
        </div>
    </div>
</div>

<!-- Container chính -->
<div class="max-w-[900px] mx-auto border border-gray-300 bg-white shadow-md">

    <!-- Logo + Tiêu đề -->
    <div class="flex justify-between items-center px-4 py-2 border-b border-gray-300">
        <div class="flex items-center space-x-2">
            <span class="text-[#f15a24] font-extrabold text-lg flex items-center">
                <i class="fas fa-bolt mr-1"></i> FLASH SALE
            </span>
         
        </div>
        <a href="all_products.php">
        <button class="text-[#f15a24] text-xs border border-[#f15a24] px-3 py-1 rounded-sm hover:bg-[#f15a24] hover:text-white transition">
            Xem tất cả
        </button></a>
    </div>

    <!-- Khung giờ dạng hàng ngang -->
    <div class="flex bg-gradient-to-b from-black/90 to-black/70 text-white text-center text-xs sm:text-sm font-semibold px-4 py-3">
        <?php foreach ($hours as $index => $time):
            $label = $hour_labels[$index];
            if ($current_time < $time) {
                $status = 'Sắp diễn ra';
                $color = 'text-gray-300';
            } elseif ($current_time >= $time && ($index === count($hours)-1 || $current_time < $hours[$index + 1])) {
                $status = 'Đang diễn ra';
                $color = 'text-[#f15a24]';
            } else {
                $status = 'Đã kết thúc';
                $color = 'text-gray-400';
            }
        ?>
        <div class="flex-1 cursor-pointer <?= $color ?>" onclick="showFlashSaleSection('<?= $time ?>')">
            <div class="text-base font-bold"><?= $label ?></div>
            <div class="text-[10px] font-normal"><?= $status ?></div>
        </div>
        <?php endforeach; ?>
    </div>
<!-- Danh sách sản phẩm -->
<div class="flashsale-container">
    <?php foreach ($hours as $i => $time): ?>
        <div id="flashsale-<?= str_replace(':', '-', $time) ?>" class="flashsale-section" style="<?= $time === $current_hour_section ? 'display:block;' : 'display:none;' ?>">
            <div class="product-slider-<?= str_replace(':', '-', $time) ?> px-4 py-4">
                <?php
                    $products = getDiscountedProducts($conn, $time);
                    if ($products->num_rows === 0): ?>
                        <div class="text-center text-gray-500">Không có sản phẩm giảm giá trong khung giờ này.</div>
                <?php endif; ?>

                <?php while ($row = $products->fetch_assoc()): 
                    $discountPercent = $row['giam_gia'] > 0 ? round(($row['giam_gia'] / $row['gia']) * 100) : 0;
                ?>
                    <div class="border border-gray-300 relative bg-white mx-1">
                        <?php if ($discountPercent > 0): ?>
                            <div class="absolute top-2 left-2 bg-[#f15a24] text-white text-[10px] font-semibold px-2 py-[2px] z-10">
                                -<?= $discountPercent ?>%
                            </div>
                        <?php endif; ?>
                        <img src="<?= $row['anh_dai_dien'] ?>" alt="<?= $row['ten_san_pham'] ?>" class="w-full object-contain bg-white h-44"/>
                        <div class="px-2 mt-1 text-[10px] text-gray-500 font-semibold">
                            F1GENZ <span class="text-[#f15a24]">Flash Sale</span>
                        </div>
                        <div class="px-2 mt-1 text-[11px] font-normal">
                            <?= $row['ten_san_pham'] ?>
                        </div>
                        <div class="px-2 mt-1 mb-2 text-[12px] font-semibold text-[#f15a24]">
                            <?= number_format($row['gia'] - $row['giam_gia'], 0, ',', '.') ?>₫
                            <span class="line-through text-gray-400 text-[10px] font-normal ml-1">
                                <?= number_format($row['gia'], 0, ',', '.') ?>₫
                            </span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


    <!-- Đường kẻ cuối -->
    <div class="h-1 bg-black mx-auto w-4 mt-1"></div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script>
function showFlashSaleSection(hour) {
    // Ẩn tất cả các khung giờ trước khi hiển thị khung giờ được chọn
    $('.flashsale-section').hide();
    $('#flashsale-' + hour.replace(/:/g, '-')).show(); // Dùng replace cho đồng bộ
}


</script>
<script>
  function startCountdown(endTime, elementId) {
    const countdownElement = document.getElementById(elementId);
    const countdownInterval = setInterval(function() {
        const now = new Date().getTime();
        const distance = endTime - now;
        
        if (distance < 0) {
            clearInterval(countdownInterval);
            countdownElement.innerHTML = "Kết thúc";
        } else {
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            countdownElement.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
        }
    }, 1000);
}

$(document).ready(function () {
    // Khởi tạo slick cho tất cả các slider sản phẩm
    $('[class^="product-slider-"]').each(function() {
        $(this).slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2500,
            arrows: true,
            dots: false,
            infinite: true,
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: 3 } },
                { breakpoint: 768, settings: { slidesToShow: 2 } },
                { breakpoint: 480, settings: { slidesToShow: 1 } }
            ]
        });
    });

    // Khởi tạo countdown cho mỗi khung giờ Flash Sale
    <?php foreach ($hours as $i => $time): ?>
        const flashSaleTime = new Date();
        const [hour, minute, second] = "<?= $time ?>".split(":");
        flashSaleTime.setHours(hour);
        flashSaleTime.setMinutes(minute);
        flashSaleTime.setSeconds(second);
        flashSaleTime.setMilliseconds(0);

        const endTime = flashSaleTime.getTime() + (60 * 60 * 1000); // Thêm 1 giờ cho thời gian Flash Sale

        startCountdown(endTime, "countdown-<?= str_replace(':', '-', $time) ?>");
    <?php endforeach; ?>
});


</script>
<!-- Slick CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<!-- jQuery + Slick JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
$(document).ready(function () {
    // Khởi tạo Slick cho mỗi slider sản phẩm
    $('[class^="product-slider-"]').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2500,
        arrows: true,
        dots: false,
        infinite: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: { slidesToShow: 3 }
            },
            {
                breakpoint: 768,
                settings: { slidesToShow: 2 }
            },
            {
                breakpoint: 480,
                settings: { slidesToShow: 1 }
            }
        ]
    });
});
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bộ sưu tập</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <style>
    .image-card img {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .image-card:hover img {
      transform: scale(1.05);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }
    .home-insta {
    background-color: #f9f9f9;
    padding: 50px 0;
    max-width: 7xl; /* Cùng kích thước với Flash Sale */
    margin: 0 auto; /* Căn giữa */
}



  </style>
</head>
<body class="bg-white">
  <div class="max-w-4xl mx-auto px-4 py-6">
    <!-- Tiêu đề -->
    <div class="text-center mb-4">
      <h2 class="text-base font-semibold text-gray-900">Bộ sưu tập</h2>
      <p class="text-[10px] text-gray-400 mt-1">Sản phẩm bán chạy nhất tuần này!</p>
    </div>

    <!-- Grid ảnh -->
    <div class="grid grid-cols-6 grid-rows-2 gap-2">
      <!-- Box 1 -->
      <div class="border border-gray-300 p-2 col-span-1 row-span-1 flex flex-col items-center image-card text-center">
        <img src="images/suutap1.jpg" alt="Khuyến mãi" class="w-[70px] h-[70px] object-cover rounded-md" />
        <p class="text-[9px] text-gray-800 mt-1">KHUYẾN MÃI</p>
      </div>

      <!-- Box 2 -->
      <div class="border border-gray-300 p-2 col-span-1 row-span-1 flex flex-col items-center image-card text-center">
        <p class="text-[9px] text-gray-800 font-semibold mb-1">SALE OFF</p>
        <img src="images/suutap2.jpg" alt="Sale off" class="w-[70px] h-[70px] object-cover rounded-md" />
      </div>

      <!-- Box 3 (dài) -->
      <div class="border border-gray-300 p-2 col-span-4 row-span-1 flex flex-col items-center image-card text-center">
        <img src="images/suutam3.jpg" alt="New sale" class="w-full h-[70px] object-cover rounded-md" />
        <p class="text-[9px] text-gray-800 mt-1">NEW SALE</p>
      </div>

      <!-- Box 4 -->
      <div class="border border-gray-300 p-2 col-span-3 row-span-1 flex flex-col items-center image-card text-center">
        <img src="images/suutap4.jpg" alt="Mới nhất" class="w-full h-[70px] object-cover rounded-md" />
        <p class="text-[9px] text-gray-800 mt-1">MỚI NHẤT</p>
      </div>

      <!-- Box 5 -->
      <div class="border border-gray-300 p-2 col-span-1 row-span-1 flex flex-col items-center image-card text-center">
        <p class="text-[9px] text-gray-800 font-semibold mb-1">HOT TREND</p>
        <img src="images/suutap5.jpg" alt="Hot trend" class="w-[70px] h-[70px] object-cover rounded-md" />
      </div>

      <!-- Box 6 -->
      <div class="border border-gray-300 p-2 col-span-2 row-span-1 flex flex-col items-center image-card text-center">
        <img src="images/suutap6.jpg" alt="Giảm giá" class="w-full h-[70px] object-cover rounded-md" />
        <p class="text-[9px] text-gray-800 mt-1">GIẢM GIÁ</p>
      </div>
    </div>
  </div>
</body>
</html>
<section class="home-product-pos">
	<picture title="F1GENZ Furniture">
		<img class="w-100 lazyloaded" width="1920" height="960" alt="F1GENZ Furniture" src="images/home.jpg">
	</picture>

	<!-- Vị trí 1 -->
	<div class="home-product-pos-item" style="top: 25%; left: 5%">
		<span class="home-product-pos-item-dots"></span>
		<div class="home-product-pos-item-contents">
			<picture>
            <img src="images/tu-quan-ao-3-cua-2-ngan.jpg" alt="Tủ quần áo 3 cửa 2 ngăn">
			</picture>
			<a href="/ban-an-4-chan-gia-dinh-cao-cap" title="Tủ quần áo 3 cửa 2 ngăn F1GENZ cao cấp">
				<h3>Tủ quần áo 3 cửa 2 ngăn F1GENZ cao cấp<br><small>Đen / Quả óc chó</small><i class="fa fa-chevron-right"></i></h3>
				<span>23.690.000₫</span>
			</a>
		</div>
	</div>

	<!-- Vị trí 2 -->
	<div class="home-product-pos-item" style="top: 66%; left: 27%">
		<span class="home-product-pos-item-dots"></span>
		<div class="home-product-pos-item-contents">
			<picture>
				<img src="images/sofa-da.jpg" width="160" height="160" alt="Sofa da cao cấp">
			</picture>
			<a href="/den-san-f1genz-cao-cap" title="Sofa da cao cấp">
				<h3>Sofa da cao cấp<br><small>Nâu/ Xám</small><i class="fa fa-chevron-right"></i></h3>
				<span>15.000.000₫</span>
			</a>
		</div>
	</div>

	<!-- Vị trí 3 -->
	<div class="home-product-pos-item" style="top: 41%; left: 80%">
		<span class="home-product-pos-item-dots"></span>
		<div class="home-product-pos-item-contents">
			<picture>
				<img src="images/ke-treo-tuong-cao-cap.jpg" width="160" height="160" alt="Kệ treo tường cao cấp">
			</picture>
			<a href="/den-san-bang-da-cam-thach" title="Kệ treo tường cao cấp">
				<h3>Kệ treo tường cao cấp<br><small>Trắng</small><i class="fa fa-chevron-right"></i></h3>
				<span>3.990.000₫</span>
			</a>
		</div>
	</div>

	<!-- Vị trí 4 -->
	<div class="home-product-pos-item" style="top: 75%; left: 60%">
		<span class="home-product-pos-item-dots"></span>
		<div class="home-product-pos-item-contents">
			<picture>
				<img src="images/ban-an-da-thieu-ket.jpg" width="160" height="160" alt="Bàn bằng đá cẩm thạch">
			</picture>
			<a href="/ban-an-da-thieu-ket" title="Bàn bằng đá cẩm thạch">
				<h3>Bàn bằng đá cẩm thạch<br><small>Trắng / Đá thiêu kết</small><i class="fa fa-chevron-right"></i></h3>
				<span>21.199.000₫</span>
			</a>
		</div>
	</div>
   
</section>

<?php require 'homeinsta.php'; ?>
<?php require 'blog.php'; ?>
<?php require 'dichvu.php'; ?>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Coupon Signup
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: 'Inter', sans-serif;
    }
  </style>
 </head>
 <body class="bg-[#f3f5f8]">
  <section class="relative overflow-hidden">
   <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16 py-20 md:py-24 flex flex-col md:flex-row items-center gap-10 md:gap-20" style="clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%)">
    <div class="flex-1 max-w-lg">
     <h2 class="text-[#1a1a1a] text-2xl md:text-3xl font-semibold leading-tight mb-2">
      Nhận ưu đãi và coupon mới nhất!
     </h2>
     <p class="text-[#9ca3af] text-sm mb-6">
      Chúng tôi cam kết bảo mật không lộ thông tin của bạn.
     </p>
     <form class="flex gap-2">
      <input class="flex-grow rounded border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Nhập email của bạn " type="text"/>
      <button class="bg-[#e3642a] text-white font-semibold text-xs uppercase px-5 py-2 rounded" type="submit">
       Đăng ký
      </button>
     </form>
    </div>
    <div class="flex-1 flex justify-center md:justify-end">
     <img alt="Corner sofa with brown cushions and wooden base on white background" class="max-w-full h-auto" height="200" src="images/uudai.jpg" width="400"/>
    </div>
   </div>
  </section>
 </body>
</html>


<?php require 'footerindex.php'; ?>
