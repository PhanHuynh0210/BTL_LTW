<?php
require_once 'database.php';

try {
    $faqs = $pdo->query("SELECT * FROM faqs ORDER BY category, id DESC")->fetchAll();
    
    // Group FAQs by category
    $grouped_faqs = [];
    foreach ($faqs as $faq) {
        $category = $faq['category'];
        if (!isset($grouped_faqs[$category])) {
            $grouped_faqs[$category] = [];
        }
        $grouped_faqs[$category][] = $faq;
    }
    
    $categories = [
        'general' => 'Chung',
        'product' => 'Sản phẩm',
        'shipping' => 'Vận chuyển',
        'payment' => 'Thanh toán',
        'warranty' => 'Bảo hành'
    ];
} catch (PDOException $e) {
    $error = "Có lỗi xảy ra khi truy vấn dữ liệu: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câu hỏi thường gặp - DiDongThongMinh</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="components/header.css">
    <style>
        .faq-section {
            margin-bottom: 40px;
        }
        .faq-question {
            font-weight: 500;
            color: #0d6efd;
            cursor: pointer;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        .faq-question:hover {
            background-color: #e9ecef;
        }
        .faq-answer {
            padding: 15px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        .faq-answer.show {
            display: block;
        }
        .category-title {
            color: #212529;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0d6efd;
        }
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <div class="container py-5">
        <h1 class="text-center mb-5">Câu hỏi thường gặp</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php foreach ($categories as $category_key => $category_name): ?>
            <?php if (isset($grouped_faqs[$category_key]) && !empty($grouped_faqs[$category_key])): ?>
                <div class="faq-section">
                    <h2 class="category-title"><?php echo htmlspecialchars($category_name); ?></h2>
                    <?php foreach ($grouped_faqs[$category_key] as $faq): ?>
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleAnswer(this)">
                                <i class="fas fa-question-circle me-2"></i>
                                <?php echo htmlspecialchars($faq['question']); ?>
                            </div>
                            <div class="faq-answer">
                                <i class="fas fa-comment-dots me-2"></i>
                                <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleAnswer(element) {
            const answer = element.nextElementSibling;
            answer.classList.toggle('show');
        }
    </script>
</body>
</html> 