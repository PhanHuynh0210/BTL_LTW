-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2025 lúc 12:41 PM
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
-- Cấu trúc bảng cho bảng `contact_addresses`
--

CREATE TABLE `contact_addresses` (
  `id` int NOT NULL,
  `contact_type_id` int NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_addresses`
--

INSERT INTO `contact_addresses` (`id`, `contact_type_id`, `region`, `address`, `phone`) VALUES
(1, 3, 'Miền Bắc', '27A Nguyễn Công Trứ, P.Đồng Nhân, Q.Hai Bà Trưng, HN', '093.235.10.80'),
(2, 3, 'Miền Trung', '27A Nguyễn Công Trứ, P.Đồng Nhân, Q.Hai Bà Trưng, Đà Nẵng', '093.235.10.80'),
(3, 3, 'Miền Nam', '27A Nguyễn Công Trứ, P.Đồng Nhân, Q.Hai Bà Trưng, TP.HCM', '093.235.10.80');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `contact_addresses`
--
ALTER TABLE `contact_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_type_id` (`contact_type_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `contact_addresses`
--
ALTER TABLE `contact_addresses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `contact_addresses`
--
ALTER TABLE `contact_addresses`
  ADD CONSTRAINT `contact_addresses_ibfk_1` FOREIGN KEY (`contact_type_id`) REFERENCES `contact_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
