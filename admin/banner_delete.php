<?php
require '../database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get current image path to delete the file
    $stmt = $pdo->prepare("SELECT image_path FROM banner WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row) {
        $filePath = '../' . $row['image_path']; // actual file path
        if (file_exists($filePath)) {
            unlink($filePath); // delete the image file
        }

        // Delete from DB
        $stmt = $pdo->prepare("DELETE FROM banner WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: ../mainpage.controller.php");
exit;
?>
