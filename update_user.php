<?php
require 'database.php'; // Adjust path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = trim($_POST['UserID']);
    $fullName = trim($_POST['FullName']);
    $numberPhone = trim($_POST['NumberPhone']);
    $email = trim($_POST['Email']);
    $password = trim($_POST['Password']);
    $address = trim($_POST['HouseRoadAddress']);
    $ward = trim($_POST['Ward']);
    $district = trim($_POST['District']);
    $province = trim($_POST['Province']);
    $status = $_POST['Status'];

    // Validation (basic example)
    if (
        empty($userID) || empty($fullName) || empty($numberPhone) || empty($email) ||
        empty($address) || empty($ward) || empty($district) || empty($province)
    ) {
        $error = "Vui lòng điền đầy đủ thông tin!";
        header("Location: update_user_form.php?id=" . urlencode($userID) . "&error=" . urlencode($error));
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Địa chỉ email không hợp lệ!";
        header("Location: update_user_form.php?error=" . urlencode(htmlspecialchars($error)));
        exit;
    }

    try {
        if (!empty($password)) {
            // Hash password if user entered a new one
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE user SET 
                        FullName = :fullName,
                        NumberPhone = :numberPhone,
                        Email = :email,
                        Password = :password,
                        HouseRoadAddress = :address,
                        Ward = :ward,
                        District = :district,
                        Province = :province,
                        Status = :status
                    WHERE UserID = :userID";
        } else {
            // Do not update password
            $sql = "UPDATE user SET 
                        FullName = :fullName,
                        NumberPhone = :numberPhone,
                        Email = :email,
                        HouseRoadAddress = :address,
                        Ward = :ward,
                        District = :district,
                        Province = :province,
                        Status = :status
                    WHERE UserID = :userID";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':numberPhone', $numberPhone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':ward', $ward);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID);

        if (!empty($password)) {
            $stmt->bindParam(':password', $hashedPassword);
        }

        $stmt->execute();

        $message = "Thông tin người dùng đã được cập nhật thành công!";
        header("Location: userinfo.controller.php?message=" . urlencode($message));
        exit;
    } catch (PDOException $e) {
        $error = "Lỗi cập nhật: " . $e->getMessage();
        header("Location: userinfo.controller.php?id=" . urlencode($userID) . "&error=" . urlencode($error));
        exit;
    }
} else {
    header("Location: userinfo.controller.php");
    exit;
}
