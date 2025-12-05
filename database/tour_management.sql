-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2025 at 08:22 AM
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

INSERT INTO `bookings` (`id`, `tour_id`, `hdv_id`, `customer_name`, `customer_phone`, `phuong_tien`, `so_luong`, `tong_tien`, `status`, `created_at`, `created_by`, `approved_by`, `approved_at`, `hotel_supplier_id`, `restaurant_supplier_id`, `chi_phi_phat_sinh`, `ly_do_phat_sinh`, `tien_da_coc`) VALUES
(3, 1, 2, 'Nguyễn Văn A', '0909111222', NULL, 2, '7000000.00', 'Đã cọc', '2025-12-05 08:14:38', NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '0.00'),
(4, 2, 1, 'Trần Thị B', '0909333444', NULL, 4, '23960000.00', 'Hoàn tất', '2025-12-05 08:14:38', NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '0.00'),
(5, 1, 2, 'Nguyễn Văn A', '0909111222', NULL, 2, '7000000.00', 'Đã cọc', '2025-12-05 08:14:39', NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '0.00'),
(6, 2, 1, 'Trần Thị B', '0909333444', NULL, 4, '23960000.00', 'Hoàn tất', '2025-12-05 08:14:39', NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '0.00');

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
(1, 'Lê Thành Long', 'avatar1.jpg', '1990-05-15', '0909123456', 'long.hdv@travel.com', 'Thẻ Quốc Tế', 'Tiếng Anh, Tiếng Pháp', 7, 'Quốc tế', 'Tốt', 'Nhiệt tình, vui tính'),
(2, 'Phạm Thu Hà', 'avatar2.jpg', '1995-10-20', '0909999888', 'ha.pham@travel.com', 'Thẻ Nội Địa', 'Tiếng Việt', 3, 'Nội địa', 'Tốt', 'Chu đáo, cẩn thận');

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
(1, 'Khách sạn Bamboo Sapa', 'Khách sạn', '02143888888', NULL, '18 Mường Hoa, Sapa', 4, '2025-12-05 08:18:46'),
(2, 'Nhà hàng A Phủ', 'Nhà hàng', '0912345678', NULL, '15 Fansipan, Sapa', 5, '2025-12-05 08:18:46'),
(3, 'Xe Sao Việt', 'Vận chuyển', '19006746', NULL, 'Hà Nội - Sapa', 4, '2025-12-05 08:18:46'),
(4, 'Novotel Danang Premier', 'Khách sạn', '02363929999', NULL, '36 Bạch Đằng, Đà Nẵng', 5, '2025-12-05 08:18:46'),
(5, 'Vietnam Airlines', 'Vận chuyển', '19001100', NULL, 'Sân bay Nội Bài', 5, '2025-12-05 08:18:46');

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
(1, 'Hà Nội - Sapa - Fansipan - Cát Cát', 'Trong nước', 'Lào Cai', '3 Ngày 2 Đêm', '3500000.00', NULL, '2024-01-10', 'Xe giường nằm', 40, 'Hoạt động'),
(2, 'Đà Nẵng - Hội An - Bà Nà - Huế', 'Trong nước', 'Đà Nẵng', '4 Ngày 3 Đêm', '5990000.00', NULL, '2024-01-15', 'Máy bay', 30, 'Hoạt động'),
(3, 'Phú Quốc - Grand World - Địa Trung Hải', 'Trong nước', 'Kiên Giang', '3 Ngày 2 Đêm', '6500000.00', NULL, '2024-01-20', 'Máy bay', 25, 'Hoạt động'),
(4, 'Hà Giang - Đồng Văn - Lũng Cú', 'Trong nước', 'Hà Giang', '3 Ngày 2 Đêm', '2800000.00', NULL, '2024-01-12', 'Ô tô du lịch', 20, 'Đang tạm dừng'),
(5, 'Tour Xuyên Việt: Bắc - Trung - Nam', 'Trong nước', 'Toàn quốc', '10 Ngày 9 Đêm', '15000000.00', NULL, '2024-02-01', 'Máy bay + Ô tô', 15, 'Hoạt động'),
(6, 'Hà Nội - Sapa - Fansipan - Cát Cát', 'Trong nước', 'Lào Cai', '3 Ngày 2 Đêm', '3500000.00', NULL, '2024-01-10', 'Xe giường nằm', 40, 'Hoạt động'),
(7, 'Đà Nẵng - Hội An - Bà Nà - Huế', 'Trong nước', 'Đà Nẵng', '4 Ngày 3 Đêm', '5990000.00', NULL, '2024-01-15', 'Máy bay', 30, 'Hoạt động'),
(8, 'Phú Quốc - Grand World - Địa Trung Hải', 'Trong nước', 'Kiên Giang', '3 Ngày 2 Đêm', '6500000.00', NULL, '2024-01-20', 'Máy bay', 25, 'Hoạt động'),
(9, 'Hà Giang - Đồng Văn - Lũng Cú', 'Trong nước', 'Hà Giang', '3 Ngày 2 Đêm', '2800000.00', NULL, '2024-01-12', 'Ô tô du lịch', 20, 'Đang tạm dừng'),
(10, 'Tour Xuyên Việt: Bắc - Trung - Nam', 'Trong nước', 'Toàn quốc', '10 Ngày 9 Đêm', '15000000.00', NULL, '2024-02-01', 'Máy bay + Ô tô', 15, 'Hoạt động');

-- --------------------------------------------------------

--
-- Table structure for table `tours_suppliers`
--

