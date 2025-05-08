<?php
require '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;
    $altText = $_POST['alt_text'] ?? '';

    if ($id !== null) {
        // Check if a new image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../assets/';
            $filename = basename($_FILES['image']['name']);
            $uploadPath = $uploadDir . $filename;
            $dbPath = 'assets/' . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
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
        header("Location: mainpage.controller.php");
        exit;
    }
}
?>
