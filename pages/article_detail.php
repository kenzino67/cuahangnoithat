<?php
include_once 'db.php';

if (!isset($_GET['slug'])) {
    header("Location: articles.php");
    exit;
}

$slug = $_GET['slug'];
$stmt = $conn->prepare("SELECT * FROM bai_viet WHERE duong_dan = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Bài viết không tồn tại.";
    exit;
}

$article = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article['tieu_de']) ?></title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h1 {
            color: #222;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .meta {
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
            border-radius: 5px;
        }

        .content {
            font-size: 17px;
            white-space: pre-line;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .back-link:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($article['tieu_de']) ?></h1>
        <div class="meta">
            <p>Ngày đăng: <?= date('d/m/Y', strtotime($article['ngay_dang'])) ?></p>
            <p>Tác giả: <?= htmlspecialchars($article['tac_gia'] ?? 'Không rõ') ?></p>
            <p>Chuyên mục: <?= htmlspecialchars($article['chuyen_muc'] ?? 'Chưa phân loại') ?></p>
        </div>
        <img src="<?= htmlspecialchars($article['anh_dai_dien']) ?>" alt="Ảnh đại diện bài viết">
        <div class="content"><?= nl2br(htmlspecialchars($article['noi_dung'])) ?></div>
        <a href="articles.php" class="back-link">← Quay lại danh sách</a>
    </div>
</body>
</html>
