-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2025 at 03:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1test`
--

-- --------------------------------------------------------

--
-- Table structure for table `commitments`
--

CREATE TABLE `commitments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commitments`
--

INSERT INTO `commitments` (`id`, `title`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Chất lượng sản phẩm', 'Cam kết về chất lượng sản phẩm', 1, '2025-05-07 11:00:19', '2025-05-07 11:00:19'),
(2, 'Dịch vụ khách hàng', 'Cam kết về dịch vụ khách hàng', 2, '2025-05-07 11:00:19', '2025-05-07 11:00:19'),
(4, 'Dịch vụ khách hàng', 'sss', 0, '2025-05-08 10:14:05', '2025-05-08 10:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `banner_filename` varchar(255) DEFAULT NULL,
  `about_image_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `description`, `created_at`, `updated_at`, `banner_filename`, `about_image_filename`) VALUES
(1, 'Một website bán điện thoại là một nền tảng thương mại điện tử chuyên cung cấp thông tin và cho phép người dùng mua các sản phẩm điện thoại di động và phụ kiện liên quan. Dưới đây là mô tả tổng quan cho một websit:', '2025-05-07 18:00:19', '2025-05-08 13:09:11', 'assets/img/1746709751_gt.jpg', 'assets/img/1746709751_gt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `core_values`
--

CREATE TABLE `core_values` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_data` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_values`
--

INSERT INTO `core_values` (`id`, `title`, `description`, `sort_order`, `created_at`, `updated_at`, `image_data`) VALUES
(1, 'Chất', 'Cam kết chất lượng sản phẩm', 1, '2025-05-07 18:00:19', '2025-05-08 08:42:39', NULL),
(2, 'Uy tín', 'Xây dựng niềm tin với khách hàng', 2, '2025-05-07 18:00:19', '2025-05-07 18:00:19', NULL),
(3, 'Sáng tạo', 'Không ngừng đổi mới và phát triển', 3, '2025-05-07 18:00:19', '2025-05-07 18:00:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` enum('general','product','shipping','payment','warranty') NOT NULL DEFAULT 'general',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Làm thế nào để đặt hàng?', 'Bạn có thể đặt hàng bằng cách:\n1. Chọn sản phẩm và thêm vào giỏ hàng\n2. Điền thông tin giao hàng\n3. Chọn phương thức thanh toán\n4. Xác nhận đơn hàng', 'general', '2025-05-08 05:10:12', '2025-05-08 05:10:12'),
(2, 'Thời gian giao hàng là bao lâu?', 'Thời gian giao hàng thông thường từ 2-5 ngày làm việc, tùy thuộc vào địa điểm giao hàng.', 'shipping', '2025-05-08 05:10:12', '2025-05-08 05:10:12'),
(3, 'Có những phương thức thanh toán nào?', 'Chúng tôi chấp nhận các phương thức thanh toán sau:\n- Thanh toán khi nhận hàng (COD)\n- Chuyển khoản ngân hàng\n- Thẻ tín dụng/ghi nợ', 'payment', '2025-05-08 05:10:12', '2025-05-08 05:10:12'),
(4, 'Chính sách bảo hành như thế nào?', 'Sản phẩm được bảo hành 12 tháng kể từ ngày mua. Trong thời gian bảo hành, chúng tôi sẽ sửa chữa hoặc thay thế miễn phí nếu có lỗi từ nhà sản xuất.', 'warranty', '2025-05-08 05:10:12', '2025-05-08 05:10:12'),
(5, 'Làm sao để kiểm tra tình trạng đơn hàng?', 'Bạn có thể kiểm tra tình trạng đơn hàng bằng cách:\n1. Đăng nhập vào tài khoản\n2. Vào mục \"Đơn hàng của tôi\"\n3. Chọn đơn hàng cần xem', 'general', '2025-05-08 05:10:12', '2025-05-08 05:10:12');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `region` enum('north','central','south') NOT NULL,
  `address` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `region`, `address`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'central', 'Số 2, Đường DEF, Quận UVW, Đà Nẵng', 1, '2025-05-07 18:00:19', '2025-05-07 18:00:19'),
