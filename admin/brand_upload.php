<?php
require '../database.php'; 

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['images'])) {
    // Prepare upload directory
    $uploadDir = '../assets/';
    $uploadedImages = [];
    
    // Loop through all the images (assuming 3 images)
    for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
        // Get the filename and set the upload path
        $filename = basename($_FILES['images']['name'][$i]);
        $uploadPath = $uploadDir . $filename;
        $dbPath = 'assets/' . $filename; // Path to store in DB
        
        // Check if the file was uploaded successfully
        if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploadPath)) {
            $uploadedImages[] = $dbPath; // Add the uploaded file path to the array
        } else {
            echo "Upload failed for image " . $filename . ".";
            exit;
        }
    }

    // Get brand name and description
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    // Insert brand data into the database
    $sql = "INSERT INTO phone_brands (name, description) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $description]);

    // Get the last inserted brand ID
    $brandId = $pdo->lastInsertId();

    // Insert image paths for the uploaded images into the database
    $sql = "INSERT INTO brand_images (brand_id, image_path) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    
    foreach ($uploadedImages as $imagePath) {
        $stmt->execute([$brandId, $imagePath]);
    }

    // Redirect to the main page or brand list page
    header("Location: mainpage.controller.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
