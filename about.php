<?php
require_once 'database.php';
$company_info = $pdo->query("SELECT * FROM company_info WHERE id = 1")->fetch();
$vision_mission = $pdo->query("SELECT * FROM vision_mission ORDER BY id DESC")->fetchAll();
$core_values = $pdo->query("SELECT * FROM core_values ORDER BY sort_order ASC")->fetchAll();
$commitments = $pdo->query("SELECT * FROM commitments ORDER BY sort_order ASC")->fetchAll();
$team_members = $pdo->query("SELECT * FROM team_members ORDER BY sort_order ASC")->fetchAll();
$testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY sort_order ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu - <?php echo htmlspecialchars($company_info['name'] ?? 'Công ty'); ?></title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="pages/about/about.css">

</head>

<body>
    <!--Header-->
    <?php
    include("components/header.php")
    ?>
        <main>
        <!-- Hero Section -->
        <div class="hero-section">
            <?php if(!empty($company_info['banner_data'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($company_info['banner_data']) ?>" alt="Banner">
            <?php endif; ?>
            <div class="hero-overlay">
                <div class="container">
                    <h1 class="display-4">Về chúng tôi</h1>
                    <p class="lead">Khám phá câu chuyện và giá trị của chúng tôi</p>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <section class="section bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <?php if(!empty($company_info['about_image_data'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($company_info['about_image_data']) ?>" alt="About Us" class="img-fluid rounded">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h2>Giới thiệu</h2>
                        <p><?php echo nl2br(htmlspecialchars($company_info['description'] ?? '')); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section class="section">
            <div class="container">
                <div class="section-title">
                    <h2>Tầm nhìn & Sứ mệnh</h2>
                    <p>Định hướng và mục tiêu của chúng tôi</p>
                </div>
                <div class="row">
                    <?php foreach ($vision_mission as $vm): ?>
                    <div class="col-md-6 mb-4">
                        <div class="vision-mission-card">
                            <h3><?php echo htmlspecialchars($vm['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($vm['content'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Core Values Section -->
        <section class="section bg-light">
            <div class="container">
                <div class="section-title">
                    <h2>Giá trị cốt lõi</h2>
                    <p>Những nguyên tắc định hướng hoạt động của chúng tôi</p>
                </div>
                <div class="row">
                    <?php foreach ($core_values as $cv): ?>
                    <div class="col-md-4 mb-4">
                        <div class="core-value-card">
                            <h3><?php echo htmlspecialchars($cv['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($cv['description'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Commitments Section -->
        <section class="section">
            <div class="container">
                <div class="section-title">
                    <h2>Cam kết</h2>
                    <p>Những cam kết của chúng tôi với khách hàng</p>
                </div>
                <div class="row">
                    <?php foreach ($commitments as $c): ?>
                    <div class="col-md-4 mb-4">
                        <div class="commitment-card">
                            <?php if(!empty($c['image_data'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($c['image_data']) ?>" alt="<?= htmlspecialchars($c['title']) ?>">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($c['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($c['description'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="section bg-light">
            <div class="container">
                <div class="section-title">
                    <h2>Đội ngũ</h2>
                    <p>Những người đứng sau thành công của chúng tôi</p>
                </div>
                <div class="row">
                    <?php foreach ($team_members as $tm): ?>
                    <div class="col-md-4 mb-4">
                        <div class="team-member-card">
                            <?php if(!empty($tm['image_data'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($tm['image_data']) ?>" alt="<?= htmlspecialchars($tm['name']) ?>">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($tm['name']); ?></h3>
                            <p class="text-muted"><?php echo htmlspecialchars($tm['position']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($tm['description'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="section">
            <div class="container">
                <div class="section-title">
                    <h2>Đánh giá từ khách hàng</h2>
                    <p>Những gì khách hàng nói về chúng tôi</p>
                </div>
                <div class="row">
                    <?php foreach ($testimonials as $t): ?>
                    <div class="col-md-4 mb-4">
                        <div class="testimonial-card">
                            <?php if(!empty($t['image_data'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($t['image_data']) ?>" alt="<?= htmlspecialchars($t['customer_name']) ?>">
                            <?php endif; ?>
                            <p class="mb-3"><?php echo nl2br(htmlspecialchars($t['content'])); ?></p>
                            <h4><?php echo htmlspecialchars($t['customer_name']); ?></h4>
                            <p class="text-muted"><?php echo htmlspecialchars($t['location']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Store Locations -->
        <section id="store-locations" class="bg-dark text-white py-5">
            <div class="container-fluid">
                <a name="He_thong_cua_hang_tren_toan_quoc"></a>
                <a name="He_thong_cua_hang_mien_bac"></a>
                <a name="He_thong_cua_hang_mien_trung"></a>
                <a name="He_thong_cua_hang_mien_nam"></a>
                
                <div class="row g-4">
                    <?php
                    $regions = ['north' => 'Miền Bắc', 'central' => 'Miền Trung', 'south' => 'Miền Nam'];
                    $sqlStores = "SELECT * FROM stores WHERE region = :region_key ORDER BY sort_order";
                    
                    try {
                        $stmtStores = $pdo->prepare($sqlStores);

                        foreach ($regions as $region_code => $regionName) {
                    ?>
                    <div class="col-lg-4 mb-4">
                        <h3 class="h4 text-center mb-4"><?= htmlspecialchars($regionName) ?></h3>
                        <div class="list-group">
                            <?php
                            if ($stmtStores) {
                                $stmtStores->execute([':region_key' => $region_code]);
                                while ($store = $stmtStores->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="location-item p-3 border-bottom border-secondary">
                                <div class="d-flex">
                                    <i class="fas fa-map-marker-alt me-3 mt-1 text-primary"></i>
                                    <p class="mb-0"><?= htmlspecialchars($store['address']) ?></p>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    } catch (PDOException $e) {
                        error_log("Error fetching stores: " . $e->getMessage());
                    ?>
                    <div class="col-12 text-center">
                        <div class="alert alert-dark">Không thể tải danh sách cửa hàng.</div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <!--Footer-->
    <?php
    include("components/footer.php")
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>