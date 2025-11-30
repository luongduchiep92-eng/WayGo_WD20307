<?php require_once "views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Nhà Cung Cấp Dịch Vụ</h1>
    <a href="index.php?action=addsupplier" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus"></i> Thêm NCC
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Nhà Cung Cấp</th>
                        <th>Liên hệ</th>
                        <th>Địa chỉ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suppliers as $s): ?>
                    <tr>
                        <td>#<?= $s['id'] ?></td>
                        <td class="fw-bold text-primary">
                            <i class="fa-solid fa-building me-2 text-secondary"></i> <?= $s['name'] ?>
                        </td>
                        <td>
                            <div><i class="fa-solid fa-phone text-success"></i> <?= $s['phone'] ?></div>
                            <small class="text-muted"><i class="fa-solid fa-envelope"></i> <?= $s['email'] ?></small>
                        </td>
                        <td><?= $s['address'] ?></td>
                        <td>
                            <a href="index.php?action=detailsupplier&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-info" title="Chi tiết"><i class="fa-solid fa-eye"></i></a>
                            <a href="index.php?action=editsupplier&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="fa-solid fa-pen"></i></a>
                            <a href="index.php?action=deletesupplier&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa nhà cung cấp này?')" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>