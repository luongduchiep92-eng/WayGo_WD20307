-- CREATE DATABASE tour_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tour_management;

CREATE TABLE tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_tour VARCHAR(255) NOT NULL,
    loai_tour ENUM('Trong nước','Quốc tế','Theo yêu cầu') NOT NULL,
    dia_diem VARCHAR(255) NOT NULL,
    thoi_gian VARCHAR(100),
    gia_tour DECIMAL(12,2),
    mo_ta TEXT,
    ngay_khoi_hanh DATE,
    phuong_tien VARCHAR(100),
    so_nguoi_toi_da INT
);

CREATE TABLE huong_dan_viens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    ngay_sinh DATE,
    so_dien_thoai VARCHAR(20),
    email VARCHAR(100),
    chung_chi VARCHAR(255),
    ngon_ngu VARCHAR(100),
    kinh_nghiem_nam INT,
    loai_hdv ENUM('Nội địa','Quốc tế'),
    suc_khoe VARCHAR(50),
    danh_gia VARCHAR(255)
);

CREATE TABLE tour_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    mo_ta VARCHAR(255),
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
);

CREATE TABLE tour_hdv (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT,
    hdv_id INT,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
    FOREIGN KEY (hdv_id) REFERENCES huong_dan_viens(id) ON DELETE CASCADE
);

INSERT INTO tours (ten_tour, loai_tour, dia_diem, thoi_gian, gia_tour, mo_ta, ngay_khoi_hanh, phuong_tien, so_nguoi_toi_da) VALUES
('Tour Đà Lạt mộng mơ', 'Trong nước', 'Đà Lạt', '3N2Đ', 3500000, 'Tham quan Thung Lũng Tình Yêu, Langbiang, chợ đêm.', '2025-12-10', 'Xe du lịch', 30),
('Tour Phú Quốc nghỉ dưỡng', 'Trong nước', 'Phú Quốc', '4N3Đ', 5200000, 'Tham quan Vinpearl, Bãi Sao, Dinh Cậu.', '2025-12-15', 'Máy bay', 25),
('Tour Hà Nội – Ninh Bình', 'Trong nước', 'Hà Nội, Ninh Bình', '2N1Đ', 1800000, 'Khám phá Tràng An, chùa Bái Đính.', '2025-11-25', 'Xe du lịch', 40),
('Tour Singapore – Malaysia', 'Quốc tế', 'Singapore, Malaysia', '5N4Đ', 11500000, 'Khám phá Marina Bay, tháp đôi Petronas.', '2026-01-05', 'Máy bay', 20),
('Tour Thái Lan – Bangkok – Pattaya', 'Quốc tế', 'Bangkok, Pattaya', '5N4Đ', 8900000, 'Tham quan Hoàng cung, Safari World.', '2026-02-01', 'Máy bay', 25),
('Tour Nhật Bản ngắm hoa anh đào', 'Quốc tế', 'Tokyo, Osaka', '6N5Đ', 32000000, 'Trải nghiệm văn hóa Nhật, ngắm hoa anh đào.', '2026-03-20', 'Máy bay', 15),
('Tour miền Tây sông nước', 'Trong nước', 'Cần Thơ, Mỹ Tho', '2N1Đ', 1500000, 'Trải nghiệm chợ nổi Cái Răng, vườn trái cây.', '2025-11-20', 'Xe du lịch', 35),
('Tour Đà Nẵng – Hội An', 'Trong nước', 'Đà Nẵng, Hội An', '3N2Đ', 2800000, 'Tham quan Cầu Rồng, phố cổ Hội An.', '2025-12-05', 'Xe du lịch', 30),
('Tour Châu Âu 5 nước', 'Quốc tế', 'Pháp, Đức, Ý, Thụy Sĩ, Hà Lan', '10N9Đ', 65000000, 'Du lịch các thành phố nổi tiếng châu Âu.', '2026-04-01', 'Máy bay', 15),
('Tour theo yêu cầu công ty ABC', 'Theo yêu cầu', 'Đà Nẵng – Huế – Quảng Bình', '4N3Đ', 7200000, 'Tour thiết kế riêng cho đoàn công ty.', '2025-12-20', 'Xe du lịch', 40);

