<?php include PATH_VIEW . 'layouts/header.php'; ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary"><i class="fa-solid fa-list-check"></i> Quản Lý Booking</h2>
        <a href="index.php?action=booking_add" class="btn btn-primary shadow-sm"><i class="fa-solid fa-plus"></i> Tạo Booking Mới</a>
    </div>

    <div class="card mb-3">
        <div class="card-body py-3">
            <form method="GET" action="index.php" class="d-flex gap-3 align-items-center">
                <input type="hidden" name="action" value="booking_list">
                
                <label class="fw-bold text-muted mb-0"><i class="fa-solid fa-filter"></i> Trạng thái:</label>
                
                <select name="status" class="form-select w-auto">
                    <option value="">-- Tất cả --</option>
                    <option value="Chờ xử lý" <?= (isset($_GET['status']) && $_GET['status']=='Chờ xử lý')?'selected':'' ?>>Chờ xử lý</option>
                    <option value="Đã cọc" <?= (isset($_GET['status']) && $_GET['status']=='Đã cọc')?'selected':'' ?>>Đã cọc</option>
                    <option value="Hoàn tất" <?= (isset($_GET['status']) && $_GET['status']=='Hoàn tất')?'selected':'' ?>>Hoàn tất</option>
                    <option value="Hủy" <?= (isset($_GET['status']) && $_GET['status']=='Hủy')?'selected':'' ?>>Hủy</option>
                </select>
                
                <button class="btn btn-info text-white"><i class="fa-solid fa-magnifying-glass"></i> Lọc</button>
                
                <?php if(isset($_GET['status']) && $_GET['status'] != ''): ?>
                    <a href="index.php?action=booking_list" class="btn btn-outline-secondary">Đặt lại</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th> 
                        <th>Tour & HDV</th>
                        <th>Khách Hàng</th>
                        <th>Tổng phải thu</th> 
                        <th>Đã thu</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($bookings)): ?>
                        <?php foreach($bookings as $b): 
                            // [MỚI] Tính tổng tiền phải thu = Tiền khách + Phát sinh
                            $tongPhaiThu = $b['tong_tien'] + $b['chi_phi_phat_sinh'];
                        ?>
                            <tr>
                                <td>#<?= $b['id'] ?></td>
                                <td>
                                    <div class="fw-bold text-primary"><?= $b['ten_tour'] ?></div>
                                    <small class="text-muted"><i class="fa-solid fa-user-tie"></i> <?= $b['hdv_name'] ?: '<span class="text-danger">Chưa chọn</span>' ?></small>
                                </td>
                                <td>
                                    <div><?= $b['customer_name'] ?></div>
                                    <small class="text-muted"><i class="fa-solid fa-phone"></i> <?= $b['customer_phone'] ?></small>
                                </td>
                                
                                <td class="text-danger fw-bold fs-6"><?= number_format($tongPhaiThu) ?> đ</td>
                                
                                <td class="text-success fw-bold"><?= number_format($b['tien_da_coc']) ?> đ</td>
                                <td>
                                    <?php 
                                        $bg = match($b['status']) { 'Hoàn tất'=>'success', 'Hủy'=>'danger', 'Đã cọc'=>'info', default=>'warning' }; 
                                    ?>
                                    <span class="badge bg-<?= $bg ?>"><?= $b['status'] ?></span>
                                </td>
                                <td>
                                    <a href="index.php?action=booking_detail&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-info" title="Chi tiết"><i class="fa-solid fa-eye"></i></a>
                                    <a href="index.php?action=booking_edit&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="fa-solid fa-pen"></i></a>
                                    <a href="index.php?action=booking_delete&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa booking này?')" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Không tìm thấy dữ liệu booking nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>