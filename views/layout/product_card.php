<div class="card h-100 shadow-sm">
    <a href="<?= BASE_URL ?>?action=product&id=<?= $product->id ?>">
        <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($product->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>">
    </a>
    <div class="card-body">
        <h5 class="card-title">
            <a href="<?= BASE_URL ?>?action=product&id=<?= $product->id ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($product->name) ?></a>
        </h5>
        <p class="card-text text-muted small"><?= htmlspecialchars($product->category_name) ?></p>
        <div>
            <?php if ($product->sale_price): ?>
                <span class="text-danger fw-bold"><?= number_format($product->sale_price, 0, ',', '.') ?> đ</span>
                <span class="text-muted text-decoration-line-through ms-2"><?= number_format($product->price, 0, ',', '.') ?> đ</span>
            <?php else: ?>
                <span class="text-primary fw-bold"><?= number_format($product->price, 0, ',', '.') ?> đ</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-footer bg-transparent border-top-0">
        <form action="<?= BASE_URL ?>?action=cart-add" method="POST">
            <input type="hidden" name="product_id" value="<?= $product->id ?>">
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-cart-plus me-2"></i> Thêm vào giỏ
            </button>
        </form>
    </div>
</div>
