<?php include PATH_VIEW . 'layouts/header_hdv.php'; ?>

<div class="container mt-3">
    <h5 class="fw-bold text-primary mb-3 ps-1">Tất cả lịch dẫn tour</h5>

    <div class="list-group shadow-sm rounded-3">
        <?php foreach ($tours as $t): ?>
        <a href="index.php?action=hdv_tour_detail&tour_id=<?= $t['tour_id'] ?>" class="list-group-item list-group-item-action p-3 border-start-0 border-end-0">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1 fw-bold"><?= $t['ten_tour'] ?></h6>
                <small class="<?= $t['status']=='Hoàn tất' ? 'text-success' : 'text-warning' ?> fw-bold">
                    <?= $t['status'] ?>
                </small>
            </div>
            <p class="mb-1 text-muted small">
                <i class="fa-regular fa-calendar"></i> <?= date('d/m/Y', strtotime($t['ngay_khoi_hanh'])) ?> 
                <span class="mx-1">|</span> 
                <i class="fa-solid fa-bus"></i> <?= $t['phuong_tien'] ?>
            </p>
            <div class="mt-2">
                <span class="badge bg-light text-dark border">Xem chi tiết <i class="fa-solid fa-arrow-right ms-1"></i></span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer_hdv.php'; ?>