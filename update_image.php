<?php
require_once 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $table = $_POST['table'] ?? '';
        $id = $_POST['id'] ?? '';
        $image_data = $_POST['image'] ?? '';
        
        if (empty($table) || empty($id) || empty($image_data)) {
            throw new Exception('Missing required parameters');
        }

        // Decode base64 image data
        $image_data = str_replace('data:image/png;base64,', '', $image_data);
        $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        $image_data = base64_decode($image_data);

        // Update database with image data
        $stmt = $pdo->prepare("UPDATE $table SET image_data = ? WHERE id = ?");
        if ($stmt->execute([$image_data, $id])) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception('Failed to update database');
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
} 