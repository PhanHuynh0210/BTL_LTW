<?php
require '../database.php';

// Check if the 'id' parameter is passed to this page for the brand to delete
if (isset($_GET['id'])) {
    $brandId = $_GET['id'];

    // First, retrieve the image paths for this brand
    $sql = "SELECT image_path FROM brand_images WHERE brand_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brandId]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Delete the images from the server (if they exist)
    foreach ($images as $image) {
        $imagePath = '../' . $image['image_path'];  // Full path to the image
        if (file_exists($imagePath)) {
            unlink($imagePath);  // Delete the image file from the server
        }
    }

    // Now, delete the records in the `brand_images` table
    $sql = "DELETE FROM brand_images WHERE brand_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brandId]);

    // Finally, delete the brand record from the `phone_brands` table
    $sql = "DELETE FROM phone_brands WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brandId]);

    // Redirect back to the brand list or another page
    header("Location: mainpage.controller.php");
    exit;
} else {
    echo "No brand ID provided.";
}
?>
