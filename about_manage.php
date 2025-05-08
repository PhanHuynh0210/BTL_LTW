<?php
require_once 'database.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['update_company_info'])) {
            $description = $_POST['description'];
            $banner_data = $company_info['banner_data'] ?? null;
            $about_image_data = $company_info['about_image_data'] ?? null;
            
            // Handle banner upload
            if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
                $banner_data = file_get_contents($_FILES['banner']['tmp_name']);
            }
            
            // Handle about image upload
            if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
                $about_image_data = file_get_contents($_FILES['about_image']['tmp_name']);
            }

            // Check if company_info record exists
            $checkStmt = $pdo->query("SELECT COUNT(*) FROM company_info WHERE id = 1");
            $exists = $checkStmt->fetchColumn();

            if ($exists) {
                // Update existing record
                $stmt = $pdo->prepare("UPDATE company_info SET description = :description, banner_data = :banner_data, about_image_data = :about_image_data WHERE id = 1");
                $result = $stmt->execute([
                    ':description' => $description,
                    ':banner_data' => $banner_data,
                    ':about_image_data' => $about_image_data
                ]);
            } else {
                // Insert new record
                $stmt = $pdo->prepare("INSERT INTO company_info (id, description, banner_data, about_image_data) VALUES (1, :description, :banner_data, :about_image_data)");
                $result = $stmt->execute([
                    ':description' => $description,
                    ':banner_data' => $banner_data,
                    ':about_image_data' => $about_image_data
                ]);
            }

            if ($result) {
                $message = "Thông tin công ty đã được cập nhật thành công!";
                // Refresh company info after update
                $company_info = $pdo->query("SELECT * FROM company_info WHERE id = 1")->fetch();
                
                // Redirect to refresh the page
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error = "Có lỗi xảy ra khi cập nhật thông tin công ty";
                error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
            }
        }
        
        if (isset($_POST['add_vision_mission'])) {
            $type = $_POST['type'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $stmt = $pdo->prepare("INSERT INTO vision_mission (type, title, content) VALUES (?, ?, ?)");
            if ($stmt->execute([$type, $title, $content])) {
                $message = "Đã thêm mới tầm nhìn/sứ mệnh thành công!";
            }
        }

        if (isset($_POST['edit_vision_mission'])) {
            $id = $_POST['id'];
            $type = $_POST['type'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $stmt = $pdo->prepare("UPDATE vision_mission SET type = ?, title = ?, content = ? WHERE id = ?");
            if ($stmt->execute([$type, $title, $content, $id])) {
                $message = "Đã cập nhật tầm nhìn/sứ mệnh thành công!";
            }
        }
        
        if (isset($_POST['add_core_value'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("INSERT INTO core_values (title, description) VALUES (?, ?)");
            if ($stmt->execute([$title, $description])) {
                $message = "Đã thêm mới giá trị cốt lõi thành công!";
            }
        }

        if (isset($_POST['edit_core_value'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("UPDATE core_values SET title = ?, description = ? WHERE id = ?");
            if ($stmt->execute([$title, $description, $id])) {
                $message = "Đã cập nhật giá trị cốt lõi thành công!";
            }
        }
        
        if (isset($_POST['add_commitment'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("INSERT INTO commitments (title, description) VALUES (?, ?)");
            if ($stmt->execute([$title, $description])) {
                $message = "Đã thêm mới cam kết thành công!";
            }
        }

        if (isset($_POST['edit_commitment'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("UPDATE commitments SET title = ?, description = ? WHERE id = ?");
            if ($stmt->execute([$title, $description, $id])) {
                $message = "Đã cập nhật cam kết thành công!";
            }
        }
        
        if (isset($_POST['add_team_member'])) {
            $name = $_POST['name'];
            $position = $_POST['position'];
            $description = $_POST['description'];
            
            // Handle image upload
            $image_data = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_data = file_get_contents($_FILES['image']['tmp_name']);
            }
            
            $stmt = $pdo->prepare("INSERT INTO team_members (name, position, description, image_data) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $position, $description, $image_data])) {
                $message = "Đã thêm mới thành viên thành công!";
            }
        }

        if (isset($_POST['edit_team_member'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $position = $_POST['position'];
            $description = $_POST['description'];
            
            // Handle image upload
            $image_data = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_data = file_get_contents($_FILES['image']['tmp_name']);
            }
            
            $stmt = $pdo->prepare("UPDATE team_members SET name = ?, position = ?, description = ?, image_data = ? WHERE id = ?");
            if ($stmt->execute([$name, $position, $description, $image_data, $id])) {
                $message = "Đã cập nhật thành viên thành công!";
            }
        }
        
        if (isset($_POST['add_testimonial'])) {
            $customer_name = $_POST['customer_name'];
            $location = $_POST['location'];
            $content = $_POST['content'];
            
            // Handle image upload
            $image_data = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_data = file_get_contents($_FILES['image']['tmp_name']);
            }
            
            $stmt = $pdo->prepare("INSERT INTO testimonials (customer_name, location, content, image_data) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$customer_name, $location, $content, $image_data])) {
                $message = "Đã thêm mới đánh giá khách hàng thành công!";
            }
        }

        if (isset($_POST['edit_testimonial'])) {
            $id = $_POST['id'];
            $customer_name = $_POST['customer_name'];
            $location = $_POST['location'];
            $content = $_POST['content'];
            
            // Handle image upload
            $image_data = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_data = file_get_contents($_FILES['image']['tmp_name']);
            }
            
            $stmt = $pdo->prepare("UPDATE testimonials SET customer_name = ?, location = ?, content = ?, image_data = ? WHERE id = ?");
            if ($stmt->execute([$customer_name, $location, $content, $image_data, $id])) {
                $message = "Đã cập nhật đánh giá khách hàng thành công!";
            }
        }

        // Xử lý thêm cửa hàng mới
        if (isset($_POST['add_store'])) {
            $region = $_POST['region'];
            $address = $_POST['address'];
            $sort_order = $_POST['sort_order'];
            
            $stmt = $pdo->prepare("INSERT INTO stores (region, address, sort_order) VALUES (?, ?, ?)");
            if ($stmt->execute([$region, $address, $sort_order])) {
                $message = "Đã thêm mới cửa hàng thành công!";
            }
        }

        // Xử lý sửa cửa hàng
        if (isset($_POST['edit_store'])) {
            $id = $_POST['id'];
            $region = $_POST['region'];
            $address = $_POST['address'];
            $sort_order = $_POST['sort_order'];
            
            $stmt = $pdo->prepare("UPDATE stores SET region = ?, address = ?, sort_order = ? WHERE id = ?");
            if ($stmt->execute([$region, $address, $sort_order, $id])) {
                $message = "Đã cập nhật cửa hàng thành công!";
            }
        }

        // Xử lý xóa cửa hàng
        if (isset($_POST['delete_store'])) {
            $id = $_POST['id'];
            
            $stmt = $pdo->prepare("DELETE FROM stores WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "Đã xóa cửa hàng thành công!";
            }
        }

        if (isset($_POST['delete_vision_mission'])) {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM vision_mission WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "Đã xóa tầm nhìn/sứ mệnh thành công!";
            }
        }

        if (isset($_POST['delete_core_value'])) {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM core_values WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "Đã xóa giá trị cốt lõi thành công!";
            }
        }

        if (isset($_POST['delete_commitment'])) {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM commitments WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "Đã xóa cam kết thành công!";
            }
        }

        if (isset($_POST['delete_team_member'])) {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM team_members WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "Đã xóa thành viên thành công!";
            }
        }

        if (isset($_POST['delete_testimonial'])) {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "Đã xóa đánh giá khách hàng thành công!";
            }
        }
    } catch (PDOException $e) {
        $error = "Có lỗi xảy ra: " . $e->getMessage();
        error_log("PDO Exception: " . $e->getMessage());
    }
}

// Fetch existing data
try {
    $company_info = $pdo->query("SELECT * FROM company_info WHERE id = 1")->fetch();
    $vision_mission = $pdo->query("SELECT * FROM vision_mission ORDER BY id DESC")->fetchAll();
    $core_values = $pdo->query("SELECT * FROM core_values ORDER BY id DESC")->fetchAll();
    $commitments = $pdo->query("SELECT * FROM commitments ORDER BY id DESC")->fetchAll();
    $team_members = $pdo->query("SELECT * FROM team_members ORDER BY id DESC")->fetchAll();
    $testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();
    $stores = $pdo->query("SELECT * FROM stores ORDER BY region, sort_order")->fetchAll();
} catch (PDOException $e) {
    $error = "Có lỗi xảy ra khi truy vấn dữ liệu: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông tin giới thiệu</title>
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
        .section {
            margin-bottom: 30px;
        }
        .edit-form {
            display: none;
        }
        .img-thumbnail {
            border: 1px solid #dee2e6;
            padding: 0.25rem;
            background-color: #fff;
            border-radius: 0.25rem;
            transition: all 0.2s ease-in-out;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .image-preview {
            position: relative;
            display: inline-block;
        }

        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
        }

        .image-preview .remove-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            cursor: pointer;
            display: none;
        }

        .image-preview:hover .remove-image {
            display: block;
        }

        .form-control[type="file"] {
            padding: 0.375rem;
        }

        .form-control[type="file"]::-webkit-file-upload-button {
            padding: 0.375rem 0.75rem;
            margin: -0.375rem 0;
            margin-right: 0.75rem;
            color: #212529;
            background-color: #e9ecef;
            border: 0;
            border-right: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control[type="file"]::-webkit-file-upload-button:hover {
            background-color: #dde2e6;
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
                    <h2 class="mb-0">Quản lý thông tin giới thiệu</h2>
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

                <!-- Company Info Section -->
                <div class="card section">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-building"></i> Thông tin công ty</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="banner" class="form-label">Banner</label>
                                        <input type="file" name="banner" id="banner" class="form-control" accept="image/*">
                                        <div id="bannerPreview" class="mt-2">
                                            <?php if(!empty($company_info['banner_data'])): ?>
                                                <div class="image-preview">
                                                    <img src="data:image/jpeg;base64,<?= base64_encode($company_info['banner_data']) ?>" class="img-thumbnail" style="max-height: 200px;">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="about_image" class="form-label">Ảnh giới thiệu</label>
                                        <input type="file" name="about_image" id="about_image" class="form-control" accept="image/*">
                                        <div id="aboutImagePreview" class="mt-2">
                                            <?php if(!empty($company_info['about_image_data'])): ?>
                                                <div class="image-preview">
                                                    <img src="data:image/jpeg;base64,<?= base64_encode($company_info['about_image_data']) ?>" class="img-thumbnail" style="max-height: 200px;">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả công ty</label>
                                <textarea id="description" name="description" class="form-control" rows="6"><?php echo htmlspecialchars($company_info['description'] ?? ''); ?></textarea>
                            </div>
                            <button type="submit" name="update_company_info" class="btn btn-primary">
                                <i class="bi bi-save"></i> Cập nhật
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Vision & Mission Section -->
                <div class="card section">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-bullseye"></i> Tầm nhìn & Sứ mệnh</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisionMissionModal">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Loại</th>
                                        <th>Tiêu đề</th>
                                        <th>Nội dung</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vision_mission as $vm): ?>
                                    <tr>
                                        <td><?php echo $vm['type'] === 'vision' ? 'Tầm nhìn' : 'Sứ mệnh'; ?></td>
                                        <td><?php echo htmlspecialchars($vm['title']); ?></td>
                                        <td><?php echo htmlspecialchars($vm['content']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editVisionMissionModal<?php echo $vm['id']; ?>">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="delete_vision_mission" value="1">
                                                <input type="hidden" name="id" value="<?php echo $vm['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal sửa Vision & Mission -->
                                    <div class="modal fade" id="editVisionMissionModal<?php echo $vm['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa <?php echo $vm['type'] === 'vision' ? 'Tầm nhìn' : 'Sứ mệnh'; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="edit_vision_mission" value="1">
                                                        <input type="hidden" name="id" value="<?php echo $vm['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Loại</label>
                                                            <select name="type" class="form-select" required>
                                                                <option value="vision" <?php echo $vm['type'] === 'vision' ? 'selected' : ''; ?>>Tầm nhìn</option>
                                                                <option value="mission" <?php echo $vm['type'] === 'mission' ? 'selected' : ''; ?>>Sứ mệnh</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tiêu đề</label>
                                                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($vm['title']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nội dung</label>
                                                            <textarea name="content" class="form-control" rows="3" required><?php echo htmlspecialchars($vm['content']); ?></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal thêm Vision & Mission -->
                <div class="modal fade" id="addVisionMissionModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Tầm nhìn/Sứ mệnh</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="add_vision_mission" value="1">
                                    <div class="mb-3">
                                        <label class="form-label">Loại</label>
                                        <select name="type" class="form-select" required>
                                            <option value="vision">Tầm nhìn</option>
                                            <option value="mission">Sứ mệnh</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nội dung</label>
                                        <textarea name="content" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Core Values Section -->
                <div class="card section">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-star"></i> Giá trị cốt lõi</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoreValueModal">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($core_values as $cv): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cv['title']); ?></td>
                                        <td><?php echo htmlspecialchars($cv['description']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCoreValueModal<?php echo $cv['id']; ?>">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="delete_core_value" value="1">
                                                <input type="hidden" name="id" value="<?php echo $cv['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal sửa Core Value -->
                                    <div class="modal fade" id="editCoreValueModal<?php echo $cv['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa Giá trị cốt lõi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="edit_core_value" value="1">
                                                        <input type="hidden" name="id" value="<?php echo $cv['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tiêu đề</label>
                                                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($cv['title']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Mô tả</label>
                                                            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($cv['description']); ?></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal thêm Core Value -->
                <div class="modal fade" id="addCoreValueModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Giá trị cốt lõi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="add_core_value" value="1">
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mô tả</label>
                                        <textarea name="description" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commitments Section -->
                <div class="card section">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-shield-check"></i> Cam kết</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCommitmentModal">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($commitments as $c): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($c['title']); ?></td>
                                        <td><?php echo htmlspecialchars($c['description']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCommitmentModal<?php echo $c['id']; ?>">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="delete_commitment" value="1">
                                                <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal sửa Commitment -->
                                    <div class="modal fade" id="editCommitmentModal<?php echo $c['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa Cam kết</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="edit_commitment" value="1">
                                                        <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tiêu đề</label>
                                                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($c['title']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Mô tả</label>
                                                            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($c['description']); ?></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal thêm Commitment -->
                <div class="modal fade" id="addCommitmentModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Cam kết</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="add_commitment" value="1">
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mô tả</label>
                                        <textarea name="description" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members Section -->
                <div class="card section">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-people"></i> Thành viên</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Tên</th>
                                        <th>Vị trí</th>
                                        <th>Mô tả</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($team_members as $tm): ?>
                                    <tr>
                                        <td>
                                            <?php if(!empty($tm['image_data'])): ?>
                                                <img src="data:image/jpeg;base64,<?= base64_encode($tm['image_data']) ?>" alt="<?= htmlspecialchars($tm['name']) ?>" class="img-thumbnail" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded p-2 text-center" style="width: 100px; height: 100px;">
                                                    <i class="bi bi-person text-secondary" style="font-size: 2rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($tm['name']); ?></td>
                                        <td><?php echo htmlspecialchars($tm['position']); ?></td>
                                        <td><?php echo htmlspecialchars($tm['description']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editTeamMemberModal<?php echo $tm['id']; ?>">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="delete_team_member" value="1">
                                                <input type="hidden" name="id" value="<?php echo $tm['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal sửa Team Member -->
                                    <div class="modal fade" id="editTeamMemberModal<?php echo $tm['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa Thành viên</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="edit_team_member" value="1">
                                                        <input type="hidden" name="id" value="<?php echo $tm['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tên</label>
                                                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($tm['name']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Vị trí</label>
                                                            <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($tm['position']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Mô tả</label>
                                                            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($tm['description']); ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Hình ảnh</label>
                                                            <input type="file" name="image" class="form-control" accept="image/*">
                                                            <?php if(!empty($tm['image_data'])): ?>
                                                                <div class="mt-2">
                                                                    <img src="data:image/jpeg;base64,<?= base64_encode($tm['image_data']) ?>" class="img-thumbnail" style="max-height: 200px;">
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal thêm Team Member -->
                <div class="modal fade" id="addTeamMemberModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Thành viên</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="add_team_member" value="1">
                                    <div class="mb-3">
                                        <label class="form-label">Tên</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Vị trí</label>
                                        <input type="text" name="position" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mô tả</label>
                                        <textarea name="description" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonials Section -->
                <div class="card section">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-chat-quote"></i> Đánh giá khách hàng</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Tên khách hàng</th>
                                        <th>Địa điểm</th>
                                        <th>Nội dung</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($testimonials as $t): ?>
                                    <tr>
                                        <td>
                                            <?php if(!empty($t['image_data'])): ?>
                                                <img src="data:image/jpeg;base64,<?= base64_encode($t['image_data']) ?>" alt="<?= htmlspecialchars($t['customer_name']) ?>" class="img-thumbnail" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded p-2 text-center" style="width: 100px; height: 100px;">
                                                    <i class="bi bi-person text-secondary" style="font-size: 2rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($t['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($t['location']); ?></td>
                                        <td><?php echo htmlspecialchars($t['content']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editTestimonialModal<?php echo $t['id']; ?>">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="delete_testimonial" value="1">
                                                <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal sửa Testimonial -->
                                    <div class="modal fade" id="editTestimonialModal<?php echo $t['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa Đánh giá khách hàng</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="edit_testimonial" value="1">
                                                        <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tên khách hàng</label>
                                                            <input type="text" name="customer_name" class="form-control" value="<?php echo htmlspecialchars($t['customer_name']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Địa điểm</label>
                                                            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($t['location']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nội dung</label>
                                                            <textarea name="content" class="form-control" rows="3" required><?php echo htmlspecialchars($t['content']); ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Hình ảnh</label>
                                                            <input type="file" name="image" class="form-control" accept="image/*">
                                                            <?php if(!empty($t['image_data'])): ?>
                                                                <div class="mt-2">
                                                                    <img src="data:image/jpeg;base64,<?= base64_encode($t['image_data']) ?>" class="img-thumbnail" style="max-height: 200px;">
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal thêm Testimonial -->
                <div class="modal fade" id="addTestimonialModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Đánh giá khách hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="add_testimonial" value="1">
                                    <div class="mb-3">
                                        <label class="form-label">Tên khách hàng</label>
                                        <input type="text" name="customer_name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Địa điểm</label>
                                        <input type="text" name="location" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nội dung</label>
                                        <textarea name="content" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quản lý cửa hàng -->
                <div class="card section">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-shop"></i> Quản lý cửa hàng</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStoreModal">
                            <i class="bi bi-plus-circle"></i> Thêm cửa hàng mới
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Khu vực</th>
                                        <th>Địa chỉ</th>
                                        <th>Thứ tự</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stores as $store): ?>
                                        <tr>
                                            <td><?php echo $store['id']; ?></td>
                                            <td>
                                                <?php
                                                $regions = [
                                                    'north' => 'Miền Bắc',
                                                    'central' => 'Miền Trung',
                                                    'south' => 'Miền Nam'
                                                ];
                                                echo $regions[$store['region']];
                                                ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($store['address']); ?></td>
                                            <td><?php echo $store['sort_order']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editStoreModal<?php echo $store['id']; ?>">
                                                    <i class="bi bi-pencil"></i> Sửa
                                                </button>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="delete_store" value="1">
                                                    <input type="hidden" name="id" value="<?php echo $store['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa cửa hàng này?')">
                                                        <i class="bi bi-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal sửa cửa hàng -->
                                        <div class="modal fade" id="editStoreModal<?php echo $store['id']; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Sửa cửa hàng</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST">
                                                            <input type="hidden" name="edit_store" value="1">
                                                            <input type="hidden" name="id" value="<?php echo $store['id']; ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label">Khu vực</label>
                                                                <select name="region" class="form-select" required>
                                                                    <option value="north" <?php echo $store['region'] === 'north' ? 'selected' : ''; ?>>Miền Bắc</option>
                                                                    <option value="central" <?php echo $store['region'] === 'central' ? 'selected' : ''; ?>>Miền Trung</option>
                                                                    <option value="south" <?php echo $store['region'] === 'south' ? 'selected' : ''; ?>>Miền Nam</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Địa chỉ</label>
                                                                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($store['address']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Thứ tự</label>
                                                                <input type="number" name="sort_order" class="form-control" value="<?php echo $store['sort_order']; ?>">
                                                            </div>
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal thêm cửa hàng mới -->
                <div class="modal fade" id="addStoreModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm cửa hàng mới</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="add_store" value="1">
                                    <div class="mb-3">
                                        <label class="form-label">Khu vực</label>
                                        <select name="region" class="form-select" required>
                                            <option value="north">Miền Bắc</option>
                                            <option value="central">Miền Trung</option>
                                            <option value="south">Miền Nam</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Thứ tự</label>
                                        <input type="number" name="sort_order" class="form-control" value="0">
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Thêm cửa hàng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function deleteItem(table, id) {
            if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
                fetch('delete_item.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `table=${table}&id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi xóa mục này');
                    }
                });
            }
        }

        // Vision & Mission
        function editVisionMission(data) {
            document.getElementById('visionMissionId').value = data.id;
            document.querySelector('#visionMissionForm select[name="type"]').value = data.type;
            document.querySelector('#visionMissionForm input[name="title"]').value = data.title;
            document.querySelector('#visionMissionForm textarea[name="content"]').value = data.content;
            document.getElementById('visionMissionSubmit').name = 'edit_vision_mission';
            document.getElementById('visionMissionSubmit').innerHTML = '<i class="bi bi-save"></i> Cập nhật';
        }

        function resetVisionMissionForm() {
            document.getElementById('visionMissionForm').reset();
            document.getElementById('visionMissionId').value = '';
            document.getElementById('visionMissionSubmit').name = 'add_vision_mission';
            document.getElementById('visionMissionSubmit').innerHTML = '<i class="bi bi-plus-circle"></i> Thêm mới';
        }

        // Core Values
        function editCoreValue(data) {
            document.getElementById('coreValueId').value = data.id;
            document.querySelector('#coreValueForm input[name="title"]').value = data.title;
            document.querySelector('#coreValueForm textarea[name="description"]').value = data.description;
            document.getElementById('coreValueSubmit').name = 'edit_core_value';
            document.getElementById('coreValueSubmit').innerHTML = '<i class="bi bi-save"></i> Cập nhật';
        }

        function resetCoreValueForm() {
            document.getElementById('coreValueForm').reset();
            document.getElementById('coreValueId').value = '';
            document.getElementById('coreValueSubmit').name = 'add_core_value';
            document.getElementById('coreValueSubmit').innerHTML = '<i class="bi bi-plus-circle"></i> Thêm mới';
        }

        // Commitments
        function editCommitment(data) {
            document.getElementById('commitmentId').value = data.id;
            document.querySelector('#commitmentForm input[name="title"]').value = data.title;
            document.querySelector('#commitmentForm textarea[name="description"]').value = data.description;
            document.getElementById('commitmentSubmit').name = 'edit_commitment';
            document.getElementById('commitmentSubmit').innerHTML = '<i class="bi bi-save"></i> Cập nhật';
        }

        function resetCommitmentForm() {
            document.getElementById('commitmentForm').reset();
            document.getElementById('commitmentId').value = '';
            document.getElementById('commitmentSubmit').name = 'add_commitment';
            document.getElementById('commitmentSubmit').innerHTML = '<i class="bi bi-plus-circle"></i> Thêm mới';
        }

        // Team Members
        function editTeamMember(data) {
            document.getElementById('teamMemberId').value = data.id;
            document.querySelector('#teamMemberForm input[name="name"]').value = data.name;
            document.querySelector('#teamMemberForm input[name="position"]').value = data.position;
            document.querySelector('#teamMemberForm textarea[name="description"]').value = data.description;
            if (data.image_data) {
                document.getElementById('teamMemberImagePreview').innerHTML = `<img src="data:image/jpeg;base64,${btoa(String.fromCharCode.apply(null, new Uint8Array(data.image_data)))}" class="img-thumbnail" style="max-height: 200px;">`;
            }
            document.getElementById('teamMemberSubmit').name = 'edit_team_member';
            document.getElementById('teamMemberSubmit').innerHTML = '<i class="bi bi-save"></i> Cập nhật';
        }

        function resetTeamMemberForm() {
            document.getElementById('teamMemberForm').reset();
            document.getElementById('teamMemberId').value = '';
            document.getElementById('teamMemberCurrentImage').value = '';
            document.getElementById('teamMemberImagePreview').innerHTML = '';
            document.getElementById('teamMemberSubmit').name = 'add_team_member';
            document.getElementById('teamMemberSubmit').innerHTML = '<i class="bi bi-plus-circle"></i> Thêm mới';
        }

        // Testimonials
        function editTestimonial(data) {
            document.getElementById('testimonialId').value = data.id;
            document.querySelector('#testimonialForm input[name="customer_name"]').value = data.customer_name;
            document.querySelector('#testimonialForm input[name="location"]').value = data.location;
            document.querySelector('#testimonialForm textarea[name="content"]').value = data.content;
            if (data.image_data) {
                document.getElementById('testimonialImagePreview').innerHTML = `<img src="data:image/jpeg;base64,${btoa(String.fromCharCode.apply(null, new Uint8Array(data.image_data)))}" class="img-thumbnail" style="max-height: 200px;">`;
            }
            document.getElementById('testimonialSubmit').name = 'edit_testimonial';
            document.getElementById('testimonialSubmit').innerHTML = '<i class="bi bi-save"></i> Cập nhật';
        }

        function resetTestimonialForm() {
            document.getElementById('testimonialForm').reset();
            document.getElementById('testimonialId').value = '';
            document.getElementById('testimonialCurrentImage').value = '';
            document.getElementById('testimonialImagePreview').innerHTML = '';
            document.getElementById('testimonialSubmit').name = 'add_testimonial';
            document.getElementById('testimonialSubmit').innerHTML = '<i class="bi bi-plus-circle"></i> Thêm mới';
        }

        // Add image preview functionality
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const previewId = this.closest('form').id + 'ImagePreview';
                const preview = document.getElementById(previewId);
                preview.innerHTML = '';
                
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'image-preview';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        
                        const removeBtn = document.createElement('span');
                        removeBtn.className = 'remove-image';
                        removeBtn.innerHTML = '×';
                        removeBtn.onclick = function() {
                            preview.innerHTML = '';
                            input.value = '';
                        };

                        // Add update button
                        const updateBtn = document.createElement('button');
                        updateBtn.className = 'btn btn-sm btn-primary mt-2';
                        updateBtn.innerHTML = '<i class="bi bi-upload"></i> Cập nhật';
                        updateBtn.onclick = function() {
                            const form = input.closest('form');
                            const table = form.id.replace('Form', '');
                            const id = form.querySelector('input[name="id"]').value;
                            
                            if (!id) {
                                alert('Vui lòng lưu thông tin trước khi cập nhật hình ảnh');
                                return;
                            }

                            const formData = new FormData();
                            formData.append('table', table);
                            formData.append('id', id);
                            formData.append('image', e.target.result);

                            fetch('update_image.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Cập nhật hình ảnh thành công!');
                                    location.reload();
                                } else {
                                    alert('Có lỗi xảy ra: ' + data.error);
                                }
                            })
                            .catch(error => {
                                alert('Có lỗi xảy ra khi cập nhật hình ảnh');
                                console.error('Error:', error);
                            });
                        };
                        
                        div.appendChild(img);
                        div.appendChild(removeBtn);
                        div.appendChild(updateBtn);
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
</body>
</html>
