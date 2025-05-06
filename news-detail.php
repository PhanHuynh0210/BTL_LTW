<?php
require 'database.php';
session_start();

$id = $_GET['id'] ?? 0;

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();
$message = '';
$name_value = '';
$comment_value = '';
$rating_value = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['customer_name'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $rating = (int) ($_POST['rating'] ?? 0);
    $captcha = $_POST['captcha'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    $name_value = htmlspecialchars($name);
    $comment_value = htmlspecialchars($comment);
    $rating_value = $rating;

    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        $message = "<div class='alert alert-danger'>Yêu cầu không hợp lệ.</div>";
    } elseif (strtolower($captcha) !== strtolower($_SESSION['captcha'] ?? '')) {
        $message = "<div class='alert alert-danger'>Mã xác nhận không đúng.</div>";
    } elseif ($name && $comment && $rating >= 1 && $rating <= 5) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, customer_name, comment, rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $name, $comment, $rating]);
        $message = "<div class='alert alert-success'>Cảm ơn bạn đã đánh giá!</div>";
        $name_value = $comment_value = '';
        $rating_value = '';
    } else {
        $message = "<div class='alert alert-danger'>Vui lòng điền đầy đủ tên, nội dung và chọn số sao hợp lệ.</div>";
    }
}

// Lấy tất cả bình luận
$stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
$stmt->execute([$id]);
$comments = $stmt->fetchAll();

// Tính trung bình sao
$stmt = $pdo->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM comments WHERE post_id = ?");
$stmt->execute([$id]);
$rating_data = $stmt->fetch();
$avg_rating = round($rating_data['avg_rating'], 1);
$total_reviews = $rating_data['total'];

// CAPTCHA
$captcha_text = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5);
$_SESSION['captcha'] = $captcha_text;

if (!$post) {
    echo "<div class='alert alert-danger text-center m-5'>Bài viết không tồn tại!</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - Chi tiết bài viết</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="components/header.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .news-container {
            max-width: 880px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .news-title {
            font-size: 2.4rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .news-meta {
            font-size: 0.95rem;
            color: #777;
            margin-bottom: 20px;
        }

        .news-image {
            border-radius: 8px;
            width: 100%;
            object-fit: cover;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .news-content {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .comments-section {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            margin-top: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .comments-section h4,
        .comments-section h5 {
            font-weight: 600;
        }

        .comment-block {
            border: 1px solid #dee2e6;
            border-left: 5px solid #0d6efd;
            padding: 15px;
            background-color: #fdfdfd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        textarea {
            resize: vertical;
        }

        @media (max-width: 575.98px) {
            .news-title {
                font-size: 1.75rem;
            }

            .news-content {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <?php include("components/header.php"); ?>
    <div class="container news-container">
        <h1 class="news-title"><?= htmlspecialchars($post['title']) ?></h1>
        <p class="news-meta">
            <i class="fa fa-calendar-alt"></i> <?= date("d/m/Y", strtotime($post['published_at'])) ?>
        </p>
        <?php if ($total_reviews > 0): ?>
            <p class="mb-3 text-muted">
                ⭐ <?= $avg_rating ?> / 5 (<?= $total_reviews ?> đánh giá)
            </p>
        <?php endif; ?>
        <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
            class="img-fluid news-image">
        <div class="news-content">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>
        <a href="news.php" class="btn btn-secondary mt-3">
            <i class="fa fa-arrow-left"></i> Quay về danh sách
        </a>
    </div>
    <div class="container comments-section">
        <h4 class="mb-4">Đánh giá & Bình luận</h4>
        <?= $message ?>
        <form method="POST" class="mb-5">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Tên bạn:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name"
                    value="<?= $name_value ?>" required>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Nội dung:</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"
                    required><?= $comment_value ?></textarea>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Xếp hạng (1 - 5 🌟):</label>
                <select class="form-select" id="rating" name="rating" required>
                    <option value="">-- Chọn sao đánh giá --</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>" <?= $rating_value == $i ? 'selected' : '' ?>><?= $i ?> ⭐</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="captcha" class="form-label">Mã xác nhận:
                    <strong><?= $_SESSION['captcha'] ?></strong></label>
                <input type="text" class="form-control" id="captcha" name="captcha" required>
            </div>
            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
        </form>

        <?php if (!empty($comments)): ?>
            <h5 class="mb-4">Bình luận từ khách hàng:</h5>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-block">
                    <strong><?= htmlspecialchars($comment['customer_name']) ?></strong>
                    <small class="text-muted ms-2">
                        (<?= date("d/m/Y H:i", strtotime($comment['created_at'])) ?>)
                    </small>
                    <div class="my-2">
                        <?php for ($i = 1; $i <= $comment['rating']; $i++): ?>
                            <i class="fa fa-star text-warning"></i>
                        <?php endfor; ?>
                        <?php for ($i = $comment['rating'] + 1; $i <= 5; $i++): ?>
                            <i class="fa fa-star text-secondary"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mb-0"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Chưa có bình luận nào, hãy là người đầu tiên!</p>
        <?php endif; ?>
    </div>
    <?php include("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>