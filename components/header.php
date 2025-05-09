<?php
// components/header.php

// 1. Include lib_session.php và khởi session
require_once __DIR__ . '/../lib_session.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Tính số lượng trong giỏ hàng (giả sử bạn lưu sản phẩm trong $_SESSION['cart'] dưới dạng mảng)
$cartCount = isset($_SESSION['cart']) && is_array($_SESSION['cart'])
    ? count($_SESSION['cart'])
    : 0;

// 3. Xác định HTML cho login/logout, dùng trực tiếp $_SESSION['current_fullName']
if (isAdminLogged()) {
    $loginHtml = '<span class="me-3">Xin chào, ' . htmlspecialchars($_SESSION['current_fullName']) . '</span>'
               . '<a href="/BTL_LTW/logout.php?isAdmin=1" class="fw-medium">Đăng Xuất</a>';
} else {
    $loginHtml = '<a href="/BTL_LTW/login.php" class="fw-medium">Đăng Nhập</a>';
}

// 4. Xây dựng navigation
$currentPage = basename($_SERVER['PHP_SELF']);
$navItems = [
    'index.php'   => 'Trang chủ',
    'product.php' => 'Sản Phẩm',
    'news.php'    => 'Tin Tức',
    'about.php'   => 'Về Chúng Tôi',
    'contact.php' => 'Liên Hệ'
];
$navHtml = '';
foreach ($navItems as $file => $label) {
    $activeClass = ($currentPage === $file) ? 'active' : '';
    $navHtml .= "<a href=\"{$file}\" class=\"fw-medium me-3 {$activeClass}\">{$label}</a>";
}
?>
<!-- Chú ý: đảm bảo đã nhúng FontAwesome trong <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<header class="header border-bottom shadow-sm">
  <div class="container py-2">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      
      <!-- Logo và Title -->
      <div class="d-flex align-items-center mb-2 mb-md-0">
        <img src="/BTL_LTW/assets/logo.png" alt="Logo" width="60" height="60">
        <h4 class="m-0 fw-bold ms-2">DiDongThongMinh</h4>
      </div>

      <!-- Navigation -->
      <nav class="contact d-flex flex-wrap justify-content-center align-items-center mb-2 mb-md-0">
        <?= $navHtml ?>
      </nav>

      <!-- Icons: Help, Orders, Cart + Đăng nhập/Đăng xuất -->
      <div class="contact d-flex align-items-center justify-content-end position-relative">
        <!-- Help icon -->
        

        <!-- Orders icon -->
        <a href="/BTL_LTW/my_order.php" class="me-3 text-dark">
          <i class="fa-solid fa-box fa-lg"></i>
        </a>

        <!-- Cart icon với badge số lượng -->
        <a href="/BTL_LTW/cart.php" class="me-3 position-relative text-dark">
          <i class="fa-solid fa-cart-shopping fa-lg"></i>
          <?php if ($cartCount > 0): ?>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
              <?= $cartCount ?>
            </span>
          <?php endif; ?>
        </a>

        <!-- Đăng nhập / Đăng xuất -->
        <?= $loginHtml ?>
      </div>

    </div>
  </div>
</header>
