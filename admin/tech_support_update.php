<?php
require '../database.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get posted values
    $north_address = trim($_POST['tech_support_north'] ?? '');
    $central_address = trim($_POST['tech_support_central'] ?? '');
    $south_address = trim($_POST['tech_support_south'] ?? '');

    $north_phone = trim($_POST['tech_support_north_phone'] ?? '');
    $central_phone = trim($_POST['tech_support_central_phone'] ?? '');
    $south_phone = trim($_POST['tech_support_south_phone'] ?? '');

    // Basic validation
    if (empty($north_address) || empty($central_address) || empty($south_address) ||
        empty($north_phone) || empty($central_phone) || empty($south_phone)) {
        echo "All fields must be filled out.";
        exit;
    }

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Prepare update statements
        $sql = "UPDATE contact_addresses SET address = :address, phone = :phone 
                WHERE region = :region AND contact_type_id = 3";
        $stmt = $pdo->prepare($sql);

        // Execute for each region
        $stmt->execute([
            ':address' => $north_address,
            ':phone' => $north_phone,
            ':region' => 'Miền Bắc'
        ]);

        $stmt->execute([
            ':address' => $central_address,
            ':phone' => $central_phone,
            ':region' => 'Miền Trung'
        ]);

        $stmt->execute([
            ':address' => $south_address,
            ':phone' => $south_phone,
            ':region' => 'Miền Nam'
        ]);

        // Commit transaction
        $pdo->commit();

        // Redirect or success message
        header("Location: ../contactpage.controller.php"); // Change if needed
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Update failed: " . $e->getMessage();
    }
}
?>
