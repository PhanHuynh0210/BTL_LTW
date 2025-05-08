<?php
require_once 'database.php';

// Fetch all users
try {
    $stmt = $pdo->query("SELECT * FROM user ORDER BY UserID");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Có lỗi xảy ra khi truy vấn dữ liệu: " . $e->getMessage();
}

$message = $_GET['message'] ?? null;
$error = $_GET['error'] ?? null;
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
                        <a href="add_user_form.php" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Thêm người dùng
                        </a>
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
                                            <th>Chỉnh sửa</th>
                                            <th>Xóa liên hệ</th>
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
                                                    <!-- Edit Button -->
                                                    <a href="update_user_form.php?id=<?php echo $user['UserID']; ?>" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil-square"></i> Chỉnh sửa
                                                    </a>
                                                </td>
                                                <td>
                                                    <!-- Delete Button with Confirmation -->
                                                    <form action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        <input type="hidden" name="user_id" value="<?php echo $user['UserID']; ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i> Xóa liên hệ
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