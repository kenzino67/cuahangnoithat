<?php
include_once 'header.php'; // Header chung
include_once 'db.php';     // Kết nối CSDL mysqli

// Truy vấn tất cả bài viết
$result = $conn->query("SELECT * FROM bai_viet ORDER BY ngay_dang DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tin tức</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    body { font-family: "Roboto", sans-serif; }
  </style>
</head>
<body class="bg-[#f5f5f5]">

<div class="max-w-[1200px] mx-auto">
  <!-- Header -->
  <header class="pt-10 pb-6 px-6"
    <h1 class="text-[20px] font-semibold text-[#1a1a1a] mb-1">Tin tức</h1>
    <p class="text-[12px] text-[#4a4a4a]">Trang chủ / Blog - Tin tức</p>
  </header>

  <!-- Main Content -->
  <main class="px-6 pb-10 grid grid-cols-1 lg:grid-cols-12 gap-6">
    <section class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
      <?php while ($row = $result->fetch_assoc()): ?>
        <article class="bg-white rounded-md p-4 shadow-sm max-w-[100%] min-h-[320px] transition hover:shadow-md">
          <a href="article_detail.php?slug=<?= htmlspecialchars($row['duong_dan']) ?>">
            <img src="<?= htmlspecialchars($row['anh_dai_dien']) ?>"
                 alt="<?= htmlspecialchars($row['tieu_de']) ?>"
                 class="rounded-md mb-3 w-full h-40 object-cover"/>
            <h2 class="text-[15px] text-[#1a1a1a] mb-1 font-normal leading-tight">
              <?= htmlspecialchars($row['tieu_de']) ?>
            </h2>
            <p class="text-[11px] text-[#d35400] mb-2 font-semibold leading-none">
              <?= date('d/m/Y H:i', strtotime($row['ngay_dang'])) ?> / F1GENZ
            </p>
            <p class="text-[11px] text-[#4a4a4a] leading-tight line-clamp-3">
              <?= htmlspecialchars(mb_substr(strip_tags($row['noi_dung']), 0, 120)) ?>...
            </p>
          </a>
        </article>
      <?php endwhile; ?>
    </section>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-6">
      <section>
        <h3 class="text-[13px] font-semibold text-[#d35400] flex items-center gap-1 mb-3">
          <i class="fas fa-pen"></i> ĐỪNG BỎ LỠ.
        </h3>
        <ol class="space-y-2 text-[11px] text-[#4a4a4a]">
          <?php
          $result2 = $conn->query("SELECT * FROM bai_viet ORDER BY ngay_dang DESC LIMIT 4");
          $i = 1;
          while ($row = $result2->fetch_assoc()):
          ?>
            <li class="flex gap-2 items-center">
              <span class="bg-[#d35400] text-white text-[10px] font-semibold w-5 h-5 flex items-center justify-center rounded-sm select-none">
                <?= $i ?>
              </span>
              <img src="<?= htmlspecialchars($row['anh_dai_dien']) ?>" alt="" class="w-[60px] h-[40px] object-cover rounded-sm">
              <a class="hover:underline truncate max-w-[180px]" href="article_detail.php?slug=<?= htmlspecialchars($row['duong_dan']) ?>">
                <?= htmlspecialchars($row['tieu_de']) ?>
              </a>
            </li>
          <?php $i++; endwhile; ?>
        </ol>
      </section>

<section>
  <h3 class="text-[13px] font-semibold text-[#d35400] border-b border-[#d35400] pb-1 mb-3">DANH MỤC BLOG</h3>
  <ul class="text-[12px] text-[#4a4a4a] space-y-1">
    <?php
    $danh_muc_result = $conn->query("SELECT * FROM danh_muc WHERE danh_muc_cha IS NULL");
    while ($dm = $danh_muc_result->fetch_assoc()):
    ?>
      <li class="border border-[#e5e5e5] px-3 py-1 flex justify-between items-center cursor-pointer">
        <?= htmlspecialchars($dm['ten_danh_muc']) ?>
        <i class="fas fa-chevron-right text-[#bfbfbf]"></i>
      </li>
    <?php endwhile; ?>
  </ul>
</section>


      <section>
        <h3 class="text-[13px] font-semibold text-[#d35400] flex items-center gap-1 mb-3">
          <i class="fas fa-pen"></i> BẠN CẦN TƯ VẤN?
        </h3>
        <img src="images/blog1.jpg" alt="Tư vấn" class="rounded-md w-full">
      </section>
    </aside>
  </main>
</div>

<?php include_once 'footerindex.php'; ?>
</body>
</html>
