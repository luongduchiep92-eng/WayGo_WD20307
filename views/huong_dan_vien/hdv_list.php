<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Danh sách hướng dẫn viên</h2>
    <a href="<?= BASE_URL . '?action=hdv_add'; ?>" class="btn btn-primary mb-3">+ Thêm hướng dẫn viên</a>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Avatar</th>
                <th>Email</th>
                <th>Ngôn ngữ</th>
                <th>Kinh nghiệm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($hdvs)): ?>
                <?php foreach ($hdvs as $hdv): ?>
                    <tr>
                        <td><?= $hdv->id ?></td>
                        <td><?= htmlspecialchars($hdv->ho_ten) ?></td>
                        <td>
                            <?php if ($hdv->avatar): ?>
                                <img src="<?= $hdv->avatar ?>" width="60" height="60" class="rounded-circle" alt="">
                            <?php else: ?>
                                <span class="text-muted">Chưa có</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($hdv->email) ?></td>
                        <td><?= htmlspecialchars($hdv->ngon_ngu) ?></td>
                        <td><?= htmlspecialchars($hdv->kinh_nghiem_nam) ?> năm</td>
                        <td>
                            <a href="<?= BASE_URL . '?action=hdv_detail&id=' . $hdv->id ?>" class="btn btn-sm btn-info">Chi tiết</a>
                            <a href="<?= BASE_URL . '?action=hdv_edit&id=' . $hdv->id ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="<?= BASE_URL . '?action=hdv_delete&id=' . $hdv->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa hướng dẫn viên này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">Chưa có hướng dẫn viên nào</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
