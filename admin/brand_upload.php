<?php
require '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['images'])) {
    $uploadDir = '../assets/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    $uploadedImages = [];

    // Loop through all uploaded files
    for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
        // Skip if no file selected
        if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) {
            echo "Error uploading image " . ($i + 1);
            exit;
        }

        $tmpName = $_FILES['images']['tmp_name'][$i];
        $originalName = basename($_FILES['images']['name'][$i]);
        $fileSize = $_FILES['images']['size'][$i];
        $mimeType = mime_content_type($tmpName);

        // Check MIME type
        if (!in_array($mimeType, $allowedTypes)) {
            echo "Invalid file type for image " . ($i + 1) . ". Only JPG, PNG, GIF, and WEBP are allowed.";
            exit;
        }

        // Check file size
        if ($fileSize > $maxFileSize) {
            echo "File size for image " . ($i + 1) . " exceeds 2MB.";
            exit;
        }

        // Create a unique filename
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid("brand_img_", true) . '.' . $extension;

        $uploadPath = $uploadDir . $uniqueName;
        $dbPath = 'assets/' . $uniqueName;

        // Move the file
        if (move_uploaded_file($tmpName, $uploadPath)) {
            $uploadedImages[] = $dbPath;
        } else {
            echo "Failed to move uploaded file for image " . ($i + 1);
            exit;
        }
    }

    // Sanitize inputs
    $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8');

    // Insert brand record
    $sql = "INSERT INTO phone_brands (name, description) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $description]);

    $brandId = $pdo->lastInsertId();

    // Insert image paths
    $sql = "INSERT INTO brand_images (brand_id, image_path) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    foreach ($uploadedImages as $imagePath) {
        $stmt->execute([$brandId, $imagePath]);
    }

    header("Location: ../mainpage.controller.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
