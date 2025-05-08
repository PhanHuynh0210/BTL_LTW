<?php
require_once 'database.php';

if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("SELECT image_data FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetchColumn();
        
        if ($image) {
            header('Content-Type: image/jpeg');
            echo $image;
        } else {
            // Return a default image if no image found
            header('Content-Type: image/jpeg');
            readfile('assets/default.jpg');
        }
    } catch (PDOException $e) {
        // Return a default image on error
        header('Content-Type: image/jpeg');
        readfile('assets/default.jpg');
    }
} else {
    // Return a default image if parameters are missing
    header('Content-Type: image/jpeg');
    readfile('assets/default.jpg');
} 