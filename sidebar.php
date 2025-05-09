<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            background-color: #0d6efd;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar-header {
            padding: 20px;
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>Admin Panel</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="news-management.php" class="nav-link">
                    <i class="bi bi-graph-up"></i>
                    Tin Tức
                </a>
            </li>
            <li class="nav-item">
                <a href="sale.php" class="nav-link">
                    <i class="bi bi-currency-dollar"></i>
                    Doanh Thu
                </a>
            </li>
            <li class="nav-item">
                <a href="brand-manager.php" class="nav-link">
                    <i class="bi bi-tags"></i>
                    Thương Hiệu
                </a>
            </li>
            <li class="nav-item">
                <a href="userinfo.controller.php" class="nav-link">
                    <i class="bi bi-person-circle"></i>
                    Liên Hệ Khách Hàng
                </a>
            </li>
            <li class="nav-item">
                <a href="mainpage.controller.php" class="nav-link">
                    <i class="bi bi-house-door-fill"></i>
                    Trang Chủ
                </a>
            </li>
            <li class="nav-item">
                <a href="contactpage.controller.php" class="nav-link">
                    <i class="bi bi-telephone-fill"></i>
                    Thông Tin Liên Hệ
                </a>
            </li>
            <li class="nav-item">
                <a href="user-manager.php" class="nav-link">
                    <i class="bi bi-people"></i>
                    Người Dùng
                </a>
            </li>
            <li class="nav-item">
                <a href="about_manage.php" class="nav-link">
                    <i class="bi bi-info-circle"></i>
                    Giới thiệu
                </a>
            </li>
            <li class="nav-item">
                <a href="faq-manager.php" class="nav-link">
                    <i class="bi bi-question-circle"></i>
                    Hỏi/Đáp
                </a>
            </li>
            <li class="nav-item">
                <a href="voucher-manager.php" class="nav-link">
                    <i class="bi bi-ticket-perforated"></i>
                    Mã Giảm Giá
                </a>
            </li>
            <li class="nav-item mt-4">
                <a href="admin-logout.php" class="nav-link text-danger" onclick="return confirmLogout();">
                    <i class="bi bi-box-arrow-right"></i>
                    Đăng Xuất
                </a>
            </li>
        </ul>
    </div>

    <script>
        function confirmLogout() {
            return confirm('Bạn có chắc chắn muốn đăng xuất?');
        }

        // Add active class to current page link
        document.addEventListener('DOMContentLoaded', function () {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>