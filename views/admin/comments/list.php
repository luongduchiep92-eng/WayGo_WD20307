<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Đánh giá Nhà cung cấp</h1>
    <a href="index.php?action=comment_add_form" class="btn btn-success shadow-sm">
        <i class="fa-solid fa-plus"></i> Thêm đánh giá
    </a>
</div>

<div class="card card-modern mb-4" style="height: auto !important;">
    <div class="card-body">
        <form method="POST" action="index.php?action=comments_list" class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="supplier_name" class="form-control" placeholder="Tìm theo tên Nhà cung cấp..." value="<?= $_POST['supplier_name'] ?? '' ?>">
            </div>
            <div class="col-md-3">
                <select name="rating" class="form-select">
                    <option value="">-- Tất cả sao --</option>
                    <option value="5" <?= (isset($_POST['rating']) && $_POST['rating']==5)?'selected':'' ?>>⭐⭐⭐⭐⭐</option>
                    <option value="4" <?= (isset($_POST['rating']) && $_POST['rating']==4)?'selected':'' ?>>⭐⭐⭐⭐</option>
                    <option value="3" <?= (isset($_POST['rating']) && $_POST['rating']==3)?'selected':'' ?>>⭐⭐⭐</option>
                    <option value="2" <?= (isset($_POST['rating']) && $_POST['rating']==2)?'selected':'' ?>>⭐⭐</option>
                    <option value="1" <?= (isset($_POST['rating']) && $_POST['rating']==1)?'selected':'' ?>>⭐</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Lọc</button>
            </div>
        </form>
    </div>
</div>

<div class="card card-modern shadow-sm" style="height: auto !important;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Người đánh giá</th>
                        <th>Nhà cung cấp</th>
                        <th width="30%">Nội dung</th>
                        <th>Đánh giá</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($comments)): ?>
                        <?php foreach($comments as $c): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($c['guest_name']) ?></td>
                            <td class="text-primary fw-bold"><?= htmlspecialchars($c['supplier_name']) ?></td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;" title="<?= htmlspecialchars($c['content']) ?>">
                                    <?= htmlspecialchars($c['content']) ?>
                                </div>
                            </td>
                            <td class="text-warning"><?= str_repeat('<i class="fa-solid fa-star"></i>', $c['rating']) ?></td>
                            <td class="small text-muted"><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
                            <td>
                                <a href="index.php?action=comment_detail&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-info" title="Chi tiết"><i class="fa-solid fa-eye"></i></a>
                                <a href="index.php?action=comment_delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa đánh giá này?')" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có dữ liệu đánh giá nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>