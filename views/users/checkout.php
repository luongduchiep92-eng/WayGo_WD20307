<?php require_once PATH_VIEW . 'layout/header.php'; ?>

<h1 class="mb-4">Thanh toán</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="row">
    <!-- Checkout Form -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Thông tin giao hàng</h5>
                <form action="<?= BASE_URL ?>?action=process-checkout" method="POST">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="customer_address" class="form-label">Địa chỉ</label>
                        <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú (tùy chọn)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>
                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Đặt hàng</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Đơn hàng của bạn</h5>
                <ul class="list-group list-group-flush">
                    <?php foreach ($cartItems as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="my-0"><?= htmlspecialchars($item->name) ?></h6>
                                <small class="text-muted">Số lượng: <?= $item->quantity ?></small>
                            </div>
                            <span class="text-muted"><?= number_format($item->subtotal, 0, ',', '.') ?> đ</span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span>Tạm tính</span>
                        <strong><?= number_format($cartTotal, 0, ',', '.') ?> đ</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span>Phí vận chuyển</span>
                        <strong>Miễn phí</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Tổng cộng</span>
                        <strong class="fs-5"><?= number_format($cartTotal, 0, ',', '.') ?> đ</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once PATH_VIEW . 'layout/footer.php'; ?>
