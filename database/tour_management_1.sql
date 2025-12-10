-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 09, 2025 lúc 07:28 AM
-- Phiên bản máy phục vụ: 8.4.3
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tour_management_1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `hdv_id` int DEFAULT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phuong_tien` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_khoi_hanh` date DEFAULT NULL,
  `so_luong` int DEFAULT NULL,
  `tong_tien` decimal(12,2) DEFAULT NULL,
  `status` enum('Chờ xử lý','Đã cọc','Hoàn tất','Hủy') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Chờ xử lý',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `hotel_supplier_id` int DEFAULT NULL,
  `restaurant_supplier_id` int DEFAULT NULL,
  `chi_phi_phat_sinh` decimal(12,2) DEFAULT '0.00',
  `ly_do_phat_sinh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tien_da_coc` decimal(12,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `tour_id`, `hdv_id`, `customer_name`, `customer_phone`, `phuong_tien`, `ngay_khoi_hanh`, `so_luong`, `tong_tien`, `status`, `created_at`, `created_by`, `approved_by`, `approved_at`, `hotel_supplier_id`, `restaurant_supplier_id`, `chi_phi_phat_sinh`, `ly_do_phat_sinh`, `tien_da_coc`) VALUES
(13, 2, 1, 'Nguyễn Văn A', '0123456789', 'Xe du lịch', '2025-12-07', 1, 5990000.00, 'Hoàn tất', '2025-12-05 16:28:35', NULL, NULL, NULL, 1, 2, 0.00, '', 5990000.00),
(14, 2, 1, 'Nguyễn Văn A', '0123456789', 'Xe du lịch', '2025-12-04', 1, 5990000.00, 'Hoàn tất', '2025-12-05 16:42:33', NULL, NULL, NULL, 1, 2, 0.00, '', 59900000.00),
(15, 1, 2, 'Nguyễn Văn B', '01234567890', 'Xe du lịch', '2025-12-13', 1, 3500000.00, 'Hoàn tất', '2025-12-05 17:14:27', NULL, NULL, NULL, NULL, NULL, 0.00, '', 3500000.00),
(16, 2, 1, 'hòa minh hoàng', '09493843', 'ô tô', '2025-12-08', 4, 17970000.00, 'Hoàn tất', '2025-12-07 17:25:05', NULL, NULL, NULL, NULL, NULL, 0.00, '', 0.00),
(17, 1, 2, 'hùng', '09482304', 'ô tô', '2025-12-12', 4, 12250000.00, 'Đã cọc', '2025-12-08 07:56:16', NULL, NULL, NULL, 4, 5, 0.00, '', 3000000.00),
(18, 2, 1, 'hều', '09384907343', '', '2025-12-20', 1, 5990000.00, 'Chờ xử lý', '2025-12-08 16:06:55', NULL, NULL, NULL, 1, 2, 0.00, '', 0.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_customers`
--

CREATE TABLE `booking_customers` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `ho_ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nam_sinh` int DEFAULT NULL,
  `CCCD` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tuoi` int DEFAULT NULL,
  `gioi_tinh` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gia_tien` decimal(12,2) DEFAULT '0.00',
  `checkin_status` enum('Chưa checkin','Có mặt','Vắng mặt','Đến muộn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Chưa checkin',
  `checkin_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `checkin_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_customers`
--

INSERT INTO `booking_customers` (`id`, `booking_id`, `ho_ten`, `phone`, `nam_sinh`, `CCCD`, `ghi_chu`, `tuoi`, `gioi_tinh`, `so_dien_thoai`, `gia_tien`, `checkin_status`, `checkin_note`, `checkin_time`) VALUES
(18, 13, 'Nguyễn Văn A', NULL, NULL, '', NULL, 25, 'Nam', '0123456789', 5990000.00, 'Có mặt', NULL, '2025-12-06 00:17:47'),
(20, 14, 'Nguyễn Văn A', NULL, NULL, '', NULL, 25, 'Nam', '0123456789', 5990000.00, 'Chưa checkin', NULL, NULL),
(22, 15, 'Nguyễn Văn B', NULL, NULL, '', NULL, 25, 'Nam', '01234567890', 3500000.00, 'Chưa checkin', NULL, NULL),
(27, 16, 'hòa minh hoàng', NULL, NULL, '', NULL, 13, 'Nam', '09493843', 5990000.00, 'Chưa checkin', NULL, NULL),
(28, 16, 'gggg', NULL, NULL, '', NULL, 1, 'Nam', '4244124', 2995000.00, 'Chưa checkin', NULL, NULL),
(29, 16, 'eeee', NULL, NULL, '', NULL, 1, 'Nam', '3434134', 2995000.00, 'Chưa checkin', NULL, NULL),
(30, 16, 'rrrrr', NULL, NULL, '', NULL, 100, 'Nam', '3333333', 5990000.00, 'Chưa checkin', NULL, NULL),
(31, 17, 'hùng', NULL, NULL, '', NULL, 12, 'Nam', '09482304', 3500000.00, 'Chưa checkin', NULL, NULL),
(32, 17, 'hằng', NULL, NULL, '', NULL, 1, 'Nữ', '13212445323', 1750000.00, 'Chưa checkin', NULL, NULL),
(33, 17, 'lâm', NULL, NULL, '', NULL, 29, 'Nam', '09876633', 3500000.00, 'Chưa checkin', NULL, NULL),
(34, 17, 'hiệp', NULL, NULL, '', NULL, 27, 'Nữ', '03902843', 3500000.00, 'Chưa checkin', NULL, NULL),
(35, 18, 'hều', NULL, NULL, '', NULL, 8, 'Nam', '09384907343', 5990000.00, 'Chưa checkin', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_schedule_activities`
--

CREATE TABLE `booking_schedule_activities` (
  `id` int NOT NULL,
  `day_id` int NOT NULL,
  `thoi_gian_bat_dau` time DEFAULT NULL,
  `thoi_gian_ket_thuc` time DEFAULT NULL,
  `dia_diem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoat_dong` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_schedule_activities`
--

INSERT INTO `booking_schedule_activities` (`id`, `day_id`, `thoi_gian_bat_dau`, `thoi_gian_ket_thuc`, `dia_diem`, `hoat_dong`) VALUES
(57, 16, '09:00:00', '10:00:00', '', 'Đón đoàn'),
(58, 16, '10:30:00', '11:30:00', '', 'Viếng chùa'),
(59, 16, '12:00:00', '13:00:00', '', 'Ăn trưa'),
(60, 16, '14:00:00', '15:00:00', '', 'Nhận phòng'),
(61, 17, '08:00:00', '09:00:00', 'Nhà hàng Mychelin', 'Ăn sáng tại nhà hàng'),
(62, 17, '09:00:00', '10:00:00', 'phố Hội An', 'Đón doàn đi tham quan phố'),
(63, 17, '11:00:00', '12:00:00', 'Nhà hàng VietFood', 'Ăn trưa'),
(64, 17, '13:00:00', '14:00:00', 'Khách sạn ', 'Về khách sạn'),
(65, 18, '08:00:00', '09:00:00', '', 'Ăn sáng tại phố đi bộ Hội An'),
(66, 18, '09:00:00', '10:00:00', '', 'Đón đoàn đi tham quan núi Bà Nà'),
(67, 18, '11:00:00', '12:00:00', '', 'Ăn trưa'),
(68, 18, '13:00:00', '14:00:00', '', 'Về khách sạn'),
(69, 19, '08:00:00', '09:00:00', '', 'Ăn sáng tại nhà hàng'),
(70, 19, '09:00:00', '11:00:00', '', 'Thời gian tự do và có mặt tại khách sạn trước 11h'),
(71, 19, '11:00:00', '11:30:00', '', 'Di chuyển tới sân bay bằng xe ô tô'),
(72, 19, '12:00:00', '12:30:00', '', 'Ăn trưa '),
(73, 19, '13:00:00', '16:00:00', '', 'Tham quan và mua đồ lưu niệm'),
(74, 19, '16:30:00', '17:00:00', '', 'Lên máy bay'),
(75, 20, '09:00:00', '10:00:00', '', 'Đón đoàn'),
(76, 20, '10:30:00', '11:30:00', '', 'Viếng chùa'),
(77, 20, '12:00:00', '13:00:00', '', 'Ăn trưa'),
(78, 20, '14:00:00', '15:00:00', '', 'Nhận phòng'),
(79, 21, '08:00:00', '09:00:00', 'Nhà hàng Mychelin', 'Ăn sáng tại nhà hàng'),
(80, 21, '09:00:00', '10:00:00', 'phố Hội An', 'Đón doàn đi tham quan phố'),
(81, 21, '11:00:00', '12:00:00', 'Nhà hàng VietFood', 'Ăn trưa'),
(82, 21, '13:00:00', '14:00:00', 'Khách sạn ', 'Về khách sạn'),
(83, 22, '08:00:00', '09:00:00', '', 'Ăn sáng tại phố đi bộ Hội An'),
(84, 22, '09:00:00', '10:00:00', '', 'Đón đoàn đi tham quan núi Bà Nà'),
(85, 22, '11:00:00', '12:00:00', '', 'Ăn trưa'),
(86, 22, '13:00:00', '14:00:00', '', 'Về khách sạn'),
(87, 23, '08:00:00', '09:00:00', '', 'Ăn sáng tại nhà hàng'),
(88, 23, '09:00:00', '11:00:00', '', 'Thời gian tự do và có mặt tại khách sạn trước 11h'),
(89, 23, '11:00:00', '11:30:00', '', 'Di chuyển tới sân bay bằng xe ô tô'),
(90, 23, '12:00:00', '12:30:00', '', 'Ăn trưa '),
(91, 23, '13:00:00', '16:00:00', '', 'Tham quan và mua đồ lưu niệm'),
(92, 23, '16:30:00', '17:00:00', '', 'Lên máy bay'),
(93, 24, '06:00:00', '12:00:00', 'Cao tốc', 'Xe đón khách đi Sapa'),
(94, 24, '12:00:00', '13:30:00', 'Nhà hàng A Phủ', 'Ăn trưa đặc sản'),
(95, 24, '14:00:00', '16:00:00', 'Khách sạn Bamboo', 'Nhận phòng nghỉ ngơi'),
(96, 24, '16:30:00', '18:30:00', 'Núi Hàm Rồng', 'Leo núi ngắm cảnh'),
(97, 25, '07:00:00', '08:00:00', 'Khách sạn', 'Ăn sáng buffet'),
(98, 25, '08:30:00', '12:00:00', 'Fansipan', 'Đi cáp treo lên đỉnh'),
(99, 25, '12:30:00', '13:30:00', 'Nhà hàng', 'Ăn trưa buffet'),
(100, 25, '14:30:00', '17:00:00', 'Bản Cát Cát', 'Thăm bản người H\'Mông'),
(101, 26, '07:00:00', '08:30:00', 'Khách sạn', 'Ăn sáng trả phòng'),
(102, 26, '09:00:00', '11:00:00', 'Chợ Sapa', 'Mua sắm quà'),
(103, 26, '13:00:00', '18:00:00', 'Xe Sao Việt', 'Về Hà Nội'),
(104, 27, '09:00:00', '10:00:00', '', 'Đón đoàn'),
(105, 27, '10:30:00', '11:30:00', '', 'Viếng chùa'),
(106, 27, '12:00:00', '13:00:00', '', 'Ăn trưa'),
(107, 27, '14:00:00', '15:00:00', '', 'Nhận phòng'),
(108, 28, '08:00:00', '09:00:00', 'Nhà hàng Mychelin', 'Ăn sáng tại nhà hàng'),
(109, 28, '09:00:00', '10:00:00', 'phố Hội An', 'Đón doàn đi tham quan phố'),
(110, 28, '11:00:00', '12:00:00', 'Nhà hàng VietFood', 'Ăn trưa'),
(111, 28, '13:00:00', '14:00:00', 'Khách sạn ', 'Về khách sạn'),
(112, 29, '08:00:00', '09:00:00', '', 'Ăn sáng tại phố đi bộ Hội An'),
(113, 29, '09:00:00', '10:00:00', '', 'Đón đoàn đi tham quan núi Bà Nà'),
(114, 29, '11:00:00', '12:00:00', '', 'Ăn trưa'),
(115, 29, '13:00:00', '14:00:00', '', 'Về khách sạn'),
(116, 30, '08:00:00', '09:00:00', '', 'Ăn sáng tại nhà hàng'),
(117, 30, '09:00:00', '11:00:00', '', 'Thời gian tự do và có mặt tại khách sạn trước 11h'),
(118, 30, '11:00:00', '11:30:00', '', 'Di chuyển tới sân bay bằng xe ô tô'),
(119, 30, '12:00:00', '12:30:00', '', 'Ăn trưa '),
(120, 30, '13:00:00', '16:00:00', '', 'Tham quan và mua đồ lưu niệm'),
(121, 30, '16:30:00', '17:00:00', '', 'Lên máy bay'),
(122, 31, '06:00:00', '12:00:00', 'Cao tốc', 'Xe đón khách đi Sapa'),
(123, 31, '12:00:00', '13:30:00', 'Nhà hàng A Phủ', 'Ăn trưa đặc sản'),
(124, 31, '14:00:00', '16:00:00', 'Khách sạn Bamboo', 'Nhận phòng nghỉ ngơi'),
(125, 31, '16:30:00', '18:30:00', 'Núi Hàm Rồng', 'Leo núi ngắm cảnh'),
(126, 32, '07:00:00', '08:00:00', 'Khách sạn', 'Ăn sáng buffet'),
(127, 32, '08:30:00', '12:00:00', 'Fansipan', 'Đi cáp treo lên đỉnh'),
(128, 32, '12:30:00', '13:30:00', 'Nhà hàng', 'Ăn trưa buffet'),
(129, 32, '14:30:00', '17:00:00', 'Bản Cát Cát', 'Thăm bản người H\'Mông'),
(130, 33, '07:00:00', '08:30:00', 'Khách sạn', 'Ăn sáng trả phòng'),
(131, 33, '09:00:00', '11:00:00', 'Chợ Sapa', 'Mua sắm quà'),
(132, 33, '13:00:00', '18:00:00', 'Xe Sao Việt', 'Về Hà Nội'),
(133, 34, '09:00:00', '10:00:00', '', 'Đón đoàn'),
(134, 34, '10:30:00', '11:30:00', '', 'Viếng chùa'),
(135, 34, '12:00:00', '13:00:00', '', 'Ăn trưa'),
(136, 34, '14:00:00', '15:00:00', '', 'Nhận phòng'),
(137, 35, '08:00:00', '09:00:00', 'Nhà hàng Mychelin', 'Ăn sáng tại nhà hàng'),
(138, 35, '09:00:00', '10:00:00', 'phố Hội An', 'Đón doàn đi tham quan phố'),
(139, 35, '11:00:00', '12:00:00', 'Nhà hàng VietFood', 'Ăn trưa'),
(140, 35, '13:00:00', '14:00:00', 'Khách sạn ', 'Về khách sạn'),
(141, 36, '08:00:00', '09:00:00', '', 'Ăn sáng tại phố đi bộ Hội An'),
(142, 36, '09:00:00', '10:00:00', '', 'Đón đoàn đi tham quan núi Bà Nà'),
(143, 36, '11:00:00', '12:00:00', '', 'Ăn trưa'),
(144, 36, '13:00:00', '14:00:00', '', 'Về khách sạn'),
(145, 37, '08:00:00', '09:00:00', '', 'Ăn sáng tại nhà hàng'),
(146, 37, '09:00:00', '11:00:00', '', 'Thời gian tự do và có mặt tại khách sạn trước 11h'),
(147, 37, '11:00:00', '11:30:00', '', 'Di chuyển tới sân bay bằng xe ô tô'),
(148, 37, '12:00:00', '12:30:00', '', 'Ăn trưa '),
(149, 37, '13:00:00', '16:00:00', '', 'Tham quan và mua đồ lưu niệm'),
(150, 37, '16:30:00', '17:00:00', '', 'Lên máy bay');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_schedule_days`
--

CREATE TABLE `booking_schedule_days` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `ngay_thu` int NOT NULL,
  `tieu_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_schedule_days`
--

INSERT INTO `booking_schedule_days` (`id`, `booking_id`, `ngay_thu`, `tieu_de`, `mo_ta`) VALUES
(16, 13, 1, 'Ngày 1: Đón sân bay - Sơn Trà', 'Checkin khách sạn'),
(17, 13, 2, 'Ngày 2: Bà Nà Hills', 'Vui chơi Bà Nà'),
(18, 13, 3, 'Ngày 3: Phố cổ Hội An', 'Khám phá phố cổ'),
(19, 13, 4, 'Ngày 4: Tiễn sân bay', 'Tạm biệt Đà Nẵng'),
(20, 14, 1, 'Ngày 1: Đón sân bay - Sơn Trà', 'Checkin khách sạn'),
(21, 14, 2, 'Ngày 2: Bà Nà Hills', 'Vui chơi Bà Nà'),
(22, 14, 3, 'Ngày 3: Phố cổ Hội An', 'Khám phá phố cổ'),
(23, 14, 4, 'Ngày 4: Tiễn sân bay', 'Tạm biệt Đà Nẵng'),
(24, 15, 1, 'Ngày 1: Hà Nội - Sapa - Hàm Rồng', 'Di chuyển và tham quan nhẹ'),
(25, 15, 2, 'Ngày 2: Fansipan - Bản Cát Cát', 'Chinh phục đỉnh núi'),
(26, 15, 3, 'Ngày 3: Sapa - Hà Nội', 'Mua sắm và trở về'),
(27, 16, 1, 'Ngày 1: Đón sân bay - Sơn Trà', 'Checkin khách sạn'),
(28, 16, 2, 'Ngày 2: Bà Nà Hills', 'Vui chơi Bà Nà'),
(29, 16, 3, 'Ngày 3: Phố cổ Hội An', 'Khám phá phố cổ'),
(30, 16, 4, 'Ngày 4: Tiễn sân bay', 'Tạm biệt Đà Nẵng'),
(31, 17, 1, 'Ngày 1: Hà Nội - Sapa - Hàm Rồng', 'Di chuyển và tham quan nhẹ'),
(32, 17, 2, 'Ngày 2: Fansipan - Bản Cát Cát', 'Chinh phục đỉnh núi'),
(33, 17, 3, 'Ngày 3: Sapa - Hà Nội', 'Mua sắm và trở về'),
(34, 18, 1, 'Ngày 1: Đón sân bay - Sơn Trà', 'Checkin khách sạn'),
(35, 18, 2, 'Ngày 2: Bà Nà Hills', 'Vui chơi Bà Nà'),
(36, 18, 3, 'Ngày 3: Phố cổ Hội An', 'Khám phá phố cổ'),
(37, 18, 4, 'Ngày 4: Tiễn sân bay', 'Tạm biệt Đà Nẵng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkin_details`
--

CREATE TABLE `checkin_details` (
  `id` int NOT NULL,
  `session_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `status` enum('Chưa checkin','Có mặt','Vắng mặt','Đến muộn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Chưa checkin',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `checkin_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `checkin_details`
--

INSERT INTO `checkin_details` (`id`, `session_id`, `customer_id`, `status`, `note`, `checkin_time`) VALUES
(1, 1, 18, 'Có mặt', NULL, '2025-12-08 00:27:03'),
(11, 8, 18, 'Chưa checkin', NULL, NULL),
(20, 11, 27, 'Đến muộn', NULL, '2025-12-08 23:33:00'),
(21, 11, 28, 'Vắng mặt', NULL, '2025-12-08 23:33:01'),
(22, 11, 29, 'Có mặt', NULL, '2025-12-08 23:27:38'),
(23, 11, 30, 'Có mặt', NULL, '2025-12-08 23:27:38'),
(24, 12, 27, 'Có mặt', NULL, '2025-12-08 23:34:06'),
(25, 12, 28, 'Đến muộn', NULL, '2025-12-08 23:34:18'),
(26, 12, 29, 'Đến muộn', NULL, '2025-12-08 23:34:23'),
(27, 12, 30, 'Đến muộn', NULL, '2025-12-08 23:34:19'),
(28, 13, 27, 'Đến muộn', NULL, '2025-12-09 14:25:21'),
(29, 13, 28, 'Có mặt', NULL, '2025-12-09 14:25:27'),
(30, 13, 29, 'Vắng mặt', NULL, '2025-12-08 23:38:06'),
(31, 13, 30, 'Đến muộn', NULL, '2025-12-08 23:38:09'),
(32, 14, 18, 'Vắng mặt', NULL, '2025-12-09 14:24:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkin_sessions`
--

CREATE TABLE `checkin_sessions` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `checkin_sessions`
--

INSERT INTO `checkin_sessions` (`id`, `booking_id`, `title`, `created_at`) VALUES
(1, 13, 'Tại nhà xe', '2025-12-05 17:26:16'),
(8, 13, 'Tại điểm đón', '2025-12-07 17:34:44'),
(11, 16, 'điểm danh tại điểm đến', '2025-12-08 16:27:32'),
(12, 16, 'sân bay', '2025-12-08 16:33:54'),
(13, 16, 'cửa khẩu', '2025-12-08 16:35:56'),
(14, 13, 'cửa khẩu', '2025-12-09 07:24:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `guest_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `guest_name`, `supplier_name`, `content`, `rating`, `created_at`) VALUES
(1, 'Nguyễn Văn Khách', 'Khách sạn Bamboo Sapa', 'Tốt', 5, '2025-12-05 15:32:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_checkin`
--

CREATE TABLE `customer_checkin` (
  `id` int NOT NULL,
  `booking_customer_id` int NOT NULL,
  `status` enum('Có mặt','Vắng mặt','Đã checkout') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Có mặt',
  `checkin_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `thoi_gian_ra` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hdv_lich_lam_viec`
--

CREATE TABLE `hdv_lich_lam_viec` (
  `id` int NOT NULL,
  `hdv_id` int NOT NULL,
  `ngay` date NOT NULL,
  `trang_thai` enum('Rảnh','Đi tour','Nghỉ phép') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Rảnh',
  `ghi_chu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hdv_nghi`
--

CREATE TABLE `hdv_nghi` (
  `id` int NOT NULL,
  `hdv_id` int NOT NULL,
  `ngay_nghi` date NOT NULL,
  `ly_do` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotel_rooms`
--

CREATE TABLE `hotel_rooms` (
  `id` int NOT NULL,
  `booking_customer_id` int NOT NULL,
  `room_type` enum('Đơn','Đôi','Gia đình','VIP') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trang_thai` enum('Chưa nhận phòng','Đã nhận phòng','Đã trả phòng') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Chưa nhận phòng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `huong_dan_viens`
--

CREATE TABLE `huong_dan_viens` (
  `id` int NOT NULL,
  `ho_ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `so_dien_thoai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chung_chi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngon_ngu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kinh_nghiem_nam` int DEFAULT NULL,
  `loai_hdv` enum('Nội địa','Quốc tế') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suc_khoe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `danh_gia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `huong_dan_viens`
--

INSERT INTO `huong_dan_viens` (`id`, `ho_ten`, `avatar`, `ngay_sinh`, `so_dien_thoai`, `email`, `chung_chi`, `ngon_ngu`, `kinh_nghiem_nam`, `loai_hdv`, `suc_khoe`, `danh_gia`) VALUES
(1, 'Lê Thành Long', NULL, NULL, '0909123456', 'long.hdv@travel.com', NULL, NULL, 7, 'Quốc tế', 'Tốt', 'Nhiệt tình'),
(2, 'Phạm Thu Hà', NULL, NULL, '0909999888', 'ha.pham@travel.com', NULL, NULL, 3, 'Nội địa', 'Tốt', 'Chu đáo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `so_tien` decimal(12,2) NOT NULL,
  `loai_thanh_toan` enum('Cọc','Thanh toán thêm','Thanh toán đợt 2','Hoàn tất','Hoàn tiền') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Cọc',
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nguoi_thu_tien` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_thu` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_history`
--

INSERT INTO `payment_history` (`id`, `booking_id`, `so_tien`, `loai_thanh_toan`, `ghi_chu`, `nguoi_thu_tien`, `ngay_thu`) VALUES
(7, 13, 5990000.00, 'Cọc', 'Đặt cọc khi tạo booking', 'Lương Đức Hiệp', '2025-12-05 16:28:35'),
(8, 14, 59900000.00, 'Cọc', 'Đặt cọc khi tạo booking', 'Lương Đức Hiệp', '2025-12-05 16:42:33'),
(9, 15, 3500000.00, 'Cọc', 'Đặt cọc khi tạo booking', 'Lương Đức Hiệp', '2025-12-05 17:14:27'),
(10, 17, 3000000.00, 'Cọc', 'Đặt cọc khi tạo booking', 'hòa minh hoàng đẹp trai', '2025-12-08 07:56:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Nhà hàng','Khách sạn','Vận chuyển') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `type`, `phone`, `email`, `address`, `rating`, `created_at`) VALUES
(1, 'Khách sạn Bamboo Sapa', 'Khách sạn', '02143888888', NULL, '18 Mường Hoa, Sapa', 4, '2025-12-05 08:32:54'),
(2, 'Nhà hàng A Phủ', 'Nhà hàng', '0912345678', NULL, '15 Fansipan, Sapa', 5, '2025-12-05 08:32:54'),
(3, 'Nhà xe Sao Việt', 'Vận chuyển', '19006746', NULL, 'Mỹ Đình - Sapa', 4, '2025-12-05 08:32:54'),
(4, 'Novotel Danang', 'Khách sạn', '02363929999', NULL, 'Bạch Đằng, Đà Nẵng', 5, '2025-12-05 08:32:54'),
(5, 'Cơm Niêu Nhà Đỏ', 'Nhà hàng', '02363999999', NULL, 'Đà Nẵng', 4, '2025-12-05 08:32:54'),
(6, 'Vietnam Airlines', 'Vận chuyển', '19001100', NULL, 'Sân Bay Nội Bài', 5, '2025-12-05 08:32:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `ten_tour` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `loai_tour` enum('Trong nước','Quốc tế','Theo yêu cầu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia_diem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thoi_gian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gia_tour` decimal(12,2) DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ngay_khoi_hanh` date DEFAULT NULL,
  `phuong_tien` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_nguoi_toi_da` int DEFAULT NULL,
  `status` enum('Hoạt động','Đang tạm dừng','Hủy') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `ten_tour`, `loai_tour`, `dia_diem`, `thoi_gian`, `gia_tour`, `mo_ta`, `ngay_khoi_hanh`, `phuong_tien`, `so_nguoi_toi_da`, `status`) VALUES
(1, 'Sapa - Chinh phục Fansipan', 'Trong nước', 'Lào Cai', '3 Ngày 2 Đêm', 3500000.00, NULL, '2025-01-10', 'Xe giường nằm', 40, 'Hoạt động'),
(2, 'Đà Nẵng - Hội An - Bà Nà', 'Theo yêu cầu', 'Đà Nẵng', '4 Ngày 3 Đêm', 5990000.00, '', NULL, 'Máy bay', 30, 'Hoạt động');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours_suppliers`
--

CREATE TABLE `tours_suppliers` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tours_suppliers`
--

INSERT INTO `tours_suppliers` (`id`, `tour_id`, `supplier_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_diaries`
--

CREATE TABLE `tour_diaries` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `ngay_thu` int NOT NULL COMMENT 'Ngày thứ mấy trong tour',
  `tieu_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tiêu đề nhật ký',
  `noi_dung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nội dung chi tiết',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_diaries`
--

INSERT INTO `tour_diaries` (`id`, `booking_id`, `ngay_thu`, `tieu_de`, `noi_dung`, `created_at`, `updated_at`) VALUES
(5, 14, 2, 'ádfasdf', 'ádfsadfsad', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(6, 14, 3, 'fasdfasdf', 'fasdfasd', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(8, 14, 3, 'ádfasdf', 'ádfasdf', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(9, 14, 4, 'ádfasdf', 'ádfasdfasdf', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(10, 14, 4, 'sdfasdfasdf', 'sfsf', '2025-12-05 18:43:20', '2025-12-05 18:43:20'),
(11, 16, 1, 'ăn sáng', 'fdfd', '2025-12-08 07:29:45', '2025-12-08 07:29:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_hdv`
--

CREATE TABLE `tour_hdv` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `hdv_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_images`
--

CREATE TABLE `tour_images` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_images`
--

INSERT INTO `tour_images` (`id`, `tour_id`, `image_path`, `mo_ta`) VALUES
(1, 1, 'img/sapa_thumb.jpg', 'Toàn cảnh Sapa'),
(2, 1, 'img/fansipan.jpg', 'Đỉnh Fansipan'),
(3, 2, 'img/cau_rong.jpg', 'Cầu Rồng Đà Nẵng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_restaurants`
--

CREATE TABLE `tour_restaurants` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `bua_an` enum('Sáng','Trưa','Tối') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay` int NOT NULL,
  `ghi_chu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_schedule_activities`
--

CREATE TABLE `tour_schedule_activities` (
  `id` int NOT NULL,
  `day_id` int NOT NULL,
  `thoi_gian_bat_dau` time DEFAULT NULL,
  `thoi_gian_ket_thuc` time DEFAULT NULL,
  `dia_diem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoat_dong` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hinh_anh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_schedule_activities`
--

INSERT INTO `tour_schedule_activities` (`id`, `day_id`, `thoi_gian_bat_dau`, `thoi_gian_ket_thuc`, `dia_diem`, `hoat_dong`, `hinh_anh`) VALUES
(1, 1, '06:00:00', '12:00:00', 'Cao tốc', 'Xe đón khách đi Sapa', NULL),
(2, 1, '12:00:00', '13:30:00', 'Nhà hàng A Phủ', 'Ăn trưa đặc sản', NULL),
(3, 1, '14:00:00', '16:00:00', 'Khách sạn Bamboo', 'Nhận phòng nghỉ ngơi', NULL),
(4, 1, '16:30:00', '18:30:00', 'Núi Hàm Rồng', 'Leo núi ngắm cảnh', NULL),
(5, 2, '07:00:00', '08:00:00', 'Khách sạn', 'Ăn sáng buffet', NULL),
(6, 2, '08:30:00', '12:00:00', 'Fansipan', 'Đi cáp treo lên đỉnh', NULL),
(7, 2, '12:30:00', '13:30:00', 'Nhà hàng', 'Ăn trưa buffet', NULL),
(8, 2, '14:30:00', '17:00:00', 'Bản Cát Cát', 'Thăm bản người H\'Mông', NULL),
(9, 3, '07:00:00', '08:30:00', 'Khách sạn', 'Ăn sáng trả phòng', NULL),
(10, 3, '09:00:00', '11:00:00', 'Chợ Sapa', 'Mua sắm quà', NULL),
(11, 3, '13:00:00', '18:00:00', 'Xe Sao Việt', 'Về Hà Nội', NULL),
(12, 4, '09:00:00', '10:00:00', '', 'Đón đoàn', NULL),
(13, 4, '10:30:00', '11:30:00', '', 'Viếng chùa', NULL),
(14, 4, '12:00:00', '13:00:00', '', 'Ăn trưa', NULL),
(15, 4, '14:00:00', '15:00:00', '', 'Nhận phòng', NULL),
(16, 5, '08:00:00', '09:00:00', 'Nhà hàng Mychelin', 'Ăn sáng tại nhà hàng', NULL),
(17, 5, '09:00:00', '10:00:00', 'phố Hội An', 'Đón doàn đi tham quan phố', NULL),
(18, 5, '11:00:00', '12:00:00', 'Nhà hàng VietFood', 'Ăn trưa', NULL),
(19, 5, '13:00:00', '14:00:00', 'Khách sạn ', 'Về khách sạn', NULL),
(20, 6, '08:00:00', '09:00:00', '', 'Ăn sáng tại phố đi bộ Hội An', NULL),
(21, 6, '09:00:00', '10:00:00', '', 'Đón đoàn đi tham quan núi Bà Nà', NULL),
(22, 6, '11:00:00', '12:00:00', '', 'Ăn trưa', NULL),
(23, 6, '13:00:00', '14:00:00', '', 'Về khách sạn', NULL),
(24, 7, '08:00:00', '09:00:00', '', 'Ăn sáng tại nhà hàng', NULL),
(25, 7, '09:00:00', '11:00:00', '', 'Thời gian tự do và có mặt tại khách sạn trước 11h', NULL),
(26, 7, '11:00:00', '11:30:00', '', 'Di chuyển tới sân bay bằng xe ô tô', NULL),
(27, 7, '12:00:00', '12:30:00', '', 'Ăn trưa ', NULL),
(28, 7, '13:00:00', '16:00:00', '', 'Tham quan và mua đồ lưu niệm', NULL),
(29, 7, '16:30:00', '17:00:00', '', 'Lên máy bay', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_schedule_days`
--

CREATE TABLE `tour_schedule_days` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `ngay_thu` int NOT NULL,
  `tieu_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_schedule_days`
--

INSERT INTO `tour_schedule_days` (`id`, `tour_id`, `ngay_thu`, `tieu_de`, `mo_ta`) VALUES
(1, 1, 1, 'Ngày 1: Hà Nội - Sapa - Hàm Rồng', 'Di chuyển và tham quan nhẹ'),
(2, 1, 2, 'Ngày 2: Fansipan - Bản Cát Cát', 'Chinh phục đỉnh núi'),
(3, 1, 3, 'Ngày 3: Sapa - Hà Nội', 'Mua sắm và trở về'),
(4, 2, 1, 'Ngày 1: Đón sân bay - Sơn Trà', 'Checkin khách sạn'),
(5, 2, 2, 'Ngày 2: Bà Nà Hills', 'Vui chơi Bà Nà'),
(6, 2, 3, 'Ngày 3: Phố cổ Hội An', 'Khám phá phố cổ'),
(7, 2, 4, 'Ngày 4: Tiễn sân bay', 'Tạm biệt Đà Nẵng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_suppliers`
--

CREATE TABLE `tour_suppliers` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `service_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_supplier_schedule`
--

CREATE TABLE `tour_supplier_schedule` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `ngay_thu` int NOT NULL,
  `loai_dich_vu` enum('Khách sạn','Nhà hàng','Vận chuyển') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','staff','user','hdv') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `hdv_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `created_at`, `status`, `hdv_id`) VALUES
(2, 'ltl', '$2y$10$KVkELglBlbJgipf9u6n3suY5AiT/Q5LmtxlFmk6zaMi96kJhZmxyy', 'lê thành long', 'long23@gmail.com', 'hdv', '2025-12-07 08:58:55', 1, 1),
(3, 'dth', '$2y$10$aJ3FwQY6nwYpGm8iz4Q20OcZFY82NQ3VZMS/kdHxgngwMWBTbSmSW', 'đặng thu hà ', 'haf123@gmail.com', 'hdv', '2025-12-07 09:01:25', 1, 2),
(5, 'hmh', '$2y$10$tgosBmmQtjW9s6pAh/J6B.C3mvgn2deyNltHt3HprP/7pU2Anvop2', 'hòa minh hoàng đẹp trai', 'hoahoang1901@gmail.com', 'admin', '2025-12-07 08:51:03', 1, NULL),
(6, 'thành', '$2y$10$Q5UW.43S9oMnSGGgD.KQE.Hv4cIAu7.GHRnN38k0hYtM0RCw1WVLW', 'hều', 'l@gmail.com', 'user', '2025-12-08 07:18:17', 1, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `hdv_id` (`hdv_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `fk_hotel_supplier` (`hotel_supplier_id`),
  ADD KEY `fk_restaurant_supplier` (`restaurant_supplier_id`);

--
-- Chỉ mục cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `booking_schedule_activities`
--
ALTER TABLE `booking_schedule_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`);

--
-- Chỉ mục cho bảng `booking_schedule_days`
--
ALTER TABLE `booking_schedule_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `checkin_details`
--
ALTER TABLE `checkin_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `checkin_sessions`
--
ALTER TABLE `checkin_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer_checkin`
--
ALTER TABLE `customer_checkin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_customer_id` (`booking_customer_id`);

--
-- Chỉ mục cho bảng `hdv_lich_lam_viec`
--
ALTER TABLE `hdv_lich_lam_viec`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Chỉ mục cho bảng `hdv_nghi`
--
ALTER TABLE `hdv_nghi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Chỉ mục cho bảng `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_customer_id` (`booking_customer_id`);

--
-- Chỉ mục cho bảng `huong_dan_viens`
--
ALTER TABLE `huong_dan_viens`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tours_suppliers`
--
ALTER TABLE `tours_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Chỉ mục cho bảng `tour_diaries`
--
ALTER TABLE `tour_diaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `tour_hdv`
--
ALTER TABLE `tour_hdv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Chỉ mục cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_restaurants`
--
ALTER TABLE `tour_restaurants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Chỉ mục cho bảng `tour_schedule_activities`
--
ALTER TABLE `tour_schedule_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`);

--
-- Chỉ mục cho bảng `tour_schedule_days`
--
ALTER TABLE `tour_schedule_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_suppliers`
--
ALTER TABLE `tour_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Chỉ mục cho bảng `tour_supplier_schedule`
--
ALTER TABLE `tour_supplier_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `booking_schedule_activities`
--
ALTER TABLE `booking_schedule_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT cho bảng `booking_schedule_days`
--
ALTER TABLE `booking_schedule_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `checkin_details`
--
ALTER TABLE `checkin_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `checkin_sessions`
--
ALTER TABLE `checkin_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `customer_checkin`
--
ALTER TABLE `customer_checkin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hdv_lich_lam_viec`
--
ALTER TABLE `hdv_lich_lam_viec`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hdv_nghi`
--
ALTER TABLE `hdv_nghi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `huong_dan_viens`
--
ALTER TABLE `huong_dan_viens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tours_suppliers`
--
ALTER TABLE `tours_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tour_diaries`
--
ALTER TABLE `tour_diaries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tour_hdv`
--
ALTER TABLE `tour_hdv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tour_restaurants`
--
ALTER TABLE `tour_restaurants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tour_schedule_activities`
--
ALTER TABLE `tour_schedule_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `tour_schedule_days`
--
ALTER TABLE `tour_schedule_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tour_suppliers`
--
ALTER TABLE `tour_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tour_supplier_schedule`
--
ALTER TABLE `tour_supplier_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_viens` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `huong_dan_viens` (`id`),
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`approved_by`) REFERENCES `huong_dan_viens` (`id`),
  ADD CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`hotel_supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `bookings_ibfk_6` FOREIGN KEY (`restaurant_supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `fk_hotel_supplier` FOREIGN KEY (`hotel_supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_restaurant_supplier` FOREIGN KEY (`restaurant_supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD CONSTRAINT `booking_customers_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_schedule_activities`
--
ALTER TABLE `booking_schedule_activities`
  ADD CONSTRAINT `booking_schedule_activities_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `booking_schedule_days` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_schedule_days`
--
ALTER TABLE `booking_schedule_days`
  ADD CONSTRAINT `booking_schedule_days_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `checkin_details`
--
ALTER TABLE `checkin_details`
  ADD CONSTRAINT `checkin_details_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `checkin_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkin_details_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `checkin_sessions`
--
ALTER TABLE `checkin_sessions`
  ADD CONSTRAINT `checkin_sessions_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `customer_checkin`
--
ALTER TABLE `customer_checkin`
  ADD CONSTRAINT `customer_checkin_ibfk_1` FOREIGN KEY (`booking_customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hdv_lich_lam_viec`
--
ALTER TABLE `hdv_lich_lam_viec`
  ADD CONSTRAINT `hdv_lich_lam_viec_ibfk_1` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_viens` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hdv_nghi`
--
ALTER TABLE `hdv_nghi`
  ADD CONSTRAINT `hdv_nghi_ibfk_1` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_viens` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD CONSTRAINT `hotel_rooms_ibfk_1` FOREIGN KEY (`booking_customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tours_suppliers`
--
ALTER TABLE `tours_suppliers`
  ADD CONSTRAINT `tours_suppliers_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tours_suppliers_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_diaries`
--
ALTER TABLE `tour_diaries`
  ADD CONSTRAINT `tour_diaries_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_hdv`
--
ALTER TABLE `tour_hdv`
  ADD CONSTRAINT `tour_hdv_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_hdv_ibfk_2` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_viens` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD CONSTRAINT `tour_images_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_restaurants`
--
ALTER TABLE `tour_restaurants`
  ADD CONSTRAINT `tour_restaurants_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_restaurants_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_schedule_activities`
--
ALTER TABLE `tour_schedule_activities`
  ADD CONSTRAINT `tour_schedule_activities_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `tour_schedule_days` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_schedule_days`
--
ALTER TABLE `tour_schedule_days`
  ADD CONSTRAINT `tour_schedule_days_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_suppliers`
--
ALTER TABLE `tour_suppliers`
  ADD CONSTRAINT `tour_suppliers_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_suppliers_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_supplier_schedule`
--
ALTER TABLE `tour_supplier_schedule`
  ADD CONSTRAINT `tour_supplier_schedule_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_supplier_schedule_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
