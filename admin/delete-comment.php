<?php
require 'database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
header('Location: news-management.php');
exit;
