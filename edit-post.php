<?php
require 'database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: news-management.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch();

if (!$post) {
    echo "Bài viết không tồn tại.";
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image = $post['image']; // giữ ảnh cũ nếu không upload mới

    $uploadDir = 'image/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['image']['name'])) {
        $imageType = $_FILES['image']['type'];
        $imageSize = $_FILES['image']['size'];

        if (!in_array($imageType, $allowedTypes)) {
            $error = "Chỉ hỗ trợ ảnh JPG, PNG, WEBP.";
        } elseif ($imageSize > $maxFileSize) {
            $error = "Ảnh quá lớn. Vui lòng chọn ảnh dưới 2MB.";
        } else {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image = 'image/' . $imageName; // Lưu đường dẫn từ gốc website
            } else {
                $error = "Không thể upload ảnh mới.";
            }
        }
    }

    if (empty($error) && $title && $description) {
        $stmt = $pdo->prepare("UPDATE posts SET title = :title, description = :description, image = :image WHERE id = :id");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'id' => $id
        ]);
        header('Location: news-management.php');
        exit;
    } elseif (empty($error)) {
        $error = "Vui lòng nhập đầy đủ tiêu đề và nội dung.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa Bài Viết</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Sửa Bài Viết</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>"
                    required>
            </div>
            <div class="mb-3">
                <label>Nội dung</label>
                <textarea name="description" class="form-control" rows="6"
                    required><?= htmlspecialchars($post['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label>Ảnh hiện tại</label><br>
                <?php if ($post['image']): ?>
                    <img src="../<?= $post['image'] ?>" alt="Ảnh bài viết" style="max-height: 150px;">
                <?php else: ?>
                    <p>Không có ảnh.</p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label>Thay ảnh mới (tuỳ chọn)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="news-management.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>

</html>