<?php
require 'database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("SELECT image FROM posts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch();
    if ($post && $post['image'] && file_exists($post['image'])) {
        unlink($post['image']); // Xóa ảnh nếu tồn tại
    }

    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
header('Location: news-management.php');
exit;
