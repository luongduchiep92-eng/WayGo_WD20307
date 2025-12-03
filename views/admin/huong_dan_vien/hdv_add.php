<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Thêm hướng dẫn viên mới</h2>

    <form method="POST" action="">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Họ tên</label>
                <input type="text" name="ho_ten" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Avatar (URL)</label>
                <input type="text" name="avatar" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Ngày sinh</label>
                <input type="date" name="ngay_sinh" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Chứng chỉ</label>
                <input type="text" name="chung_chi" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Ngôn ngữ</label>
                <input type="text" name="ngon_ngu" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Kinh nghiệm (năm)</label>
                <input type="number" name="kinh_nghiem_nam" class="form-control" min="0">
            </div>

            <div class="col-md-6 mb-3">
                <label>Loại hướng dẫn viên</label>
                <input type="text" name="loai_hdv" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Sức khỏe</label>
                <input type="text" name="suc_khoe" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label>Đánh giá</label>
                <textarea name="danh_gia" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="<?= BASE_URL . '?action=hdv_list'; ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>