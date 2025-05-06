-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2025 lúc 11:47 AM
-- Phiên bản máy phục vụ: 9.1.0
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
-- Cấu trúc bảng cho bảng `brand_images`
--

CREATE TABLE `brand_images` (
  `id` int NOT NULL,
  `brand_id` int NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `brand_images`
--

INSERT INTO `brand_images` (`id`, `brand_id`, `image_path`) VALUES
(1, 1, 'assets/iphone2.webp'),
(2, 1, 'assets/ip_add1.jpg'),
(3, 1, 'assets/ip_add2.avif'),
(4, 2, 'assets/samsung2.webp'),
(5, 2, 'assets/samsung_ad1.jpg'),
(6, 2, 'assets/samsung_ad2.jpg'),
(7, 3, 'assets/xiaomi2.webp'),
(8, 3, 'assets/xiaomi_ad1.jpg'),
(9, 3, 'assets/xiaomi_ad2.jpg'),
(10, 4, 'assets/vivo2.webp'),
(11, 4, 'assets/vivo_ad1.png'),
(12, 4, 'assets/vivo_ad2.jpg'),
(13, 5, 'assets/oppo2.webp'),
(14, 5, 'assets/oppo_ad1.avif'),
(15, 5, 'assets/oppo_ad2.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brand_images`
--
ALTER TABLE `brand_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brand_images`
--
ALTER TABLE `brand_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `brand_images`
--
ALTER TABLE `brand_images`
  ADD CONSTRAINT `brand_images_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `phone_brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
