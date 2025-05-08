<?php
require '../database.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['image'])) {
    $uploadDir = '../assets/';
    $filename = basename($_FILES['image']['name']);
    $uploadPath = $uploadDir . $filename;
    $dbPath = 'assets/' . $filename; // Store this in DB

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
        $altText = $_POST['alt_text'] ?? '';
        $sql = "INSERT INTO banner (image_path, alt_text) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$dbPath, $altText]);
        header("Location: mainpage.controller.php");
        exit;
    } else {
        echo "Upload failed.";
    }
}
?>