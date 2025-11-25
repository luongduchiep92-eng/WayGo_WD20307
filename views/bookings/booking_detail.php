<?php include PATH_VIEW . 'layouts/header.php'; ?>

<link rel="stylesheet" href="assets/css/booking_detail.css">

<div class="detail-container">

    <h2 class="detail-title">Chi tiết Booking #<?= $booking['id'] ?></h2>

    <!-- Thông tin cơ bản -->
    <div class="detail-card">
        <h3 class="section-title">Thông tin cơ bản</h3>

        <p><strong>Tour:</strong> <?= $booking['ten_tour'] ?></p>
        <a href="index.php?action=tour_detail&id=<?= $booking['tour_id'] ?>" class="btn-link">
            ➜ Xem chi tiết tour
        </a>

        <p class="mt-2"><strong>Hướng dẫn viên:</strong> <?= $booking['hdv_name'] ?></p>
        <a href="index.php?action=hdv_detail&id=<?= $booking['hdv_id'] ?>" class="btn-link">
            ➜ Xem chi tiết hướng dẫn viên
        </a>

        <p class="mt-2">
            <strong>Khách hàng:</strong> <?= $booking['customer_name'] ?> (<?= $booking['customer_phone'] ?>)
        </p>

        <p><strong>Số lượng:</strong> <?= $booking['so_luong'] ?> |
            <strong>Tổng tiền:</strong> <?= number_format($booking['tong_tien']) ?> VND
        </p>

        <p><strong>Trạng thái:</strong> <?= $booking['status'] ?></p>
    </div>

    <!-- Danh sách khách hàng -->
    <div class="detail-card">
        <h3 class="section-title">Danh sách khách hàng</h3>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Năm sinh</th>
                    <th>CCCD</th>
                    <th>Phòng khách sạn</th>
                    <th>Trạng thái nhận phòng</th>
                    <th>Checkin</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($booking['customers'] as $c): ?>
                    <tr>
                        <td><?= $c['ho_ten'] ?></td>
                        <td><?= $c['nam_sinh'] ?></td>
                        <td><?= $c['CCCD'] ?></td>
                        <td><?= $c['room_type'] ?></td>
                        <td><?= $c['trang_thai'] ?></td>
                        <td><?= $c['checkin_status'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Nhà cung cấp -->
    <div class="detail-card">
        <h3 class="section-title">🏨 Nhà cung cấp tour</h3>

        <?php if (!empty($booking['suppliers'])): ?>

            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Loại NCC</th>
                        <th>Tên NCC</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Đánh giá</th>
                        <th>Rank</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($booking['suppliers'] as $sup): ?>
                        <tr>
                            <td><?= $sup['type'] ?></td>
                            <td class="font-medium"><?= $sup['name'] ?></td>
                            <td><?= $sup['phone'] ?? '—' ?></td>
                            <td><?= $sup['email'] ?? '—' ?></td>
                            <td><?= $sup['address'] ?? '—' ?></td>
                            <td><?= $sup['rating'] ?? '—' ?></td>
                            <td><?= $sup['rank'] ?? '—' ?></td>
                            <td><?= $sup['created_at'] ?? '—' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p class="italic text-gray-500">Chưa có nhà cung cấp nào được gán cho tour này.</p>
        <?php endif; ?>
    </div>

    <!-- Lịch trình -->
    <div class="detail-card">
        <h3 class="section-title">🗺️ Lịch trình tour</h3>

        <?php foreach ($booking['schedule'] as $day): ?>
            <div class="detail-card" style="background:#f8fafc;">
                <h4 class="text-xl font-semibold mb-2">
                    📅 Ngày <?= $day['ngay_thu'] ?> – <?= $day['tieu_de'] ?>
                </h4>

                <p class="mb-3 text-gray-700"><?= $day['mo_ta'] ?></p>

                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Thời gian</th>
                            <th>Địa điểm</th>
                            <th>Hoạt động</th>
                            <th>Hình ảnh</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($day['activities'] as $act): ?>
                            <tr>
                                <td><?= $act['thoi_gian_bat_dau'] ?> - <?= $act['thoi_gian_ket_thuc'] ?></td>
                                <td><?= $act['dia_diem'] ?></td>
                                <td><?= $act['hoat_dong'] ?></td>
                                <td>
                                    <?php if (!empty($act['hinh_anh'])): ?>
                                        <img src="<?= $act['hinh_anh'] ?>" class="detail-img">
                                    <?php else: ?> —
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="index.php?action=booking_list" class="btn-back">⟵ Quay lại</a>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>