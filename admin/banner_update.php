<?php
require '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;
    $altText = htmlspecialchars($_POST['alt_text'] ?? '', ENT_QUOTES, 'UTF-8'); // Sanitize alt text

    if ($id !== null) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxFileSize = 2 * 1024 * 1024; // 2MB

            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileType = mime_content_type($fileTmpPath);
            $fileSize = $_FILES['image']['size'];

            if (!in_array($fileType, $allowedTypes)) {
                echo "Error: Only JPG, PNG, GIF, and WEBP files are allowed.";
                exit;
            }

            if ($fileSize > $maxFileSize) {
                echo "Error: File size exceeds 2MB limit.";
                exit;
            }

            $uploadDir = '../assets/';
            $originalName = basename($_FILES['image']['name']);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $safeName = uniqid('img_', true) . '.' . $extension;
            $uploadPath = $uploadDir . $safeName;
            $dbPath = 'assets/' . $safeName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                // Update both image and alt text
                $sql = "UPDATE banner SET image_path = ?, alt_text = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$dbPath, $altText, $id]);
            } else {
                echo "Image upload failed.";
                exit;
            }
        } else {
            // Update only alt text
            $sql = "UPDATE banner SET alt_text = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$altText, $id]);
        }

        header("Location: ../mainpage.controller.php");
        exit;
    }
}
?>
