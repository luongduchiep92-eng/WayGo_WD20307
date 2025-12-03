<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Chi tiết Nhật Ký Tour #<?= $diary['id'] ?></h3>
    <div>
        <a href="index.php?action=diary_edit&id=<?= $diary['id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pen"></i> Sửa</a>
        <a href="index.php?action=diary_list" class="btn btn-secondary">Quay lại</a>
    </div>
</div>

<div class="card card-modern mb-4" style="height: auto !important;">
    <div class="card-header bg-light">
        <strong>Thông tin chuyến đi</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Tour:</strong> <?= $diary['ten_tour'] ?></p>
                <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($diary['ngay_khoi_hanh'])) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Trưởng đoàn/Khách đặt:</strong> <?= $diary['customer_name'] ?></p>
                <p><strong>Số lượng khách:</strong> <?= $diary['so_luong'] ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-modern h-100 border-start border-4 border-success">
            <div class="card-body">
                <h5 class="card-title text-success fw-bold"><i class="fa-solid fa-hotel me-2"></i> Phản ánh Dịch vụ NCC</h5>
                <p class="card-text text-secondary"><?= nl2br($diary['supplier_feedback'] ?: 'Không có ghi nhận.') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-modern h-100 border-start border-4 border-info">
            <div class="card-body">
                <h5 class="card-title text-info fw-bold"><i class="fa-solid fa-comments me-2"></i> Ý kiến Khách hàng</h5>
                <p class="card-text text-secondary"><?= nl2br($diary['customer_feedback'] ?: 'Không có ghi nhận.') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-modern h-100 border-start border-4 border-warning">
            <div class="card-body">
                <h5 class="card-title text-warning fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i> Sự cố phát sinh</h5>
                <p class="card-text text-secondary"><?= nl2br($diary['incidents'] ?: 'Chuyến đi an toàn, không sự cố.') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-modern h-100 border-start border-4 border-primary">
            <div class="card-body">
                <h5 class="card-title text-primary fw-bold"><i class="fa-solid fa-wand-magic-sparkles me-2"></i> Hướng xử lý</h5>
                <p class="card-text text-secondary"><?= nl2br($diary['resolution'] ?: 'Không có.') ?></p>
            </div>
        </div>
    </div>
</div>

<div class="text-end mt-3 text-muted small">
    Được tạo lúc: <?= date('H:i d/m/Y', strtotime($diary['created_at'])) ?>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>