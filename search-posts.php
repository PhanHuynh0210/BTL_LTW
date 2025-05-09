<?php
require 'database.php';

// Lấy chuỗi tìm kiếm từ GET
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$search = trim($search);

// Khởi tạo SQL cơ bản
$postSql = "SELECT * FROM posts";
$params = [];

// Nếu có từ khóa tìm kiếm
if (!empty($search)) {
    $postSql .= " WHERE title LIKE :keyword ESCAPE '\\\\' OR description LIKE :keyword ESCAPE '\\\\'";
    $escaped = str_replace(['%', '_'], ['\%', '\_'], $search);
    $params['keyword'] = "%$escaped%";
}

try {
    $postStmt = $pdo->prepare($postSql);
    $postStmt->execute($params);
    $posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<tr><td colspan="4" class="text-danger">Lỗi truy vấn: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
    exit;
}

// Xuất kết quả HTML
if (!empty($posts)):
    foreach ($posts as $post): ?>
        <tr>
            <td><?= htmlspecialchars($post['title']) ?></td>
            <td><?= htmlspecialchars($post['avg_rating'] ?? 'Chưa có') ?></td>
            <td><?= date('d/m/Y', strtotime($post['published_at'])) ?></td>
            <td>
                <a href="edit-post.php?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="delete-post.php?id=<?= $post['id'] ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc muốn xoá?')">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach;

else: ?>
    <tr>
        <td colspan="4" class="text-center">Không có bài viết nào.</td>
    </tr>
<?php endif; ?>