<?php
require 'database.php';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT * FROM posts";

if (!empty($search)) {
    $sql .= " WHERE title LIKE :keyword OR description LIKE :keyword";
}
$stmt = $pdo->prepare($sql);

if (!empty($search)) {
    $stmt->execute(['keyword' => "%$search%"]);
} else {
    $stmt->execute();
}

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức - Danh Sách Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="components/header.css">
</head>

<body>
    <?php include("components/header.php"); ?>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Danh Sách Bài Viết</h2>
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm bài viết..."
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm</button>
            </div>
        </form>

        <div class="row">
            <?php if (empty($posts)): ?>
                <div class="col-12">
                    <p class="text-danger">Không tìm thấy bài viết nào!</p>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($post['image']) ?>" class="card-img-top"
                                alt="<?= htmlspecialchars($post['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($post['description']) ?></p>
                                <a href="news-detail.php?id=<?= $post['id'] ?>" class="btn btn-outline-primary mt-auto">Đọc
                                    thêm</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    <?php include("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>