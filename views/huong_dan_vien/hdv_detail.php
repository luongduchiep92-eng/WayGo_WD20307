<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Thông tin chi tiết hướng dẫn viên</h2>

    <div class="card shadow p-4">
        <div class="row">
            <div class="col-md-4 text-center">
                <?php if ($hdv->avatar): ?>
                    <img src="<?= $hdv->avatar ?>" alt="Avatar" class="rounded-circle mb-3" width="150" height="150">
                <?php else: ?>
                    <div class="bg-secondary text-white rounded-circle d-inline-flex justify-content-center align-items-center" style="width:150px;height:150px;">
                        <span>Không có ảnh</span>
                    </div>
                <?php endif; ?>
                <h4 class="mt-3"><?= htmlspecialchars($hdv->ho_ten) ?></h4>
                <p class="text-muted"><?= htmlspecialchars($hdv->email) ?></p>
            </div>

            <div class="col-md-8">
                <table class="table table-striped">
                    <tr><th>Ngày sinh:</th><td><?= $hdv->ngay_sinh ?></td></tr>
                    <tr><th>Số điện thoại:</th><td><?= $hdv->so_dien_thoai ?></td></tr>
                    <tr><th>Chứng chỉ:</th><td><?= $hdv->chung_chi ?></td></tr>
                    <tr><th>Ngôn ngữ:</th><td><?= $hdv->ngon_ngu ?></td></tr>
                    <tr><th>Kinh nghiệm:</th><td><?= $hdv->kinh_nghiem_nam ?> năm</td></tr>
                    <tr><th>Loại hướng dẫn viên:</th><td><?= $hdv->loai_hdv ?></td></tr>
                    <tr><th>Sức khỏe:</th><td><?= $hdv->suc_khoe ?></td></tr>
                    <tr><th>Đánh giá:</th><td><?= $hdv->danh_gia ?></td></tr>
                </table>
                <a href="<?= BASE_URL . '?action=hdv_edit&id=' . $hdv->id ?>" class="btn btn-warning">Chỉnh sửa</a>
                <a href="<?= BASE_URL . '?action=hdv_list'; ?>" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
