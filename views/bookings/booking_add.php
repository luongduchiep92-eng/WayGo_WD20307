<?php include PATH_VIEW . 'layouts/header.php'; ?>

<link rel="stylesheet" href="assets/css/booking_add.css">

<div class="booking-container">
    <h2 class="booking-title">Thêm Booking</h2>

    <?php if (isset($error)): ?>
        <p class="booking-error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post" class="booking-form">

        <div class="form-group">
            <label>Tour:</label>
            <select name="tour_id" required>
                <?php foreach ($tours as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= $t['ten_tour'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Hướng dẫn viên:</label>
            <select name="hdv_id" required>
                <?php foreach ($hdvs as $h): ?>
                    <option value="<?= $h['id'] ?>"><?= $h['ho_ten'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Khách hàng chính:</label>
            <input type="text" name="customer_name" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="customer_phone" required>
        </div>

        <div class="form-group">
            <label>Số lượng khách:</label>
            <input type="number" name="so_luong" required>
        </div>

        <div class="form-group">
            <label>Tổng tiền:</label>
            <input type="number" name="tong_tien" required>
        </div>

        <div class="form-group">
            <label>Nhà cung cấp khách sạn:</label>
            <select name="hotel_supplier_id">
                <option value="">--Chọn--</option>
                <?php foreach ($hotels as $h): ?>
                    <option value="<?= $h['id'] ?>"><?= $h['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nhà cung cấp nhà hàng:</label>
            <select name="restaurant_supplier_id">
                <option value="">--Chọn--</option>
                <?php foreach ($restaurants as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="booking-submit">Thêm Booking</button>

    </form>

    <a href="index.php?action=booking_list" class="booking-back">Quay lại</a>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>