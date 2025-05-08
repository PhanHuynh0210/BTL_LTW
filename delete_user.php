<?php
require_once 'database.php'; // Adjust the path to your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate user input
    $userID = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';

    if (empty($userID)) {
        $error = "Không tìm thấy ID người dùng cần xóa.";
        header("Location: userinfo.controller.php?error=" . urlencode($error));
        exit;
    }

    try {
        // Prepare DELETE statement
        $stmt = $pdo->prepare("DELETE FROM user WHERE UserID = :userID");
        $stmt->bindParam(':userID', $userID);

        // Execute deletion
        $stmt->execute();

        // Check if a row was actually deleted
        if ($stmt->rowCount() > 0) {
            $message = "Người dùng đã được xóa thành công.";
            header("Location: userinfo.controller.php?message=" . urlencode($message));
        } else {
            $error = "Người dùng không tồn tại hoặc đã bị xóa.";
            header("Location: userinfo.controller.php?error=" . urlencode($error));
        }
        exit;

    } catch (PDOException $e) {
        $error = "Lỗi cơ sở dữ liệu khi xóa người dùng: " . $e->getMessage();
        header("Location: userinfo.controller.php?error=" . urlencode($error));
        exit;
    }
} else {
    // If someone tries to access this page without POST
    header("Location: userinfo.controller.php");
    exit;
}
