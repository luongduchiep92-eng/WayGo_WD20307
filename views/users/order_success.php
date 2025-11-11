<?php require_once PATH_VIEW . 'layout/header.php'; ?>

<div class="container text-center">
    <div class="py-5">
        <i class="fa-solid fa-circle-check fa-5x text-success mb-4"></i>
        <h1 class="display-5 fw-bold">Đặt hàng thành công!</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <p class="fs-4 text-muted"><?= $_SESSION['success'] ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if ($order_id): ?>
            <p class="lead">Cảm ơn bạn đã mua hàng tại PK-Shop. Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.</p>
        <?php else: ?>
            <p class="lead">Cảm ơn bạn đã mua hàng tại PK-Shop.</p>
        <?php endif; ?>
        
        <hr class="my-4">
        
        <p>Bạn có muốn tiếp tục mua sắm?</p>
        <a class="btn btn-primary btn-lg" href="<?= BASE_URL ?>" role="button">Về trang chủ</a>
    </div>
</div>

<?php require_once PATH_VIEW . 'layout/footer.php'; ?>
