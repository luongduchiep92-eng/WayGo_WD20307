<?php require 'views/layout/header_admin.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card admin-form-card">
                <div class="card-header">
                    <h1 class="h3 mb-0">Cập nhật sản phẩm</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($productCurrent->name) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <div class="mt-2">
                                <small>Ảnh hiện tại:</small>
                                <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($productCurrent->image) ?>" height="100" alt="<?= htmlspecialchars($productCurrent->name) ?>" class="img-thumbnail">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= htmlspecialchars($productCurrent->price) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($productCurrent->description) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category->id ?>" <?= ($category->id == $productCurrent->category_id) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" name="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <a href="index.php?role=admin&action=product-list" class="btn btn-secondary ms-2">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layout/footer_admin.php'; ?>
