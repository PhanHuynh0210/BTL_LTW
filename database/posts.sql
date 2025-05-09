-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 09, 2025 lúc 03:19 PM
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
-- Cơ sở dữ liệu: `test`
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
  `status` tinyint(1) DEFAULT 1,
  `avg_rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `image`, `description`, `content`, `author`, `published_at`, `category_id`, `status`, `avg_rating`) VALUES
(2, 'Samsung Galaxy S24 Ultra chính thức trình làng', 'samsung-galaxy-s24-ultra', 'image/galaxy-s24.jpg', 'Sản phẩm cao cấp nhất từ Samsung với camera đột phá.', 'Chi tiết nội dung bài viết về Galaxy S24 Ultra...', 'Admin', '2025-05-06 11:33:55', 2, 1, 3.75),
(3, 'Xiaomi giới thiệu dòng Redmi Note 13', 'xiaomi-gioi-thieu-redmi-note-13', 'image/redmi-note13.jpg', 'Xiaomi tiếp tục gây ấn tượng với giá rẻ và cấu hình mạnh.', 'Chi tiết nội dung bài viết về Redmi Note 13...', 'Editor', '2025-05-06 11:33:55', 2, 1, 2.8),
(4, 'Trên tay MacBook Air M3 mới', 'tren-tay-macbook-air-m3', 'image/macbook-m3.jpg', 'MacBook Air M3 mang lại hiệu năng cao và thiết kế mỏng nhẹ.', 'Đánh giá chi tiết MacBook Air M3 từ Apple...', 'Admin', '2025-05-06 11:33:55', 1, 1, 3.75),
(5, 'Sony công bố PlayStation 6', 'sony-cong-bo-playstation-6', 'image/ps6.jpg', 'Sony tiếp tục phát triển dòng máy chơi game nổi tiếng.', 'PlayStation 6 được kỳ vọng với đồ họa đỉnh cao...', 'Editor', '2025-05-06 11:33:55', 3, 1, 3.75),
(6, 'Oppo Find X7 Pro ra mắt với camera tiềm vọng', 'oppo-find-x7-pro', 'image/oppo-find-x7-pro.jpg', 'Oppo đầu tư mạnh vào công nghệ camera cao cấp.', 'Chi tiết cấu hình và tính năng của Oppo Find X7 Pro...', 'Admin', '2025-05-06 11:33:55', 2, 1, 4.5),
(7, 'iOS 18 mang lại nhiều thay đổi đáng chú ý', 'ios-18-thay-doi-dang-chu-y', 'image/ios18.jpg', 'Phiên bản iOS mới từ Apple cải tiến mạnh về AI và quyền riêng tư.', 'Tổng quan các tính năng mới trên iOS 18...', 'Editor', '2025-05-06 11:33:55', 1, 1, 4),
(31, 'Samsung trình làng Galaxy S23 Ultra', 'samsung-galaxy-s23-ultra', 'image/1746701823_samsung_s23_-_1_1_1.webp', 'Galaxy S23 Ultra với camera 200MP và hiệu năng mạnh mẽ từ Snapdragon.', 'Samsung ra mắt Galaxy S23 Ultra với 200MP camera, Snapdragon 8 Gen 2 tối ưu cho hiệu suất vượt trội, màn hình Dynamic AMOLED 2X 120Hz, pin 5000mAh hỗ trợ sạc nhanh 45W.', NULL, '2025-05-08 17:49:11', NULL, 1, 3.66667),
(34, 'OPPO Find X6 Pro chính thức trình làng', 'oppo-find-x6-pro', 'image/1746770282_samsung_ad2.jpg', 'OPPO Find X6 Pro sở hữu camera “siêu khủng” và thiết kế thời thượng.', 'OPPO giới thiệu flagship Find X6 Pro với cảm biến Sony IMX989 1 inch, camera siêu rộng cao cấp, hỗ trợ lấy nét siêu nhanh, sạc SuperVOOC 100W, màn hình AMOLED đỉnh cao.', NULL, '2025-05-08 17:49:11', NULL, 1, 3.75),
(35, 'Realme ra mắt GT Neo 5', 'realme-gt-neo-5', 'image/1746770301_vivo_ad1.png', 'GT Neo 5 nổi bật với sạc nhanh 240W, nhanh nhất thế giới.', 'Realme GT Neo 5 là điện thoại đầu tiên trên thế giới có công nghệ sạc 240W – đầy pin 100% chỉ trong 9 phút. Thiết bị cũng đi kèm Snapdragon 8+ Gen 1, màn hình AMOLED 144Hz và thiết kế trẻ trung.', NULL, '2025-05-08 17:49:11', NULL, 1, 3),
(36, 'Sony Xperia 1 V chính thức trình làng', 'sony-xperia-1-v', 'image/1746770038_Banner2.png', 'Sony Xperia 1 V với cảm biến ảnh mới, hỗ trợ quay phim chuyên nghi', 'Sony Xperia 1 V được thiết kế dành cho nhà làm phim và nhiếp ảnh gia. Cảm biến Exmor T mới cho khả năng tái tạo màu sắc trung thực, quay phim 4K HDR 120fps và điều khiển thủ công toàn diện.', NULL, '2025-05-08 17:49:11', NULL, 1, 4.66667);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
