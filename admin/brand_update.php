<?php
require '../database.php';

// Ensure the brand ID is passed in the URL
if (isset($_GET['id'])) {
    $brandId = $_GET['id'];

    // Retrieve the current details of the brand
    $sql = "SELECT * FROM phone_brands WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brandId]);
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$brand) {
        echo "Brand not found.";
        exit;
    }

    // Get the images associated with the brand
    $sql = "SELECT * FROM brand_images WHERE brand_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brandId]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "No brand ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Store</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="components/header.css">
</head>

<body>
    <div class="container py-5">
        <h1 class="mb-4 text-center">Update Brand</h1>

        <!-- Update Form -->
        <form action="brand_update_process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="brand_id" value="<?= $brand['id'] ?>">

            <!-- Brand Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($brand['name']) ?>" required>
            </div>

            <!-- Brand Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Brand Description</label>
                <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($brand['description']) ?></textarea>
            </div>

            <!-- Current Images -->
            <div class="mb-3">
                <h5>Current Images</h5>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($images as $image): ?>
                        <div class="position-relative">
                            <img src="<?= '../' . htmlspecialchars($image['image_path']) ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            <input type="checkbox" name="delete_images[]" value="<?= $image['id'] ?>" class="position-absolute top-0 end-0" onclick="return confirm('Are you sure you want to delete this image?')">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- New Images -->
            <div class="mb-3">
                <label for="images" class="form-label">Upload New Images (Optional)</label>
                <input type="file" class="form-control" name="images[]" multiple accept="image/*">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Brand</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>