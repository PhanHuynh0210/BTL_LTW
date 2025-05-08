<?php
require_once 'database.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['add_faq'])) {
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $category = $_POST['category'];
            $stmt = $pdo->prepare("INSERT INTO faqs (question, answer, category) VALUES (?, ?, ?)");
            if ($stmt->execute([$question, $answer, $category])) {
                $message = "Đã thêm câu hỏi mới thành công!";
            }
        }

        if (isset($_POST['edit_faq'])) {
            $id = $_POST['id'];
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $category = $_POST['category'];
            $stmt = $pdo->prepare("UPDATE faqs SET question = ?, answer = ?, category = ? WHERE id = ?");
            if ($stmt->execute([$question, $answer, $category, $id])) {
                $message = "Đã cập nhật câu hỏi thành công!";
            }
        }
    } catch (PDOException $e) {
        $error = "Có lỗi xảy ra: " . $e->getMessage();
    }
}

// Fetch existing FAQs
try {
    $faqs = $pdo->query("SELECT * FROM faqs ORDER BY category, id DESC")->fetchAll();
} catch (PDOException $e) {
    $error = "Có lỗi xảy ra khi truy vấn dữ liệu: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hỏi/Đáp</title>
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
                    <h2 class="mb-0">Quản lý Hỏi/Đáp</h2>
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

                <!-- FAQ Form Section -->
               

                <!-- FAQ List Section -->
                <div class="card section">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list"></i> Danh sách câu hỏi</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Danh mục</th>
                                        <th>Câu hỏi</th>
                                        <th>Câu trả lời</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($faqs as $faq): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $categories = [
                                                'general' => 'Chung',
                                                'product' => 'Sản phẩm',
                                                'shipping' => 'Vận chuyển',
                                                'payment' => 'Thanh toán',
                                                'warranty' => 'Bảo hành'
                                            ];
                                            echo $categories[$faq['category']] ?? $faq['category'];
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($faq['question']); ?></td>
                                        <td><?php echo htmlspecialchars($faq['answer']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editFaqModal<?php echo $faq['id']; ?>">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="delete_faq" value="1">
                                                <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal sửa FAQ -->
                                    <div class="modal fade" id="editFaqModal<?php echo $faq['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa câu hỏi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="edit_faq" value="1">
                                                        <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Danh mục</label>
                                                            <select name="category" class="form-select" required>
                                                                <option value="general" <?php echo $faq['category'] === 'general' ? 'selected' : ''; ?>>Chung</option>
                                                                <option value="product" <?php echo $faq['category'] === 'product' ? 'selected' : ''; ?>>Sản phẩm</option>
                                                                <option value="shipping" <?php echo $faq['category'] === 'shipping' ? 'selected' : ''; ?>>Vận chuyển</option>
                                                                <option value="payment" <?php echo $faq['category'] === 'payment' ? 'selected' : ''; ?>>Thanh toán</option>
                                                                <option value="warranty" <?php echo $faq['category'] === 'warranty' ? 'selected' : ''; ?>>Bảo hành</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Câu hỏi</label>
                                                            <input type="text" name="question" class="form-control" value="<?php echo htmlspecialchars($faq['question']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Câu trả lời</label>
                                                            <textarea name="answer" class="form-control" rows="4" required><?php echo htmlspecialchars($faq['answer']); ?></textarea>
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

                <!-- Modal thêm FAQ -->
                <div class="modal fade" id="addFaqModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm câu hỏi mới</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="add_faq" value="1">
                                    <div class="mb-3">
                                        <label class="form-label">Danh mục</label>
                                        <select name="category" class="form-select" required>
                                            <option value="general">Chung</option>
                                            <option value="product">Sản phẩm</option>
                                            <option value="shipping">Vận chuyển</option>
                                            <option value="payment">Thanh toán</option>
                                            <option value="warranty">Bảo hành</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Câu hỏi</label>
                                        <input type="text" name="question" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Câu trả lời</label>
                                        <textarea name="answer" class="form-control" rows="4" required></textarea>
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
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function deleteItem(table, id) {
            if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
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
                        alert('Có lỗi xảy ra khi xóa câu hỏi');
                    }
                });
            }
        }

        function editFaq(data) {
            document.getElementById('faqId').value = data.id;
            document.querySelector('#faqForm select[name="category"]').value = data.category;
            document.querySelector('#faqForm input[name="question"]').value = data.question;
            document.querySelector('#faqForm textarea[name="answer"]').value = data.answer;
            document.getElementById('faqSubmit').name = 'edit_faq';
            document.getElementById('faqSubmit').innerHTML = '<i class="bi bi-save"></i> Cập nhật';
        }

        function resetFaqForm() {
            document.getElementById('faqForm').reset();
            document.getElementById('faqId').value = '';
            document.getElementById('faqSubmit').name = 'add_faq';
            document.getElementById('faqSubmit').innerHTML = '<i class="bi bi-plus-circle"></i> Thêm mới';
        }
    </script>
</body>
</html> 