(3, 'south', 'Số 3, Đường GHI, Quận KLM, TP.HCM', 1, '2025-05-07 18:00:19', '2025-05-07 18:00:19'),
(6, 'north', 'Hà Nội', 2, '2025-05-08 08:56:45', '2025-05-08 09:53:28'),
(7, 'central', 'dđ', 2, '2025-05-08 08:59:10', '2025-05-08 08:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `position`, `description`, `sort_order`, `created_at`, `updated_at`, `image_filename`) VALUES
(1, 'Nguyễn Văn A', 'Giám đốc', 'Mô tả về giám đốc', 1, '2025-05-07 18:00:19', '2025-05-08 13:13:25', 'assets/img/1746710005_gt.jpg'),
(3, 'Nguyễn Văn A', 'Chủ thịc', 'Một website bán điện thoại là một nền tảng thương mại điện tử chuyên cung cấp thông tin và cho phép người dùng mua các sản phẩm điện thoại di động và phụ kiện liên quan. Dưới đây là mô tả tổng quan cho một website bán điện thoại:', 0, '2025-05-08 08:23:55', '2025-05-08 13:13:18', 'assets/img/1746709998_gt.jpg'),
(4, 'Nguyễn Văn S', 'Giám đốc', 'sssss', 0, '2025-05-08 13:17:09', '2025-05-08 13:17:09', 'assets/img/1746710229_gt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `customer_name`, `location`, `content`, `sort_order`, `created_at`, `updated_at`, `image_filename`) VALUES
(1, 'Lê Văn C', 'Hà Nội', 'Đánh giá của khách hàng ', 1, '2025-05-07 18:00:19', '2025-05-08 13:14:59', 'assets/img/1746710099_gt.jpg'),
(10, 'Lê Văn C', 'Hà Nội', 'tốt', 0, '2025-05-08 09:52:14', '2025-05-08 13:14:51', 'assets/img/1746710091_gt.jpg'),
(11, 'phan huynh', 'thchcm', 'tốt', 0, '2025-05-08 09:52:58', '2025-05-08 13:14:43', 'assets/img/1746710083_gt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(8) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `NumberPhone` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `HouseRoadAddress` varchar(50) NOT NULL,
  `Ward` varchar(30) NOT NULL,
  `District` varchar(30) NOT NULL,
  `Province` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FullName`, `NumberPhone`, `Email`, `Password`, `HouseRoadAddress`, `Ward`, `District`, `Province`, `Status`) VALUES
('US000001', 'Võ Văn Hùng', '0907604514', 'vovanhung2864@gmail.com', '123456', '521, CMT8', 'Phường 14', 'Quận 10', 'Thành phố Hồ Chí Minh', 1),
('US000002', 'Lê Phan Huỳnh Như', '0907604532', 'nhuhuynh2862@gmail.com', '123456', '45', 'Xã Khuôn Hà', 'Huyện Lâm Bình', 'Tỉnh Tuyên Quang', 1),
('US000003', 'Võ Quang Đăng Khoa', '0907685643', 'dangkhoa2345@gmail.com', '123456', '34', 'Xã Lương Can', 'Huyện Hà Quảng', 'Tỉnh Cao Bằng', 1),
('US000004', 'Thiều Việt Hoàng', '0908675435', 'thieuhoang2346@gmail.com', '123456', '34', 'Phường Bồng Lai', 'Thị xã Quế Võ', 'Tỉnh Bắc Ninh', 0),
('US000005', 'Hoàng Bình Minh', '0908765367', 'binhminh@gmail.com', '123456', '31', 'Phường Mỹ Long', 'Thành phố Long Xuyên', 'Tỉnh An Giang', 1),
('US000006', 'Thiều Bảo Trâm', '0907604999', 'baotram2345@gmail.com', '123456', '61 An Định A', 'Thị trấn Ba Chúc', 'Huyện Tri Tôn', 'Tỉnh An Giang', 1),
('US000007', 'Lê Hồng Cẩm thu', '0327794675', 'camthu@gmail.com', '123456', '1', 'Phường An Hòa', 'Quận Ninh Kiều', 'Thành phố Cần Thơ', 1),
('US000008', 'Lê Ngọc Trâm', '0976543678', 'ngoctram567@gmail.com', '123456', '770 CMT8', 'Phường 05', 'Quận Tân Bình', 'Thành phố Hồ Chí Minh', 1),
('US000009', 'Phạm Cẩm Thơ', '0976548762', 'camtho234@gmail.com', '123456', '521/91E CMT8', 'Phường 13', 'Quận 10', 'Thành phố Hồ Chí Minh', 1),
('US000010', 'Đào Công Trứ', '0327794829', 'congtru2865@gmail.com', '123456', 'Đường 19/5', 'Xã Tân Ân', 'Huyện Cần Đước', 'Tỉnh Long An', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vision_mission`
--

CREATE TABLE `vision_mission` (
  `id` int(11) NOT NULL,
  `type` enum('vision','mission') NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vision_mission`
--

INSERT INTO `vision_mission` (`id`, `type`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'vision', 'Tầm nhìn', 'Nội dung tầm nhìn của công ty', '2025-05-07 18:00:19', '2025-05-07 18:00:19'),
(2, 'vision', 'Sứ mệnh', 'Nội dung sứ mệ\r\ny', '2025-05-07 18:00:19', '2025-05-08 02:28:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commitments`
--
ALTER TABLE `commitments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_values`
--
ALTER TABLE `core_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vision_mission`
--
ALTER TABLE `vision_mission`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commitments`
--
ALTER TABLE `commitments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vision_mission`
--
ALTER TABLE `vision_mission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
