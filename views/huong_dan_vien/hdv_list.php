<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Danh sách Hướng Dẫn Viên</h1>
    <a href="index.php?action=hdv_add" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-user-plus fa-sm text-white-50"></i> Thêm HDV
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thông tin cá nhân</th>
                        <th>Liên hệ</th>
                        <th>Kinh nghiệm</th>
                        <th>Đánh giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($hdvs)): ?>
                        <?php foreach ($hdvs as $hdv): ?>
                            <tr>
                                <td>#<?= $hdv->id ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($hdv->avatar): ?>
                                            <img src="<?= $hdv->avatar ?>" class="rounded-circle me-3 border" width="50" height="50" style="object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle me-3 bg-secondary text-white d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold"><?= htmlspecialchars($hdv->ho_ten) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($hdv->loai_hdv) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><i class="fa-solid fa-envelope text-primary"></i> <?= htmlspecialchars($hdv->email) ?></div>
                                    <small><i class="fa-solid fa-phone text-success"></i> <?= htmlspecialchars($hdv->so_dien_thoai) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark"><?= htmlspecialchars($hdv->kinh_nghiem_nam) ?> năm</span>
                                    <br><small class="text-muted"><?= htmlspecialchars($hdv->ngon_ngu) ?></small>
                                </td>
                                <td>
                                    <div class="text-warning small"><i class="fa-solid fa-star"></i> <?= htmlspecialchars($hdv->danh_gia) ?></div>
                                </td>
                                <td>
                                    <a href="index.php?action=hdv_detail&id=<?= $hdv->id ?>" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-circle-info"></i></a>
                                    <a href="index.php?action=hdv_edit&id=<?= $hdv->id ?>" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen"></i></a>
                                    <a href="index.php?action=hdv_delete&id=<?= $hdv->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa HDV này?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Chưa có dữ liệu.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>