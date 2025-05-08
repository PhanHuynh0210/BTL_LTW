<?php
require '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['brand_id'])) {
    $brandId = $_POST['brand_id'];

    // Sanitize text inputs to prevent XSS
    $brandName = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $brandDescription = htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8');

    // Update brand details
    $sql = "UPDATE phone_brands SET name = ?, description = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brandName, $brandDescription, $brandId]);

    // Delete selected images securely
    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $imageId) {
            $sql = "SELECT image_path FROM brand_images WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$imageId]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($image) {
                $imagePath = '../' . $image['image_path'];
                if (is_file($imagePath)) {
                    unlink($imagePath); // Physically delete the file
                }

                // Remove image record from DB
                $sql = "DELETE FROM brand_images WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$imageId]);
            }
        }
    }

    // Handle new image uploads securely
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $uploadDir = '../assets/';

        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            $originalName = $_FILES['images']['name'][$index];
            $fileSize = $_FILES['images']['size'][$index];
            $error = $_FILES['images']['error'][$index];

            if ($error !== UPLOAD_ERR_OK) {
                echo "Upload error with file: $originalName";
                exit;
            }

            // Validate MIME type
            $mimeType = mime_content_type($tmpName);
            if (!in_array($mimeType, $allowedTypes)) {
                echo "Invalid file type for image: $originalName";
                exit;
            }

            // Validate file size
            if ($fileSize > $maxFileSize) {
                echo "File too large: $originalName";
                exit;
            }

            // Generate unique filename
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $uniqueName = uniqid("brand_img_", true) . '.' . $extension;

            $uploadPath = $uploadDir . $uniqueName;
            $dbPath = 'assets/' . $uniqueName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                // Insert image path into database
                $sql = "INSERT INTO brand_images (brand_id, image_path) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$brandId, $dbPath]);
            } else {
                echo "Failed to move uploaded file: $originalName";
                exit;
            }
        }
    }

    header("Location: ../mainpage.controller.php");
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>
