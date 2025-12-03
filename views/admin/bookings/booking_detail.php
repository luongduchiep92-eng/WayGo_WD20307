<?php include PATH_VIEW . 'layouts/header.php'; 
    // Tính toán lại biến cho view
    $tongPhaiTra = $booking['tong_tien'] + $booking['chi_phi_phat_sinh'];
    $daThanhToan = $booking['tien_da_coc'];
    $conLai = $tongPhaiTra - $daThanhToan;
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-primary">Booking #<?= $booking['id'] ?>: <?= $booking['ten_tour'] ?></h3>
            <span class="text-muted"><i class="fa-regular fa-clock"></i> Khởi hành: <strong><?= date('d/m/Y', strtotime($booking['ngay_khoi_hanh'])) ?></strong></span>
        </div>
        <div>
            <span class="badge rounded-pill bg-<?= $booking['status']=='Hoàn tất'?'success':($booking['status']=='Hủy'?'danger':'warning') ?> fs-6 px-3 py-2">
                <?= $booking['status'] ?>
            </span>
            <a href="index.php?action=booking_edit&id=<?= $booking['id'] ?>" class="btn btn-outline-primary ms-2"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
            <a href="index.php?action=booking_list" class="btn btn-secondary ms-1">Quay lại</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold text-info"><i class="fa-solid fa-circle-info"></i> Thông tin điều hành</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class="fa-solid fa-user-tie"></i> HDV:</strong> <?= $booking['hdv_name'] ?></p>
                            <p class="mb-2"><strong><i class="fa-solid fa-plane"></i> Phương tiện:</strong> <?= $booking['phuong_tien'] ?: 'Chưa cập nhật' ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class="fa-solid fa-hotel"></i> Khách sạn:</strong> <?= $booking['hotel_name'] ?></p>
                            <p class="mb-2"><strong><i class="fa-solid fa-utensils"></i> Nhà hàng:</strong> <?= $booking['res_name'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold text-info"><i class="fa-solid fa-users"></i> Danh sách hành khách</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr><th>Họ tên</th><th>SĐT</th><th>Tuổi</th><th>Giới tính</th><th class="text-end">Giá vé</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($booking['customers'] as $c): ?>
                            <tr>
                                <td class="fw-bold"><?= $c['ho_ten'] ?></td>
                                <td><?= $c['so_dien_thoai'] ?></td>
                                <td><?= $c['tuoi'] ?></td>
                                <td><?= $c['gioi_tinh'] ?></td>
                                <td class="text-end"><?= number_format($c['gia_tien']) ?> đ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
             <div class="card shadow-sm">
    <div class="card-header bg-white fw-bold text-info"><i class="fa-solid fa-map-location-dot"></i> Lịch trình chi tiết</div>
    <div class="card-body">
        <?php if(!empty($booking['schedule'])): ?>
            <?php foreach($booking['schedule'] as $day): ?>
                <div class="mb-3">
                    <div class="fw-bold text-primary border-bottom pb-1 mb-2">
                        Ngày <?= $day['ngay_thu'] ?>: <?= $day['tieu_de'] ?>
                    </div>
                    <?php if(!empty($day['mo_ta'])): ?>
                        <p class="small text-muted fst-italic mb-2"><?= nl2br($day['mo_ta']) ?></p>
                    <?php endif; ?>

                    <?php if(!empty($day['activities'])): ?>
                        <table class="table table-sm table-bordered table-striped mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 120px;">Thời gian</th>
                                    <th>Hoạt động</th>
                                    <th>Địa điểm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($day['activities'] as $act): ?>
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">
                                            <?= substr($act['thoi_gian_bat_dau'], 0, 5) ?> - <?= substr($act['thoi_gian_ket_thuc'], 0, 5) ?>
                                        </td>
                                        <td><?= $act['hoat_dong'] ?></td>
                                        <td><?= $act['dia_diem'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-muted small ps-3">Không có hoạt động chi tiết.</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center py-3">Chưa có dữ liệu lịch trình cho booking này.</p>
        <?php endif; ?>
    </div>
</div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-success text-white text-center fw-bold">BẢNG TÍNH TIỀN</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2"><span>Giá tour gốc:</span><strong><?= number_format($booking['tong_tien']) ?> đ</strong></div>
                    <?php if($booking['chi_phi_phat_sinh'] > 0): ?>
                    <div class="d-flex justify-content-between mb-2 text-danger"><span>Phát sinh:</span><strong>+<?= number_format($booking['chi_phi_phat_sinh']) ?> đ</strong></div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mb-3 fs-5 border-top pt-2"><span>TỔNG CỘNG:</span><strong class="text-primary"><?= number_format($tongPhaiTra) ?> đ</strong></div>
                    <div class="d-flex justify-content-between mb-2 text-success"><span>Đã thanh toán:</span><strong>-<?= number_format($daThanhToan) ?> đ</strong></div>
                    <div class="alert alert-<?= $conLai <= 0 ? 'success' : 'danger' ?> text-center fw-bold mt-3 mb-0">CÒN LẠI: <?= number_format($conLai) ?> đ</div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử giao dịch</div>
                <ul class="list-group list-group-flush">
                    <?php if(!empty($booking['payments'])): ?>
                        <?php foreach($booking['payments'] as $p): ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">+<?= number_format($p['so_tien']) ?> đ</span>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($p['ngay_thu'])) ?></small>
                            </div>
                            <div class="small mt-1">
                                <span class="badge bg-light text-dark border"><?= $p['loai_thanh_toan'] ?></span>
                                <span class="text-muted ms-1">- Thu bởi: <?= $p['nguoi_thu_tien'] ?></span>
                            </div>
                            <?php if($p['ghi_chu']): ?>
                                <small class="d-block text-muted fst-italic mt-1">"<?= $p['ghi_chu'] ?>"</small>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center text-muted">Chưa có giao dịch nào.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>