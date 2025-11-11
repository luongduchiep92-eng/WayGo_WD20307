<?php require_once PATH_VIEW . 'layout/header.php'; ?>

<h1 class="mb-4">Kết quả tìm kiếm cho: "<?= htmlspecialchars($keyword) ?>"</h1>

<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3">
        <h4>Danh mục</h4>
        <ul class="list-group">
            <?php foreach ($categories as $cat): ?>
                <a href="<?= BASE_URL ?>?action=category&id=<?= $cat->id ?>" class="list-group-item list-group-item-action">
                    <?= htmlspecialchars($cat->name) ?>
                </a>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Products -->
    <div class="col-md-9">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col">
                        <?php include PATH_VIEW . 'layout/product_card.php'; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?= htmlspecialchars($keyword) ?>".
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once PATH_VIEW . 'layout/footer.php'; ?>
