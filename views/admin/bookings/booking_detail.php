<?php include PATH_VIEW . 'layouts/header.php'; 
    // 1. TÍNH TOÁN CÁC CON SỐ TÀI CHÍNH
    $tongTienTour = $booking['tong_tien'] ?? 0;
    $phatSinh = $booking['chi_phi_phat_sinh'] ?? 0;
    $tongPhaiTra = $tongTienTour + $phatSinh;
    $daThanhToan = $booking['tien_da_coc'] ?? 0;
    $conLai = $tongPhaiTra - $daThanhToan;

    // 2. XỬ LÝ DATE (SỬA LỖI 1970)
    $ngayKhoiHanh = !empty($booking['ngay_khoi_hanh']) ? date('d/m/Y', strtotime($booking['ngay_khoi_hanh'])) : '<span class="text-danger fst-italic">Chưa xác định</span>';
    $ngayTao = !empty($booking['created_at']) ? date('H:i d/m/Y', strtotime($booking['created_at'])) : '';
?>

<style>
    .info-label { font-size: 0.85rem; font-weight: 700; color: #6c757d; text-transform: uppercase; margin-bottom: 3px; }
    .info-value { font-size: 1rem; font-weight: 600; color: #2e384d; }
    .price-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e3e6f0; }
    .price-row:last-child { border-bottom: none; }
    .price-total { font-size: 1.25rem; font-weight: 800; color: #4e73df; border-top: 2px solid #e3e6f0; padding-top: 10px; margin-top: 5px; }
    .status-badge-lg { padding: 8px 20px; border-radius: 50px; font-size: 0.9rem; font-weight: bold; text-transform: uppercase; }
</style>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="d-flex align-items-center gap-3">
                <h2 class="fw-bold text-gray-800 mb-0">Booking #<?= $booking['id'] ?></h2>
                <?php 
                    $statusClass = match($booking['status']) {
                        'Hoàn tất' => 'success',
                        'Hủy' => 'danger',
                        'Đã cọc' => 'info',
                        default => 'warning'
                    };
                ?>
                <span class="badge bg-<?= $statusClass ?> status-badge-lg shadow-sm"><?= $booking['status'] ?></span>
            </div>
            <p class="text-muted mt-2 mb-0">
                <i class="fa-regular fa-clock me-1"></i> Ngày tạo: <?= $ngayTao ?> 
                <span class="mx-2">|</span> 
                <i class="fa-solid fa-user-pen me-1"></i> Tạo bởi: Admin/Staff
            </p>
        </div>
        <div>
            <a href="index.php?action=booking_edit&id=<?= $booking['id'] ?>" class="btn btn-warning fw-bold shadow-sm">
                <i class="fa-solid fa-pen-to-square me-1"></i> Chỉnh sửa
            </a>
            <a href="index.php?action=booking_list" class="btn btn-secondary shadow-sm ms-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            
            <div class="card card-modern mb-4 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom fw-bold text-primary">
                    <i class="fa-solid fa-circle-info me-2"></i> Thông tin Tour & Điều hành
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="p-3 bg-light rounded border border-primary border-opacity-25">
                                <div class="info-label">Tên Tour</div>
                                <div class="info-value text-primary fs-5"><?= $booking['ten_tour'] ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label"><i class="fa-regular fa-calendar me-1"></i> Ngày khởi hành</div>
                            <div class="info-value"><?= $ngayKhoiHanh ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label"><i class="fa-solid fa-user-tie me-1"></i> Hướng dẫn viên</div>
                            <div class="info-value"><?= $booking['hdv_name'] ?: '<span class="text-muted fst-italic">Chưa gán HDV</span>' ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label"><i class="fa-solid fa-bus me-1"></i> Phương tiện</div>
                            <div class="info-value"><?= $booking['phuong_tien'] ?: '---' ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label"><i class="fa-solid fa-users me-1"></i> Số lượng khách</div>
                            <div class="info-value"><?= $booking['so_luong'] ?> người</div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-info-subtle text-info rounded p-2 me-3"><i class="fa-solid fa-hotel fa-lg"></i></div>
                                <div>
                                    <div class="info-label">Khách sạn</div>
                                    <div class="fw-bold"><?= $booking['hotel_name'] ?: 'Chưa chọn' ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-warning-subtle text-warning rounded p-2 me-3"><i class="fa-solid fa-utensils fa-lg"></i></div>
                                <div>
                                    <div class="info-label">Nhà hàng</div>
                                    <div class="fw-bold"><?= $booking['res_name'] ?: 'Chưa chọn' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-modern mb-4 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom fw-bold text-success">
                    <i class="fa-solid fa-users-viewfinder me-2"></i> Danh sách hành khách
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th>Họ và tên</th>
                                <th>Liên hệ</th>
                                <th class="text-center">Thông tin</th>
                                <th class="text-end">Giá vé áp dụng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($booking['customers'])): ?>
                                <?php foreach($booking['customers'] as $c): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $c['ho_ten'] ?></div>
                                        <?php if($c['CCCD']): ?><small class="text-muted">CCCD: <?= $c['CCCD'] ?></small><?php endif; ?>
                                    </td>
                                    <td><?= $c['so_dien_thoai'] ?: '<span class="text-muted small">---</span>' ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border me-1"><?= $c['gioi_tinh'] ?></span>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info"><?= $c['tuoi'] ?> tuổi</span>
                                    </td>
                                    <td class="text-end fw-bold text-success">
                                        <?= number_format($c['gia_tien']) ?> đ
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-3 text-muted">Chưa có thông tin khách hàng.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-modern mb-4 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom fw-bold text-secondary">
                    <i class="fa-solid fa-route me-2"></i> Lịch trình chi tiết
                </div>
                <div class="card-body">
                    <?php if(!empty($booking['schedule'])): ?>
                        <?php foreach($booking['schedule'] as $day): ?>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary me-2">Ngày <?= $day['ngay_thu'] ?></span>
                                    <span class="fw-bold text-dark"><?= $day['tieu_de'] ?></span>
                                </div>
                                <?php if(!empty($day['mo_ta'])): ?>
                                    <p class="text-muted small fst-italic mb-2 ps-2 border-start border-2 ms-1"><?= nl2br($day['mo_ta']) ?></p>
                                <?php endif; ?>

                                <?php if(!empty($day['activities'])): ?>
                                    <ul class="list-group list-group-flush border rounded-3 overflow-hidden">
                                        <?php foreach($day['activities'] as $act): ?>
                                            <li class="list-group-item d-flex align-items-start bg-light py-2">
                                                <div class="me-3 fw-bold text-nowrap text-secondary" style="width: 80px; font-size: 0.9rem;">
                                                    <?= substr($act['thoi_gian_bat_dau'], 0, 5) ?> 
                                                    <i class="fa-solid fa-arrow-right fa-xs text-muted"></i> 
                                                    <?= substr($act['thoi_gian_ket_thuc'], 0, 5) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= $act['hoat_dong'] ?></div>
                                                    <?php if($act['dia_diem']): ?>
                                                        <small class="text-muted"><i class="fa-solid fa-location-dot fa-xs me-1"></i> <?= $act['dia_diem'] ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fa-regular fa-calendar-xmark fa-2x mb-2"></i>
                            <p>Chưa có dữ liệu lịch trình.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            
            <div class="card card-modern shadow mb-4 border-0">
                <div class="card-header bg-success text-white text-center fw-bold py-3">
                    <i class="fa-solid fa-calculator me-2"></i> BẢNG TÍNH TIỀN
                </div>
                <div class="card-body">
                    <div class="price-row">
                        <span class="text-muted">Tổng tiền Tour:</span>
                        <span class="fw-bold"><?= number_format($tongTienTour) ?> đ</span>
                    </div>
                    <?php if($phatSinh > 0): ?>
                    <div class="price-row text-danger">
                        <span><i class="fa-solid fa-circle-exclamation me-1"></i> Phụ thu / Phát sinh:</span>
                        <span class="fw-bold">+<?= number_format($phatSinh) ?> đ</span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="price-row price-total mt-2">
                        <span>TỔNG CỘNG:</span>
                        <span class="text-primary"><?= number_format($tongPhaiTra) ?> đ</span>
                    </div>

                    <div class="price-row text-success mt-2">
                        <span><i class="fa-solid fa-check-circle me-1"></i> Đã thanh toán:</span>
                        <span class="fw-bold">-<?= number_format($daThanhToan) ?> đ</span>
                    </div>

                    <hr>

                    <div class="alert <?= $conLai > 0 ? 'alert-danger' : 'alert-success' ?> text-center fw-bold mb-0 shadow-sm">
                        <div class="small text-uppercase mb-1"><?= $conLai > 0 ? 'CÒN PHẢI THU' : 'ĐÃ THANH TOÁN ĐỦ' ?></div>
                        <div class="fs-4"><?= number_format($conLai) ?> đ</div>
                    </div>
                    
                    <?php if($booking['ly_do_phat_sinh']): ?>
                        <div class="mt-3 p-2 bg-warning bg-opacity-10 border border-warning rounded text-small text-muted fst-italic">
                            <strong>Ghi chú phát sinh:</strong> <?= $booking['ly_do_phat_sinh'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card card-modern shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-bold border-bottom">
                    <i class="fa-solid fa-clock-rotate-left me-2 text-secondary"></i> Lịch sử giao dịch
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if(!empty($booking['payments'])): ?>
                            <?php foreach($booking['payments'] as $p): ?>
                            <li class="list-group-item p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-success fs-5">+<?= number_format($p['so_tien']) ?> đ</span>
                                    <small class="text-muted bg-light px-2 py-1 rounded border"><?= date('d/m/Y H:i', strtotime($p['ngay_thu'])) ?></small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="badge bg-secondary"><?= $p['loai_thanh_toan'] ?></span>
                                    <span class="text-muted fst-italic"><i class="fa-solid fa-user me-1"></i> <?= $p['nguoi_thu_tien'] ?></span>
                                </div>
                                <?php if($p['ghi_chu']): ?>
                                    <div class="mt-2 text-muted small border-top pt-1">
                                        <i class="fa-regular fa-comment-dots me-1"></i> <?= $p['ghi_chu'] ?>
                                    </div>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-center text-muted py-4">Chưa có giao dịch nào.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>