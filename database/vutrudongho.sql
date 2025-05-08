-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 08, 2025 lúc 12:58 PM
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
-- Cơ sở dữ liệu: `didongthongminh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `AdminID` varchar(4) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`AdminID`, `FullName`, `Email`, `Password`) VALUES
('AD01', 'Võ Quang Đăng Khoa', 'dangkhoa1509@gmail.com', '123456'),
('AD02', 'Võ Văn Hùng', 'vovanhung2864@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `BrandID` varchar(5) NOT NULL,
  `BrandName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`BrandID`, `BrandName`, `Description`, `Status`) VALUES
('BR001', 'Apple', 'Apple – Thương hiệu công nghệ Mỹ nổi tiếng với iPhone, hệ sinh thái khép kín, thiết kế tinh tế, hiệu năng mạnh mẽ và sự tích hợp chặt chẽ với các dịch vụ như App Store, iCloud và Apple Pay.', 1),
('BR002', 'Asus', 'Asus – Thương hiệu Đài Loan nổi tiếng với các sản phẩm gaming (ROG Phone), Zenfone hiệu năng ổn định, thiết kế tinh gọn và giá cả hợp lý.', 1),
('BR003', 'Google', 'Google – Thương hiệu Mỹ phát triển dòng Pixel với Android thuần, camera hàng đầu và cập nhật phần mềm nhanh chóng trực tiếp từ Google.', 1),
('BR004', 'Huawei', 'Huawei – Thương hiệu Trung Quốc dẫn đầu về công nghệ camera tiên tiến, thiết kế cao cấp và hiệu năng mạnh mẽ, dù chịu ảnh hưởng bởi các hạn chế dịch vụ Google.', 1),
('BR005', 'OnePlus', 'OnePlus – Thương hiệu Trung Quốc nổi bật với smartphone hiệu năng cao, giao diện OxygenOS mượt mà và công nghệ sạc nhanh Warp Charge.', 1),
('BR006', 'OPPO', 'OPPO – Thương hiệu Trung Quốc nổi bật với thiết kế thời trang, camera selfie sắc nét và công nghệ sạc nhanh VOOC.', 1),
('BR007', 'Realme', 'Realme – Thương hiệu con của OPPO, hướng đến phân khúc giá rẻ và tầm trung với cấu hình vượt trội, pin dung lượng lớn và thiết kế trẻ trung.', 1),
('BR008', 'Samsung', 'Samsung – Thương hiệu Hàn Quốc dẫn đầu thị trường smartphone với dòng Galaxy S, Note và A, nổi bật với màn hình AMOLED, camera chất lượng và nhiều công nghệ tiên tiến.', 1),
('BR009', 'Sony', 'Sony – Thương hiệu Nhật Bản với dòng Xperia, tập trung vào khả năng chụp ảnh, quay video chuyên nghiệp, thiết kế lịch lãm và chất lượng âm thanh cao.', 1),
('BR010', 'Vivo', 'Vivo – Thương hiệu Trung Quốc chú trọng vào thiết kế sáng tạo, camera ẩn dưới màn hình, công nghệ sạc nhanh FlashCharge và trải nghiệm giải trí đa phương tiện.', 1),
('BR011', 'Xiaomi', 'Xiaomi – Thương hiệu Trung Quốc nổi tiếng với giá thành cạnh tranh, cấu hình cao và hệ sinh thái thiết bị IoT phong phú, từ smartphone đến TV và phụ kiện.', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `UserID` varchar(8) NOT NULL,
  `ProductID` varchar(8) NOT NULL,
  `Quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`UserID`, `ProductID`, `Quantity`) VALUES
('US000001', 'PR000001', 2),
('US000001', 'PR000002', 4),
('US000001', 'PR000005', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `inventoryreceivingvoucher`
--

CREATE TABLE `inventoryreceivingvoucher` (
  `InID` varchar(10) NOT NULL,
  `SupplierID` varchar(8) NOT NULL,
  `Date` date NOT NULL,
  `Total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `OrderID` varchar(10) NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `OderDate` datetime NOT NULL,
  `ShippingFee` int(11) NOT NULL,
  `OrderDiscount` int(11) NOT NULL,
  `OrderTotal` double NOT NULL,
  `Address` varchar(150) NOT NULL,
  `PaymentID` varchar(4) NOT NULL,
  `VoucherID` varchar(5) NOT NULL,
  `OrderStatus` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`OrderID`, `UserID`, `OderDate`, `ShippingFee`, `OrderDiscount`, `OrderTotal`, `Address`, `PaymentID`, `VoucherID`, `OrderStatus`) VALUES
