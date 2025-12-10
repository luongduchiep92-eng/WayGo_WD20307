<?php include PATH_VIEW . 'layouts/header_hdv.php'; ?>

<div class="container mt-3">
    <div class="row g-2 mb-4">
        <div class="col-6">
            <div class="p-3 bg-primary text-white rounded-3 shadow-sm h-100 text-center">
                <i class="fa-regular fa-calendar-check fa-2x mb-2 opacity-50"></i>
                <h3 class="fw-bold mb-0"><?= $stats['upcoming'] ?? 0 ?></h3>
                <small>Tour sắp tới</small>
            </div>
        </div>
        <div class="col-6">
            <div class="p-3 bg-success text-white rounded-3 shadow-sm h-100 text-center">
                <i class="fa-solid fa-flag fa-2x mb-2 opacity-50"></i>
                <h3 class="fw-bold mb-0"><?= $stats['total_tours'] ?? 0 ?></h3>
                <small>Tổng dẫn tour</small>
            </div>
        </div>
    </div>

    <h6 class="fw-bold text-secondary text-uppercase mb-3 ps-1"><i class="fa-solid fa-bolt text-warning"></i> Sắp khởi hành</h6>

    <?php if (empty($tours)): ?>
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-umbrella-beach fa-3x mb-3 text-secondary opacity-25"></i>
            <p>Hiện chưa có lịch tour nào.</p>
        </div>
    <?php else: ?>
        <?php foreach ($tours as $t): 
            $isToday = (date('Y-m-d') == $t['ngay_khoi_hanh']);
        ?>
        <div class="tour-card p-3 position-relative <?= $isToday ? 'border border-2 border-warning' : '' ?>">
            <?php if($isToday): ?>
                <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2">Hôm nay</span>
            <?php endif; ?>
            
            <div class="d-flex align-items-center mb-2">
                <div class="bg-light rounded p-2 me-3 text-center" style="min-width: 60px;">
                    <span class="d-block fw-bold text-danger"><?= date('d', strtotime($t['ngay_khoi_hanh'])) ?></span>
                    <span class="d-block small text-muted text-uppercase"><?= date('M', strtotime($t['ngay_khoi_hanh'])) ?></span>
                </div>
                <div>
                    <h6 class="fw-bold text-primary mb-1 text-truncate" style="max-width: 200px;"><?= $t['ten_tour'] ?></h6>
                    <small class="text-muted"><i class="fa-solid fa-clock"></i> <?= $t['thoi_gian'] ?> • <i class="fa-solid fa-users"></i> <?= $t['so_luong'] ?> khách</small>
                </div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-6">
                    <a href="index.php?action=hdv_tour_detail&tour_id=<?= $t['tour_id'] ?>" class="btn btn-outline-primary btn-sm w-100 fw-bold">
                        <i class="fa-solid fa-map-location-dot"></i> Lịch trình
                    </a>
                </div>
                <div class="col-6">
                    <a href="index.php?action=checkin_perform&id=<?= $t['booking_id'] ?>" class="btn btn-warning btn-sm w-100 fw-bold">
                        <i class="fa-solid fa-clipboard-user"></i> Check-in
                    </a>
                </div>
                <?php if (strtotime($t['ngay_khoi_hanh']) <= time() && $t['status'] !== 'Hủy'): ?>
                <div class="col-12">
                    <a href="index.php?action=diary_add" class="btn btn-success btn-sm w-100">
                        <i class="fa-solid fa-pen-nib"></i> Viết Nhật Ký
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>