<?php
require 'database.php';
// Post search
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

$postStmt = $pdo->prepare($postSql);
$postStmt->execute($params);
$posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);

// Post dropdown for filtering
$allPostsSql = "SELECT id, title FROM posts ORDER BY title";
$allPosts = $pdo->query($allPostsSql)->fetchAll(PDO::FETCH_ASSOC);

// Comment filters
$filterPost = filter_input(INPUT_GET, 'post', FILTER_VALIDATE_INT);
$filterRating = filter_input(INPUT_GET, 'rating', FILTER_VALIDATE_INT);
$filterComment = filter_input(INPUT_GET, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Pagination
$commentsPerPage = 5;
$page = max(1, (int) filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT));
$offset = ($page - 1) * $commentsPerPage;

// Build comment query with filters
$commentSql = "SELECT c.*, p.title AS post_title 
               FROM comments c
               JOIN posts p ON c.post_id = p.id 
               WHERE 1=1";
$commentParams = [];
$countSql = "SELECT COUNT(*) FROM comments c JOIN posts p ON c.post_id = p.id WHERE 1=1";

// Apply filters to both queries
if ($filterPost) {
    $filterCondition = " AND p.id = :post_id";
    $commentSql .= $filterCondition;
    $countSql .= $filterCondition;
    $commentParams['post_id'] = $filterPost;
}
if ($filterRating) {
    $filterCondition = " AND c.rating = :rating";
    $commentSql .= $filterCondition;
    $countSql .= $filterCondition;
    $commentParams['rating'] = $filterRating;
}
if (!empty($filterComment)) {
    $filterCondition = " AND c.comment LIKE :comment";
    $commentSql .= $filterCondition;
    $countSql .= $filterCondition;
    $commentParams['comment'] = '%' . $filterComment . '%';
}

// Get filtered comment count
$countStmt = $pdo->prepare($countSql);
foreach ($commentParams as $key => $val) {
    $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $countStmt->bindValue(":$key", $val, $type);
}
$countStmt->execute();
$filteredCommentCount = $countStmt->fetchColumn();

// Calculate pagination based on filtered comments
$totalPages = ceil($filteredCommentCount / $commentsPerPage);

// Finalize and execute comments query
$commentSql .= " ORDER BY c.id DESC LIMIT :limit OFFSET :offset";
$commentParams['limit'] = $commentsPerPage;
$commentParams['offset'] = $offset;

$commentStmt = $pdo->prepare($commentSql);
foreach ($commentParams as $key => $val) {
    $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $commentStmt->bindValue(":$key", $val, $type);
}
$commentStmt->execute();
$comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

// Get total comment count (unfiltered) for stats
$totalComments = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();

// Average rating
$avgRatingStmt = $pdo->query("SELECT AVG(rating) AS average_rating FROM comments");
$avgRating = $avgRatingStmt->fetch(PDO::FETCH_ASSOC)['average_rating'];

// Generate CSRF token for forms
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Tin tức - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }

        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #212529;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #0d6efd;
        }

        .main {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }

        .stats-icon {
            font-size: 1.5rem;
            padding: 10px;
            border-radius: 50%;
            color: white;
        }

        .stats-icon.purple {
            background-color: #6f42c1;
        }

        .stats-icon.blue {
            background-color: #0d6efd;
        }

        .stats-icon.green {
            background-color: #198754;
        }
    </style>
</head>

<body>
    <?php include("sidebar.php") ?>
    <div class="main">
        <h3 class="mb-4">Quản lý Tin tức</h3>

        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon purple me-3">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted">Tổng số bài viết</p>
                            <h5><?= count($posts) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon blue me-3">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted">Tổng bình luận</p>
                            <h5><?= $totalComments ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon green me-3">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted">Đánh giá trung bình</p>
                            <h5><?= $avgRating ? number_format($avgRating, 1) . ' ⭐' : 'Chưa có' ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts List -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Danh sách bài viết</h5>
                <a href="add-post.php" class="btn btn-primary btn-sm">+ Thêm bài viết</a>
            </div>
            <div class="card-body">
                <form class="input-group mb-3" method="GET" id="searchForm">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm bài viết..."
                        value="<?= htmlspecialchars($search) ?>" autocomplete="off">
                    <button class="btn btn-outline-primary" type="submit">Tìm</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Đánh giá</th>
                                <th>Ngày đăng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="postTableBody">
                            <!-- Content loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
                <div id="loading-indicator" class="text-center d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Bình luận và Đánh giá</h5>
            </div>
            <div class="card-body">
                <form class="row g-2 mb-3" method="GET" id="filterForm">
                    <!-- Preserve search parameter if exists -->
                    <?php if (!empty($search)): ?>
                        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                    <?php endif; ?>

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
                                <option value="<?= $i ?>" <?= $filterRating == $i ? 'selected' : '' ?>><?= $i ?> sao</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="comment" class="form-control" placeholder="Tìm nội dung bình luận"
                            value="<?= htmlspecialchars($filterComment) ?>">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">Lọc</button>
                    </div>
                </form>

                <!-- Show filter stats if any filters are applied -->
                <?php if ($filterPost || $filterRating || !empty($filterComment)): ?>
                    <div class="alert alert-info">
                        Hiển thị <?= $filteredCommentCount ?> bình luận phù hợp với bộ lọc
                        <a href="?<?= !empty($search) ? 'search=' . urlencode($search) : '' ?>"
                            class="ms-2 btn btn-sm btn-outline-secondary">
                            Xóa bộ lọc
                        </a>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped">
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
                                    <td><?= str_repeat('⭐', intval($comment['rating'])) ?></td>
                                    <td>
                                        <form method="POST" action="delete-comment.php" class="d-inline"
                                            onsubmit="return confirm('Xoá bình luận này?')">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                                    &laquo; Trước
                                </a>
                            </li>

                            <?php
                            // Show limited page numbers with ellipsis
                            $startPage = max(1, min($page - 2, $totalPages - 4));
                            $endPage = min($totalPages, max(5, $page + 2));

                            if ($startPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>"><?= $totalPages ?></a>
                                </li>
                            <?php endif; ?>

                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                                    Tiếp &raquo;
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-muted text-center mt-5">
            <p>2024 &copy; Quản lý Tin Tức</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput = document.querySelector('input[name="search"]');
        const loadingIndicator = document.getElementById('loading-indicator');
        let typingTimer;
        const debounceDelay = 400;

        fetchPosts(searchInput.value);

        searchInput.addEventListener('input', function () {
            clearTimeout(typingTimer);
            loadingIndicator.classList.remove('d-none');

            typingTimer = setTimeout(() => {
                fetchPosts(this.value);
            }, debounceDelay);
        });

        function fetchPosts(searchValue) {
            fetch(`search-posts.php?search=${encodeURIComponent(searchValue)}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('postTableBody').innerHTML = data;
                    loadingIndicator.classList.add('d-none');
                })
                .catch(error => {
                    console.error('Error fetching posts:', error);
                    loadingIndicator.classList.add('d-none');
                });
        }

        document.querySelectorAll('#filterForm select').forEach(select => {
            select.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
</body>

</html>