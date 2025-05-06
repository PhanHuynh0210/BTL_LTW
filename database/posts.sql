-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2025 lúc 09:12 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `news`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `published_at` datetime DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `image`, `description`, `content`, `author`, `published_at`, `category_id`, `status`) VALUES
(1, 'Apple ra mắt iPhone 15 Pro Max', 'apple-ra-mat-iphone-15-pro-max', 'assets/iphone15.jpg', 'Phiên bản cao cấp nhất nhà Apple ra mắt với chip mạnh mẽ.', 'Chi tiết nội dung bài viết về iPhone 15 Pro...', 'Admin', '2025-05-06 11:23:39', 2, 1),
(2, 'Samsung Galaxy S24 Ultra chính thức trình làng', 'samsung-galaxy-s24-ultra', 'assets/galaxy-s24.jpg', 'Sản phẩm cao cấp nhất từ Samsung với camera đột phá.', 'Chi tiết nội dung bài viết về Galaxy S24 Ultra...', 'Admin', '2025-05-06 11:33:55', 2, 1),
(3, 'Xiaomi giới thiệu dòng Redmi Note 13', 'xiaomi-gioi-thieu-redmi-note-13', 'assets/redmi-note13.jpg', 'Xiaomi tiếp tục gây ấn tượng với giá rẻ và cấu hình mạnh.', 'Chi tiết nội dung bài viết về Redmi Note 13...', 'Editor', '2025-05-06 11:33:55', 2, 1),
(4, 'Trên tay MacBook Air M3 mới', 'tren-tay-macbook-air-m3', 'assets/macbook-m3.jpg', 'MacBook Air M3 mang lại hiệu năng cao và thiết kế mỏng nhẹ.', 'Đánh giá chi tiết MacBook Air M3 từ Apple...', 'Admin', '2025-05-06 11:33:55', 1, 1),
(5, 'Sony công bố PlayStation 6', 'sony-cong-bo-playstation-6', 'assets/ps6.jpg', 'Sony tiếp tục phát triển dòng máy chơi game nổi tiếng.', 'PlayStation 6 được kỳ vọng với đồ họa đỉnh cao...', 'Editor', '2025-05-06 11:33:55', 3, 1),
(6, 'Oppo Find X7 Pro ra mắt với camera tiềm vọng', 'oppo-find-x7-pro', 'assets/oppo-find-x7-pro.jpg', 'Oppo đầu tư mạnh vào công nghệ camera cao cấp.', 'Chi tiết cấu hình và tính năng của Oppo Find X7 Pro...', 'Admin', '2025-05-06 11:33:55', 2, 1),
(7, 'iOS 18 mang lại nhiều thay đổi đáng chú ý', 'ios-18-thay-doi-dang-chu-y', 'assets/ios18.jpg', 'Phiên bản iOS mới từ Apple cải tiến mạnh về AI và quyền riêng tư.', 'Tổng quan các tính năng mới trên iOS 18...', 'Editor', '2025-05-06 11:33:55', 1, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
