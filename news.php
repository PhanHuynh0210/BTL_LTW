<?php
require 'database.php';

// Thiết lập phân trang
$posts_per_page = 6; // Số bài viết trên mỗi trang
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Đảm bảo trang không âm
$offset = ($current_page - 1) * $posts_per_page;

// Xử lý tìm kiếm an toàn
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Xây dựng câu truy vấn
$sql = "SELECT * FROM posts";
$params = [];

if (!empty($search)) {
    $sql .= " WHERE title LIKE :keyword OR description LIKE :keyword";
    $params['keyword'] = "%$search%";
}

// Thêm sắp xếp
switch ($sort) {
    case 'oldest':
        $sql .= " ORDER BY published_at ASC";
        break;
    case 'title_asc':
        $sql .= " ORDER BY title ASC";
        break;
    case 'title_desc':
        $sql .= " ORDER BY title DESC";
        break;
    case 'newest':
    default:
        $sql .= " ORDER BY published_at DESC";
        break;
}

// Thêm phân trang
$sql_count = str_replace("SELECT *", "SELECT COUNT(*)", $sql);
$count_stmt = $pdo->prepare($sql_count);
$count_stmt->execute($params);
$total_posts = $count_stmt->fetchColumn();
$total_pages = ceil($total_posts / $posts_per_page);

// Thêm LIMIT cho phân trang
$sql .= " LIMIT :offset, :limit";
$params['offset'] = $offset;
$params['limit'] = $posts_per_page;

// Thực thi truy vấn
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $stmt->bindValue($key, $value, $type);
}
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hàm rút gọn nội dung
function truncateText($text, $limit = 100) {
    if (mb_strlen($text) <= $limit) return $text;
    return mb_substr($text, 0, $limit) . '...';
}

// Hàm định dạng ngày
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức - Danh Sách Bài Viết</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="components/header.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.15rem;
            font-weight: bold;
            min-height: 3rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-text {
            min-height: 4.5rem;
            overflow: hidden;
        }
        .date-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0,0,0,0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        .pagination {
            justify-content: center;
        }
    </style>
</head>

<body>
    <?php include("components/header.php"); ?>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Danh Sách Bài Viết</h2>
        
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm bài viết..."
                            value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm</button>
                    </div>
                    <?php if (!empty($search)): ?>
                        <a href="news.php" class="btn btn-outline-secondary ms-2">Xóa bộ lọc</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-md-4">
                <form method="GET" id="sortForm" class="d-flex justify-content-end">
                    <?php if (!empty($search)): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <?php endif; ?>
                    <select name="sort" class="form-select" onchange="document.getElementById('sortForm').submit()">
                        <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                        <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Cũ nhất</option>
                        <option value="title_asc" <?php echo $sort === 'title_asc' ? 'selected' : ''; ?>>Tiêu đề (A-Z)</option>
                        <option value="title_desc" <?php echo $sort === 'title_desc' ? 'selected' : ''; ?>>Tiêu đề (Z-A)</option>
                    </select>
                </form>
            </div>
        </div>

        <?php if (!empty($search)): ?>
            <div class="alert alert-info">
                Kết quả tìm kiếm cho: <strong><?php echo htmlspecialchars($search); ?></strong>
                <span class="badge bg-secondary"><?php echo $total_posts; ?> bài viết</span>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if (empty($posts)): ?>
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-circle me-2"></i>
                        Không tìm thấy bài viết nào! Vui lòng thử tìm kiếm khác.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                <img src="<?= htmlspecialchars($post['image']) ?>" class="card-img-top"
                                    alt="<?= htmlspecialchars($post['title']) ?>">
                                <?php if (isset($post['published_at'])): ?>
                                <span class="date-badge">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= formatDate($post['published_at']) ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                                <p class="card-text"><?= truncateText(htmlspecialchars($post['description']), 120) ?></p>
                                <a href="news-detail.php?id=<?= $post['id'] ?>" class="btn btn-outline-primary mt-auto">
                                    <i class="fas fa-book-reader me-1"></i> Đọc thêm
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($sort) ? '&sort=' . urlencode($sort) : '' ?>">
                                <i class="fas fa-chevron-left"></i> Trước
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $start_page + 4);
                    if ($end_page - $start_page < 4) {
                        $start_page = max(1, $end_page - 4);
                    }
                    
                    for ($i = $start_page; $i <= $end_page; $i++): 
                    ?>
                        <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($sort) ? '&sort=' . urlencode($sort) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($sort) ? '&sort=' . urlencode($sort) : '' ?>">
                                Tiếp <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
    <?php include("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>