INSERT INTO huong_dan_viens (ho_ten, avatar, ngay_sinh, so_dien_thoai, email, chung_chi, ngon_ngu, kinh_nghiem_nam, loai_hdv, suc_khoe, danh_gia) VALUES
('Nguyễn Văn An', 'uploads/hdv/an.jpg', '1990-05-12', '0905123456', 'an@tour.vn', 'Chứng chỉ HDV quốc gia', 'Tiếng Việt', 8, 'Nội địa', 'Tốt', 'Rất tốt'),
('Lê Thị Bình', 'uploads/hdv/binh.jpg', '1988-09-23', '0933123456', 'binh@tour.vn', 'Chứng chỉ HDV quốc tế', 'Anh, Thái', 10, 'Quốc tế', 'Tốt', 'Xuất sắc'),
('Trần Quốc Cường', 'uploads/hdv/cuong.jpg', '1992-07-11', '0978123456', 'cuong@tour.vn', 'Chứng chỉ HDV du lịch', 'Tiếng Việt', 5, 'Nội địa', 'Tốt', 'Khá'),
('Phạm Thị Dung', 'uploads/hdv/dung.jpg', '1995-03-09', '0902123456', 'dung@tour.vn', 'HDV quốc tế', 'Anh, Nhật', 6, 'Quốc tế', 'Tốt', 'Tốt'),
('Vũ Đức Hùng', 'uploads/hdv/hung.jpg', '1987-01-05', '0981123456', 'hung@tour.vn', 'HDV quốc gia', 'Việt, Anh', 12, 'Quốc tế', 'Tốt', 'Xuất sắc'),
('Nguyễn Mai Lan', 'uploads/hdv/lan.jpg', '1996-12-21', '0909876543', 'lan@tour.vn', 'HDV nội địa', 'Việt', 4, 'Nội địa', 'Tốt', 'Tốt'),
('Hoàng Văn Minh', 'uploads/hdv/minh.jpg', '1991-06-10', '0933123123', 'minh@tour.vn', 'HDV du lịch', 'Anh, Trung', 9, 'Quốc tế', 'Tốt', 'Xuất sắc'),
('Phan Thị Ngọc', 'uploads/hdv/ngoc.jpg', '1993-02-17', '0912333444', 'ngoc@tour.vn', 'HDV nội địa', 'Việt', 7, 'Nội địa', 'Tốt', 'Rất tốt'),
('Đỗ Văn Quân', 'uploads/hdv/quan.jpg', '1994-08-05', '0903344556', 'quan@tour.vn', 'HDV quốc tế', 'Anh, Hàn', 6, 'Quốc tế', 'Tốt', 'Tốt'),
('Bùi Thị Trang', 'uploads/hdv/trang.jpg', '1998-04-30', '0977888999', 'trang@tour.vn', 'HDV nội địa', 'Việt', 3, 'Nội địa', 'Tốt', 'Khá');

INSERT INTO tour_images (tour_id, image_path, mo_ta) VALUES
(1, 'uploads/tours/dalat1.jpg', 'Thung lũng Tình Yêu'),
(1, 'uploads/tours/dalat2.jpg', 'Đồi chè Cầu Đất'),
(1, 'uploads/tours/dalat3.jpg', 'Chợ đêm Đà Lạt'),
(2, 'uploads/tours/phuquoc1.jpg', 'Bãi Sao Phú Quốc'),
(2, 'uploads/tours/phuquoc2.jpg', 'Vinpearl Safari'),
(3, 'uploads/tours/ninhbinh1.jpg', 'Tràng An Ninh Bình'),
(3, 'uploads/tours/ninhbinh2.jpg', 'Chùa Bái Đính'),
(4, 'uploads/tours/singapore1.jpg', 'Marina Bay Sands'),
(5, 'uploads/tours/thailan1.jpg', 'Hoàng cung Bangkok'),
(6, 'uploads/tours/nhatban1.jpg', 'Hoa anh đào Tokyo'),
(7, 'uploads/tours/mientay1.jpg', 'Chợ nổi Cái Răng'),
(8, 'uploads/tours/hoian1.jpg', 'Phố cổ Hội An về đêm'),
(9, 'uploads/tours/chauau1.jpg', 'Tháp Eiffel - Paris'),
(10, 'uploads/tours/congtyabc1.jpg', 'Đoàn công ty tại Huế');