CREATE TABLE `tours_suppliers` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_diaries`
--

CREATE TABLE `tour_diaries` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `supplier_feedback` text COLLATE utf8mb4_unicode_ci,
  `incidents` text COLLATE utf8mb4_unicode_ci,
  `resolution` text COLLATE utf8mb4_unicode_ci,
  `customer_feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, '06:00:00', '12:00:00', 'Cao tốc Nội Bài', 'Di chuyển bằng xe giường nằm Sao Việt', NULL),
(2, 1, '14:00:00', '17:00:00', 'Núi Hàm Rồng', 'Tham quan vườn lan, cổng trời', NULL),
(3, 2, '08:00:00', '12:00:00', 'Ga cáp treo', 'Đi cáp treo lên đỉnh Fansipan', NULL),
(4, 2, '14:00:00', '17:00:00', 'Bản Cát Cát', 'Tìm hiểu văn hóa người H\'Mông', NULL),
(5, 3, '09:00:00', '11:00:00', 'Chợ Sapa', 'Mua sắm đặc sản làm quà', NULL),
(6, 4, '09:00:00', '11:00:00', 'Chùa Linh Ứng', 'Viếng Phật Bà Quan Âm', NULL),
(7, 5, '08:00:00', '16:00:00', 'Bà Nà Hills', 'Tham quan Cầu Vàng, Làng Pháp', NULL),
(8, 6, '15:00:00', '21:00:00', 'Hội An', 'Ăn cao lầu và đi thuyền sông Hoài', NULL),
(9, 1, '06:00:00', '12:00:00', 'Cao tốc Nội Bài', 'Di chuyển bằng xe giường nằm Sao Việt', NULL),
(10, 1, '14:00:00', '17:00:00', 'Núi Hàm Rồng', 'Tham quan vườn lan, cổng trời', NULL),
(11, 2, '08:00:00', '12:00:00', 'Ga cáp treo', 'Đi cáp treo lên đỉnh Fansipan', NULL),
(12, 2, '14:00:00', '17:00:00', 'Bản Cát Cát', 'Tìm hiểu văn hóa người H\'Mông', NULL),
(13, 3, '09:00:00', '11:00:00', 'Chợ Sapa', 'Mua sắm đặc sản làm quà', NULL),
(14, 4, '09:00:00', '11:00:00', 'Chùa Linh Ứng', 'Viếng Phật Bà Quan Âm', NULL),
(15, 5, '08:00:00', '16:00:00', 'Bà Nà Hills', 'Tham quan Cầu Vàng, Làng Pháp', NULL),
(16, 6, '15:00:00', '21:00:00', 'Hội An', 'Ăn cao lầu và đi thuyền sông Hoài', NULL);

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
(1, 1, 1, 'Ngày 1: Hà Nội - Sapa - Hàm Rồng', 'Di chuyển lên Sapa, chiều leo núi Hàm Rồng'),
(2, 1, 2, 'Ngày 2: Fansipan - Bản Cát Cát', 'Chinh phục nóc nhà Đông Dương'),
(3, 1, 3, 'Ngày 3: Sapa - Hà Nội', 'Tự do mua sắm và trở về'),
(4, 2, 1, 'Ngày 1: Đón sân bay - Sơn Trà', 'Xe đưa về khách sạn Novotel'),
(5, 2, 2, 'Ngày 2: Bà Nà Hills', 'Vui chơi tại đường lên tiên cảnh'),
(6, 2, 3, 'Ngày 3: Phố Cổ Hội An', 'Tham quan chùa Cầu, thả đèn hoa đăng'),
(7, 2, 4, 'Ngày 4: Mua sắm - Tiễn sân bay', 'Ghé chợ Hàn và ra sân bay'),
(8, 1, 1, 'Ngày 1: Hà Nội - Sapa - Hàm Rồng', 'Di chuyển lên Sapa, chiều leo núi Hàm Rồng'),
(9, 1, 2, 'Ngày 2: Fansipan - Bản Cát Cát', 'Chinh phục nóc nhà Đông Dương'),
(10, 1, 3, 'Ngày 3: Sapa - Hà Nội', 'Tự do mua sắm và trở về'),
(11, 2, 1, 'Ngày 1: Đón sân bay - Sơn Trà', 'Xe đưa về khách sạn Novotel'),
(12, 2, 2, 'Ngày 2: Bà Nà Hills', 'Vui chơi tại đường lên tiên cảnh'),
(13, 2, 3, 'Ngày 3: Phố Cổ Hội An', 'Tham quan chùa Cầu, thả đèn hoa đăng'),
(14, 2, 4, 'Ngày 4: Mua sắm - Tiễn sân bay', 'Ghé chợ Hàn và ra sân bay');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booking_schedule_activities`
--
ALTER TABLE `booking_schedule_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_schedule_days`
--
ALTER TABLE `booking_schedule_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_checkin`
--
ALTER TABLE `customer_checkin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hdv_lich_lam_viec`
--
ALTER TABLE `hdv_lich_lam_viec`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hdv_nghi`
--
ALTER TABLE `hdv_nghi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `huong_dan_viens`
--
ALTER TABLE `huong_dan_viens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tours_suppliers`
--
ALTER TABLE `tours_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tour_diaries`
--
ALTER TABLE `tour_diaries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tour_hdv`
--
ALTER TABLE `tour_hdv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_restaurants`
--
ALTER TABLE `tour_restaurants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tour_schedule_activities`
--
ALTER TABLE `tour_schedule_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tour_schedule_days`
--
ALTER TABLE `tour_schedule_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tour_suppliers`
--
ALTER TABLE `tour_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tour_supplier_schedule`
--
ALTER TABLE `tour_supplier_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
