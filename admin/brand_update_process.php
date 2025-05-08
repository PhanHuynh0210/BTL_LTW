<?php
require '../database.php';

// Check if form is submitted and necessary data is present
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['brand_id'])) {
    $brandId = $_POST['brand_id'];
    $brandName = $_POST['name'];
    $brandDescription = $_POST['description'];

    // Update brand details
    $sql = "UPDATE phone_brands SET name = ?, description = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brandName, $brandDescription, $brandId]);

    // Delete selected images
    if (isset($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $imageId) {
            // Get the image path to delete from the server
            $sql = "SELECT image_path FROM brand_images WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$imageId]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($image) {
                $imagePath = '../' . $image['image_path'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);  // Delete the image file from the server
                }

                // Delete the image record from the database
                $sql = "DELETE FROM brand_images WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$imageId]);
            }
        }
    }

    // Upload new images
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $uploadDir = '../assets/';
        $imagePaths = [];

        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            $filename = basename($_FILES['images']['name'][$index]);
            $uploadPath = $uploadDir . $filename;
            $dbPath = 'assets/' . $filename;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                // Insert new image into the database
                $sql = "INSERT INTO brand_images (brand_id, image_path) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$brandId, $dbPath]);
            }
        }
    }

    // Redirect to the brand list or another page
    header("Location: mainpage.controller.php");
    exit;
} else {
    echo "Invalid request.";
    exit;
}
