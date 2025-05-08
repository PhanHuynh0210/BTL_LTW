<?php
require '../database.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $online_consultation = $_POST['online_consultation'] ?? '';
    $online_sales_email = $_POST['online_sales_email'] ?? '';
    $phone_hanoi = $_POST['phone_hanoi'] ?? '';
    $phone_danang = $_POST['phone_danang'] ?? '';
    $phone_hcm = $_POST['phone_hcm'] ?? '';
    $common_email = $_POST['common_email'] ?? '';

    // Validate input data
    if (empty($online_consultation) || empty($online_sales_email) || empty($phone_hanoi) || empty($phone_danang) || empty($phone_hcm) || empty($common_email)) {
        echo "All fields must be filled out.";
        exit;
    }

    try {
        // Start a transaction for safety in case of multiple updates
        $pdo->beginTransaction();

        // Update query for Tư vấn & Mua hàng trực tuyến
        $sql1 = "UPDATE contact_info SET value = :online_consultation WHERE label = 'Tư vấn & Mua hàng trực tuyến' AND contact_type_id = 1";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':online_consultation', $online_consultation);
        $stmt1->execute();

        // Update query for Email hỗ trợ bán hàng Online
        $sql2 = "UPDATE contact_info SET value = :online_sales_email WHERE label = 'Email hỗ trợ bán hàng Online' AND contact_type_id = 1";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':online_sales_email', $online_sales_email);
        $stmt2->execute();

        // Update query for Hà Nội
        $sql3 = "UPDATE contact_info SET value = :phone_hanoi WHERE label = 'Hà Nội' AND contact_type_id = 1";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->bindParam(':phone_hanoi', $phone_hanoi);
        $stmt3->execute();

        // Update query for Đà Nẵng
        $sql4 = "UPDATE contact_info SET value = :phone_danang WHERE label = 'Đà Nẵng' AND contact_type_id = 1";
        $stmt4 = $pdo->prepare($sql4);
        $stmt4->bindParam(':phone_danang', $phone_danang);
        $stmt4->execute();

        // Update query for TP.Hồ Chí Minh
        $sql5 = "UPDATE contact_info SET value = :phone_hcm WHERE label = 'TP.Hồ Chí Minh' AND contact_type_id = 1";
        $stmt5 = $pdo->prepare($sql5);
        $stmt5->bindParam(':phone_hcm', $phone_hcm);
        $stmt5->execute();

        // Update query for Email hỗ trợ chung
        $sql6 = "UPDATE contact_info SET value = :common_email WHERE label = 'Email hỗ trợ chung' AND contact_type_id = 1";
        $stmt6 = $pdo->prepare($sql6);
        $stmt6->bindParam(':common_email', $common_email);
        $stmt6->execute();

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