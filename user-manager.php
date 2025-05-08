<?php
require_once 'database.php';

// Handle password reset
if (isset($_POST['reset_password'])) {
    try {
        $user_id = $_POST['user_id'];
        $new_password = "123456"; // Default password
        
        $stmt = $pdo->prepare("UPDATE user SET Password = ? WHERE UserID = ?");
        if ($stmt->execute([$new_password, $user_id])) {
            $message = "Mật khẩu đã được reset thành công!";
        } else {
            $error = "Có lỗi xảy ra khi reset mật khẩu!";
        }
    } catch (PDOException $e) {
        $error = "Có lỗi xảy ra: " . $e->getMessage();
    }
}

// Handle user status toggle
if (isset($_POST['toggle_status'])) {
    try {
        $user_id = $_POST['user_id'];
        $new_status = $_POST['current_status'] == 1 ? 0 : 1;
        
        $stmt = $pdo->prepare("UPDATE user SET Status = ? WHERE UserID = ?");
        if ($stmt->execute([$new_status, $user_id])) {
            $message = "Trạng thái người dùng đã được cập nhật!";
        } else {
            $error = "Có lỗi xảy ra khi cập nhật trạng thái!";
        }
    } catch (PDOException $e) {
        $error = "Có lỗi xảy ra: " . $e->getMessage();
    }
}

// Fetch all users
try {
    $stmt = $pdo->query("SELECT * FROM user ORDER BY UserID");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Có lỗi xảy ra khi truy vấn dữ liệu: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }
        .content {
            padding: 20px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
        }
        .status-active {
            background-color: #198754;
            color: white;
        }
        .status-locked {
            background-color: #dc3545;
            color: white;
        }
        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <?php include 'sidebar.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Quản lý người dùng</h2>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus"></i> Thêm người dùng
                        </button>
                    </div>
                </div>

                <?php if (isset($message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if (isset($users) && count($users) > 0): ?>
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ và tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                        <th>Địa chỉ</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['UserID']); ?></td>
                                        <td><?php echo htmlspecialchars($user['FullName']); ?></td>
                                        <td><?php echo htmlspecialchars($user['NumberPhone']); ?></td>
                                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                        <td>
                                            <?php 
                                            echo htmlspecialchars($user['HouseRoadAddress'] . ', ' . 
                                                $user['Ward'] . ', ' . 
                                                $user['District'] . ', ' . 
                                                $user['Province']); 
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($user['Status'] == 1): ?>
                                                <span class="status-badge status-active">Hoạt động</span>
                                            <?php else: ?>
                                                <span class="status-badge status-locked">Đã khóa</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['UserID']); ?>">
                                                <button type="submit" name="reset_password" class="btn btn-warning btn-sm" 
                                                        onclick="return confirm('Bạn có chắc chắn muốn reset mật khẩu của người dùng này?')">
                                                   Reset 
                                                </button>
                                            </form>
                                            
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['UserID']); ?>">
                                                <input type="hidden" name="current_status" value="<?php echo htmlspecialchars($user['Status']); ?>">
                                                <button type="submit" name="toggle_status" 
                                                        class="btn btn-sm <?php echo $user['Status'] == 1 ? 'btn-danger' : 'btn-success'; ?>"
                                                        onclick="return confirm('Bạn có chắc chắn muốn <?php echo $user['Status'] == 1 ? 'khóa' : 'mở khóa'; ?> người dùng này?')">
                                                    <i class="bi <?php echo $user['Status'] == 1 ? 'bi-lock' : 'bi-unlock'; ?>"></i>
                                                    <?php echo $user['Status'] == 1 ? 'Khóa' : 'Mở khóa'; ?>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    Không có dữ liệu người dùng!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 