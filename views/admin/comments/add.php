<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Thêm Đánh Giá Mới</h3>
    <a href="index.php?action=comments_list" class="btn btn-secondary">Quay lại</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-modern p-4" style="height: auto !important;">
            <form method="POST" action="index.php?action=comment_add">
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và tên khách hàng</label>
                    <input type="text" name="guest_name" class="form-control" required placeholder="Nhập tên người đánh giá...">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên Nhà cung cấp</label>
                    <input type="text" name="supplier_name" class="form-control" required placeholder="VD: Khách sạn Mường Thanh...">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Mức độ hài lòng</label>
                    <select name="rating" class="form-select text-warning fw-bold" required>
                        <option value="5" class="text-dark">⭐⭐⭐⭐⭐ (Xuất sắc)</option>
                        <option value="4" class="text-dark">⭐⭐⭐⭐ (Tốt)</option>
                        <option value="3" class="text-dark">⭐⭐⭐ (Bình thường)</option>
                        <option value="2" class="text-dark">⭐⭐ (Tệ)</option>
                        <option value="1" class="text-dark">⭐ (Rất tệ)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Nội dung đánh giá</label>
                    <textarea name="content" class="form-control" rows="4" required placeholder="Chi tiết trải nghiệm..."></textarea>
                </div>
                
                <div class="text-center">
                    <button class="btn btn-success px-5 fw-bold">LƯU ĐÁNH GIÁ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>