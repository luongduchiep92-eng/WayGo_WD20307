-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2025 at 08:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tour_management_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `hdv_id` int DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phuong_tien` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_khoi_hanh` date DEFAULT NULL,
  `so_luong` int DEFAULT NULL,
  `tong_tien` decimal(12,2) DEFAULT NULL,
  `status` enum('Chờ xử lý','Đã cọc','Hoàn tất','Hủy') COLLATE utf8mb4_unicode_ci DEFAULT 'Chờ xử lý',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `hotel_supplier_id` int DEFAULT NULL,
  `restaurant_supplier_id` int DEFAULT NULL,
  `chi_phi_phat_sinh` decimal(12,2) DEFAULT '0.00',
  `ly_do_phat_sinh` text COLLATE utf8mb4_unicode_ci,
  `tien_da_coc` decimal(12,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `tour_id`, `hdv_id`, `customer_name`, `customer_phone`, `phuong_tien`, `ngay_khoi_hanh`, `so_luong`, `tong_tien`, `status`, `created_at`, `created_by`, `approved_by`, `approved_at`, `hotel_supplier_id`, `restaurant_supplier_id`, `chi_phi_phat_sinh`, `ly_do_phat_sinh`, `tien_da_coc`) VALUES
(13, 2, 1, 'Nguyễn Văn A', '0123456789', 'Xe du lịch', '2025-12-07', 1, '5990000.00', 'Hoàn tất', '2025-12-05 16:28:35', NULL, NULL, NULL, 1, 2, '0.00', '', '5990000.00'),
(14, 2, 1, 'Nguyễn Văn A', '0123456789', 'Xe du lịch', '2025-12-04', 1, '5990000.00', 'Hoàn tất', '2025-12-05 16:42:33', NULL, NULL, NULL, 1, 2, '0.00', '', '59900000.00'),
(15, 1, 2, 'Nguyễn Văn B', '01234567890', 'Xe du lịch', '2025-12-13', 1, '3500000.00', 'Hoàn tất', '2025-12-05 17:14:27', NULL, NULL, NULL, NULL, NULL, '0.00', '', '3500000.00');

-- --------------------------------------------------------

--
-- Table structure for table `booking_customers`
--

CREATE TABLE `booking_customers` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `ho_ten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nam_sinh` int DEFAULT NULL,
  `CCCD` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci,
  `tuoi` int DEFAULT NULL,
  `gioi_tinh` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gia_tien` decimal(12,2) DEFAULT '0.00',
  `checkin_status` enum('Chưa checkin','Có mặt','Vắng mặt','Đến muộn') COLLATE utf8mb4_unicode_ci DEFAULT 'Chưa checkin',
  `checkin_note` text COLLATE utf8mb4_unicode_ci,
  `checkin_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_customers`
--

INSERT INTO `booking_customers` (`id`, `booking_id`, `ho_ten`, `phone`, `nam_sinh`, `CCCD`, `ghi_chu`, `tuoi`, `gioi_tinh`, `so_dien_thoai`, `gia_tien`, `checkin_status`, `checkin_note`, `checkin_time`) VALUES
(18, 13, 'Nguyễn Văn A', NULL, NULL, '', NULL, 25, 'Nam', '0123456789', '5990000.00', 'Có mặt', NULL, '2025-12-06 00:17:47'),
(20, 14, 'Nguyễn Văn A', NULL, NULL, '', NULL, 25, 'Nam', '0123456789', '5990000.00', 'Chưa checkin', NULL, NULL),
(22, 15, 'Nguyễn Văn B', NULL, NULL, '', NULL, 25, 'Nam', '01234567890', '3500000.00', 'Chưa checkin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_schedule_activities`
--

