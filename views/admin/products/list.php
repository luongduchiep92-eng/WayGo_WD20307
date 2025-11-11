<?php include_once './views/layout/header_admin.php'; ?>

<div class="container mt-4 admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3 admin-header">
        <h1>Danh sách sản phẩm</h1>
        <a href="index.php?role=admin&action=product-add" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Thêm sản phẩm mới
        </a>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['success_message'] ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Giá</th>
                    <th scope="col" style="width: 30%;">Mô tả</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach($products as $product): ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($product->id); ?></th>
                        <td><?= htmlspecialchars($product->name); ?></td>
                        <td>
                            <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($product->image); ?>" width="100" alt="<?= htmlspecialchars($product->name); ?>" class="img-thumbnail">
                        </td>
                        <td><?= number_format($product->price, 0, ',', '.'); ?> VNĐ</td>
                        <td><?= htmlspecialchars($product->description); ?></td>
                        <td>
                            <a href="<?= BASE_URL . 'index.php?role=admin&action=product-edit&id=' . $product->id ?>" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Sửa
                            </a>
                            <a href="<?= BASE_URL . 'index.php?role=admin&action=product-delete&id=' . $product->id  ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once './views/layout/footer_admin.php'; ?>
