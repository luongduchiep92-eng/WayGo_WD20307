<?php require_once PATH_VIEW . 'layout/header.php'; ?>

<h1 class="mb-4">Giỏ hàng của bạn</h1>

<?php if (!empty($cartItems)): ?>
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tạm tính</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td style="width: 100px;">
                                    <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($item->image) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($item->name) ?>">
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>?action=product&id=<?= $item->product_id ?>" class="text-decoration-none text-dark fw-bold"><?= htmlspecialchars($item->name) ?></a>
                                </td>
                                <td>
                                    <?php if ($item->sale_price): ?>
                                        <span class="text-danger"><?= number_format($item->sale_price, 0, ',', '.') ?> đ</span>
                                    <?php else: ?>
                                        <span><?= number_format($item->price, 0, ',', '.') ?> đ</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="<?= BASE_URL ?>?action=cart-update" method="POST" class="d-flex">
                                        <input type="hidden" name="product_id" value="<?= $item->product_id ?>">
                                        <input type="number" name="quantity" class="form-control form-control-sm" value="<?= $item->quantity ?>" min="1" max="<?= $item->stock ?>" style="width: 70px;">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary ms-2"><i class="fa-solid fa-rotate"></i></button>
                                    </form>
                                </td>
                                <td class="fw-bold"><?= number_format($item->subtotal, 0, ',', '.') ?> đ</td>
                                <td>
                                    <a href="<?= BASE_URL ?>?action=cart-remove&id=<?= $item->product_id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="<?= BASE_URL ?>" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i> Tiếp tục mua sắm</a>
                <a href="<?= BASE_URL ?>?action=cart-clear" class="btn btn-outline-danger" onclick="return confirm('Bạn chắc chắn muốn xóa toàn bộ giỏ hàng?')"><i class="fa-solid fa-trash me-2"></i> Xóa giỏ hàng</a>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Tổng cộng giỏ hàng</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tạm tính</span>
                        <span><?= number_format($cartTotal, 0, ',', '.') ?> đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển</span>
                        <span>Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Tổng cộng</span>
                        <span><?= number_format($cartTotal, 0, ',', '.') ?> đ</span>
                    </div>
                    <div class="d-grid mt-4">
                        <a href="<?= BASE_URL ?>?action=checkout" class="btn btn-primary btn-lg">Tiến hành thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info text-center" role="alert">
        <i class="fa-solid fa-cart-shopping fa-2x mb-3"></i>
        <h4 class="alert-heading">Giỏ hàng của bạn đang trống!</h4>
        <p>Hãy khám phá các sản phẩm tuyệt vời của chúng tôi và thêm vào giỏ hàng nhé.</p>
        <a href="<?= BASE_URL ?>" class="btn btn-primary">Bắt đầu mua sắm</a>
    </div>
<?php endif; ?>

<?php require_once PATH_VIEW . 'layout/footer.php'; ?>
