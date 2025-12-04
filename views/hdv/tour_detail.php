<?php include PATH_VIEW . 'layouts/header_hdv.php'; ?>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <a href="index.php?action=dashboard" class="btn btn-light shadow-sm rounded-circle" style="width: 40px; height: 40px;"><i class="fa-solid fa-arrow-left"></i></a>
        <div class="text-end">
            <span class="badge bg-primary"><?= $tour['loai_tour'] ?></span>
            <span class="badge bg-secondary"><?= $tour['thoi_gian'] ?></span>
        </div>
    </div>

    <h4 class="fw-bold text-dark mb-1"><?= $tour['ten_tour'] ?></h4>
    <p class="text-muted small"><i class="fa-solid fa-location-dot text-danger"></i> <?= $tour['dia_diem'] ?></p>

    <div class="mt-4">
        <h6 class="text-uppercase fw-bold text-secondary mb-3 ps-1">Chi tiết lịch trình</h6>
        
        <?php if(!empty($tour['schedule'])): ?>
            <?php foreach($tour['schedule'] as $day): ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white fw-bold text-primary border-bottom-0 pt-3">
                        <i class="fa-regular fa-calendar-check me-1"></i> Ngày <?= $day['ngay_thu'] ?>: <?= $day['tieu_de'] ?>
                    </div>
                    <div class="card-body pt-0">
                        <p class="small text-muted fst-italic mb-3 ps-4 border-start border-2 ms-1"><?= nl2br($day['mo_ta']) ?></p>
                        
                        <?php if(!empty($day['activities'])): ?>
                            <div class="vstack gap-2">
                                <?php foreach($day['activities'] as $act): ?>
                                    <div class="d-flex align-items-start p-2 rounded bg-light">
                                        <div class="schedule-time text-end me-3">
                                            <?= substr($act['thoi_gian_bat_dau'], 0, 5) ?><br>
                                            <small class="text-muted fw-normal"><?= substr($act['thoi_gian_ket_thuc'], 0, 5) ?></small>
                                        </div>
                                        <div class="border-start border-3 border-primary ps-3">
                                            <div class="fw-bold text-dark"><?= $act['hoat_dong'] ?></div>
                                            <?php if($act['dia_diem']): ?>
                                                <small class="text-muted"><i class="fa-solid fa-map-pin"></i> <?= $act['dia_diem'] ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted small py-2">Chưa cập nhật hoạt động.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning text-center">Chưa có dữ liệu lịch trình.</div>
        <?php endif; ?>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>