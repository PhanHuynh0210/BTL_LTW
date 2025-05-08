<?php
require 'database.php'; // Adjust path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect posted form data
    $userID = trim($_POST['UserID']);
    $fullName = trim($_POST['FullName']);
    $numberPhone = trim($_POST['NumberPhone']);
    $email = filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL);
    $passwordRaw = trim($_POST['Password']);
    $address = trim($_POST['HouseRoadAddress']);
    $ward = trim($_POST['Ward']);
    $district = trim($_POST['District']);
    $province = trim($_POST['Province']);
    $status = $_POST['Status'];

    // Validate fields
    if (
        empty($userID) || empty($fullName) || empty($numberPhone) || empty($email) ||
        empty($_POST['Password']) || empty($address) || empty($ward) || empty($district) || empty($province)
    ) {
        $error = "Vui lòng điền đầy đủ thông tin!";
        header("Location: add_user_form.php?error=" . urlencode($error));
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Địa chỉ email không hợp lệ!";
        header("Location: add_user_form.php?error=" . urlencode(htmlspecialchars($error)));
        exit;
    }

    // Hash the password securely
    $hashedPassword = password_hash($passwordRaw, PASSWORD_DEFAULT);

    try {
        // Check if the UserID already exists
        $checkStmt = $pdo->prepare("SELECT * FROM user WHERE UserID = ?");
        $checkStmt->execute([$userID]);
        if ($checkStmt->rowCount() > 0) {
            $error = "Mã người dùng '$userID' đã tồn tại!";
            header("Location: add_user_form.php?error=" . urlencode($error));
            exit;
        }

        // Insert user into the database
        $sql = "INSERT INTO user (UserID, FullName, NumberPhone, Email, Password, HouseRoadAddress, Ward, District, Province, Status) 
                VALUES (:userID, :fullName, :numberPhone, :email, :password, :address, :ward, :district, :province, :status)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':numberPhone', $numberPhone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':ward', $ward);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);

        $stmt->execute();

        $message = "Người dùng đã được thêm thành công!";
        header("Location: userinfo.controller.php?message=" . urlencode($message));
        exit;
    } catch (PDOException $e) {
        $error = "Lỗi cơ sở dữ liệu: " . $e->getMessage();
        header("Location: userinfo.controller.php?error=" . urlencode($error));
        exit;
    }
}
?>