CREATE TABLE `booking_schedule_activities` (
  `id` int NOT NULL,
  `day_id` int NOT NULL,
  `thoi_gian_bat_dau` time DEFAULT NULL,
  `thoi_gian_ket_thuc` time DEFAULT NULL,
  `dia_diem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoat_dong` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_schedule_activities`
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
(103, 26, '13:00:00', '18:00:00', 'Xe Sao Việt', 'Về Hà Nội');

-- --------------------------------------------------------

--
-- Table structure for table `booking_schedule_days`
--

CREATE TABLE `booking_schedule_days` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `ngay_thu` int NOT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_schedule_days`
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
(26, 15, 3, 'Ngày 3: Sapa - Hà Nội', 'Mua sắm và trở về');

-- --------------------------------------------------------

--
-- Table structure for table `checkin_details`
--

CREATE TABLE `checkin_details` (
  `id` int NOT NULL,
  `session_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `status` enum('Chưa checkin','Có mặt','Vắng mặt','Đến muộn') COLLATE utf8mb4_unicode_ci DEFAULT 'Chưa checkin',
  `note` text COLLATE utf8mb4_unicode_ci,
  `checkin_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checkin_details`
--

INSERT INTO `checkin_details` (`id`, `session_id`, `customer_id`, `status`, `note`, `checkin_time`) VALUES
(1, 1, 18, 'Có mặt', NULL, '2025-12-06 00:26:26');

-- --------------------------------------------------------

--
-- Table structure for table `checkin_sessions`
--

CREATE TABLE `checkin_sessions` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checkin_sessions`
--

INSERT INTO `checkin_sessions` (`id`, `booking_id`, `title`, `created_at`) VALUES
(1, 13, 'Tại nhà xe', '2025-12-05 17:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `guest_name`, `supplier_name`, `content`, `rating`, `created_at`) VALUES
(1, 'Nguyễn Văn Khách', 'Khách sạn Bamboo Sapa', 'Tốt', 5, '2025-12-05 15:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `customer_checkin`
--

CREATE TABLE `customer_checkin` (
  `id` int NOT NULL,
  `booking_customer_id` int NOT NULL,
  `status` enum('Có mặt','Vắng mặt','Đã checkout') COLLATE utf8mb4_unicode_ci DEFAULT 'Có mặt',
  `checkin_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `thoi_gian_ra` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hdv_lich_lam_viec`
--

CREATE TABLE `hdv_lich_lam_viec` (
  `id` int NOT NULL,
  `hdv_id` int NOT NULL,
  `ngay` date NOT NULL,
  `trang_thai` enum('Rảnh','Đi tour','Nghỉ phép') COLLATE utf8mb4_unicode_ci DEFAULT 'Rảnh',
  `ghi_chu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hdv_nghi`
--

CREATE TABLE `hdv_nghi` (
  `id` int NOT NULL,
  `hdv_id` int NOT NULL,
  `ngay_nghi` date NOT NULL,
  `ly_do` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_rooms`
--

CREATE TABLE `hotel_rooms` (
  `id` int NOT NULL,
  `booking_customer_id` int NOT NULL,
  `room_type` enum('Đơn','Đôi','Gia đình','VIP') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `trang_thai` enum('Chưa nhận phòng','Đã nhận phòng','Đã trả phòng') COLLATE utf8mb4_unicode_ci DEFAULT 'Chưa nhận phòng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `huong_dan_viens`
--

CREATE TABLE `huong_dan_viens` (
  `id` int NOT NULL,
  `ho_ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chung_chi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngon_ngu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kinh_nghiem_nam` int DEFAULT NULL,
  `loai_hdv` enum('Nội địa','Quốc tế') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suc_khoe` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `danh_gia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `huong_dan_viens`
--

INSERT INTO `huong_dan_viens` (`id`, `ho_ten`, `avatar`, `ngay_sinh`, `so_dien_thoai`, `email`, `chung_chi`, `ngon_ngu`, `kinh_nghiem_nam`, `loai_hdv`, `suc_khoe`, `danh_gia`) VALUES
(1, 'Lê Thành Long', NULL, NULL, '0909123456', 'long.hdv@travel.com', NULL, NULL, 7, 'Quốc tế', 'Tốt', 'Nhiệt tình'),
(2, 'Phạm Thu Hà', NULL, NULL, '0909999888', 'ha.pham@travel.com', NULL, NULL, 3, 'Nội địa', 'Tốt', 'Chu đáo');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `so_tien` decimal(12,2) NOT NULL,
  `loai_thanh_toan` enum('Cọc','Thanh toán thêm','Thanh toán đợt 2','Hoàn tất','Hoàn tiền') COLLATE utf8mb4_unicode_ci DEFAULT 'Cọc',
  `ghi_chu` text COLLATE utf8mb4_unicode_ci,
  `nguoi_thu_tien` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_thu` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `booking_id`, `so_tien`, `loai_thanh_toan`, `ghi_chu`, `nguoi_thu_tien`, `ngay_thu`) VALUES
(7, 13, '5990000.00', 'Cọc', 'Đặt cọc khi tạo booking', 'Lương Đức Hiệp', '2025-12-05 16:28:35'),
(8, 14, '59900000.00', 'Cọc', 'Đặt cọc khi tạo booking', 'Lương Đức Hiệp', '2025-12-05 16:42:33'),
(9, 15, '3500000.00', 'Cọc', 'Đặt cọc khi tạo booking', 'Lương Đức Hiệp', '2025-12-05 17:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Nhà hàng','Khách sạn','Vận chuyển') COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
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
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `ten_tour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loai_tour` enum('Trong nước','Quốc tế','Theo yêu cầu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia_diem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thoi_gian` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gia_tour` decimal(12,2) DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `ngay_khoi_hanh` date DEFAULT NULL,
  `phuong_tien` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_nguoi_toi_da` int DEFAULT NULL,
  `status` enum('Hoạt động','Đang tạm dừng','Hủy') COLLATE utf8mb4_unicode_ci DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `ten_tour`, `loai_tour`, `dia_diem`, `thoi_gian`, `gia_tour`, `mo_ta`, `ngay_khoi_hanh`, `phuong_tien`, `so_nguoi_toi_da`, `status`) VALUES
(1, 'Sapa - Chinh phục Fansipan', 'Trong nước', 'Lào Cai', '3 Ngày 2 Đêm', '3500000.00', NULL, '2025-01-10', 'Xe giường nằm', 40, 'Hoạt động'),
(2, 'Đà Nẵng - Hội An - Bà Nà', 'Theo yêu cầu', 'Đà Nẵng', '4 Ngày 3 Đêm', '5990000.00', '', NULL, 'Máy bay', 30, 'Hoạt động');

-- --------------------------------------------------------

--
-- Table structure for table `tours_suppliers`
--

CREATE TABLE `tours_suppliers` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours_suppliers`
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
-- Table structure for table `tour_diaries`
--

CREATE TABLE `tour_diaries` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `ngay_thu` int NOT NULL COMMENT 'Ngày thứ mấy trong tour',
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tiêu đề nhật ký',
  `noi_dung` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nội dung chi tiết',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_diaries`
--

INSERT INTO `tour_diaries` (`id`, `booking_id`, `ngay_thu`, `tieu_de`, `noi_dung`, `created_at`, `updated_at`) VALUES
(2, 14, 1, 'Sáng ngày 1 bắt đầu chuyến đi', '1 số khách đến muộn nhưng ai cũng vui vẻ', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(3, 14, 1, 'ADAđá', 'dsafsadfsdf', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(4, 14, 1, 'ádfasdf', 'ádfasdfsadf', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(5, 14, 2, 'ádfasdf', 'ádfsadfsad', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(6, 14, 3, 'fasdfasdf', 'fasdfasd', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(7, 14, 2, 'fasdfasdf', 'ádfasdfasdf', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(8, 14, 3, 'ádfasdf', 'ádfasdf', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(9, 14, 4, 'ádfasdf', 'ádfasdfasdf', '2025-12-05 18:19:33', '2025-12-05 18:19:33'),
(10, 14, 4, 'sdfasdfasdf', 'sfsf', '2025-12-05 18:43:20', '2025-12-05 18:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `tour_hdv`
--

CREATE TABLE `tour_hdv` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `hdv_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_images`
--

CREATE TABLE `tour_images` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_images`
--

INSERT INTO `tour_images` (`id`, `tour_id`, `image_path`, `mo_ta`) VALUES
(1, 1, 'img/sapa_thumb.jpg', 'Toàn cảnh Sapa'),
(2, 1, 'img/fansipan.jpg', 'Đỉnh Fansipan'),
(3, 2, 'img/cau_rong.jpg', 'Cầu Rồng Đà Nẵng');

-- --------------------------------------------------------

--
-- Table structure for table `tour_restaurants`
--

CREATE TABLE `tour_restaurants` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `bua_an` enum('Sáng','Trưa','Tối') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay` int NOT NULL,
  `ghi_chu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_schedule_activities`
--

CREATE TABLE `tour_schedule_activities` (
  `id` int NOT NULL,
  `day_id` int NOT NULL,
  `thoi_gian_bat_dau` time DEFAULT NULL,
  `thoi_gian_ket_thuc` time DEFAULT NULL,
  `dia_diem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoat_dong` text COLLATE utf8mb4_unicode_ci,
  `hinh_anh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_schedule_activities`
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
-- Table structure for table `tour_schedule_days`
--

CREATE TABLE `tour_schedule_days` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `ngay_thu` int NOT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_schedule_days`
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
-- Table structure for table `tour_suppliers`
--

CREATE TABLE `tour_suppliers` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `service_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_supplier_schedule`
--

CREATE TABLE `tour_supplier_schedule` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `ngay_thu` int NOT NULL,
  `loai_dich_vu` enum('Khách sạn','Nhà hàng','Vận chuyển') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','staff','user','hdv') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$Ex...', 'Nguyễn Quản Trị', 'admin@travel.com', 'admin', '2025-12-05 08:32:54'),
(2, 'staff_tu', '$2y$10$Ex...', 'Trần Thị Tú', 'tu.sale@travel.com', 'staff', '2025-12-05 08:32:54'),
(3, 'user_nam', '$2y$10$Ex...', 'Hoàng Văn Nam', 'nam.khach@gmail.com', 'user', '2025-12-05 08:32:54'),
(4, 'hiepld', '$2y$10$VHAdVkTNnMKIseTrZHh1Keph8omSsoa6tUaVkpHIgWKk8fRnSw0HG', 'Lương Đức Hiệp', 'hiepld@gmail.com', 'admin', '2025-12-05 14:21:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
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
-- Indexes for table `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_schedule_activities`
--
ALTER TABLE `booking_schedule_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`);

--
-- Indexes for table `booking_schedule_days`
--
ALTER TABLE `booking_schedule_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `checkin_details`
--
ALTER TABLE `checkin_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `checkin_sessions`
--
ALTER TABLE `checkin_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_checkin`
--
ALTER TABLE `customer_checkin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_customer_id` (`booking_customer_id`);

--
-- Indexes for table `hdv_lich_lam_viec`
--
ALTER TABLE `hdv_lich_lam_viec`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Indexes for table `hdv_nghi`
--
ALTER TABLE `hdv_nghi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Indexes for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_customer_id` (`booking_customer_id`);

--
-- Indexes for table `huong_dan_viens`
--
ALTER TABLE `huong_dan_viens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours_suppliers`
--
ALTER TABLE `tours_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `tour_diaries`
--
ALTER TABLE `tour_diaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `tour_hdv`
--
ALTER TABLE `tour_hdv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `hdv_id` (`hdv_id`);

--
-- Indexes for table `tour_images`
--
ALTER TABLE `tour_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `tour_restaurants`
--
ALTER TABLE `tour_restaurants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `tour_schedule_activities`
--
ALTER TABLE `tour_schedule_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`);

--
-- Indexes for table `tour_schedule_days`
--
ALTER TABLE `tour_schedule_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `tour_suppliers`
--
ALTER TABLE `tour_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `tour_supplier_schedule`
--
ALTER TABLE `tour_supplier_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `booking_schedule_activities`
--
ALTER TABLE `booking_schedule_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `booking_schedule_days`
--
ALTER TABLE `booking_schedule_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `checkin_details`
--
ALTER TABLE `checkin_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checkin_sessions`
--
ALTER TABLE `checkin_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_checkin`
--
ALTER TABLE `customer_checkin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hdv_lich_lam_viec`
--
ALTER TABLE `hdv_lich_lam_viec`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hdv_nghi`
--
ALTER TABLE `hdv_nghi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `huong_dan_viens`
--
ALTER TABLE `huong_dan_viens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tours_suppliers`
--
ALTER TABLE `tours_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tour_diaries`
--
ALTER TABLE `tour_diaries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tour_hdv`
--
ALTER TABLE `tour_hdv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tour_restaurants`
--
ALTER TABLE `tour_restaurants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_schedule_activities`
--
ALTER TABLE `tour_schedule_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tour_schedule_days`
--
ALTER TABLE `tour_schedule_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tour_suppliers`
--
ALTER TABLE `tour_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_supplier_schedule`
--
ALTER TABLE `tour_supplier_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
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
-- Constraints for table `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD CONSTRAINT `booking_customers_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_schedule_activities`
--
ALTER TABLE `booking_schedule_activities`
  ADD CONSTRAINT `booking_schedule_activities_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `booking_schedule_days` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_schedule_days`
--
ALTER TABLE `booking_schedule_days`
  ADD CONSTRAINT `booking_schedule_days_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checkin_details`
--
ALTER TABLE `checkin_details`
  ADD CONSTRAINT `checkin_details_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `checkin_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkin_details_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checkin_sessions`
--
ALTER TABLE `checkin_sessions`
  ADD CONSTRAINT `checkin_sessions_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_checkin`
--
ALTER TABLE `customer_checkin`
  ADD CONSTRAINT `customer_checkin_ibfk_1` FOREIGN KEY (`booking_customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hdv_lich_lam_viec`
--
ALTER TABLE `hdv_lich_lam_viec`
  ADD CONSTRAINT `hdv_lich_lam_viec_ibfk_1` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_viens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hdv_nghi`
--
ALTER TABLE `hdv_nghi`
  ADD CONSTRAINT `hdv_nghi_ibfk_1` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_viens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD CONSTRAINT `hotel_rooms_ibfk_1` FOREIGN KEY (`booking_customer_id`) REFERENCES `booking_customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tours_suppliers`
--
ALTER TABLE `tours_suppliers`
  ADD CONSTRAINT `tours_suppliers_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tours_suppliers_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_diaries`
--
ALTER TABLE `tour_diaries`
  ADD CONSTRAINT `tour_diaries_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_hdv`
--
ALTER TABLE `tour_hdv`
  ADD CONSTRAINT `tour_hdv_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_hdv_ibfk_2` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_viens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_images`
--
ALTER TABLE `tour_images`
  ADD CONSTRAINT `tour_images_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_restaurants`
--
ALTER TABLE `tour_restaurants`
  ADD CONSTRAINT `tour_restaurants_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_restaurants_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_schedule_activities`
--
ALTER TABLE `tour_schedule_activities`
  ADD CONSTRAINT `tour_schedule_activities_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `tour_schedule_days` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_schedule_days`
--
ALTER TABLE `tour_schedule_days`
  ADD CONSTRAINT `tour_schedule_days_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_suppliers`
--
ALTER TABLE `tour_suppliers`
  ADD CONSTRAINT `tour_suppliers_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_suppliers_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_supplier_schedule`
--
ALTER TABLE `tour_supplier_schedule`
  ADD CONSTRAINT `tour_supplier_schedule_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_supplier_schedule_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
