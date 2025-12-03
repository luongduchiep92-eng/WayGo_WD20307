<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Viết Nhật Ký Tour Mới</h3>
    <a href="index.php?action=diary_list" class="btn btn-secondary">Quay lại</a>
</div>

<form method="POST" class="card card-modern p-4">
    <div class="mb-4">
        <label class="form-label fw-bold">Chọn Tour đã hoàn thành <span class="text-danger">*</span></label>
        <select name="booking_id" class="form-select" required>
            <option value="">-- Chọn chuyến đi --</option>
            <?php foreach($bookings as $b): ?>
                <option value="<?= $b['id'] ?>">
                    #<?= $b['id'] ?> - <?= $b['ten_tour'] ?> (KH: <?= date('d/m/Y', strtotime($b['ngay_khoi_hanh'])) ?> - Khách: <?= $b['customer_name'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <div class="form-text">Chỉ hiển thị các tour có trạng thái "Hoàn tất" và chưa có nhật ký.</div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label fw-bold text-success"><i class="fa-solid fa-hotel"></i> Phản ánh dịch vụ (NCC)</label>
            <textarea name="supplier_feedback" class="form-control" rows="5" placeholder="Chất lượng khách sạn, nhà hàng, xe cộ..."></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold text-info"><i class="fa-solid fa-comments"></i> Phản ánh của Khách</label>
            <textarea name="customer_feedback" class="form-control" rows="5" placeholder="Khách khen/chê điểm nào..."></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold text-warning"><i class="fa-solid fa-triangle-exclamation"></i> Tình huống phát sinh</label>
            <textarea name="incidents" class="form-control" rows="5" placeholder="Sự cố, tai nạn, mất mát..."></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold text-primary"><i class="fa-solid fa-wand-magic-sparkles"></i> Cách xử lý</label>
            <textarea name="resolution" class="form-control" rows="5" placeholder="Đã giải quyết như thế nào..."></textarea>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary px-5 fw-bold">LƯU NHẬT KÝ</button>
    </div>
</form>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>