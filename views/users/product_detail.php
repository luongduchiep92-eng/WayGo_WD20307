<?php require_once PATH_VIEW . 'layout/header.php'; ?>

<div class="row">
    <!-- Product Image -->
    <div class="col-md-6">
        <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($product->image) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product->name) ?>">
    </div>

    <!-- Product Info -->
    <div class="col-md-6">
        <h1 class="mb-3"><?= htmlspecialchars($product->name) ?></h1>
        <p class="text-muted">Danh mục: <a href="<?= BASE_URL ?>?action=category&id=<?= $product->category_id ?>"><?= htmlspecialchars($product->category_name) ?></a></p>
        
        <div class="mb-4">
            <?php if ($product->sale_price): ?>
                <span class="h2 text-danger fw-bold"><?= number_format($product->sale_price, 0, ',', '.') ?> đ</span>
                <span class="h4 text-muted text-decoration-line-through ms-2"><?= number_format($product->price, 0, ',', '.') ?> đ</span>
            <?php else: ?>
                <span class="h2 text-primary fw-bold"><?= number_format($product->price, 0, ',', '.') ?> đ</span>
            <?php endif; ?>
        </div>

        <p class="mb-4"><?= nl2br(htmlspecialchars($product->description)) ?></p>

        <div class="d-flex align-items-center mb-4">
            <span class="me-3">Tình trạng:</span>
            <?php if ($product->stock > 0): ?>
                <span class="badge bg-success">Còn hàng</span>
            <?php else: ?>
                <span class="badge bg-danger">Hết hàng</span>
            <?php endif; ?>
        </div>

        <form action="<?= BASE_URL ?>?action=cart-add" method="POST" class="d-flex">
            <input type="hidden" name="product_id" value="<?= $product->id ?>">
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
            
            <div class="me-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?= $product->stock ?>">
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg align-self-end" <?= $product->stock <= 0 ? 'disabled' : '' ?>>
                <i class="fa-solid fa-cart-plus me-2"></i> Thêm vào giỏ
            </button>
        </form>
    </div>
</div>

<!-- Related Products -->
<hr class="my-5">
<section>
    <h2 class="mb-4">Sản phẩm liên quan</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php if (!empty($relatedProducts)): ?>
            <?php foreach ($relatedProducts as $product): ?>
                <div class="col">
                    <?php include PATH_VIEW . 'layout/product_card.php'; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Không có sản phẩm liên quan.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once PATH_VIEW . 'layout/footer.php'; ?>
