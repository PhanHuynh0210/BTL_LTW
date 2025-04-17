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

echo <<<HTML
<header class="header border-bottom shadow-sm">
    <div class="container py-2">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <!-- Logo and Title -->
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <img src="assets/logo.png" alt="Logo" width="60" height="60">
                <h4 class="m-0 fw-bold">DiDongThongMinh</h4>
            </div>

            <!-- Navigation -->
            <nav class="contact d-flex flex-wrap justify-content-center align-items-center mb-2 mb-md-0">
                $navHtml
            </nav>

            <!-- Icons and Login -->
            <div class="contact d-flex align-items-center justify-content-end">
                <a href="#" class="me-3"><i class="fa-regular fa-circle-question fa-lg"></i></a>
                <a href="#" class="me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 
                        0L6.75 15.75h10.5l1.644-7.572a1.125 1.125 0 
                        00-1.096-1.428H5.106m0 0L4.5 4.125m2.25 
                        14.625a.75.75 0 11-1.5 0 .75.75 0 
                        011.5 0zm11.25 0a.75.75 0 11-1.5 0 
                        .75.75 0 011.5 0z" />
                    </svg>
                </a>
                <a href="#" class="fw-medium">Đăng Nhập</a>
            </div>
        </div>
    </div>
</header>
HTML;
?>