('OR00000001', 'US000001', '2025-05-08 04:07:33', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S01'),
('OR00000002', 'US000001', '2025-05-08 04:09:04', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S05'),
('OR00000003', 'US000001', '2025-05-08 04:09:04', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S05'),
('OR00000004', 'US000001', '2025-05-08 04:09:04', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S05'),
('OR00000005', 'US000001', '2025-05-08 04:09:04', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S03'),
('OR00000006', 'US000001', '2025-05-08 04:09:04', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S04'),
('OR00000007', 'US000001', '2025-05-08 04:09:04', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S02'),
('OR00000008', 'US000001', '2025-05-08 04:09:04', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S05'),
('OR00000009', 'US000001', '0000-00-00 00:00:00', 30000, 10000, 1000000, '521/91E CMT8#P13#Q10#HCM', 'PA01', 'VO001', 'S05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderstatus`
--

CREATE TABLE `orderstatus` (
  `StatusID` varchar(3) NOT NULL,
  `StatusName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderstatus`
--

INSERT INTO `orderstatus` (`StatusID`, `StatusName`) VALUES
('S01', 'Chưa xác nhận'),
('S02', 'Đã xác nhận'),
('S03', 'Đang giao hàng'),
('S04', 'Đã giao hàng'),
('S05', 'Đã hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_line`
--

CREATE TABLE `order_line` (
  `OrderID` varchar(10) NOT NULL,
  `ProductID` varchar(8) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment`
--

CREATE TABLE `payment` (
  `PaymentID` varchar(4) NOT NULL,
  `PaymentName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payment`
--

INSERT INTO `payment` (`PaymentID`, `PaymentName`) VALUES
('PA01', 'Thanh toán khi nhận hàng'),
('PA02', 'Internet Banking');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(8) NOT NULL,
  `BrandID` varchar(5) NOT NULL,
  `ProductName` varchar(300) NOT NULL,
  `PriceToSell` double NOT NULL,
  `ImportPrice` double NOT NULL,
  `Discount` double DEFAULT NULL,
  `Model` varchar(100) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Description` text DEFAULT NULL,
  `ProductImg` varchar(200) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `CanDel` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ProductID`, `BrandID`, `ProductName`, `PriceToSell`, `ImportPrice`, `Discount`, `Model`, `Color`, `Gender`, `Description`, `ProductImg`, `Status`, `CanDel`) VALUES
('PR000001', 'BR001', 'Apple iPhone 12 mini', 14990000, 13490000, 0, 'iPhone12mini', 'Black', 'Mới', '• Màn hình: Super Retina XDR OLED 5.4″ (2340×1080)\r\n• Chip: A14 Bionic\r\n• RAM: 4 GB\r\n• Bộ nhớ: 64/128 GB\r\n• Camera sau: 12 MP (wide + ultrawide), Night Mode & Deep Fusion\r\n• Camera trước: 12 MP, Face ID\r\n• Pin: 2 227 mAh, sạc nhanh 20 W\r\n• Kết nối: 5G, Wi-Fi 6, Bluetooth 5.0\r\n• Kháng nước: IP68\r\n• Hệ điều hành: iOS 14', 'assets/Img/productImg/PR000001.webp', 1, 1),
('PR000002', 'BR001', 'Apple iPhone SE 2022', 10990000, 9990000, 0, 'iPhoneSE2022', 'White', 'Cũ', '• Màn hình: Retina HD 4.7″ (1334×750)\r\n• Chip: A15 Bionic\r\n• RAM: 4 GB\r\n• Bộ nhớ: 64/128/256 GB\r\n• Camera sau: 12 MP, Portrait Mode & Smart HDR 4\r\n• Camera trước: 7 MP\r\n• Pin: ~2018 mAh, sạc nhanh 18 W\r\n• Kháng nước: IP67\r\n• Hệ điều hành: iOS 15', 'assets/Img/productImg/PR000002.webp', 1, 1),
('PR000003', 'BR001', 'Apple iPhone 13 Pro Max', 32990000, 29990000, 5, 'iPhone13ProMax', 'Silver', 'Mới', '• Màn hình: Super Retina XDR OLED 6.7″ ProMotion 120 Hz\r\n• Chip: A15 Bionic (GPU 5 nhân)\r\n• RAM: 6 GB\r\n• Bộ nhớ: 128 GB–1 TB\r\n• Camera sau: 3×12 MP (wide/ultrawide/tele) với Night Mode, Deep Fusion, Zoom quang 3×\r\n• Camera trước: 12 MP, Cinematic Mode 4K\r\n• Pin: 4 352 mAh, sạc nhanh 27 W, MagSafe\r\n• Kháng nước: IP68\r\n• Hệ điều hành: iOS 15', 'assets/Img/productImg/PR000003.webp', 1, 1),
('PR000004', 'BR001', 'Apple iPhone 14', 23990000, 21990000, 0, 'iPhone14', 'Midnight', 'Mới', '• Màn hình: Super Retina XDR OLED 6.1″\r\n• Chip: A15 Bionic\r\n• RAM: 6 GB\r\n• Bộ nhớ: 128/256/512 GB\r\n• Camera sau: 12 MP (wide + ultrawide) với Action Mode & Cinematic Mode\r\n• Camera trước: 12 MP\r\n• Pin: ~3 279 mAh, sạc nhanh 20 W\r\n• Kháng nước: IP68\r\n• Hệ điều hành: iOS 16', 'assets/Img/productImg/PR000004.webp', 1, 1),
('PR000005', 'BR001', 'Apple iPhone 14 Pro', 27990000, 25990000, 0, 'iPhone14Pro', 'Deep Purple', 'Mới', '• Màn hình: Super Retina XDR OLED 6.1″ ProMotion 120 Hz với Dynamic Island\r\n• Chip: A16 Bionic\r\n• RAM: 6 GB\r\n• Bộ nhớ: 128 GB–1 TB\r\n• Camera sau: 48 MP + 12 MP ultrawide + 12 MP tele với Photonic Engine\r\n• Camera trước: 12 MP, Always-On Display\r\n• Pin: ~3 200 mAh\r\n• Kháng nước: IP68\r\n• Hệ điều hành: iOS 16', 'assets/Img/productImg/PR000005.webp', 1, 1),
('PR000006', 'BR008', 'Samsung Galaxy S21', 18990000, 16990000, 5, 'SM-G991B', 'Phantom Gray', 'Mới', '• Màn hình: Dynamic AMOLED 6.2″ FHD+ 120 Hz\r\n• Chip: Exynos 2100 / Snapdragon 888\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 12 MP (wide) + 64 MP (tele) + 12 MP (ultrawide)\r\n• Camera trước: 10 MP\r\n• Pin: 4 000 mAh, sạc nhanh 25 W\r\n• Kháng nước: IP68\r\n• One UI 3.1 (Android 11)', 'assets/Img/productImg/PR000006.webp', 1, 1),
('PR000007', 'BR008', 'Samsung Galaxy S21 Ultra 5G', 30990000, 27990000, 5, 'SM-G998B', 'Phantom Black', 'Mới', '• Màn hình: Dynamic AMOLED 2X 6.8″ QHD+ 120 Hz\r\n• Chip: Exynos 2100 / Snapdragon 888\r\n• RAM: 12/16 GB\r\n• Bộ nhớ: 128/256/512 GB\r\n• Camera sau: 108 MP (wide) + 10 MP periscope + 10 MP tele + 12 MP ultrawide\r\n• Camera trước: 40 MP\r\n• Pin: 5 000 mAh, sạc nhanh 25 W, S Pen tích hợp\r\n• Kháng nước: IP68\r\n• One UI 3.1 (Android 11)', 'assets/Img/productImg/PR000007.webp', 1, 1),
('PR000008', 'BR008', 'Samsung Galaxy S22 Ultra', 32990000, 29990000, 0, 'SM-S908B', 'Green', 'Mới', '• Màn hình: Dynamic AMOLED 2X 6.8″ QHD+ 120 Hz\r\n• Chip: Exynos 2200 / Snapdragon 8 Gen 1\r\n• RAM: 8/12 GB\r\n• Bộ nhớ: 128 GB–1 TB\r\n• Camera sau: 108 MP + 10 MP periscope + 10 MP tele + 12 MP ultrawide\r\n• S Pen tích hợp\r\n• Pin: 5 000 mAh, sạc nhanh 45 W\r\n• Kháng nước: IP68\r\n• One UI 4.1 (Android 12)', 'assets/Img/productImg/PR000008.webp', 1, 1),
('PR000009', 'BR008', 'Samsung Galaxy Note 20 Ultra', 24990000, 22990000, 0, 'SM-N986B', 'Mystic Bronze', 'Mới', '• Màn hình: Dynamic AMOLED 2X 6.9″ 120 Hz\r\n• Chip: Exynos 990 / Snapdragon 865+\r\n• RAM: 8 GB\r\n• Bộ nhớ: 256/512 GB\r\n• Camera sau: 108 MP + 12 MP periscope + 12 MP ultrawide\r\n• Camera trước: 10 MP\r\n• Pin: 4 500 mAh, sạc nhanh 25 W\r\n• Kháng nước: IP68, S Pen độ trễ thấp\r\n• One UI 2.5 (Android 10)', 'assets/Img/productImg/PR000009.webp', 1, 1),
('PR000010', 'BR008', 'Samsung Galaxy Z Fold3 5G', 35990000, 32990000, 0, 'SM-F926B', 'Phantom Silver', 'Mới', '• Màn hình gập: Dynamic AMOLED 7.6″ 120 Hz\r\n• Màn hình ngoài: Super AMOLED 6.2″\r\n• Chip: Snapdragon 888\r\n• RAM: 12 GB\r\n• Bộ nhớ: 256/512 GB\r\n• Camera sau: 12 MP triple\r\n• Camera dưới màn hình: 4 MP\r\n• Camera ngoài: 10 MP\r\n• Pin: 4 400 mAh, hỗ trợ S Pen\r\n• Kháng nước: IPX8', 'assets/Img/productImg/PR000010.webp', 1, 1),
('PR000011', 'BR008', 'Samsung Galaxy Z Flip3 5G', 23990000, 21990000, 0, 'SM-F711B', 'Cream', 'Mới', '• Màn hình gập: Dynamic AMOLED 6.7″ 120 Hz\r\n• Màn hình phụ: 1.9″ Super AMOLED\r\n• Chip: Snapdragon 888\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 12 MP + 12 MP ultrawide\r\n• Camera trước: 10 MP\r\n• Pin: 3 300 mAh\r\n• Kháng nước: IPX8', 'assets/Img/productImg/PR000011.webp', 1, 1),
('PR000012', 'BR008', 'Samsung Galaxy A52 5G', 7990000, 6990000, 10, 'SM-A526B', 'Awesome Blue', 'Mới', '• Màn hình: Super AMOLED 6.5″ 120 Hz\r\n• Chip: Snapdragon 750G\r\n• RAM: 6/8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 64 MP + 12 MP ultrawide + 5 MP macro + 5 MP depth\r\n• Camera trước: 32 MP\r\n• Pin: 4 500 mAh, sạc nhanh 25 W\r\n• Kháng nước: IP67\r\n• One UI 3.1 (Android 11)', 'assets/Img/productImg/PR000012.webp', 1, 1),
('PR000013', 'BR011', 'Xiaomi Mi 11', 12990000, 11990000, 5, 'M2011K2C', 'Horizon Blue', 'Mới', '• Màn hình: AMOLED 6.81″ 120 Hz QHD+\r\n• Chip: Snapdragon 888\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 108 MP + 13 MP ultrawide + 5 MP macro\r\n• Camera trước: 20 MP\r\n• Pin: 4 600 mAh, sạc nhanh 55 W, sạc không dây 50 W\r\n• Kháng nước: IP53\r\n• MIUI 12', 'assets/Img/productImg/PR000013.webp', 1, 1),
('PR000014', 'BR011', 'Xiaomi Mi 11 Ultra', 18990000, 16990000, 5, 'M2102K1G', 'Ceramic White', 'Mới', '• Màn hình: AMOLED 6.81″ 120 Hz QHD+ + màn hình phụ 1.1″\r\n• Chip: Snapdragon 888\r\n• RAM: 8/12 GB\r\n• Bộ nhớ: 256/512 GB\r\n• Camera sau: 50 MP + 48 MP + 48 MP\r\n• Camera trước: 20 MP\r\n• Pin: 5 000 mAh, sạc nhanh 67 W (có dây & không dây)\r\n• Kháng nước: IP68\r\n• MIUI 12.5', 'assets/Img/productImg/PR000014.jpg', 1, 1),
('PR000015', 'BR011', 'Redmi Note 10 Pro', 6990000, 5990000, 0, 'M2101K6G', 'Onyx Gray', 'Cũ', '• Màn hình: AMOLED 6.67″ 120 Hz FHD+\r\n• Chip: Snapdragon 732G\r\n• RAM: 6/8 GB\r\n• Bộ nhớ: 64/128 GB\r\n• Camera sau: 108 MP + 8 MP ultrawide + 5 MP macro + 2 MP depth\r\n• Camera trước: 16 MP\r\n• Pin: 5 020 mAh, sạc nhanh 33 W\r\n• Kháng nước: IP53\r\n• MIUI 12', 'assets/Img/productImg/PR000015.webp', 1, 1),
('PR000016', 'BR011', 'Poco F3', 8990000, 7990000, 0, 'M2012K11G', 'Night Black', 'Mới', '• Màn hình: AMOLED 6.67″ 120 Hz FHD+\r\n• Chip: Snapdragon 870\r\n• RAM: 6/8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 48 MP + 8 MP ultrawide + 5 MP macro\r\n• Camera trước: 20 MP\r\n• Pin: 4 520 mAh, sạc nhanh 33 W\r\n• MIUI for POCO 12', 'assets/Img/productImg/PR000016.webp', 1, 1),
('PR000017', 'BR011', 'Redmi 9A', 1990000, 1790000, 0, 'M2006C3LG', 'Sea Blue', 'Cũ', '• Màn hình: IPS LCD 6.53″ HD+\r\n• Chip: Helio G25\r\n• RAM: 2/3 GB\r\n• Bộ nhớ: 32/64 GB\r\n• Camera sau: 13 MP\r\n• Camera trước: 5 MP\r\n• Pin: 5 000 mAh, sạc 10 W\r\n• Kháng nước: IP53\r\n• MIUI 12', 'assets/Img/productImg/PR000017.webp', 1, 1),
('PR000018', 'BR003', 'Google Pixel 6', 15990000, 14490000, 5, 'GB6213', 'Sorta Seafoam', 'Mới', '• Màn hình: AMOLED 6.4″ 90 Hz FHD+\r\n• Chip: Google Tensor\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 50 MP + 12 MP ultrawide\r\n• Camera trước: 8 MP\r\n• Pin: 4 614 mAh, sạc nhanh 30 W\r\n• Sạc không dây: Qi\r\n• Kháng nước: IP68\r\n• Android 12 gốc', 'assets/Img/productImg/PR000018.jpg', 1, 1),
('PR000019', 'BR003', 'Google Pixel 7', 17990000, 15990000, 5, 'GB62KQ', 'Snow', 'Cũ', '• Màn hình: AMOLED 6.3″ 90 Hz FHD+\r\n• Chip: Google Tensor G2\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 50 MP + 12 MP ultrawide\r\n• Camera trước: 10.8 MP\r\n• Pin: 4 355 mAh, sạc nhanh 30 W\r\n• Sạc không dây: Qi\r\n• Kháng nước: IP68\r\n• Android 13 gốc', 'assets/Img/productImg/PR000019.webp', 1, 1),
('PR000020', 'BR005', 'OnePlus 9 Pro', 24990000, 22990000, 5, 'LE2121', 'Pine Green', 'Mới', '• Màn hình: Fluid AMOLED 6.7″ QHD+ 120 Hz\r\n• Chip: Snapdragon 888\r\n• RAM: 8/12 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: Hasselblad 48 MP + 50 MP ultrawide + 8 MP tele + 2 MP mono\r\n• Camera trước: 16 MP\r\n• Pin: 4 500 mAh, sạc nhanh 65 W\r\n• Sạc không dây: 50 W\r\n• Kháng nước: IP68\r\n• OxygenOS 11', 'assets/Img/productImg/PR000020.webp', 1, 1),
('PR000021', 'BR005', 'OnePlus 10 Pro', 27990000, 25990000, 5, 'NE2211', 'Volcano Black', 'Mới', '• Màn hình: Fluid AMOLED 6.7″ QHD+ 120 Hz\r\n• Chip: Snapdragon 8 Gen 1\r\n• RAM: 8/12 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: Hasselblad 48 MP + 50 MP ultrawide + 8 MP tele\r\n• Camera trước: 32 MP\r\n• Pin: 5 000 mAh, sạc nhanh 80 W\r\n• Sạc không dây: 50 W\r\n• Kháng nước: IP68\r\n• OxygenOS 12', 'assets/Img/productImg/PR000021.webp', 1, 1),
('PR000022', 'BR006', 'OPPO Find X3 Pro', 28990000, 26990000, 5, 'CPH2173', 'Gloss Black', 'Mới', '• Màn hình: AMOLED 6.7″ QHD+ 120 Hz\r\n• Chip: Snapdragon 888\r\n• RAM: 8/12 GB\r\n• Bộ nhớ: 256/512 GB\r\n• Camera sau: 50 MP + 50 MP ultrawide + 13 MP tele + 3 MP microlens\r\n• Camera trước: 32 MP\r\n• Pin: 4 500 mAh, sạc SuperVOOC 65 W\r\n• Sạc không dây: 30 W\r\n• Kháng nước: IP68\r\n• ColorOS 11.2', 'assets/Img/productImg/PR000022.webp', 1, 1),
('PR000023', 'BR006', 'OPPO Reno6 Pro 5G', 11990000, 10990000, 0, 'PEPM00', 'Aurora', 'Cũ', '• Màn hình: AMOLED 6.55″ 90 Hz\r\n• Chip: Dimensity 1200\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128 GB\r\n• Camera sau: 64 MP + 8 MP ultrawide + 2 MP macro + 2 MP depth\r\n• Camera trước: 32 MP\r\n• Pin: 4 500 mAh, sạc SuperVOOC 65 W\r\n• Kháng nước: IPX4\r\n• ColorOS 11.3', 'assets/Img/productImg/PR000023.webp', 1, 1),
('PR000024', 'BR007', 'Realme GT 5G', 12990000, 11990000, 0, 'RMX2202', 'Storm White', 'Mới', '• Màn hình: Super AMOLED 6.43″ 120 Hz\r\n• Chip: Snapdragon 888\r\n• RAM: 8/12 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 64 MP + 8 MP ultrawide + 2 MP macro\r\n• Camera trước: 16 MP\r\n• Pin: 4 500 mAh, sạc Dart 65 W\r\n• Kháng nước: IP53\r\n• Realme UI 2.0', 'assets/Img/productImg/PR000024.webp', 1, 1),
('PR000025', 'BR007', 'Realme 8 Pro', 6990000, 5990000, 0, 'RMX3081', 'Infinite Blue', 'Mới', '• Màn hình: Super AMOLED 6.4″\r\n• Chip: Snapdragon 720G\r\n• RAM: 6/8 GB\r\n• Bộ nhớ: 128 GB\r\n• Camera sau: 108 MP + 8 MP ultrawide + 2 MP macro + 2 MP depth\r\n• Camera trước: 16 MP\r\n• Pin: 4 500 mAh, sạc nhanh 50 W\r\n• Kháng nước: IP53\r\n• Realme UI 2.0', 'assets/Img/productImg/PR000025.webp', 1, 1),
('PR000026', 'BR010', 'Vivo X60 Pro', 15990000, 14990000, 5, 'V2043', 'Shimmer Blue', 'Cũ', '• Màn hình: AMOLED 6.56″ 120 Hz\r\n• Chip: Snapdragon 870\r\n• RAM: 12 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: Gimbal 48 MP + 13 MP ultrawide + 13 MP portrait\r\n• Camera trước: 32 MP\r\n• Pin: 4 200 mAh, sạc nhanh 33 W\r\n• Kháng nước: IP53\r\n• OriginOS', 'assets/Img/productImg/PR000026.webp', 1, 1),
('PR000027', 'BR004', 'Huawei P40 Pro', 21990000, 19990000, 0, 'ELS-NX9', 'Silver Frost', 'Cũ', '• Màn hình: OLED 6.58″ 90 Hz\r\n• Chip: Kirin 990 5G\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 50 MP + 40 MP ultrawide + 12 MP periscope + ToF\r\n• Camera trước: 32 MP + ToF\r\n• Pin: 4 200 mAh, sạc nhanh 40 W\r\n• Sạc không dây: 27 W\r\n• Kháng nước: IP68\r\n• EMUI 10.1', 'assets/Img/productImg/PR000027.webp', 1, 1),
('PR000028', 'BR004', 'Huawei Mate 40 Pro', 24990000, 22990000, 0, 'NOH-NX9', 'Black', 'Mới', '• Màn hình: OLED 6.76″ 90 Hz\r\n• Chip: Kirin 9000\r\n• RAM: 8 GB\r\n• Bộ nhớ: 128/256 GB\r\n• Camera sau: 50 MP + 20 MP ultrawide + 12 MP tele + ToF\r\n• Camera trước: 13 MP\r\n• Pin: 4 400 mAh, sạc nhanh 66 W\r\n• Sạc không dây: 50 W\r\n• Kháng nước: IP68\r\n• EMUI 11', 'assets/Img/productImg/PR000028.webp', 1, 1),
('PR000029', 'BR009', 'Sony Xperia 1 III', 30990000, 28990000, 5, 'XQ-BC72', 'Frosted Black', 'Mới', '• Màn hình: OLED 4K 6.5″ 120 Hz\r\n• Chip: Snapdragon 888\r\n• RAM: 12 GB\r\n• Bộ nhớ: 256 GB\r\n• Camera sau: ZEISS Triple 12 MP + variable telephoto\r\n• Camera trước: 8 MP\r\n• Pin: 4 500 mAh, sạc nhanh 30 W\r\n• Kháng nước: IP65/68\r\n• Android 11', 'assets/Img/productImg/PR000029.webp', 1, 1),
('PR000030', 'BR002', 'Asus ROG Phone 5', 19990000, 17990000, 0, 'I005DA', 'Phantom Black', 'Mới', '• Màn hình: AMOLED 6.78″ 144 Hz\r\n• Chip: Snapdragon 888\r\n• RAM: 8/12/16 GB\r\n• Bộ nhớ: 128/256/512 GB\r\n• Camera sau: 64 MP + 13 MP ultrawide + 5 MP macro\r\n• Camera trước: 24 MP\r\n• Pin: 6 000 mAh dual-cell, sạc nhanh 65 W\r\n• Tính năng: AirTrigger, ROG UI\r\n• Kháng nước: IPX4', 'assets/Img/productImg/PR000030.webp', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_quantity`
--

CREATE TABLE `product_quantity` (
  `ProductID` varchar(8) NOT NULL,
  `Date` datetime NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_quantity`
--

INSERT INTO `product_quantity` (`ProductID`, `Date`, `Quantity`) VALUES
('PR000001', '2023-05-16 12:53:57', 21),
('PR000002', '2023-05-16 07:35:17', 34),
('PR000003', '2023-05-15 16:41:13', 31),
('PR000004', '2023-04-24 20:13:35', 1),
('PR000005', '2023-04-24 20:13:35', 15),
('PR000006', '2023-04-24 20:13:35', 50),
('PR000007', '2023-04-24 20:13:35', 50),
('PR000008', '2023-04-24 20:13:35', 50),
('PR000009', '2023-04-24 20:13:35', 60),
('PR000010', '2023-04-24 20:13:35', 23),
('PR000011', '2023-05-15 16:12:13', 34),
('PR000012', '2023-05-15 16:43:01', 48),
('PR000013', '2023-04-24 20:13:35', 16),
('PR000014', '2023-04-24 20:13:35', 8),
('PR000015', '2023-05-15 16:43:01', 36),
('PR000016', '2023-05-15 16:43:01', 36),
('PR000017', '2023-05-15 16:43:01', 36),
('PR000018', '2023-05-16 06:16:43', 11),
('PR000019', '2023-05-15 16:43:01', 36),
('PR000020', '2023-05-15 16:43:01', 36),
('PR000021', '2023-05-15 16:45:50', 10),
('PR000022', '2023-05-15 16:43:01', 7),
('PR000023', '2023-05-15 16:43:01', 6),
('PR000024', '2023-05-15 16:43:01', 6),
('PR000025', '2023-05-15 16:44:26', 5),
('PR000026', '2023-05-15 16:44:26', 5),
('PR000027', '2023-05-15 16:44:26', 5),
('PR000028', '2023-05-15 16:44:26', 5),
('PR000029', '2023-05-15 16:44:26', 5),
('PR000030', '2023-05-15 16:44:26', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `receivingdetail`
--

CREATE TABLE `receivingdetail` (
  `InID` varchar(10) NOT NULL,
  `ProductID` varchar(10) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ReceivingUnitPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `receivingdetail`
--
DELIMITER $$
CREATE TRIGGER `trg_receivingdetail_afterdel` AFTER DELETE ON `receivingdetail` FOR EACH ROW update `product` set `CanDel` = 1 where ProductID = old.ProductID and canDel = 0 and ProductID not in (select distinct ProductID from `order_line` where ProductID = old.ProductID) and ProductID not in (select distinct ProductID from `receivingdetail` where ProductID = old.ProductID)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` varchar(8) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `NumberPhone` varchar(10) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `Name`, `NumberPhone`, `Address`, `Email`, `Status`) VALUES
('SU000001', 'Tân Phúc', '0987675433', '770 CMT8, P13, Q10, Hồ Chí Minh', 'tanphuc@gmail.com', 1),
('SU000002', 'Thịnh Long', '0976543234', '4 Cao Lỗ, P4, Q8, Hồ Chí Minh', 'thinhlong@gmail.com', 1),
('SU000003', 'Kim Long', '0363468765', '772 3/2, P13, Q10, Hồ Chí Minh', 'thinhgia@gmail.com', 1),
('SU000004', 'Thế Giới Đồng Hồ', '0907876588', 'Lê Văn Việt, Q11, Hồ Chí Minh', 'thegioidongho@gmail.com', 1),
('SU000005', 'Minh Tân', '0908765432', 'Gò Vấp, Hồ Chí Minh', 'minhtan@gmail.com', 1),
('SU000006', 'Đức Tài', '0907865222', 'Chợ Bến Thành, Quận 1, Hồ Chí Minh', 'ductai@gmail.com', 1),
('SU000007', 'Nam Sơn', '0908777888', '33 CMT8, P11, Q10, Hồ Chí Minh', 'namson@gmail.com', 1),
('SU000008', 'Thịnh Hưng', '0393678444', 'Hà Nội', 'thinhhung@gmail.com', 1),
('SU000009', 'Duy Anh', '0987654111', '445, Hoàng Kiếm, Hà Nội', 'duyanh@gmail.com', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `UserID` varchar(8) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `NumberPhone` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `HouseRoadAddress` varchar(50) NOT NULL,
  `Ward` varchar(30) NOT NULL,
  `District` varchar(30) NOT NULL,
  `Province` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`UserID`, `FullName`, `NumberPhone`, `Email`, `Password`, `HouseRoadAddress`, `Ward`, `District`, `Province`, `Status`) VALUES
('US000001', 'Võ Văn Hùng', '0907604514', 'vovanhung2864@gmail.com', '123456', '521/91E, CMT8', 'Phường 13', 'Quận 10', 'Thành phố Hồ Chí Minh', 1),
('US000002', 'Lê Phan Huỳnh Như', '0907604532', 'nhuhuynh2862@gmail.com', '123456', '45', 'Xã Khuôn Hà', 'Huyện Lâm Bình', 'Tỉnh Tuyên Quang', 1),
('US000003', 'Võ Quang Đăng Khoa', '0907685643', 'dangkhoa2345@gmail.com', '123456', '34', 'Xã Lương Can', 'Huyện Hà Quảng', 'Tỉnh Cao Bằng', 1),
('US000004', 'Thiều Việt Hoàng', '0908675435', 'thieuhoang2346@gmail.com', '123456', '34', 'Phường Bồng Lai', 'Thị xã Quế Võ', 'Tỉnh Bắc Ninh', 1),
('US000005', 'Hoàng Bình Minh', '0908765367', 'binhminh@gmail.com', '123456', '31', 'Phường Mỹ Long', 'Thành phố Long Xuyên', 'Tỉnh An Giang', 1),
('US000006', 'Thiều Bảo Trâm', '0907604999', 'baotram2345@gmail.com', '123456', '61 An Định A', 'Thị trấn Ba Chúc', 'Huyện Tri Tôn', 'Tỉnh An Giang', 1),
('US000007', 'Lê Hồng Cẩm thu', '0327794675', 'camthu@gmail.com', '123456', '1', 'Phường An Hòa', 'Quận Ninh Kiều', 'Thành phố Cần Thơ', 1),
('US000008', 'Lê Ngọc Trâm', '0976543678', 'ngoctram567@gmail.com', '123456', '770 CMT8', 'Phường 05', 'Quận Tân Bình', 'Thành phố Hồ Chí Minh', 1),
('US000009', 'Phạm Cẩm Thơ', '0976548762', 'camtho234@gmail.com', '123456', '521/91E CMT8', 'Phường 13', 'Quận 10', 'Thành phố Hồ Chí Minh', 1),
('US000010', 'Đào Công Trứ', '0327794829', 'congtru2865@gmail.com', '123456', 'Đường 19/5', 'Xã Tân Ân', 'Huyện Cần Đước', 'Tỉnh Long An', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `voucher`
--

CREATE TABLE `voucher` (
  `VoucherID` varchar(5) NOT NULL,
  `VoucherName` varchar(50) NOT NULL,
  `Discount` int(11) NOT NULL,
  `Unit` varchar(5) NOT NULL,
  `DateFrom` date NOT NULL,
  `DateTo` date NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `voucher`
--

INSERT INTO `voucher` (`VoucherID`, `VoucherName`, `Discount`, `Unit`, `DateFrom`, `DateTo`, `Status`) VALUES
('VO001', '30/4', 5, '%', '2023-04-24', '2023-04-30', 1),
('VO002', '5/5', 2, '%', '2023-05-04', '2023-05-07', 1),
('VO003', '1/1 Tết Dương Lịch', 1, '%', '2022-01-01', '2022-01-03', 1),
('VO004', 'Valentine', 2, '%', '2022-02-14', '2022-02-14', 1),
('VO005', 'Ngày thành lập Đảng Cộng Sản Việt Nam 3/2', 2, '%', '2022-02-03', '2022-02-03', 1),
('VO006', 'Ngày Quốc Tế Phụ Nữ 8/3', 3, '%', '2022-03-08', '2022-03-08', 1),
('VO007', 'Ngày sinh của Bác Hồ', 3, '%', '2022-05-19', '2022-05-19', 1),
('VO008', 'Lễ Giáng Sinh', 3, '%', '2022-12-15', '2022-12-25', 1),
('VO009', 'Quốc tế lao động', 3, '%', '2022-05-01', '2022-05-01', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`BrandID`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`UserID`,`ProductID`),
  ADD KEY `FK_ProductID_Cart` (`ProductID`);

--
-- Chỉ mục cho bảng `inventoryreceivingvoucher`
--
ALTER TABLE `inventoryreceivingvoucher`
  ADD PRIMARY KEY (`InID`),
  ADD KEY `FK_SupplierID` (`SupplierID`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `FK_Order_User` (`UserID`),
  ADD KEY `FK_Order_VoucherID` (`VoucherID`),
  ADD KEY `FK_Order_Status` (`OrderStatus`),
  ADD KEY `FK_Order_PaymentID` (`PaymentID`);

--
-- Chỉ mục cho bảng `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`StatusID`);

--
-- Chỉ mục cho bảng `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `FK_OrderLine_ProductID` (`ProductID`);

--
-- Chỉ mục cho bảng `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `FK_BrandID` (`BrandID`);

--
-- Chỉ mục cho bảng `product_quantity`
--
ALTER TABLE `product_quantity`
  ADD PRIMARY KEY (`ProductID`,`Date`);

--
-- Chỉ mục cho bảng `receivingdetail`
--
ALTER TABLE `receivingdetail`
  ADD PRIMARY KEY (`InID`,`ProductID`),
  ADD KEY `FK_ProductID_Re` (`ProductID`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Chỉ mục cho bảng `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`VoucherID`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_ProductID_Cart` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `FK_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Các ràng buộc cho bảng `inventoryreceivingvoucher`
--
ALTER TABLE `inventoryreceivingvoucher`
  ADD CONSTRAINT `FK_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_Order_PaymentID` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Order_Status` FOREIGN KEY (`OrderStatus`) REFERENCES `orderstatus` (`StatusID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Order_User` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Order_VoucherID` FOREIGN KEY (`VoucherID`) REFERENCES `voucher` (`VoucherID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `FK_OrderLine_OrderID` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_OrderLine_ProductID` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_BrandID` FOREIGN KEY (`BrandID`) REFERENCES `brand` (`BrandID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_quantity`
--
ALTER TABLE `product_quantity`
  ADD CONSTRAINT `FK_ProductID` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `receivingdetail`
--
ALTER TABLE `receivingdetail`
  ADD CONSTRAINT `FK_InID` FOREIGN KEY (`InID`) REFERENCES `inventoryreceivingvoucher` (`InID`),
  ADD CONSTRAINT `FK_ProductID_Re` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
