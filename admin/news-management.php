<?php
require 'database.php';

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$search = trim($search);

$params = [];

if (!empty($search)) {
    $escaped = str_replace(['%', '_'], ['\%', '\_'], $search);
    $postSql = "SELECT * FROM posts 
                WHERE title LIKE :keyword ESCAPE '\\\\' 
                   OR description LIKE :keyword ESCAPE '\\\\'";
    $params['keyword'] = "%$escaped%";
} else {
    $postSql = "SELECT * FROM posts";
}

try {
    $postStmt = $pdo->prepare($postSql);
    $postStmt->execute($params);
    $posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi SQL: " . $e->getMessage();
    exit;
}

$postStmt = $pdo->prepare($postSql);
$postStmt->execute($params);
$posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);

// Danh sách bài viết cho dropdown
$allPosts = $pdo->query("SELECT id, title FROM posts ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);

// Bộ lọc bình luận
$filterPost = filter_input(INPUT_GET, 'post', FILTER_VALIDATE_INT);
$filterRating = filter_input(INPUT_GET, 'rating', FILTER_VALIDATE_INT);
$filterComment = filter_input(INPUT_GET, 'comment', FILTER_SANITIZE_STRING);

// Truy vấn bình luận có điều kiện lọc
$commentSql = "SELECT comments.*, posts.title AS post_title 
               FROM comments 
               JOIN posts ON comments.post_id = posts.id 
               WHERE 1=1";
$commentParams = [];

if ($filterPost) {
    $commentSql .= " AND posts.id = :post_id";
    $commentParams['post_id'] = $filterPost;
}
if ($filterRating) {
    $commentSql .= " AND comments.rating = :rating";
    $commentParams['rating'] = $filterRating;
}
if (!empty($filterComment)) {
    $commentSql .= " AND comments.comment LIKE :comment";
    $commentParams['comment'] = '%' . $filterComment . '%';
}
$commentSql .= " ORDER BY comments.id DESC";

$commentStmt = $pdo->prepare($commentSql);
$commentStmt->execute($commentParams);
$comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Tin tức - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="iconly.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="logo">
                        <a href="index.html">
                            <h5>DIDONGTHONGMINH</h5>
                        </a>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item active">
                            <a href="news-management.php" class="sidebar-link">
                                <i class="bi bi-journal-text"></i>
                                <span>Quản lý Tin tức</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="logout.php" class="sidebar-link">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-list fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>Quản lý Tin tức</h3>
            </div>

            <div class="page-content">
                <div class="row">
                    <!-- Tổng quan -->
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon purple me-3">
                                    <i class="bi bi-journal-text fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Tổng số bài viết</h6>
                                    <h5 class="mb-0 font-bold"><?= count($posts) ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon blue me-3">
                                    <i class="bi bi-chat-dots-fill fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Tổng bình luận</h6>
                                    <h5 class="mb-0 font-bold"><?= count($comments) ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon green me-3">
                                    <i class="bi bi-star-fill fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Đánh giá trung bình</h6>
                                    <h5 class="mb-0 font-bold">4.5 / 5</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách bài viết -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Danh sách bài viết</h4>
                        <a href="add-post.php" class="btn btn-primary btn-sm">+ Thêm bài viết</a>
                    </div>
                    <div class="card-body">
                        <form class="input-group mb-3" method="GET">
                            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm bài viết..."
                                value="<?= htmlspecialchars($search) ?>">
                            <button class="btn btn-outline-primary" type="submit">Tìm</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Đánh giá</th>
                                        <th>Ngày đăng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="postTableBody">
                                    <!-- nội dung bài viết -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quản lý bình luận -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Bình luận và Đánh giá</h4>
                    </div>
                    <div class="card-body">
                        <!-- Bộ lọc -->
                        <form class="row g-2 mb-3" method="GET">
                            <div class="col-md-4">
                                <select name="post" class="form-select">
                                    <option value="">-- Lọc theo bài viết --</option>
                                    <?php foreach ($allPosts as $p): ?>
                                        <option value="<?= $p['id'] ?>" <?= $filterPost == $p['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="rating" class="form-select">
                                    <option value="">-- Số sao --</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>" <?= $filterRating == $i ? 'selected' : '' ?>><?= $i ?> sao
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="comment" class="form-control"
                                    placeholder="Tìm nội dung bình luận"
                                    value="<?= htmlspecialchars($filterComment) ?>">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary w-100" type="submit">Lọc</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Người dùng</th>
                                        <th>Bài viết</th>
                                        <th>Bình luận</th>
                                        <th>Đánh giá</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comments as $comment): ?>
                                        <tr>
                                            <td>@<?= htmlspecialchars($comment['customer_name']) ?></td>
                                            <td><?= htmlspecialchars($comment['post_title']) ?></td>
                                            <td><?= htmlspecialchars($comment['comment']) ?></td>
                                            <td><?= htmlspecialchars($comment['rating']) ?> ⭐</td>
                                            <td>
                                                <a href="delete-comment.php?id=<?= $comment['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xoá bình luận này?')"><i
                                                        class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($comments)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Không có bình luận nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="mt-5">
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2024 &copy; Quản lý Tin Tức</p>
                    </div>
                    <div class="float-end">
                        <p>Thiết kế bởi <a href="https://github.com/zuramai">Mazer</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        const searchInput = document.querySelector('input[name="search"]');
        let typingTimer;
        const debounceDelay = 400; // milliseconds

        searchInput.addEventListener('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                const searchValue = this.value;

                fetch(`search-posts.php?search=${encodeURIComponent(searchValue)}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('postTableBody').innerHTML = data;
                    });
            }, debounceDelay);
        });
    </script>
</body>

</html>