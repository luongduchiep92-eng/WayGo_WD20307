<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-modern shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="fw-bold mb-0"><i class="fa-solid fa-pen-nib me-2"></i> Bắt đầu viết Nhật Ký</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-center text-muted mb-4">Vui lòng chọn một tour <strong>đang đi</strong> hoặc <strong>đã đi</strong> để bắt đầu ghi chép.</p>
                    
                    <form action="index.php" method="GET">
                        <input type="hidden" name="action" value="diary_manage">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Chọn Tour:</label>
                            <select name="booking_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="">-- Chọn chuyến đi --</option>
                                <?php foreach($bookings as $b): ?>
                                    <option value="<?= $b['id'] ?>">
                                        [<?= date('d/m', strtotime($b['ngay_khoi_hanh'])) ?>] <?= $b['ten_tour'] ?> (<?= $b['customer_name'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold py-2 shadow">
                                <i class="fa-solid fa-arrow-right me-2"></i> TIẾP TỤC
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="index.php?action=diary_list" class="text-decoration-none text-secondary">Quay lại danh sách</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>