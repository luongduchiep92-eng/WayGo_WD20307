<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Cập nhật Nhật Ký Tour</h3>
    <a href="index.php?action=diary_detail&id=<?= $diary['id'] ?>" class="btn btn-secondary">Hủy</a>
</div>

<div class="alert alert-info">
    Đang cập nhật nhật ký cho tour: <strong><?= $diary['ten_tour'] ?></strong> (<?= date('d/m/Y', strtotime($diary['ngay_khoi_hanh'])) ?>)
</div>

<form method="POST" class="card card-modern p-4">
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label fw-bold text-success">Phản ánh dịch vụ (NCC)</label>
            <textarea name="supplier_feedback" class="form-control" rows="5"><?= $diary['supplier_feedback'] ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold text-info">Phản ánh của Khách</label>
            <textarea name="customer_feedback" class="form-control" rows="5"><?= $diary['customer_feedback'] ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold text-warning">Tình huống phát sinh</label>
            <textarea name="incidents" class="form-control" rows="5"><?= $diary['incidents'] ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold text-primary">Cách xử lý</label>
            <textarea name="resolution" class="form-control" rows="5"><?= $diary['resolution'] ?></textarea>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-warning px-5 fw-bold text-white">CẬP NHẬT</button>
    </div>
</form>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>