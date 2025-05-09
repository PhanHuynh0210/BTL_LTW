-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 09, 2025 lúc 03:18 PM
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
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `customer_name`, `comment`, `rating`, `created_at`) VALUES
(7, 2, 'khoa', 'khoacadasda', 3, '2025-05-06 12:18:35'),
(56, 1, 'hai', 'Bài viết rất rõ ràng, giúp mình hiểu rõ hơn về thiết kế và tính năng mới của iPhone.', 5, '2025-05-08 18:36:41'),
(57, 2, 'linh', 'Nội dung hấp dẫn, nhưng thông tin về hiệu năng chưa được đề cập nhiều.', 4, '2025-05-08 18:36:41'),
(58, 3, 'nam', 'Bài viết dài và chi tiết, tuy nhiên phần so sánh còn hơi thiếu.', 4, '2025-05-08 18:36:41'),
(59, 4, 'thu', 'Thông tin khá hữu ích, cảm ơn tác giả đã tổng hợp.', 5, '2025-05-08 18:36:41'),
(60, 5, 'an', 'Chưa thực sự thuyết phục với bài viết này, phần đánh giá pin rất sơ sài.', 3, '2025-05-08 18:36:41'),
(61, 6, 'vy', 'Cảm ơn bài chia sẻ, mình có được cái nhìn khá rõ ràng về dòng Xiaomi mới.', 5, '2025-05-08 18:36:41'),
(62, 7, 'tien', 'Thông tin khá tốt, đặc biệt là phần camera.', 4, '2025-05-08 18:36:41'),
(63, 31, 'minh', 'Bài viết có nhiều lỗi chính tả, nhưng nội dung cũng được.', 3, '2025-05-08 18:36:41'),
(64, 32, 'phuong', 'Samsung cải thiện nhiều, rất đáng mua. Bài viết chi tiết.', 5, '2025-05-08 18:36:41'),
(65, 33, 'khoa', 'Cần thêm thông tin về hiệu năng thực tế để đánh giá đúng hơn.', 3, '2025-05-08 18:36:41'),
(66, 34, 'trinh', 'OPPO năm nay làm khá tốt, bài này phân tích hợp lý.', 4, '2025-05-08 18:36:41'),
(67, 35, 'tuan', 'Bài viết chưa rõ phần đánh giá màn hình.', 2, '2025-05-08 18:36:41'),
(68, 36, 'nguyet', 'Sony vẫn giữ phong độ, cảm ơn bài viết.', 5, '2025-05-08 18:36:41'),
(69, 37, 'bao', 'Đây là chiếc gaming phone đúng nghĩa!', 5, '2025-05-08 18:36:41'),
(70, 38, 'tam', 'Huawei quay trở lại mạnh mẽ!', 4, '2025-05-08 18:36:41'),
(71, 39, 'nga', 'Vivo X90 Pro+ thật sự rất chất lượng.', 5, '2025-05-08 18:36:41'),
(73, 2, 'long', 'Phần đánh giá camera rất chi tiết, mình thích phần này.', 4, '2025-05-08 18:41:27'),
(74, 3, 'dai', 'Nội dung ổn nhưng bố cục chưa logic lắm.', 3, '2025-05-08 18:41:27'),
(75, 4, 'nhu', 'Thiết kế đẹp, mong bài viết sau có phần pin chi tiết hơn.', 4, '2025-05-08 18:41:27'),
(76, 5, 'kiet', 'Bài viết khá sơ lược, chưa có nhiều điểm nổi bật.', 2, '2025-05-08 18:41:27'),
(77, 6, 'khanh', 'Tác giả phân tích rất sâu, mình thấy rất hữu ích.', 5, '2025-05-08 18:41:27'),
(78, 7, 'yen', 'Tham khảo được nhiều điều, cảm ơn người viết bài.', 5, '2025-05-08 18:41:27'),
(79, 31, 'tung', 'Chưa thấy đề cập các thông số hiệu năng.', 3, '2025-05-08 18:41:27'),
(80, 32, 'mai', 'So sánh cấu hình giữa các dòng rất cụ thể.', 5, '2025-05-08 18:41:27'),
(81, 33, 'chau', 'Thiếu hình ảnh minh họa nên hơi khó hình dung.', 3, '2025-05-08 18:41:27'),
(82, 34, 'son', 'Phân tích đúng trọng tâm, mình đánh giá cao bài viết.', 5, '2025-05-08 18:41:27'),
(83, 35, 'dung', 'Nội dung phù hợp người mới tìm hiểu công nghệ.', 4, '2025-05-08 18:41:27'),
(84, 36, 'hoa', 'Nếu thêm bảng giá chi tiết sẽ hoàn hảo hơn.', 4, '2025-05-08 18:41:27'),
(85, 37, 'hieu', 'Rất hữu ích, dễ nắm bắt thông tin.', 5, '2025-05-08 18:41:27'),
(86, 38, 'ha', 'Tác giả nên kiểm tra lại lỗi chính tả.', 3, '2025-05-08 18:41:27'),
(87, 39, 'tai', 'Phân tích chi tiết, đặc biệt thích phần pin.', 5, '2025-05-08 18:41:27'),
(88, 1, 'trang', 'Bài viết hay nhưng hơi dài.', 3, '2025-05-08 18:41:27'),
(89, 2, 'phat', 'Các hình ảnh minh họa làm bài viết sinh động hơn.', 4, '2025-05-08 18:41:27'),
(90, 3, 'quyen', 'Chưa thấy đề cập các tính năng AI trên máy.', 3, '2025-05-08 18:41:27'),
(91, 4, 'vinh', 'Phân tích quá chuyên sâu, bạn đọc phổ thông hơi khó hiểu.', 2, '2025-05-08 18:41:27'),
(92, 5, 'phuong', 'Từng phần trình bày hợp lý, mình hài lòng.', 5, '2025-05-08 18:41:27'),
(93, 6, 'linh', 'Bài đăng này rất bổ ích cho mình khi đang tìm máy mới.', 5, '2025-05-08 18:41:27'),
(94, 7, 'thao', 'Chưa có bảng so sánh thông số, mong bổ sung.', 3, '2025-05-08 18:41:27'),
(95, 31, 'truong', 'Phần nhận xét camera rất chính xác.', 5, '2025-05-08 18:41:27'),
(96, 32, 'mi', 'Cần thêm video trải nghiệm thực tế.', 4, '2025-05-08 18:41:27'),
(97, 33, 'viet', 'Bài viết ngắn gọn, dễ theo dõi.', 5, '2025-05-08 18:41:27'),
(98, 34, 'nhan', 'Rất thích phần đề cập nội dung bảo mật.', 4, '2025-05-08 18:41:27'),
(99, 35, 'vy', 'Thông tin đưa ra chưa cập nhật phiên bản mới.', 3, '2025-05-08 18:41:27'),
(100, 36, 'duy', 'Phân tích phần mềm khá sâu, hữu ích.', 5, '2025-05-08 18:41:27'),
(101, 37, 'bao', 'Tác giả viết mạch lạc, rõ ràng.', 5, '2025-05-08 18:41:27'),
(102, 38, 'hieu', 'Camera đẹp nhưng hiệu năng chưa được nói rõ.', 4, '2025-05-08 18:41:27'),
(103, 39, 'dao', 'Thích phần nói về thiết kế kim loại nguyên khối.', 4, '2025-05-08 18:41:27'),
(104, 1, 'phuc', 'Chưa có phần đánh giá game, thiếu sót lớn.', 3, '2025-05-08 18:41:27'),
(106, 3, 'loan', 'Nội dung ổn nhưng còn lỗi chính tả.', 3, '2025-05-08 18:41:27'),
(107, 4, 'quoc', 'Thiết lập bài viết gọn gàng, dễ nhìn.', 4, '2025-05-08 18:41:27'),
(108, 5, 'hoang', 'Tác giả có kiến thức tốt, trình bày chuyên nghiệp.', 5, '2025-05-08 18:41:27'),
(109, 6, 'hanh', 'Chưa đủ thông tin để mình quyết định mua.', 3, '2025-05-08 18:41:27'),
(121, 3, 'kiokama', 'aaabbbccc', 1, '2025-05-09 12:59:20'),
(122, 34, 'kdas', 'da', 2, '2025-05-09 13:32:16');

