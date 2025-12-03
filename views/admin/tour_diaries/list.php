<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Nhật Ký Tour</h1>
    <a href="index.php?action=diary_add" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-pen-nib"></i> Viết Nhật Ký Mới
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tour & Thời gian</th>
                        <th>Người đặt tour</th>
                        <th>Ngày viết</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($diaries)): ?>
                        <?php foreach ($diaries as $d): ?>
                        <tr>
                            <td>#<?= $d['id'] ?></td>
                            <td>
                                <div class="fw-bold text-primary"><?= $d['ten_tour'] ?></div>
                                <small class="text-muted"><i class="fa-regular fa-clock"></i> KH: <?= date('d/m/Y', strtotime($d['ngay_khoi_hanh'])) ?></small>
                            </td>
                            <td><?= $d['customer_name'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($d['created_at'])) ?></td>
                            <td>
                                <a href="index.php?action=diary_detail&id=<?= $d['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a>
                                <a href="index.php?action=diary_edit&id=<?= $d['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen"></i></a>
                                <a href="index.php?action=diary_delete&id=<?= $d['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa nhật ký này?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Chưa có nhật ký nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>