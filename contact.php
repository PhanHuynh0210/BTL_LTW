<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Store</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="css/contact.css">
    <!-- <link rel="stylesheet" href="pages/contact/contact.css"> -->
</head>

<body>
    <!--Header-->
    <?php
    include("components/header.php")
    ?>
    <div class="container my-5">
        <img src="assets/contact.jpg" alt="contact" class="img-fluid mb-4 rounded shadow">

        <!-- Online Sales -->
        <div class="card contact-card mb-4">
            <div class="card-body">
                <h2 class="card-title text-primary">Bán hàng online</h2>
                <p>Tư vấn & Mua hàng trực tuyến: <strong>1900.2109</strong> (08:30 - 12:00; 13:30 - 21:30)</p>
                <p class="mb-1">Số điện thoại liên hệ:</p>
                <ul class="ps-3">
                    <li>Hà Nội: (077).3646912</li>
                    <li>Đà Nẵng: (077).3646912</li>
                    <li>TP.Hồ Chí Minh: (077).3646912</li>
                </ul>
                <p>Email hỗ trợ bán hàng Online, doanh nghiệp: <a href="mailto:dienthoaithongminh@gmail.com">dienthoaithongminh@gmail.com</a></p>
                <p>Email hỗ trợ chung: <a href="mailto:dienthoaithongminh@gmail.com">dienthoaithongminh@gmail.com</a></p>
            </div>
        </div>

        <!-- Customer Care -->
        <div class="card contact-card mb-4">
            <div class="card-body">
                <h2 class="card-title text-primary">Chăm sóc khách hàng</h2>
                <p>Bộ phận Chăm sóc khách hàng là bộ phận chuyên tiếp nhận góp ý, thắc mắc & phản hồi của khách hàng trước, đang và sau khi mua hàng.</p>
                <p>Với đội ngũ nhân viên năng động & sẵn sàng lắng nghe, mọi thắc mắc về dịch vụ, chất lượng sản phẩm,... đều sẽ được tiếp nhận và tư vấn rõ ràng.</p>
                <p>Quý khách vui lòng liên hệ qua:</p>
                <ul class="ps-3">
                    <li>Email: <a href="mailto:dttmcskh@gmail.com">dttmcskh@gmail.com</a></li>
                    <li>Hotline: 1900 2000</li>
                    <li>Zalo: /ZaloDienThoaiThongMinh</li>
                    <li>Facebook: /DienThoaiThongMinhOfficial</li>
                </ul>
            </div>
        </div>

        <!-- Technical Support -->
        <div class="card contact-card mb-4">
            <div class="card-body">
                <h2 class="card-title text-primary">Hỗ trợ kỹ thuật</h2>
                <ul class="ps-3">
                    <li>Miền Bắc: 27A Nguyễn Công Trứ, P.Đồng Nhân, Q.Hai Bà Trưng, HN (SĐT 093.235.10.80)</li>
                    <li>Miền Trung: 27A Nguyễn Công Trứ, P.Đồng Nhân, Q.Hai Bà Trưng, Đà Nẵng (SĐT 093.235.10.80)</li>
                    <li>Miền Nam: 27A Nguyễn Công Trứ, P.Đồng Nhân, Q.Hai Bà Trưng, TP.HCM (SĐT 093.235.10.80)</li>
                </ul>
            </div>
        </div>
    </div>

    <!--Footer-->
    <?php
    include("components/footer.php")
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>