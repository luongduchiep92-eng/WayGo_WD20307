<?php include PATH_VIEW . 'layouts/header.php'; ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary"><i class="fa-solid fa-list-check"></i> Quản Lý Booking</h2>
        <a href="index.php?action=booking_add" class="btn btn-primary shadow-sm"><i class="fa-solid fa-plus"></i> Tạo Booking Mới</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tour & HDV</th>
                        <th>Khách Hàng</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Cọc</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $b): ?>
                        <tr>
                            <td>#<?= $b['id'] ?></td>
                            <td>
                                <div class="fw-bold"><?= $b['ten_tour'] ?></div>
                                <small class="text-muted"><i class="fa-solid fa-user-tie"></i> <?= $b['hdv_name'] ?></small>
                            </td>
                            <td>
                                <div><?= $b['customer_name'] ?></div>
                                <small class="text-muted"><?= $b['customer_phone'] ?></small>
                            </td>
                            <td class="text-center"><?= $b['so_luong'] ?></td>
                            <td class="text-danger fw-bold"><?= number_format($b['tong_tien']) ?> đ</td>
                            <td class="text-success"><?= number_format($b['tien_da_coc']) ?> đ</td>
                            <td>
                                <?php 
                                    $cls = match($b['status']) { 'Hoàn tất'=>'success', 'Hủy'=>'danger', 'Đã cọc'=>'info', default=>'warning' }; 
                                ?>
                                <span class="badge bg-<?= $cls ?>"><?= $b['status'] ?></span>
                            </td>
                            <td>
                                <a href="index.php?action=booking_detail&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-info" title="Chi tiết"><i class="fa-solid fa-eye"></i></a>
                                <a href="index.php?action=booking_edit&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="fa-solid fa-pen"></i></a>
                                <a href="index.php?action=booking_delete&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa booking này?')" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>