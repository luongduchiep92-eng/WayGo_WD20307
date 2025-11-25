<?php include PATH_VIEW . 'layouts/header.php'; ?>

<link rel="stylesheet" href="assets/css/booking_edit.css">

<div class="edit-container">
    <h2 class="edit-title">Sửa Booking #<?= $booking['id'] ?></h2>

    <form method="post" class="edit-form">

        <div class="form-group">
            <label>Tour:</label>
            <select name="tour_id" required>
                <?php foreach ($tours as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= $t['id'] == $booking['tour_id'] ? 'selected' : '' ?>>
                        <?= $t['ten_tour'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Hướng dẫn viên:</label>
            <select name="hdv_id" required>
                <?php foreach ($hdvs as $h): ?>
                    <option value="<?= $h['id'] ?>" <?= $h['id'] == $booking['hdv_id'] ? 'selected' : '' ?>>
                        <?= $h['ho_ten'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Khách hàng chính:</label>
            <input type="text" name="customer_name" value="<?= $booking['customer_name'] ?>" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="customer_phone" value="<?= $booking['customer_phone'] ?>" required>
        </div>

        <div class="form-group">
            <label>Số lượng khách:</label>
            <input type="number" name="so_luong" value="<?= $booking['so_luong'] ?>" required>
        </div>

        <div class="form-group">
            <label>Tổng tiền:</label>
            <input type="number" name="tong_tien" value="<?= $booking['tong_tien'] ?>" required>
        </div>

        <div class="form-group">
            <label>Nhà cung cấp khách sạn:</label>
            <select name="hotel_supplier_id">
                <option value="">--Chọn--</option>
                <?php foreach ($hotels as $h): ?>
                    <option value="<?= $h['id'] ?>" <?= $h['id'] == $booking['hotel_supplier_id'] ? 'selected' : '' ?>>
                        <?= $h['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nhà cung cấp nhà hàng:</label>
            <select name="restaurant_supplier_id">
                <option value="">--Chọn--</option>
                <?php foreach ($restaurants as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= $r['id'] == $booking['restaurant_supplier_id'] ? 'selected' : '' ?>>
                        <?= $r['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display:flex; justify-content: space-between; align-items:center; margin-top:10px;">
            <a href="index.php?action=booking_list" class="edit-back">Quay lại</a>
            <button type="submit" class="edit-submit">Cập nhật Booking</button>
        </div>

    </form>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>