--
-- Bẫy `comments`
--
DELIMITER $$
CREATE TRIGGER `after_comment_delete` AFTER DELETE ON `comments` FOR EACH ROW BEGIN
    DECLARE total_rating DECIMAL(10,2);
    DECLARE rating_count INT;

    SELECT COALESCE(SUM(rating), 0), COUNT(*)
    INTO total_rating, rating_count
    FROM comments
    WHERE post_id = OLD.post_id;

    IF rating_count > 0 THEN
        UPDATE posts
        SET avg_rating = total_rating / rating_count
        WHERE id = OLD.post_id;  -- Thay đổi từ post_id sang id
    ELSE
        UPDATE posts
        SET avg_rating = 0
        WHERE id = OLD.post_id;    -- Thay đổi từ post_id sang id
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_comment_insert` AFTER INSERT ON `comments` FOR EACH ROW BEGIN
    DECLARE total_rating DECIMAL(10,2);
    DECLARE rating_count INT;

    SELECT COALESCE(SUM(rating), 0), COUNT(*)
    INTO total_rating, rating_count
    FROM comments
    WHERE post_id = NEW.post_id;

    IF rating_count > 0 THEN
        UPDATE posts
        SET avg_rating = total_rating / rating_count
        WHERE id = NEW.post_id;  -- Thay đổi từ post_id sang id
    ELSE
        UPDATE posts
        SET avg_rating = 0
        WHERE id = NEW.post_id;    -- Thay đổi từ post_id sang id
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_comment_update` AFTER UPDATE ON `comments` FOR EACH ROW BEGIN
    DECLARE total_rating DECIMAL(10,2);
    DECLARE rating_count INT;

    SELECT COALESCE(SUM(rating), 0), COUNT(*)
    INTO total_rating, rating_count
    FROM comments
    WHERE post_id = NEW.post_id;

    IF rating_count > 0 THEN
        UPDATE posts
        SET avg_rating = total_rating / rating_count
        WHERE id = NEW.post_id;  -- Thay đổi từ post_id sang id
    ELSE
        UPDATE posts
        SET avg_rating = 0
        WHERE id = NEW.post_id;    -- Thay đổi từ post_id sang id
    END IF;
END
$$
DELIMITER ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
