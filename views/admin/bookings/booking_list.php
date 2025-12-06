<?php include PATH_VIEW . 'layouts/header.php'; ?>

<style>
    /* Bảng hiện đại */
    .table-modern thead th {
        border-bottom: 2px solid #f0f2f5;
        color: #6c757d;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 15px;
        background: #f8f9fa;
        white-space: nowrap; /* Giữ tiêu đề thẳng hàng */
    }
    .table-modern tbody td {
        padding: 15px;
        border-bottom: 1px solid #f0f2f5;
        vertical-align: middle;
    }
    .table-modern tbody tr:hover {
        background-color: #fcfcfc;
    }
    
    /* Badge màu pastel */
    .badge-soft-success { background-color: #d1e7dd; color: #0f5132; }
    .badge-soft-warning { background-color: #fff3cd; color: #664d03; }
    .badge-soft-danger  { background-color: #f8d7da; color: #842029; }
    .badge-soft-info    { background-color: #cff4fc; color: #055160; }
    .badge-soft-secondary { background-color: #e2e3e5; color: #41464b; }
    
    .icon-circle {
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #495057;
        margin-right: 10px;
    }

    /* Style cho nút hành động trực tiếp */
    .btn-action {
        width: 32px; height: 32px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
        border: 1px solid transparent;
        color: #6c757d;
        background: #fff;
    }
    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .btn-action-view:hover { background-color: #e7f1ff; color: #0d6efd; border-color: #cce5ff; }
    .btn-action-edit:hover { background-color: #fff9e6; color: #ffc107; border-color: #ffeeba; }
    .btn-action-delete:hover { background-color: #f8d7da; color: #dc3545; border-color: #f5c6cb; }
</style>

<div class="container-fluid px-4 mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-gray-800 mb-1"><i class="fa-solid fa-ticket-simple text-primary me-2"></i>Quản Lý Booking</h2>
            <p class="text-muted small mb-0">Theo dõi trạng thái tour và quản lý đơn đặt chỗ</p>
        </div>
        <a href="index.php?action=booking_add" class="btn btn-primary fw-bold px-4 shadow-sm rounded-pill">
            <i class="fa-solid fa-plus me-1"></i> Booking Mới
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-2">
            <form method="GET" action="index.php" class="row g-2 align-items-center">
                <input type="hidden" name="action" value="booking_list">
                
                <div class="col-auto ps-3">
                    <span class="fw-bold text-secondary small text-uppercase"><i class="fa-solid fa-filter me-1"></i> Lọc theo:</span>
                </div>
                
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm border-0 bg-light fw-bold text-secondary" style="width: 150px;">
                        <option value="">-- Trạng thái --</option>
                        <option value="Chờ xử lý" <?= (isset($_GET['status']) && $_GET['status']=='Chờ xử lý')?'selected':'' ?>>Chờ xử lý</option>
                        <option value="Đã cọc" <?= (isset($_GET['status']) && $_GET['status']=='Đã cọc')?'selected':'' ?>>Đã cọc</option>
                        <option value="Hoàn tất" <?= (isset($_GET['status']) && $_GET['status']=='Hoàn tất')?'selected':'' ?>>Hoàn tất</option>
                        <option value="Hủy" <?= (isset($_GET['status']) && $_GET['status']=='Hủy')?'selected':'' ?>>Hủy</option>
                    </select>
                </div>
                
                <div class="col-auto">
                    <button class="btn btn-sm btn-dark px-3 rounded-pill">Áp dụng</button>
                    <?php if(isset($_GET['status']) && $_GET['status'] != ''): ?>
                        <a href="index.php?action=booking_list" class="btn btn-sm btn-link text-decoration-none text-muted">Xóa lọc</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="min-height: 400px;"> <div class="table-responsive"> <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="25%">Thông tin Tour & Thời gian</th>
                        <th width="20%">Khách Hàng</th>
                        <th width="15%" class="text-center">Trạng thái Tour</th>
                        <th width="15%" class="text-center">Hành động nhanh</th>
                        <th width="10%">Trạng thái Đơn</th>
                        <th width="10%" class="text-end" style="padding-right: 25px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($bookings)): ?>
                        <?php foreach($bookings as $b): 
                            // 1. Logic Ngày & Trạng thái Tour
                            $today = date('Y-m-d');
                            $startDate = $b['ngay_khoi_hanh'] ?? $b['hien_thi_ngay'];
                            
                            // A. TÍNH TOÁN NGÀY KẾT THÚC
                            $endDate = $startDate; // Mặc định nếu không có thời gian
                            if (!empty($startDate) && !empty($b['thoi_gian'])) {
                                // Lấy số đầu tiên trong chuỗi (VD: "3N2D" -> lấy 3)
                                if (preg_match('/(\d+)/', $b['thoi_gian'], $matches)) {
                                    $days = (int)$matches[1]; 
                                    if ($days > 1) {
                                        // Ngày kết thúc = Ngày đi + (số ngày - 1)
                                        $endDate = date('Y-m-d', strtotime($startDate . ' + ' . ($days - 1) . ' days'));
                                    }
                                }
                            }

                            $allowCheckin = false;
                            $allowDiary = false;
                            $tourStatusBadge = '';

                            if ($b['status'] == 'Hủy') {
                                $tourStatusBadge = '<span class="badge bg-secondary opacity-50 rounded-pill px-3"><i class="fa-solid fa-ban"></i> Đã hủy</span>';
                            } elseif (empty($startDate)) {
                                $tourStatusBadge = '<span class="badge bg-light text-muted border rounded-pill">Chưa có lịch</span>';
                            } else {
                                // B. SO SÁNH NGÀY
                                if ($today < $startDate) {
                                    // CHƯA ĐI
                                    $diff = (strtotime($startDate) - strtotime($today)) / (60 * 60 * 24);
                                    if ($diff <= 3) {
                                        $tourStatusBadge = '<span class="badge badge-soft-warning border border-warning rounded-pill px-3"><i class="fa-regular fa-clock"></i> Còn '.$diff.' ngày</span>';
                                        $allowCheckin = true; 
                                    } else {
                                        $tourStatusBadge = '<span class="badge badge-soft-info border border-info rounded-pill px-3">Sắp tới</span>';
                                    }
                                } elseif ($today >= $startDate && $today <= $endDate) {
                                    // ĐANG ĐI (Trong khoảng từ Start -> End)
                                    $tourStatusBadge = '<span class="badge badge-soft-success border border-success rounded-pill px-3 fw-bold"><i class="fa-solid fa-plane-departure"></i> Đang đi tour</span>';
                                    $allowCheckin = true; // Vẫn cho checkin trong lúc đang đi
                                } else {
                                    // ĐÃ XONG (Lớn hơn ngày kết thúc)
                                    $tourStatusBadge = '<span class="badge badge-soft-secondary border border-secondary rounded-pill px-3"><i class="fa-solid fa-check"></i> Hoàn thành</span>';
                                    $allowDiary = true;
                                }
                            }
                        ?>
                            <tr>
                                <td>
                                    <a href="index.php?action=booking_detail&id=<?= $b['id'] ?>" class="text-dark fw-bold text-decoration-none">#<?= $b['id'] ?></a>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 flex-shrink-0">
                                            <?php if(!empty($b['tour_image'])): ?>
                                                <img src="<?= $b['tour_image'] ?>" class="rounded-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="icon-circle"><i class="fa-solid fa-map-location-dot"></i></div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 200px;" title="<?= $b['ten_tour'] ?>"><?= $b['ten_tour'] ?></div>
                                            <div class="small text-muted mt-1">
                                                <i class="fa-regular fa-calendar-check me-1 text-primary"></i> 
                                                <?= !empty($startDate) ? date('d/m/Y', strtotime($startDate)) : '<span class="fst-italic text-danger">--</span>' ?>
                                                <?php if(!empty($b['thoi_gian'])): ?>
                                                    <span class="text-muted ms-1">| <?= $b['thoi_gian'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="small text-muted"><i class="fa-solid fa-user-tie me-1"></i> <?= $b['hdv_name'] ?: '<span class="text-muted fst-italic">--</span>' ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=<?= $b['customer_name'] ?>&background=random&size=32" class="rounded-circle me-2" width="32" height="32">
                                        <div>
                                            <div class="fw-bold text-dark"><?= $b['customer_name'] ?></div>
                                            <div class="small text-muted"><i class="fa-solid fa-phone fa-xs me-1"></i> <?= $b['customer_phone'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="text-center align-middle"><?= $tourStatusBadge ?></td>

                                <td class="text-center align-middle">
                                    <?php if($allowCheckin): ?>
                                        <a href="index.php?action=checkin_perform&id=<?= $b['id'] ?>" class="btn btn-sm btn-success fw-bold shadow-sm px-3 rounded-pill text-nowrap"><i class="fa-solid fa-list-check me-1"></i> Check-in</a>
                                    <?php elseif($allowDiary): ?>
                                        <a href="index.php?action=diary_add&booking_id=<?= $b['id'] ?>" class="btn btn-sm btn-primary fw-bold shadow-sm px-3 rounded-pill text-nowrap"><i class="fa-solid fa-pen-nib me-1"></i> Nhật ký</a>
                                    <?php else: ?>
                                        <span class="text-muted opacity-25"><i class="fa-solid fa-minus"></i></span>
                                    <?php endif; ?>
                                </td>
                                
                                <td>
                                    <?php 
                                        $bgClass = match($b['status']) { 'Hoàn tất'=>'success', 'Hủy'=>'danger', 'Đã cọc'=>'info', default=>'warning' }; 
                                        $iconClass = match($b['status']) { 'Hoàn tất'=>'fa-check-circle', 'Hủy'=>'fa-times-circle', 'Đã cọc'=>'fa-dollar-sign', default=>'fa-spinner' };
                                    ?>
                                    <span class="badge badge-soft-<?= $bgClass ?> rounded-pill px-2 py-1"><i class="fa-solid <?= $iconClass ?> me-1"></i> <?= $b['status'] ?></span>
                                </td>
                                
                                <td class="text-end text-nowrap">
                                    <a href="index.php?action=booking_detail&id=<?= $b['id'] ?>" class="btn-action btn-action-view" title="Xem chi tiết"><i class="fa-solid fa-eye"></i></a>
                                    <a href="index.php?action=booking_edit&id=<?= $b['id'] ?>" class="btn-action btn-action-edit" title="Chỉnh sửa"><i class="fa-solid fa-pen"></i></a>
                                    <a href="index.php?action=booking_delete&id=<?= $b['id'] ?>" class="btn-action btn-action-delete" onclick="return confirm('CẢNH BÁO: Xóa booking này sẽ mất hết dữ liệu liên quan! Bạn có chắc không?')" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-5"><div class="text-muted opacity-50"><i class="fa-solid fa-clipboard-list fa-3x mb-3"></i><p class="fs-5">Chưa có dữ liệu Booking nào.</p></div></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>