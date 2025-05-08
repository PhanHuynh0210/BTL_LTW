<?php
require '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['image'])) {
    // Allowed MIME types for images
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB max file size

    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileError = $_FILES['image']['error'];
    $fileSize = $_FILES['image']['size'];
    $fileType = mime_content_type($fileTmpPath);

    // Check for upload error
    if ($fileError !== UPLOAD_ERR_OK) {
        echo "Error during file upload.";
        exit;
    }

    // Validate MIME type
    if (!in_array($fileType, $allowedTypes)) {
        echo "Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.";
        exit;
    }

    // Validate file size
    if ($fileSize > $maxFileSize) {
        echo "File too large. Maximum allowed size is 2MB.";
        exit;
    }

    // Create a unique file name to prevent overwrite
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $safeFileName = uniqid('img_', true) . '.' . $extension;

    $uploadDir = '../assets/';
    $uploadPath = $uploadDir . $safeFileName;
    $dbPath = 'assets/' . $safeFileName;

    // Move uploaded file to the designated directory
    if (move_uploaded_file($fileTmpPath, $uploadPath)) {
        // Sanitize alt text to prevent XSS
        $altText = htmlspecialchars($_POST['alt_text'] ?? '', ENT_QUOTES, 'UTF-8');

        // Insert image path and alt text into the database
        $sql = "INSERT INTO banner (image_path, alt_text) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$dbPath, $altText]);

        header("Location: ../mainpage.controller.php");
        exit;
    } else {
        echo "Upload failed while moving the file.";
    }
}
?>