INSERT INTO tour_hdv (tour_id, hdv_id) VALUES
(1, 1),
(2, 8),
(3, 3),
(4, 2),
(5, 5),
(6, 7),
(7, 6),
(8, 8),
(9, 4),
(10, 9);

CREATE TABLE tour_schedule_days (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    ngay_thu INT NOT NULL,
    tieu_de VARCHAR(255),
    mo_ta TEXT,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
);

CREATE TABLE tour_schedule_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day_id INT NOT NULL,
    thoi_gian_bat_dau TIME,
    thoi_gian_ket_thuc TIME,
    dia_diem VARCHAR(255),
    hoat_dong TEXT,
    hinh_anh VARCHAR(255),
    FOREIGN KEY (day_id) REFERENCES tour_schedule_days(id) ON DELETE CASCADE
);


-- - Ngày 1: Khám phá trung tâm Đà Lạt
INSERT INTO tour_schedule_days (tour_id, ngay_thu, tieu_de, mo_ta)
VALUES (1, 1, 'Khám phá trung tâm Đà Lạt', 'Tham quan các điểm nổi tiếng và thưởng thức ẩm thực Đà Lạt.');

INSERT INTO tour_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong, hinh_anh) VALUES
(1, '08:00:00', '10:00:00', 'Thung lũng Tình Yêu', 'Tham quan và chụp ảnh tại Thung lũng Tình Yêu', 'uploads/tours/dalat1.jpg'),
(1, '10:30:00', '12:00:00', 'Nhà hàng Cơm Niêu Đà Lạt', 'Dùng bữa trưa tại nhà hàng địa phương', NULL),
(1, '13:30:00', '15:00:00', 'Quán Cafe Mê Linh', 'Thưởng thức cà phê và ngắm cảnh hồ Tuyền Lâm', NULL),
(1, '16:00:00', '18:00:00', 'Chợ đêm Đà Lạt', 'Dạo chợ đêm và mua sắm đặc sản địa phương', 'uploads/tours/dalat3.jpg');

--  Ngày 2: Langbiang – Vườn hoa Đà Lạt
INSERT INTO tour_schedule_days (tour_id, ngay_thu, tieu_de, mo_ta)
VALUES (1, 2, 'Khám phá vùng ven Đà Lạt', 'Tham quan Langbiang, vườn hoa Đà Lạt và hồ Xuân Hương.');

INSERT INTO tour_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong, hinh_anh) VALUES
(2, '08:00:00', '10:30:00', 'Núi Langbiang', 'Leo núi và ngắm toàn cảnh Đà Lạt', NULL),
(2, '11:00:00', '12:30:00', 'Nhà hàng Hoa Đà Lạt', 'Dùng bữa trưa tại nhà hàng địa phương', NULL),
(2, '13:30:00', '16:00:00', 'Vườn hoa Thành phố', 'Tham quan và chụp ảnh tại vườn hoa nổi tiếng', NULL),
(2, '18:30:00', '20:00:00', 'Nhà hàng Memory', 'Thưởng thức bữa tối và nghe nhạc acoustic', NULL);

--  Ngày 3: Tự do tham quan và mua sắm
INSERT INTO tour_schedule_days (tour_id, ngay_thu, tieu_de, mo_ta)
VALUES (1, 3, 'Tự do tham quan và mua sắm', 'Mua quà lưu niệm, nghỉ ngơi trước khi về.');

INSERT INTO tour_schedule_activities (day_id, thoi_gian_bat_dau, thoi_gian_ket_thuc, dia_diem, hoat_dong, hinh_anh) VALUES
(3, '08:00:00', '11:00:00', 'Chợ Đà Lạt', 'Tự do mua sắm đặc sản và quà lưu niệm', NULL),
(3, '11:30:00', '13:00:00', 'Nhà hàng Hương Rừng', 'Dùng bữa trưa trước khi về', NULL),
(3, '13:30:00', '15:00:00', 'Khách sạn', 'Thu dọn hành lý và trả phòng', NULL);

