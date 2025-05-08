<?php
require_once 'database.php';
// session_start();

// // Check if user is logged in and is admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     echo json_encode(['success' => false, 'message' => 'Unauthorized']);
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'] ?? '';
    $id = $_POST['id'] ?? 0;

    $allowed_tables = [
        'vision_mission',
        'core_values',
        'commitments',
        'team_members',
        'testimonials'
    ];

    if (!in_array($table, $allowed_tables)) {
        echo json_encode(['success' => false, 'message' => 'Invalid table']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
        $result = $stmt->execute([$id]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete item']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 