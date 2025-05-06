-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2025 lúc 11:40 AM
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
-- Cấu trúc bảng cho bảng `phone_brands`
--

CREATE TABLE `phone_brands` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `phone_brands`
--

INSERT INTO `phone_brands` (`id`, `name`, `description`) VALUES
(1, 'IPHONE', 'iPhone là dòng điện thoại thông minh cao cấp do Apple phát triển, nổi bật với thiết kế sang trọng, hiệu năng mạnh mẽ và hệ điều hành iOS mượt mà. Với các tính năng hiện đại như Face ID, camera chất lượng cao và khả năng bảo mật vượt trội, iPhone luôn là lựa chọn hàng đầu của người dùng yêu công nghệ trên toàn thế giới.'),
(2, 'SAMSUNG', 'Samsung là thương hiệu điện thoại thông minh hàng đầu đến từ Hàn Quốc, bật với thiết kế hiện đại, màn hình sắc nét và công nghệ tiên tiến. Các dòng sản phẩm như Galaxy S và Galaxy Z luôn đi đầu trong đổi mới với tính năng gập mở, chất lượng cao và hiệu năng mạnh mẽ, đáp ứng mọi nhu cầu từ công việc đến giải trí của người dùng.'),
(3, 'XIAOMI', 'Xiaomi là thương hiệu điện thoại thông minh đến từ Trung Quốc, được biết đến với hiệu năng mạnh mẽ, thiết kế hiện đại và mức giá phải chăng. Với các dòng sản phẩm đa dạng từ phổ thông đến cao cấp như Redmi và Xiaomi series, hãng mang đến trải nghiệm công nghệ vượt trội phù hợp với mọi đối tượng người dùng. Xiaomi không ngừng đổi mới để đem lại giá trị tối ưu cho khách hàng trên toàn thế giới.'),
(4, 'VIVO', 'Vivo là thương hiệu điện thoại thông minh nổi bật đến từ Trung Quốc, gây ấn tượng với thiết kế thời trang, camera chất lượng cao và công nghệ âm thanh tiên tiến. Các dòng sản phẩm của Vivo không chỉ đáp ứng tốt nhu cầu giải trí, chụp ảnh mà còn có hiệu năng ổn định, giao diện thân thiện và mức giá hợp lý, phù hợp với nhiều đối tượng người dùng.'),
(5, 'OPPO', 'OPPO là thương hiệu điện thoại thông minh nổi tiếng đến từ Trung Quốc, được ưa chuộng nhờ thiết kế tinh tế, camera selfie ấn tượng và công nghệ sạc nhanh VOOC độc quyền. Với các dòng sản phẩm như OPPO Reno và OPPO A series, hãng mang đến trải nghiệm mượt mà, hiện đại cùng mức giá hợp lý, phù hợp với giới trẻ và người dùng yêu thích phong cách năng động.');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `phone_brands`
--
ALTER TABLE `phone_brands`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `phone_brands`
--
ALTER TABLE `phone_brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
