<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Sửa thông tin HDV</h1>
    <a href="index.php?action=hdv_list" class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
</div>

<form method="POST" action="" class="card card-modern p-4">
    <div class="row">
        <div class="col-md-6">
            <h5 class="text-primary mb-3">1. Thông tin cá nhân</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Họ tên</label>
                <input type="text" name="ho_ten" value="<?= $hdv->ho_ten ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Link Avatar (URL)</label>
                <input type="text" name="avatar" value="<?= $hdv->avatar ?>" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="ngay_sinh" value="<?= $hdv->ngay_sinh ?>" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Giới tính/Sức khỏe</label>
                    <input type="text" name="suc_khoe" value="<?= $hdv->suc_khoe ?>" class="form-control" placeholder="Tốt/Bình thường">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Liên hệ</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                    <input type="text" name="so_dien_thoai" value="<?= $hdv->so_dien_thoai ?>" class="form-control">
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" value="<?= $hdv->email ?>" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h5 class="text-primary mb-3">2. Kỹ năng nghề nghiệp</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Loại HDV</label>
                <select name="loai_hdv" class="form-select">
                    <option value="Nội địa" <?= $hdv->loai_hdv == 'Nội địa' ? 'selected' : '' ?>>Nội địa</option>
                    <option value="Quốc tế" <?= $hdv->loai_hdv == 'Quốc tế' ? 'selected' : '' ?>>Quốc tế</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kinh nghiệm (năm)</label>
                    <input type="number" name="kinh_nghiem_nam" value="<?= $hdv->kinh_nghiem_nam ?>" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngôn ngữ</label>
                    <input type="text" name="ngon_ngu" value="<?= $hdv->ngon_ngu ?>" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Chứng chỉ hành nghề</label>
                <input type="text" name="chung_chi" value="<?= $hdv->chung_chi ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Đánh giá / Ghi chú</label>
                <textarea name="danh_gia" class="form-control" rows="3"><?= $hdv->danh_gia ?></textarea>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-warning px-5 fw-bold text-white">LƯU CẬP NHẬT</button>
    </div>
</form>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>