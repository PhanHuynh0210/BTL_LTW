<?php
require 'database.php';

function generateSlug($string)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return $slug;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $published_at = date('Y-m-d H:i:s');
    $slug = generateSlug($title);

    $image = null;
    // Nếu file xử lý nằm trong thư mục admin, thì cần ../ để upload ra ngoài
    $uploadDir = '../image/';
    $imagePathInDb = null;

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['image']['name'])) {
        $imageType = $_FILES['image']['type'];
        $imageSize = $_FILES['image']['size'];

        if (!in_array($imageType, $allowedTypes)) {
            $error = "Chỉ hỗ trợ các định dạng ảnh JPG, PNG, WEBP.";
        } elseif ($imageSize > $maxFileSize) {
            $error = "Ảnh quá lớn. Vui lòng chọn ảnh nhỏ hơn 2MB.";
        } else {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Lưu đường dẫn tương đối từ gốc website để hiển thị
                $imagePathInDb = 'image/' . $imageName;
            } else {
                $error = "Không thể upload ảnh.";
            }
        }
    }

    if (empty($error) && $title && $description) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, slug, description, image, published_at) 
                               VALUES (:title, :slug, :description, :image, :published_at)");
        $stmt->execute([
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'image' => $imagePathInDb,
            'published_at' => $published_at
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
    <title>Thêm Bài Viết</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Thêm Bài Viết</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nội dung</label>
                <textarea name="description" class="form-control" rows="6" required></textarea>
            </div>
            <div class="mb-3">
                <label>Hình ảnh</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Thêm</button>
            <a href="news-management.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>

</html>