-- quản lý nhà cung cấp
CREATE TABLE suppliers ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -- dán thêm vào sql trong bảng suppliers
    ALTER TABLE suppliers
    ADD COLUMN rating INT DEFAULT 0;
);
INSERT INTO suppliers (name, phone, email, address)
VALUES
('Công ty Du Lịch Việt', '0909123456', 'contact@dulichviet.com', '123 Nguyễn Trãi, Quận 1, TP.HCM'),
('Saigon Tourist', '0911222333', 'info@saigontourist.vn', '45 Lê Lợi, Quận 1, TP.HCM'),
('Vietnam Travel Group', '0988777666', 'support@vietnamtravel.com', '98 Trần Hưng Đạo, Hoàn Kiếm, Hà Nội'),
('Hà Nội Tourist', '0933445566', 'sales@hanoitourist.vn', '12 Đinh Tiên Hoàng, Hoàn Kiếm, Hà Nội'),
('Asia Tour Service', '0977112233', 'booking@asiatour.com', '56 Võ Văn Tần, Quận 3, TP.HCM'),
('Fiditour Travel', '0908112233', 'info@fiditour.com', '129 Nguyễn Huệ, Quận 1, TP.HCM'),
('Bến Thành Tourist', '0933778899', 'contact@benthanhtourist.vn', '86 Nguyễn Trãi, Quận 1, TP.HCM'),
('An Travel Agency', '0912555666', 'service@antravel.vn', '22 Lý Thường Kiệt, Hà Nội'),
('Hoàng Gia Travel', '0981667788', 'hoanggia@travel.vn', '55 Phan Đình Phùng, Đà Nẵng'),
('Sunshine Holiday', '0976223344', 'booking@sunshineholiday.vn', '33 Nguyễn Văn Linh, Đà Nẵng');

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    customer_name VARCHAR(255),
    customer_phone VARCHAR(20),
    so_luong INT,
    tong_tien DECIMAL(12,2),
    status ENUM('Chờ xử lý','Đã cọc','Hoàn tất','Hủy') DEFAULT 'Chờ xử lý',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
);

-- 9. KHÁCH THAM GIA (BỔ SUNG)
CREATE TABLE booking_customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    ho_ten VARCHAR(255),
    nam_sinh INT,
    CCCD VARCHAR(100),
    ghi_chu TEXT,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

-- 10. PHÂN PHÒNG KHÁCH SẠN (BỔ SUNG)
CREATE TABLE hotel_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_customer_id INT NOT NULL,
    room_type ENUM('Đơn','Đôi','Gia đình'),
    note TEXT,
    FOREIGN KEY (booking_customer_id) REFERENCES booking_customers(id) ON DELETE CASCADE
);

-- 11. CHECK-IN KHÁCH (BỔ SUNG)
CREATE TABLE customer_checkin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_customer_id INT NOT NULL,
    status ENUM('Có mặt','Vắng mặt') DEFAULT 'Có mặt',
    checkin_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_customer_id) REFERENCES booking_customers(id) ON DELETE CASCADE
);
-- dán thêm vào sql trong bảng suppliers
UPDATE suppliers SET rating = 5 WHERE id = 4;
UPDATE suppliers SET rating = 4 WHERE id = 5;
UPDATE suppliers SET rating = 5 WHERE id = 6;
UPDATE suppliers SET rating = 4 WHERE id = 7;
UPDATE suppliers SET rating = 5 WHERE id = 8;
UPDATE suppliers SET rating = 4 WHERE id = 9;
-- bảng tour_supplier (các tour thuộc quyền quản lý của supplier nào)
CREATE TABLE tours_supperliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    duration VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    price DECIMAL(10,2) NULL,
    supplier_id INT NULL,
    CONSTRAINT fk_supplier
        FOREIGN KEY (supplier_id)
        REFERENCES suppliers(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
chưa có dữ liệu
