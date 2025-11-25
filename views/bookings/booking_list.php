<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="tour-container">
    <a href="index.php?action=booking_add" class="add-tour-btn">+ Thêm Booking</a>

    <h1>Danh sách Booking</h1>

    <table class="tour-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tour</th>
                <th>Hướng dẫn viên</th>
                <th>Khách hàng</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($bookings)): ?>
                <?php foreach($bookings as $b): ?>
                    <tr>
                        <td><?= $b['id'] ?></td>
                        <td><?= $b['ten_tour'] ?></td>
                        <td><?= $b['hdv_name'] ?></td>
                        <td><?= $b['customer_name'] ?></td>
                        <td><?= $b['so_luong'] ?></td>
                        <td><?= number_format($b['tong_tien']) ?> VND</td>
                        <td><?= $b['status'] ?></td>
                        <td>
                            <a href="index.php?action=booking_detail&id=<?= $b['id'] ?>" class="btn btn-sm btn-warning">Chi tiết</a>
                            <a href="index.php?action=booking_edit&id=<?= $b['id'] ?>" class="btn btn-sm btn-info">Sửa</a>
                            <a href="index.php?action=booking_delete&id=<?= $b['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding: 15px;">Chưa có Booking nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<link rel="stylesheet" href="<?= BASE_URL . 'assets/css/booking_list.css' ?>">

<?php include PATH_VIEW . 'layouts/footer.php'; ?>
