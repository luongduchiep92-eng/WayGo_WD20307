<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Cập nhật Nhà Cung Cấp</h1>
    <a href="index.php?action=listsupplier" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-modern">
            <div class="card-body p-4">
                <form method="post" action="index.php?action=updatesupplier&id=<?= $supplier['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Nhà Cung Cấp</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($supplier['name']) ?>" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" value="<?= htmlspecialchars($supplier['phone']) ?>" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($supplier['email']) ?>" class="form-control">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Địa chỉ</label>
                        <input type="text" name="address" value="<?= htmlspecialchars($supplier['address']) ?>" class="form-control">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-warning px-5 fw-bold text-white">
                            <i class="fa-solid fa-pen-to-square"></i> CẬP NHẬT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>