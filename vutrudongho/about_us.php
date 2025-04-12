<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vũ Trụ Đồng Hồ</title>
    <link rel="shortcut icon" href="assets/Img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/about_us.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap&amp;_cacheOverride=1679484892371"
        data-tag="font">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        data-tag="font">
    <style>
        /* Thêm các style cần thiết */
        .section-title {
            color: #333; 
            margin-bottom: 30px; 
            font-size: 28px;
            text-align: center;
        }
        
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .value-item {
            width: 250px; 
            padding: 25px 15px; 
            background-color: #f8f8f8; 
            border-radius: 8px; 
            margin-bottom: 20px;
            text-align: center;
        }
        
        .brand-item {
            width: 150px; 
            height: 100px; 
            background-color: #fff; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 5px; 
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .team-member {
            width: 250px; 
            background-color: #f8f8f8; 
            border-radius: 8px; 
            overflow: hidden; 
            margin-bottom: 20px;
        }
        
        .testimonial {
            width: 350px; 
            background-color: #f8f8f8; 
            padding: 25px; 
            border-radius: 8px; 
            text-align: left; 
            margin-bottom: 20px; 
            position: relative;
        }
        
        .bg-light {
            background-color: #f8f8f8;
        }
        
        .flex-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>

<body style="position: relative;">
    <!--Start: Header-->
    <div id="bar-header">
        <?php include("components/header.php"); ?>
    </div>
    <!--End: Header-->

    <div id="container-aboutUs" style="position: relative;top:50px;height: fit-content;width: 100%;display: flex;flex-direction: column;align-items: center;">
        <?php
        // Kết nối database
        require_once "mainproduct/CONNECT.PHP";
        
        // Lấy thông tin công ty
        $companyInfo = $conn->query("SELECT * FROM company_info LIMIT 1")->fetch_assoc();
        ?>
        
        <!-- Banner -->
        <img src="<?= $companyInfo['banner_path'] ?>" width="100%" alt="Banner giới thiệu">
        
        <!-- Giới thiệu công ty -->
        <div id="main-aboutUs" style="display: flex;flex-direction: row; margin: 40px 0;">
            <div id="img-aboutUs-div" style="flex: 1; padding: 20px;">
                <img id="img-aboutUs" src="<?= $companyInfo['about_image_path'] ?>" width="100%" alt="Ảnh giới thiệu">
            </div>
            <div id="content-aboutUs" style="flex: 2; display: flex;align-items: center; padding: 20px;">
                <p id="text-content-aboutUs" style="text-align: justify;">
                    <?= $companyInfo['description'] ?>
                </p>
            </div>
        </div>
        
        <!-- Tầm nhìn & Sứ mệnh -->
        <div id="vision-mission" class="bg-light" style="width: 100%; padding: 40px 20px;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <h2 class="section-title">TẦM NHÌN & SỨ MỆNH</h2>
                <div class="flex-container">
                    <?php
                    $visionMission = $conn->query("SELECT * FROM vision_mission ORDER BY type DESC");
                    while ($row = $visionMission->fetch_assoc()) {
                        ?>
                    <div class="card" style="flex: 1; min-width: 300px;">
                        <h3 style="color: #1a1a1a; margin-bottom: 20px; font-size: 22px;"><?= $row['title'] ?></h3>
                        <p style="text-align: justify; line-height: 1.6;">
                            <?= $row['content'] ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Giá trị cốt lõi -->
        <div id="core-values" style="width: 100%; padding: 40px 20px;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 class="section-title">GIÁ TRỊ CỐT LÕI</h2>
                <div class="flex-container">
                    <?php
                    $coreValues = $conn->query("SELECT * FROM core_values ORDER BY sort_order");
                    while ($value = $coreValues->fetch_assoc()
) {
                    ?>
                    <div class="value-item">
                        <?php if($value['icon_path']) { ?>
                        <img src="<?= $value['icon_path'] ?>" alt="<?= $value['title'] ?>" style="width: 60px; height: 60px; margin-bottom: 15px;">
                        <?php } ?>
                        <h3 style="font-size: 18px; margin-bottom: 10px; color: #1a1a1a;"><?= $value['title'] ?></h3>
                        <p style="text-align: center; line-height: 1.5;"><?= $value['description'] ?></p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Thương hiệu hợp tác -->
        <div id="brands" class="bg-light" style="width: 100%; padding: 40px 20px;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 class="section-title">THƯƠNG HIỆU HỢP TÁC</h2>
                <p style="max-width: 800px; margin: 0 auto 30px; text-align: center; line-height: 1.6;">
                    Vũ Trụ Đồng Hồ tự hào là đối tác phân phối chính thức của nhiều thương hiệu đồng hồ nổi tiếng trên thế giới. 
                    Chúng tôi cam kết mang đến những sản phẩm chính hãng với mẫu mã đa dạng và giá cả cạnh tranh.
                </p>
                <div class="flex-container" style="gap: 40px; margin-top: 20px;">
                    <?php
                    $brands = $conn->query("SELECT * FROM brands ORDER BY sort_order");
                    while ($brand = $brands->fetch_assoc()
) {
                    ?>
                    <div class="brand-item">
                        <img src="<?= $brand['logo_path'] ?>" alt="<?= $brand['name'] ?>" style="max-width: 80%; max-height: 80%;">
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Đội ngũ chuyên gia -->
        <div id="our-team" style="width: 100%; padding: 40px 20px;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 class="section-title">ĐỘI NGŨ CHUYÊN GIA</h2>
                <p style="max-width: 800px; margin: 0 auto 30px; text-align: center; line-height: 1.6;">
                    Đội ngũ tư vấn viên tại Vũ Trụ Đồng Hồ được đào tạo chuyên sâu về sản phẩm, có kiến thức chuyên môn cao và nhiều năm kinh nghiệm trong lĩnh vực đồng hồ.
                </p>
                <div class="flex-container" style="gap: 30px; margin-top: 20px;">
                    <?php
                    $teamMembers = $conn->query("SELECT * FROM team_members ORDER BY sort_order");
                    while ($member = $teamMembers->fetch_assoc()
) {
                    ?>
                    <div class="team-member">
                        <?php if($member['image_path']) { ?>
                        <img src="<?= $member['image_path'] ?>" alt="<?= $member['name'] ?>" style="width: 100%; height: 250px; object-fit: cover;">
                        <?php } ?>
                        <div style="padding: 15px;">
                            <h3 style="font-size: 18px; margin-bottom: 5px; color: #1a1a1a;"><?= $member['name'] ?></h3>
                            <p style="color: #666; margin-bottom: 10px;"><?= $member['position'] ?></p>
                            <p style="text-align: center; line-height: 1.5; font-size: 14px;"><?= $member['description'] ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Cam kết của chúng tôi -->
        <div id="our-commitment" class="bg-light" style="width: 100%; padding: 40px 20px;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 class="section-title">CAM KẾT CỦA CHÚNG TÔI</h2>
                <div style="display: flex; flex-direction: column; gap: 20px; max-width: 800px; margin: 0 auto;">
                    <?php
                    $commitments = $conn->query("SELECT * FROM commitments ORDER BY sort_order");
                    while ($commitment = $commitments->fetch_assoc()
) {
                    ?>
                    <div class="card" style="text-align: left;">
                        <h3 style="font-size: 18px; margin-bottom: 10px; color: #1a1a1a;"><?= $commitment['title'] ?></h3>
                        <p style="line-height: 1.6;">
                            <?= $commitment['description'] ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Đánh giá khách hàng -->
        <div id="testimonials" style="width: 100%; padding: 40px 20px;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 class="section-title">KHÁCH HÀNG NÓI GÌ VỀ CHÚNG TÔI</h2>
                <div class="flex-container">
                    <?php
                    $testimonials = $conn->query("SELECT * FROM testimonials ORDER BY sort_order");
                    while ($testimonial = $testimonials->fetch_assoc()
) {
                    ?>
                    <div class="testimonial">
                        <div style="font-size: 40px; color: #ddd; position: absolute; top: 15px; left: 20px;">"</div>
                        <p style="margin-top: 20px; line-height: 1.6; font-style: italic;">
                            <?= $testimonial['content'] ?>
                        </p>
                        <div style="margin-top: 20px; display: flex; align-items: center;">
                            <?php if($testimonial['image_path']) { ?>
                            <img src="<?= $testimonial['image_path'] ?>" alt="<?= $testimonial['customer_name'] ?>" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 15px;">
                            <?php } ?>
                            <div>
                                <h4 style="margin: 0; font-size: 16px;"><?= $testimonial['customer_name'] ?></h4>
                                <?php if($testimonial['location']) { ?>
                                <p style="margin: 5px 0 0; color: #666; font-size: 14px;"><?= $testimonial['location'] ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Hệ thống cửa hàng -->
        <a name="He_thong_cua_hang_tren_toan_quoc"></a>
        <a name="He_thong_cua_hang_mien_bac"></a>
        <a name="He_thong_cua_hang_mien_trung"></a>
        <a name="He_thong_cua_hang_mien_nam"></a>
        <img src="assets/Img/hoangImg/imgs/banner_hethongcuahang.png" width="100%" alt="Hệ thống cửa hàng">
        
        <div id="container-hethongcuahang" style="display: flex;flex-direction: row;width: 100%;height: fit-content; background-color: #333; color: white; padding: 20px 0;">
            <?php
            $regions = ['north' => 'Miền Bắc', 'central' => 'Miền Trung', 'south' => 'Miền Nam'];
            
            foreach ($regions as $region => $regionName) {
                $stores = $conn->prepare("SELECT * FROM stores WHERE region = :region ORDER BY sort_order");
                $stores->execute([':region' => $region]);
            ?>
            <div style="display: flex;flex-direction: column;width: calc(100%/3);height: fit-content;align-items: center; padding: 0 15px;">
                <h3 style="color: #fff; margin-bottom: 20px; text-align: center;"><?= $regionName ?></h3>
                <?php while ($store = $stores->fetch_assoc()
) { ?>
                <div style="display: flex;flex-direction: row;margin-top: 8px; width: 100%;">
                    <img src="assets/Img/hoangImg/icons/icons8-location-24.png" alt="" style="margin-right: 10px;">
                    <p style="line-height: 24px;color: #fff;"><?= $store['address'] ?></p>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <!--Start: Footer-->
    <div id="my-footer" style="margin-top: 50px;">
        <?php include("components/footer.php"); ?>
    </div>
    <!--End: Footer-->
    
    <!--start Hiện thanh line-->
    <script>
        var lineHome = document.getElementById("navbarAbout");
        lineHome.style.borderBottom = '2px solid #fff';
        lineHome.style.paddingBottom = '1.15px';
    </script>
</body>
</html>