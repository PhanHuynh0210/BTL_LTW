<?php
require 'database.php';
$sql = "SELECT * FROM banner";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$carouselImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Fetch all brands
$stmt = $pdo->query("SELECT * FROM phone_brands");
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all images grouped by brand_id
$stmt = $pdo->query("SELECT * FROM brand_images");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group images by brand_id
$imagesByBrand = [];
foreach ($images as $img) {
    $imagesByBrand[$img['brand_id']][] = $img['image_path'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page Controller</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-md-10 content">
                <h1>Welcome to the Main Page Controller</h1>
                <div class="container my-4">
                    <h2 class="mb-4">Carousel Manager</h2>

                    <!-- Upload New -->
                    <form action="admin/banner_upload.php" method="POST" enctype="multipart/form-data" class="mb-4">
                        <div class="mb-2">
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <input type="text" name="alt_text" class="form-control" placeholder="Alt text" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload New Slide</button>
                    </form>

                    <!-- Existing Banners -->
                    <div class="row">
                        <?php foreach ($carouselImages as $image): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow">
                                    <img src="<?= htmlspecialchars($image['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($image['alt_text']) ?>">
                                    <div class="card-body">
                                        <form action="admin/banner_update.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $image['id'] ?>">

                                            <div class="mb-2">
                                                <input type="text" name="alt_text" value="<?= htmlspecialchars($image['alt_text']) ?>" class="form-control">
                                            </div>

                                            <div class="mb-2">
                                                <input type="file" name="image" class="form-control">
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                <a href="admin/banner_delete.php?id=<?= $image['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this image?')">Delete</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Banner-carousel -->
                <div class="banner-carousel">
                    <div id="banner-carousel" class="carousel slide" data-bs-ride="carousel">

                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            <?php foreach ($carouselImages as $index => $image): ?>
                                <button type="button"
                                    data-bs-target="#banner-carousel"
                                    data-bs-slide-to="<?= $index ?>"
                                    <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>
                                    aria-label="Slide <?= $index + 1 ?>"></button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <?php foreach ($carouselImages as $index => $image): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($image['image_path']) ?>"
                                        class="d-block w-100"
                                        alt="<?= htmlspecialchars($image['alt_text']) ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#banner-carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#banner-carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                    </div>
                </div>

                <div class="container py-5">
                    <h1 class="mb-4 text-center">Phone Brands</h1>

                    <!-- Upload Form -->
                    <div class="card p-4 mb-5 shadow">
                        <h4 class="mb-3">➕ Add New Brand</h4>
                        <form action="admin/brand_upload.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Brand Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Upload 3 Images</label>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Brand</button>
                        </form>
                    </div>

                    <!-- Brand Cards -->
                    <div class="row g-4">
                        <?php foreach ($brands as $brand): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow">
                                    <?php if (!empty($imagesByBrand[$brand['id']])): ?>
                                        <img src="<?= htmlspecialchars($imagesByBrand[$brand['id']][0]) ?>" class="card-img-top" style="height: 250px; object-fit: cover;" alt="<?= htmlspecialchars($brand['name']) ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($brand['name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($brand['description']) ?></p>
                                    </div>
                                    <div class="card-footer bg-white border-top">
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <?php foreach (array_slice($imagesByBrand[$brand['id']], 1) as $img): ?>
                                                <img src="<?= htmlspecialchars($img) ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <a href="admin/brand_update.php?id=<?= $brand['id'] ?>" class="btn btn-sm btn-success">Update</a>
                                            <a href="admin/brand_delete.php?id=<?= $brand['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this brand and its images?')">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>