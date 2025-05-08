<?php
require 'database.php';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT * FROM posts";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$sql = "SELECT * FROM banner";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$carouselImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <!--Start Nut di chuyen-->
    <div id="btnLenXuong">
        <img id="btn-top" src="assets/slideup.png" alt="slideup">
        <img id="scroll-to-bottom" onclick="scrollToBottom()" src="assets/slidedown.png" alt="slidedown">
    </div>
    <!--End nut di chuyen-->

    <!--Header-->
    <?php include("components/header.php") ?>

    <!-- Banner-carousel -->
    <div class="banner-carousel">
        <div id="banner-carousel" class="carousel slide" data-bs-ride="carousel">

            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php foreach ($carouselImages as $index => $image): ?>
                    <button type="button"
                        data-bs-target="#banner-carousel"
                        data-bs-slide-to="<?= $index ?>"
                        <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>
                        aria-label="Slide <?= $index + 1 ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- Carousel items -->
            <div class="carousel-inner">
                <?php foreach ($carouselImages as $index => $image): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($image['image_path']) ?>"
                            class="d-block w-100"
                            alt="<?= htmlspecialchars($image['alt_text']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#banner-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#banner-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>
    </div>

    <!-- SALE-carousel -->
    <div class="container my-5">
        <div class="product-carousel p-4 position-relative">

            <!-- Title -->
            <h2 class="text-center mb-4 fw-bold">
                SẢN PHẨM GIÁ SỐC
            </h2>

            <!-- Carousel -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <div class="row g-3">
                            <!-- Product 1 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/iphone2.webp" class="card-img-top" alt="iPhone 12">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">iPhone 12 128GB (Chính Hãng VN/A)</h5>
                                            <p class="text-danger fw-bold">19,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product 2 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/samsung2.webp" class="card-img-top" alt="iPhone X">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">iPhone X 256GB (Chưa Active) mới 100% fullbox</h5>
                                            <p class="text-danger fw-bold">15,390,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product 3 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/xiaomi2.webp" class="card-img-top" alt="Samsung S9 Plus">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">Samsung Galaxy S9 Plus 256GB 2 Sim Mới 100%</h5>
                                            <p class="text-danger fw-bold">7,290,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product 4 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/vivo2.webp" class="card-img-top" alt="Samsung S20 Plus">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">Samsung Galaxy S20 Plus (128GB) Công Ty mới</h5>
                                            <p class="text-danger fw-bold">13,990,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                    <!-- More slides if needed -->
                    <div class="carousel-item">
                        <div class="row g-3">
                            <!-- Product 5 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/oppo2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/iphone2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/samsung2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/xiaomi2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Add more products if needed -->
                        </div>
                    </div>

                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>
        </div>
    </div>

    <!-- NEWPRODUCT-carousel -->
    <div class="container my-5">
        <div class="product-carousel p-4 position-relative">

            <!-- Title -->
            <h2 class="text-center mb-4 fw-bold">
                SẢN PHẨM MỚI VỀ
            </h2>

            <!-- Carousel -->
            <div id="newproductCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <div class="row g-3">
                            <!-- Product 1 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/iphone2.webp" class="card-img-top" alt="iPhone 12">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">iPhone 12 128GB (Chính Hãng VN/A)</h5>
                                            <p class="text-danger fw-bold">19,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product 2 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/samsung2.webp" class="card-img-top" alt="iPhone X">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">iPhone X 256GB (Chưa Active) mới 100% fullbox</h5>
                                            <p class="text-danger fw-bold">15,390,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product 3 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/xiaomi2.webp" class="card-img-top" alt="Samsung S9 Plus">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">Samsung Galaxy S9 Plus 256GB 2 Sim Mới 100%</h5>
                                            <p class="text-danger fw-bold">7,290,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product 4 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/vivo2.webp" class="card-img-top" alt="Samsung S20 Plus">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">Samsung Galaxy S20 Plus (128GB) Công Ty mới</h5>
                                            <p class="text-danger fw-bold">13,990,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                    <!-- More slides if needed -->
                    <div class="carousel-item">
                        <div class="row g-3">
                            <!-- Product 5 -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/oppo2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/iphone2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/samsung2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="card-link">
                                    <div class="card h-100">
                                        <img src="assets/xiaomi2.webp" class="card-img-top" alt="Oppo Reno5">
                                        <div class="card-body text-center">
                                            <span class="badge bg-success">HOT</span>
                                            <h5 class="card-title mt-2">OPPO Reno5 4G (8GB – 128GB) Công Ty mới fullbox</h5>
                                            <p class="text-danger fw-bold">6,890,000 ₫</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Add more products if needed -->
                        </div>
                    </div>

                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#newproductCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newproductCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>
        </div>
    </div>

    <!-- NEWS-carousel -->
    <div class="container my-5">
        <div class="product-carousel p-4 position-relative">

            <!-- Title -->
            <h2 class="text-center mb-4 fw-bold">
                BLOG CÔNG NGHỆ
            </h2>

            <!-- Carousel -->
            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">
                    <?php
                    $chunks = array_chunk($posts, 4); // 4 posts per slide
                    foreach ($chunks as $index => $chunk): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row g-3">
                                <?php foreach ($chunk as $post): ?>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <a href="news-detail.php?id=<?= $post['id'] ?>" class="card-link">
                                            <div class="card h-100">
                                                <img src="<?= htmlspecialchars($post['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title mt-2"><?= htmlspecialchars($post['title']) ?></h5>
                                                    <p class="text-secondary fw-bold"><?= date('d/m/Y', strtotime($post['created_at'] ?? 'now')) ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>
        </div>
    </div>

    <?php
    // Fetch all phone brands
    $sql_brands = "SELECT * FROM phone_brands";
    $stmt_brands = $pdo->prepare($sql_brands);
    $stmt_brands->execute();
    $brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);

    // Start the section for phone brands
    echo '<div class="container my-5 overview">';
    echo '<h1 class="text-center mb-4">Các hãng điện thoại chúng tôi đang kinh doanh</h1>';
    echo '<div class="overview_img">';

    // Loop through each brand and generate HTML for the brand box
    foreach ($brands as $brand) {
        $brand_name = $brand['name'];
        $brand_id = $brand['id'];

        // Fetch the first image for the brand (for the thumbnail)
        $sql_images = "SELECT * FROM brand_images WHERE brand_id = :brand_id LIMIT 1";
        $stmt_images = $pdo->prepare($sql_images);
        $stmt_images->execute(['brand_id' => $brand_id]);
        $image = $stmt_images->fetch(PDO::FETCH_ASSOC);

        // Generate the brand box with image and clickable link
        echo '<div class="brand-box position-relative">';
        echo '<img src="' . $image['image_path'] . '" alt="' . strtolower($brand_name) . '">';
        echo '<a class="brand-name" onclick="window.location.href=\'#' . strtolower($brand_name) . '_section\'">' . strtoupper($brand_name) . '</a>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
    ?>

    <?php
    // Fetch all brands from the phone_brands table
    $sql_brands = "SELECT * FROM phone_brands";
    $stmt_brands = $pdo->query($sql_brands);
    $brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the brands
    foreach ($brands as $brand) {
        // Fetch associated images for the current brand
        $sql_images = "SELECT * FROM brand_images WHERE brand_id = :brand_id";
        $stmt_images = $pdo->prepare($sql_images);
        $stmt_images->execute(['brand_id' => $brand['id']]);
        $images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);

        // Generate the HTML for each brand section
        echo '<div class="phone_section container py-5 shadow-sm" id="' . strtolower($brand['name']) . '_section">';
        echo '<h1 class="text-center mb-4">' . $brand['name'] . '</h1>';

        echo '<div class="row align-items-center mb-4 ip_header">';
        echo '<div class="col-md-5 text-center">';
        echo '<img src="' . $images[0]['image_path'] . '" alt="' . strtolower($brand['name']) . '" class="img-fluid rounded">';
        echo '</div>';
        echo '<div class="col-md-7">';
        echo '<p class="fs-5">' . $brand['description'] . '</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="row g-3">';
        // Loop through the images for the current brand and display them
        foreach ($images as $index => $image) {
            // Skip the first image as it has already been displayed above
            if ($index > 0) {
                echo '<div class="col-md-6">';
                echo '<img src="' . $image['image_path'] . '" alt="' . strtolower($brand['name']) . '_ad' . ($index) . '" class="img-fluid rounded shadow-sm">';
                echo '</div>';
            }
        }
        echo '</div>';
        echo '</div>';
    }
    ?>

    <!-- section-nav -->
    <!-- <div class="container my-5 overview">
        <h1 class="text-center mb-4">Các hãng điện thoại chúng tôi đang kinh doanh</h1>
        <div class="overview_img">
            <div class="brand-box position-relative">
                <img src="assets/iphone2.webp" alt="iphone">
                <a class="brand-name" onclick="window.location.href='#iphone_section'">IPHONE</a>
            </div>
            <div class="brand-box position-relative">
                <img src="assets/samsung2.webp" alt="samsung">
                <a class="brand-name" onclick="window.location.href='#samsung_section'">SAMSUNG</a>
            </div>
            <div class="brand-box position-relative">
                <img src="assets/xiaomi2.webp" alt="xiaomi">
                <a class="brand-name" onclick="window.location.href='#xiaomi_section'">XIAOMI</a>
            </div>
            <div class="brand-box position-relative">
                <img src="assets/vivo2.webp" alt="vivo">
                <a class="brand-name" onclick="window.location.href='#vivo_section'">VIVO</a>
            </div>
            <div class="brand-box position-relative">
                <img src="assets/oppo2.webp" alt="oppo">
                <a class="brand-name" onclick="window.location.href='#oppo_section'">OPPO</a>
            </div>
        </div>
    </div> -->

    <!-- IPHONE-section -->
    <!-- <div class="phone_section container py-5 shadow-sm" id="iphone_section">
        <h1 class="text-center mb-4">iPhone</h1>

        <div class="row align-items-center mb-4 ip_header">
            <div class="col-md-5 text-center">
                <img src="assets/iphone2.webp" alt="iphone" class="img-fluid rounded">
            </div>
            <div class="col-md-7">
                <p class="fs-5">
                    iPhone là dòng điện thoại thông minh cao cấp do Apple phát triển, nổi bật với thiết kế sang trọng,
                    hiệu năng mạnh mẽ và hệ điều hành iOS mượt mà. Với các tính năng hiện đại như Face ID,
                    camera chất lượng cao và khả năng bảo mật vượt trội,
                    iPhone luôn là lựa chọn hàng đầu của người dùng yêu công nghệ trên toàn thế giới.
                </p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <img src="assets/ip_add1.jpg" alt="ip_add1" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <img src="assets/ip_add2.avif" alt="ip_add2" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div> -->

    <!-- SAMSUNG-section -->
    <!-- <div class="phone_section container py-5 shadow-sm" id="samsung_section">
        <h1 class="text-center mb-4">Samsung</h1>

        <div class="row align-items-center mb-4 ip_header">
            <div class="col-md-5 text-center">
                <img src="assets/samsung2.webp" alt="samsung" class="img-fluid rounded">
            </div>
            <div class="col-md-7">
                <p class="fs-5">
                    Samsung là thương hiệu điện thoại thông minh hàng đầu đến từ Hàn Quốc,
                    nổi bật với thiết kế hiện đại, màn hình sắc nét và công nghệ tiên tiến.
                    Các dòng sản phẩm như Galaxy S và Galaxy Z luôn đi đầu trong đổi mới với tính năng gập mở,
                    camera chất lượng cao và hiệu năng mạnh mẽ, đáp ứng mọi nhu cầu từ công việc đến giải trí của người
                    dùng.
                </p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <img src="assets/samsung_ad1.jpg" alt="samsung_ad1" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <img src="assets/samsung_ad2.jpg" alt="samsung_ad2" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div> -->

    <!-- XIAOMI-section -->
    <!-- <div class="phone_section container py-5 shadow-sm" id="xiaomi_section">
        <h1 class="text-center mb-4">Xiaomi</h1>

        <div class="row align-items-center mb-4 ip_header">
            <div class="col-md-5 text-center">
                <img src="assets/xiaomi2.webp" alt="xiaomi" class="img-fluid rounded">
            </div>
            <div class="col-md-7">
                <p class="fs-5">
                    Xiaomi là thương hiệu điện thoại thông minh đến từ Trung Quốc, được biết đến với hiệu năng mạnh mẽ,
                    thiết kế hiện đại và mức giá phải chăng.
                    Với các dòng sản phẩm đa dạng từ phổ thông đến cao cấp như Redmi và Xiaomi series,
                    hãng mang đến trải nghiệm công nghệ vượt trội phù hợp với mọi đối tượng người dùng.
                    Xiaomi không ngừng đổi mới để đem lại giá trị tối ưu cho khách hàng trên toàn thế giới.
                </p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <img src="assets/xiaomi_ad1.jpg" alt="xiaomi_ad1" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <img src="assets/xiaomi_ad2.jpg" alt="xiaomi_ad2" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div> -->

    <!-- VIVO-section -->
    <!-- <div class="phone_section container py-5 shadow-sm" id="vivo_section">
        <h1 class="text-center mb-4">Vivo</h1>

        <div class="row align-items-center mb-4 ip_header">
            <div class="col-md-5 text-center">
                <img src="assets/vivo2.webp" alt="vivo" class="img-fluid rounded">
            </div>
            <div class="col-md-7">
                <p class="fs-5">
                    Vivo là thương hiệu điện thoại thông minh nổi bật đến từ Trung Quốc,
                    gây ấn tượng với thiết kế thời trang, camera chất lượng cao và công nghệ âm thanh tiên tiến.
                    Các dòng sản phẩm của Vivo không chỉ đáp ứng tốt nhu cầu giải trí, chụp ảnh mà còn có hiệu năng ổn
                    định,
                    giao diện thân thiện và mức giá hợp lý, phù hợp với nhiều đối tượng người dùng.
                </p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <img src="assets/vivo_ad1.png" alt="vivo_ad1" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <img src="assets/vivo_ad2.jpg" alt="vivo_ad2" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div> -->

    <!-- OPPO-section -->
    <!-- <div class="phone_section container py-5 shadow-sm" id="oppo_section">
        <h1 class="text-center mb-4">Oppo</h1>

        <div class="row align-items-center mb-4 ip_header">
            <div class="col-md-5 text-center">
                <img src="assets/oppo2.webp" alt="oppo" class="img-fluid rounded">
            </div>
            <div class="col-md-7">
                <p class="fs-5">
                    OPPO là thương hiệu điện thoại thông minh nổi tiếng đến từ Trung Quốc,
                    được ưa chuộng nhờ thiết kế tinh tế, camera selfie ấn tượng và công nghệ sạc nhanh VOOC độc quyền.
                    Với các dòng sản phẩm như OPPO Reno và OPPO A series, hãng mang đến trải nghiệm mượt mà,
                    hiện đại cùng mức giá hợp lý, phù hợp với giới trẻ và người dùng yêu thích phong cách năng động.
                </p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <img src="assets/oppo_ad1.avif" alt="oppo_ad1" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <img src="assets/oppo_ad2.jpg" alt="oppo_ad2" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div> -->

    <?php include "components/footer.php"; ?>

    <script>
        const btnTop = document.getElementById("btn-top");
        const btnBottom = document.getElementById("scroll-to-bottom");

        function scrollToBottom() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: "smooth"
            });
        }

        function updateScrollButtons() {
            const scrollY = window.scrollY || window.pageYOffset;
            const windowHeight = window.innerHeight;
            const bodyHeight = document.documentElement.scrollHeight;

            const atTop = scrollY === 0;
            const atBottom = scrollY + windowHeight >= bodyHeight - 2; // -2 để tránh sai số pixel

            // Ẩn hiện các nút theo vị trí
            btnTop.style.display = atTop ? "none" : "block";
            btnBottom.style.display = atBottom ? "none" : "block";
        }

        // Sự kiện khi cuộn và khi load trang
        window.addEventListener("scroll", updateScrollButtons);
        window.addEventListener("load", updateScrollButtons);

        // Nút cuộn lên đầu
        btnTop.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>