<?php require_once PATH_VIEW . 'layout/header.php'; ?>

<!-- Hero Banner -->
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Chào mừng đến PK-Shop</h1>
        <p class="col-md-8 fs-4">Nơi cung cấp các loại phụ kiện điện thoại, máy tính chính hãng, chất lượng cao với giá cả phải chăng. Khám phá ngay!</p>
        <a class="btn btn-primary btn-lg" href="#products" role="button">Xem sản phẩm</a>
    </div>
</div>

<!-- Featured Products -->
<section class="mb-5">
    <h2 class="mb-4">Sản phẩm nổi bật</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php if (!empty($featuredProducts)): ?>
            <?php foreach ($featuredProducts as $product): ?>
                <div class="col">
                    <?php include PATH_VIEW . 'layout/product_card.php'; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Chưa có sản phẩm nổi bật nào.</p>
        <?php endif; ?>
    </div>
</section>

<!-- New Products -->
<section class="mb-5">
    <h2 class="mb-4">Sản phẩm mới</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php if (!empty($newProducts)): ?>
            <?php foreach ($newProducts as $product): ?>
                <div class="col">
                    <?php include PATH_VIEW . 'layout/product_card.php'; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Chưa có sản phẩm mới nào.</p>
        <?php endif; ?>
    </div>
</section>

<!-- All Products -->
<section id="products">
    <h2 class="mb-4">Tất cả sản phẩm</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php if (!empty($allProducts)): ?>
            <?php foreach ($allProducts as $product): ?>
                <div class="col">
                    <?php include PATH_VIEW . 'layout/product_card.php'; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once PATH_VIEW . 'layout/footer.php'; ?>
