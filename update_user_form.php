<?php
require 'database.php';

if (!isset($_GET['id'])) {
    die("Thiếu ID người dùng.");
}

$userID = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM user WHERE UserID = ?");
$stmt->execute([$userID]);
$user = $stmt->fetch();

if (!$user) {
    die("Không tìm thấy người dùng.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Chỉnh sửa Người Dùng</h2>
    <form action="update_user.php" method="POST">
        <!-- Keep UserID hidden to avoid modifying -->
        <input type="hidden" name="UserID" value="<?= htmlspecialchars($user['UserID']) ?>">

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Mã người dùng</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($user['UserID']) ?>" disabled>
            </div>
            <div class="col">
                <label for="FullName" class="form-label">Họ và tên</label>
                <input type="text" name="FullName" class="form-control" value="<?= htmlspecialchars($user['FullName']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="NumberPhone" class="form-label">Số điện thoại</label>
                <input type="text" name="NumberPhone" class="form-control" value="<?= htmlspecialchars($user['NumberPhone']) ?>" required>
            </div>
            <div class="col">
                <label for="Email" class="form-label">Email</label>
                <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($user['Email']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="Password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
            <input type="password" name="Password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="HouseRoadAddress" class="form-label">Số nhà, đường</label>
            <input type="text" name="HouseRoadAddress" class="form-control" value="<?= htmlspecialchars($user['HouseRoadAddress']) ?>" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="Ward" class="form-label">Phường/Xã</label>
                <input type="text" name="Ward" class="form-control" value="<?= htmlspecialchars($user['Ward']) ?>" required>
            </div>
            <div class="col">
                <label for="District" class="form-label">Quận/Huyện</label>
                <input type="text" name="District" class="form-control" value="<?= htmlspecialchars($user['District']) ?>" required>
            </div>
            <div class="col">
                <label for="Province" class="form-label">Tỉnh/Thành phố</label>
                <input type="text" name="Province" class="form-control" value="<?= htmlspecialchars($user['Province']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="Status" class="form-label">Trạng thái</label>
            <select name="Status" class="form-select">
                <option value="1" <?= $user['Status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= $user['Status'] == 0 ? 'selected' : '' ?>>Ngừng hoạt động</option>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
        <a href="userinfo.controller.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>

</body>
</html>
