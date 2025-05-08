<?php
require '../database.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $customer_care_email = $_POST['customer_care_email'] ?? '';
    $customer_care_hotline = $_POST['customer_care_hotline'] ?? '';
    $customer_care_zalo = $_POST['customer_care_zalo'] ?? '';
    $customer_care_facebook = $_POST['customer_care_facebook'] ?? '';

    // Validate input data
    if (empty($customer_care_email) || empty($customer_care_hotline) || empty($customer_care_zalo) || empty($customer_care_facebook)) {
        echo "All fields must be filled out.";
        exit;
    }

    try {
        // Start a transaction for safety in case of multiple updates
        $pdo->beginTransaction();

        // Update query for Email hỗ trợ chăm sóc khách hàng
        $sql1 = "UPDATE contact_info SET value = :customer_care_email WHERE label = 'Email hỗ trợ chăm sóc khách hàng' AND contact_type_id = 2";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':customer_care_email', $customer_care_email);
        $stmt1->execute();

        // Update query for Hotline
        $sql2 = "UPDATE contact_info SET value = :customer_care_hotline WHERE label = 'Hotline' AND contact_type_id = 2";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':customer_care_hotline', $customer_care_hotline);
        $stmt2->execute();

        // Update query for Zalo
        $sql3 = "UPDATE contact_info SET value = :customer_care_zalo WHERE label = 'Zalo' AND contact_type_id = 2";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->bindParam(':customer_care_zalo', $customer_care_zalo);
        $stmt3->execute();

        // Update query for Facebook
        $sql4 = "UPDATE contact_info SET value = :customer_care_facebook WHERE label = 'Facebook' AND contact_type_id = 2";
        $stmt4 = $pdo->prepare($sql4);
        $stmt4->bindParam(':customer_care_facebook', $customer_care_facebook);
        $stmt4->execute();

        // Commit the transaction
        $pdo->commit();

        header("Location: contactpage.controller.php");
    } catch (PDOException $e) {
        // Rollback in case of an error
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
