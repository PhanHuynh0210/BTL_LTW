<?php
require '../database.php';  

// Fetching the "Bán hàng online" contact information
$sql_onlineSales = "SELECT label, value FROM contact_info WHERE contact_type_id = 1";
$stmt_onlineSales = $pdo->query($sql_onlineSales);
$onlineSales = $stmt_onlineSales->fetchAll(PDO::FETCH_ASSOC);

// Fetching the "Chăm sóc khách hàng" contact information
$sql_customerCare = "SELECT label, value FROM contact_info WHERE contact_type_id = 2";
$stmt_customerCare = $pdo->query($sql_customerCare);
$customerCare = $stmt_customerCare->fetchAll(PDO::FETCH_ASSOC);

// Fetching the "Hỗ trợ kỹ thuật" contact addresses
$sql_technicalSupport = "SELECT region, address, phone FROM contact_addresses WHERE contact_type_id = 3";
$stmt_technicalSupport = $pdo->query($sql_technicalSupport);
$technicalSupport = $stmt_technicalSupport->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page Controller</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="../css/contact.css">
    <!-- <link rel="stylesheet" href="pages/contact/contact.css"> -->
</head>

<body>
    <!--Header-->
    <?php
    include("components/header.php")
    ?>
    <div class="container my-5">
        <div class="container my-5">
            <h1>Welcome to the Contact Page Controller</h1>

            <!-- Online Sales -->
            <div class="card contact-card mb-4">
                <div class="card-body">
                    <h2 class="card-title text-primary">Bán hàng online</h2>
                    <form action="online_sale_update.php" method="POST">
                        <!-- Tư vấn & Mua hàng trực tuyến -->
                        <label for="online_consultation">Tư vấn & Mua hàng trực tuyến:</label>
                        <input type="text" id="online_consultation" name="online_consultation" value="<?php
                                                                                                        foreach ($onlineSales as $contact) {
                                                                                                            if ($contact['label'] == 'Tư vấn & Mua hàng trực tuyến') {
                                                                                                                echo $contact['value'];
                                                                                                            }
                                                                                                        }
                                                                                                        ?>"><br><br>

                        <!-- Email hỗ trợ bán hàng Online -->
                        <label for="online_sales_email">Email hỗ trợ bán hàng Online:</label>
                        <input type="email" id="online_sales_email" name="online_sales_email" value="<?php
                                                                                                        foreach ($onlineSales as $contact) {
                                                                                                            if ($contact['label'] == 'Email hỗ trợ bán hàng Online') {
                                                                                                                echo $contact['value'];
                                                                                                            }
                                                                                                        }
                                                                                                        ?>"><br><br>

                        <!-- Regional Phone Numbers -->
                        <label for="phone_hanoi">Hà Nội:</label>
                        <input type="text" id="phone_hanoi" name="phone_hanoi" value="<?php
                                                                                        foreach ($onlineSales as $contact) {
                                                                                            if ($contact['label'] == 'Hà Nội') {
                                                                                                echo $contact['value'];
                                                                                            }
                                                                                        }
                                                                                        ?>"><br><br>

                        <label for="phone_danang">Đà Nẵng:</label>
                        <input type="text" id="phone_danang" name="phone_danang" value="<?php
                                                                                        foreach ($onlineSales as $contact) {
                                                                                            if ($contact['label'] == 'Đà Nẵng') {
                                                                                                echo $contact['value'];
                                                                                            }
                                                                                        }
                                                                                        ?>"><br><br>

                        <label for="phone_hcm">TP.Hồ Chí Minh:</label>
                        <input type="text" id="phone_hcm" name="phone_hcm" value="<?php
                                                                                    foreach ($onlineSales as $contact) {
                                                                                        if ($contact['label'] == 'TP.Hồ Chí Minh') {
                                                                                            echo $contact['value'];
                                                                                        }
                                                                                    }
                                                                                    ?>"><br><br>

                        <!-- Common Email -->
                        <label for="common_email">Email hỗ trợ chung:</label>
                        <input type="email" id="common_email" name="common_email" value="<?php
                                                                                            foreach ($onlineSales as $contact) {
                                                                                                if ($contact['label'] == 'Email hỗ trợ chung') {
                                                                                                    echo $contact['value'];
                                                                                                }
                                                                                            }
                                                                                            ?>"><br><br>

                        <button type="submit">Update Online Sales Contact</button>
                    </form>
                </div>
            </div>

            <!-- Customer Care -->
            <div class="card contact-card mb-4">
                <div class="card-body">
                    <h2 class="card-title text-primary">Chăm sóc khách hàng</h2>
                    <form action="customer_care_update.php" method="POST">
                        <!-- Email hỗ trợ chăm sóc khách hàng -->
                        <label for="customer_care_email">Email hỗ trợ chăm sóc khách hàng:</label>
                        <input type="email" id="customer_care_email" name="customer_care_email" value="<?php
                                                                                                        foreach ($customerCare as $contact) {
                                                                                                            if ($contact['label'] == 'Email hỗ trợ chăm sóc khách hàng') {
                                                                                                                echo $contact['value'];
                                                                                                            }
                                                                                                        }
                                                                                                        ?>"><br><br>

                        <!-- Hotline -->
                        <label for="customer_care_hotline">Hotline:</label>
                        <input type="text" id="customer_care_hotline" name="customer_care_hotline" value="<?php
                                                                                                            foreach ($customerCare as $contact) {
                                                                                                                if ($contact['label'] == 'Hotline') {
                                                                                                                    echo $contact['value'];
                                                                                                                }
                                                                                                            }
                                                                                                            ?>"><br><br>

                        <!-- Zalo -->
                        <label for="customer_care_zalo">Zalo:</label>
                        <input type="text" id="customer_care_zalo" name="customer_care_zalo" value="<?php
                                                                                                    foreach ($customerCare as $contact) {
                                                                                                        if ($contact['label'] == 'Zalo') {
                                                                                                            echo $contact['value'];
                                                                                                        }
                                                                                                    }
                                                                                                    ?>"><br><br>

                        <!-- Facebook -->
                        <label for="customer_care_facebook">Facebook:</label>
                        <input type="text" id="customer_care_facebook" name="customer_care_facebook" value="<?php
                                                                                                            foreach ($customerCare as $contact) {
                                                                                                                if ($contact['label'] == 'Facebook') {
                                                                                                                    echo $contact['value'];
                                                                                                                }
                                                                                                            }
                                                                                                            ?>"><br><br>

                        <button type="submit">Update Customer Care</button>
                    </form>
                </div>
            </div>

            <!-- Technical Support -->
            <div class="card contact-card mb-4">
                <div class="card-body">
                    <h2 class="card-title text-primary">Hỗ trợ kỹ thuật</h2>
                    <form action="tech_support_update.php" method="POST">
                        <!-- Technical Support Regions -->
                        <label for="tech_support_north">Miền Bắc:</label>
                        <input type="text" id="tech_support_north" name="tech_support_north" value="<?php
                                                                                                    foreach ($technicalSupport as $address) {
                                                                                                        if ($address['region'] == 'Miền Bắc') {
                                                                                                            echo $address['address'];
                                                                                                        }
                                                                                                    }
                                                                                                    ?>"><br><br>

                        <label for="tech_support_central">Miền Trung:</label>
                        <input type="text" id="tech_support_central" name="tech_support_central" value="<?php
                                                                                                        foreach ($technicalSupport as $address) {
                                                                                                            if ($address['region'] == 'Miền Trung') {
                                                                                                                echo $address['address'];
                                                                                                            }
                                                                                                        }
                                                                                                        ?>"><br><br>

                        <label for="tech_support_south">Miền Nam:</label>
                        <input type="text" id="tech_support_south" name="tech_support_south" value="<?php
                                                                                                    foreach ($technicalSupport as $address) {
                                                                                                        if ($address['region'] == 'Miền Nam') {
                                                                                                            echo $address['address'];
                                                                                                        }
                                                                                                    }
                                                                                                    ?>"><br><br>

                        <!-- Phone Numbers -->
                        <label for="tech_support_north_phone">Phone Miền Bắc:</label>
                        <input type="text" id="tech_support_north_phone" name="tech_support_north_phone" value="<?php
                                                                                                                foreach ($technicalSupport as $address) {
                                                                                                                    if ($address['region'] == 'Miền Bắc') {
                                                                                                                        echo $address['phone'];
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>"><br><br>

                        <label for="tech_support_central_phone">Phone Miền Trung:</label>
                        <input type="text" id="tech_support_central_phone" name="tech_support_central_phone" value="<?php
                                                                                                                    foreach ($technicalSupport as $address) {
                                                                                                                        if ($address['region'] == 'Miền Trung') {
                                                                                                                            echo $address['phone'];
                                                                                                                        }
                                                                                                                    }
                                                                                                                    ?>"><br><br>

                        <label for="tech_support_south_phone">Phone Miền Nam:</label>
                        <input type="text" id="tech_support_south_phone" name="tech_support_south_phone" value="<?php
                                                                                                                foreach ($technicalSupport as $address) {
                                                                                                                    if ($address['region'] == 'Miền Nam') {
                                                                                                                        echo $address['phone'];
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>"><br><br>

                        <button type="submit">Update Technical Support</button>
                    </form>
                </div>
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