<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Thêm Người Dùng Mới</h2>
    <form action="add_user.php" method="POST">
        <div class="row mb-3">
            <div class="col">
                <label for="UserID" class="form-label">Mã người dùng</label>
                <input type="text" name="UserID" class="form-control" required>
            </div>
            <div class="col">
                <label for="FullName" class="form-label">Họ và tên</label>
                <input type="text" name="FullName" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="NumberPhone" class="form-label">Số điện thoại</label>
                <input type="text" name="NumberPhone" class="form-control" required>
            </div>
            <div class="col">
                <label for="Email" class="form-label">Email</label>
                <input type="email" name="Email" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="Password" class="form-label">Mật khẩu</label>
            <input type="password" name="Password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="HouseRoadAddress" class="form-label">Số nhà, đường</label>
            <input type="text" name="HouseRoadAddress" class="form-control" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="Ward" class="form-label">Phường/Xã</label>
                <input type="text" name="Ward" class="form-control" required>
            </div>
            <div class="col">
                <label for="District" class="form-label">Quận/Huyện</label>
                <input type="text" name="District" class="form-control" required>
            </div>
            <div class="col">
                <label for="Province" class="form-label">Tỉnh/Thành phố</label>
                <input type="text" name="Province" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="Status" class="form-label">Trạng thái</label>
            <select name="Status" class="form-select">
                <option value="1" selected>Hoạt động</option>
                <option value="0">Ngừng hoạt động</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Thêm người dùng</button>
        <a href="userinfo.controller.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>

</body>
</html>
