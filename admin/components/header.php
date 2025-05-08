<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$navItems = [
    'index.php' => 'Trang chủ',
    'products.php' => [
        'label' => 'Sản Phẩm',
        'dropdown' => [
            'phones.php' => 'Điện Thoại',
            'laptops.php' => 'Laptop',
            'accessories.php' => 'Phụ Kiện'
        ]
    ],
    'news.php' => 'Tin Tức',
    'about.php' => 'Về Chúng Tôi',
    'contact.php' => 'Liên Hệ'
];

$navHtml = '';
foreach ($navItems as $file => $label) {
    if (is_array($label)) {
        $activeClass = $currentPage === $file || in_array($currentPage, array_keys($label['dropdown'])) ? 'active' : '';
        $navHtml .= '
        <div class="dropdown me-3">
            <a class="fw-medium nav-link dropdown-toggle ' . $activeClass . '" href="' . $file . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ' . $label['label'] . '
            </a>
            <ul class="dropdown-menu">';
        foreach ($label['dropdown'] as $subFile => $subLabel) {
            $subActive = $currentPage === $subFile ? 'active' : '';
            $navHtml .= '<li><a class="dropdown-item ' . $subActive . '" href="' . $subFile . '">' . $subLabel . '</a></li>';
        }
        $navHtml .= '</ul>
        </div>';
    } else {
        $activeClass = $currentPage === $file ? 'active' : '';
        $navHtml .= "<a href=\"$file\" class=\"fw-medium me-3 $activeClass\">$label</a>";
    }
}

$username = "Nguyen Van A";
$userImage = "../assets/logo.png";

echo <<<HTML
<header class="header border-bottom shadow-sm">
    <div class="container py-2">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <!-- Logo and Title -->
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <img src="../assets/logo.png" alt="Logo" width="60" height="60">
                <h4 class="m-0 fw-bold ms-2">DiDongThongMinh</h4>
            </div>

            <!-- User Info and Sidebar Toggle -->
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary me-3" id="menu-toggle">☰</button>
                <img src="$userImage" alt="User" width="40" height="40" class="rounded-circle me-2">
                <span class="fw-medium">$username</span>
            </div>
        </div>
    </div>
</header>

<!-- Sidebar (hidden by default) -->
<div id="sidebar" class="bg-light border-bottom py-3 d-none">
    <div class="container">
        <div class="list-group list-group-horizontal flex-wrap">
            <a href="#" class="list-group-item list-group-item-action">Dashboard</a>
            <a href="#" class="list-group-item list-group-item-action">Orders</a>
            <a href="#" class="list-group-item list-group-item-action">Products</a>
            <a href="#" class="list-group-item list-group-item-action">Customers</a>
            <a href="mainpage.controller.php" class="list-group-item list-group-item-action">Main Page</a>
            <a href="contactpage.controller.php" class="list-group-item list-group-item-action">Contact Page</a>
        </div>
    </div>
</div>

<!-- Toggle Script -->
<script>
document.getElementById("menu-toggle").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("d-none");
});
</script>
HTML;
