<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary">Cập nhật Booking #<?= $booking['id'] ?></h3>
        <span class="badge bg-<?= $booking['status']=='Hoàn tất'?'success':($booking['status']=='Hủy'?'danger':'warning') ?> fs-6">
            <?= $booking['status'] ?>
        </span>
    </div>

    <?php if (isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

    <form method="post" id="bookingForm" class="card shadow p-4">
        
        <h5 class="section-title text-info border-bottom pb-2">1. Thông tin Tour & Thời gian</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tour hiện tại</label>
                <select name="tour_id" id="tourSelect" class="form-select bg-light" readonly style="pointer-events: none;">
                    <?php foreach ($tours as $t): ?>
                        <option value="<?= $t['id'] ?>" 
                            <?= $t['id'] == $booking['tour_id'] ? 'selected' : '' ?>
                            data-type="<?= $t['loai_tour'] ?>" 
                            data-price="<?= $t['gia_tour'] ?>">
                            <?= $t['ten_tour'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="tour_id" value="<?= $booking['tour_id'] ?>">
                <input type="hidden" name="tour_type" value="<?= $booking['loai_tour'] ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Ngày Khởi Hành</label>
                <input type="date" name="ngay_khoi_hanh" class="form-control" value="<?= $booking['ngay_khoi_hanh'] ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Hướng Dẫn Viên</label>
                <select name="hdv_id" class="form-select" required>
                    <?php foreach ($hdvs as $h): ?>
                        <option value="<?= $h['id'] ?>" <?= $h['id'] == $booking['hdv_id'] ? 'selected' : '' ?>>
                            <?= $h['ho_ten'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <h5 class="section-title mt-4 text-info border-bottom pb-2">2. Thông tin Người đặt & Danh sách Khách</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label>Tên người đặt</label>
                <input type="text" name="customer_name" id="mainName" class="form-control" value="<?= $booking['customer_name'] ?>" required>
            </div>
            <div class="col-md-6">
                <label>SĐT liên hệ</label>
                <input type="text" name="customer_phone" id="mainPhone" class="form-control" value="<?= $booking['customer_phone'] ?>" required>
            </div>
        </div>
        
        <table class="table table-bordered" id="custTable">
            <thead class="table-light">
                <tr><th>Họ tên</th><th>Tuổi</th><th>Giới tính</th><th>CCCD</th><th>Giá vé (VND)</th><th>#</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($booking['customers'])): ?>
                    <?php foreach ($booking['customers'] as $key => $c): ?>
                    <tr>
                        <td><input type="text" name="customers[<?= $key ?>][name]" class="form-control" value="<?= $c['ho_ten'] ?>" required></td>
                        <td><input type="number" name="customers[<?= $key ?>][age]" class="form-control" value="<?= $c['tuoi'] ?>" required></td>
                        <td>
                            <select name="customers[<?= $key ?>][gender]" class="form-select">
                                <option value="Nam" <?= $c['gioi_tinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                                <option value="Nữ" <?= $c['gioi_tinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                            </select>
                        </td>
                        <td><input type="text" name="customers[<?= $key ?>][cccd]" class="form-control" value="<?= $c['CCCD'] ?>"></td>
                        <td><input type="number" name="customers[<?= $key ?>][price]" class="form-control price-input" value="<?= $c['gia_tien'] ?>"></td>
                        <td>
                            <?php if($key == 0): ?>
                                <span class="badge bg-secondary">Trưởng đoàn</span>
                            <?php else: ?>
                                <button type="button" class="btn btn-danger btn-sm del-row">X</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addCustBtn">+ Thêm hành khách</button>

        <h5 class="section-title mt-4 text-info border-bottom pb-2">3. Tài chính & Trạng thái</h5>
        <div class="row g-3 bg-light p-3 rounded border">
            <div class="col-md-3">
                <label>Tổng số khách:</label>
                <input type="text" name="so_luong" id="totalPax" class="form-control fw-bold" value="<?= $booking['so_luong'] ?>" readonly>
            </div>
            <div class="col-md-3">
                <label class="text-danger fw-bold">TỔNG TIỀN TOUR:</label>
                <input type="text" name="tong_tien" id="totalMoney" class="form-control fw-bold text-danger" value="<?= $booking['tong_tien'] ?>" readonly>
            </div>
            
            <div class="col-md-3">
                <label>Đã thanh toán (Lịch sử):</label>
                <input type="text" class="form-control bg-white" value="<?= number_format($booking['tien_da_coc']) ?>" readonly>
            </div>

            <div class="col-md-3">
                <label class="text-success fw-bold">Thanh toán thêm (nếu có):</label>
                <input type="number" name="them_coc" class="form-control border-success" placeholder="Nhập số tiền..." value="0">
            </div>

            <div class="col-md-3">
                <label>Trạng thái:</label>
                <select name="status" class="form-select">
                    <option value="Chờ xử lý" <?= $booking['status']=='Chờ xử lý'?'selected':'' ?>>Chờ xử lý</option>
                    <option value="Đã cọc" <?= $booking['status']=='Đã cọc'?'selected':'' ?>>Đã cọc</option>
                    <option value="Hoàn tất" <?= $booking['status']=='Hoàn tất'?'selected':'' ?>>Hoàn tất</option>
                    <option value="Hủy" <?= $booking['status']=='Hủy'?'selected':'' ?>>Hủy</option>
                </select>
            </div>
            <div class="col-md-5">
                <label>Chi phí phát sinh:</label>
                <input type="number" name="chi_phi_phat_sinh" class="form-control" value="<?= $booking['chi_phi_phat_sinh'] ?>">
            </div>
            <div class="col-md-4">
                <label>Lý do phát sinh:</label>
                <input type="text" name="ly_do_phat_sinh" class="form-control" value="<?= $booking['ly_do_phat_sinh'] ?>">
            </div>
        </div>

        <h5 class="section-title mt-4 text-info border-bottom pb-2">
            4. Lịch trình chi tiết 
            <?php if($booking['loai_tour'] == 'Theo yêu cầu'): ?>
                <span class="badge bg-success">Tour Theo Yêu Cầu (Được phép sửa)</span>
            <?php else: ?>
                <span class="badge bg-secondary">Tour Cố Định (Chỉ xem)</span>
            <?php endif; ?>
        </h5>
        
        <div id="scheduleBox" class="mb-3 border p-3 rounded bg-white">
            <?php if(!empty($booking['schedule'])): ?>
                <?php foreach($booking['schedule'] as $i => $d): ?>
                    <div class="mb-4 border-bottom pb-3">
                        <div class="d-flex align-items-center mb-2 bg-light p-2">
                            <strong class="text-primary me-2">Ngày <?= $d['ngay_thu'] ?>:</strong>
                            <?php if($booking['loai_tour'] == 'Theo yêu cầu'): ?>
                                <input type="text" name="schedule[<?= $i ?>][tieu_de]" class="form-control form-control-sm w-50" value="<?= $d['tieu_de'] ?>">
                            <?php else: ?>
                                <span><?= $d['tieu_de'] ?></span>
                                <input type="hidden" name="schedule[<?= $i ?>][tieu_de]" value="<?= $d['tieu_de'] ?>">
                            <?php endif; ?>
                            <input type="hidden" name="schedule[<?= $i ?>][ngay_thu]" value="<?= $d['ngay_thu'] ?>">
                        </div>

                        <div class="mb-2 ps-2">
                            <label class="small text-muted">Mô tả:</label>
                            <?php if($booking['loai_tour'] == 'Theo yêu cầu'): ?>
                                <textarea name="schedule[<?= $i ?>][mo_ta]" class="form-control"><?= $d['mo_ta'] ?></textarea>
                            <?php else: ?>
                                <p class="mb-0 text-muted fst-italic"><?= $d['mo_ta'] ?></p>
                                <input type="hidden" name="schedule[<?= $i ?>][mo_ta]" value="<?= $d['mo_ta'] ?>">
                            <?php endif; ?>
                        </div>

                        <div class="ps-2">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width:15%">Bắt đầu</th>
                                        <th style="width:15%">Kết thúc</th>
                                        <th style="width:40%">Hoạt động</th>
                                        <th style="width:30%">Địa điểm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($d['activities'])): ?>
                                        <?php foreach($d['activities'] as $j => $act): ?>
                                            <tr>
                                                <td>
                                                    <?php if($booking['loai_tour'] == 'Theo yêu cầu'): ?>
                                                        <input type="time" name="schedule[<?= $i ?>][activities][<?= $j ?>][start]" class="form-control form-control-sm" value="<?= $act['thoi_gian_bat_dau'] ?>">
                                                    <?php else: ?>
                                                        <?= substr($act['thoi_gian_bat_dau'], 0, 5) ?>
                                                        <input type="hidden" name="schedule[<?= $i ?>][activities][<?= $j ?>][start]" value="<?= $act['thoi_gian_bat_dau'] ?>">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($booking['loai_tour'] == 'Theo yêu cầu'): ?>
                                                        <input type="time" name="schedule[<?= $i ?>][activities][<?= $j ?>][end]" class="form-control form-control-sm" value="<?= $act['thoi_gian_ket_thuc'] ?>">
                                                    <?php else: ?>
                                                        <?= substr($act['thoi_gian_ket_thuc'], 0, 5) ?>
                                                        <input type="hidden" name="schedule[<?= $i ?>][activities][<?= $j ?>][end]" value="<?= $act['thoi_gian_ket_thuc'] ?>">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($booking['loai_tour'] == 'Theo yêu cầu'): ?>
                                                        <input type="text" name="schedule[<?= $i ?>][activities][<?= $j ?>][action]" class="form-control form-control-sm" value="<?= $act['hoat_dong'] ?>">
                                                    <?php else: ?>
                                                        <?= $act['hoat_dong'] ?>
                                                        <input type="hidden" name="schedule[<?= $i ?>][activities][<?= $j ?>][action]" value="<?= $act['hoat_dong'] ?>">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($booking['loai_tour'] == 'Theo yêu cầu'): ?>
                                                        <input type="text" name="schedule[<?= $i ?>][activities][<?= $j ?>][place]" class="form-control form-control-sm" value="<?= $act['dia_diem'] ?>">
                                                    <?php else: ?>
                                                        <?= $act['dia_diem'] ?>
                                                        <input type="hidden" name="schedule[<?= $i ?>][activities][<?= $j ?>][place]" value="<?= $act['dia_diem'] ?>">
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center small text-muted">Không có hoạt động chi tiết</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted text-center">Chưa có dữ liệu lịch trình.</p>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Khách sạn</label>
                <select name="hotel_supplier_id" class="form-select">
                    <option value="">--Chọn--</option>
                    <?php foreach($hotels as $h):?>
                        <option value="<?=$h['id']?>" <?= $booking['hotel_supplier_id']==$h['id']?'selected':'' ?>>
                            <?=$h['name']?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-6">
                <label>Nhà hàng</label>
                <select name="restaurant_supplier_id" class="form-select">
                    <option value="">--Chọn--</option>
                    <?php foreach($restaurants as $r):?>
                        <option value="<?=$r['id']?>" <?= $booking['restaurant_supplier_id']==$r['id']?'selected':'' ?>>
                            <?=$r['name']?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-warning btn-lg px-5">CẬP NHẬT BOOKING</button>
            <a href="index.php?action=booking_list" class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const custTable = document.getElementById("custTable").querySelector("tbody");
    
    // Đếm số lượng khách hiện tại để tạo index tiếp theo
    let idx = <?= count($booking['customers']) ?>;

    // Thêm khách
    document.getElementById("addCustBtn").addEventListener("click", function(){
        const row = custTable.insertRow();
        row.innerHTML = `
            <td><input type="text" name="customers[${idx}][name]" class="form-control" required></td>
            <td><input type="number" name="customers[${idx}][age]" class="form-control" required></td>
            <td><select name="customers[${idx}][gender]" class="form-select"><option>Nam</option><option>Nữ</option></select></td>
            <td><input type="text" name="customers[${idx}][cccd]" class="form-control"></td>
            <td><input type="number" name="customers[${idx}][price]" class="form-control price-input" value="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm del-row">X</button></td>
        `;
        idx++;
        updateTotal(); 
    });

    // Xóa khách & Update Tổng
    custTable.addEventListener("click", function(e){
        if(e.target.classList.contains("del-row")){ 
            if(confirm("Bạn muốn xóa khách này khỏi danh sách?")) {
                e.target.closest("tr").remove(); 
                updateTotal(); 
            }
        }
    });

    // Tự động tính tiền khi sửa giá vé
    custTable.addEventListener("input", function(e){
        if(e.target.classList.contains("price-input")) updateTotal();
    });

    // Đồng bộ tên người đặt chính vào dòng đầu tiên (chỉ nếu dòng đầu tồn tại)
    const mainNameInput = document.getElementById("mainName");
    const firstRowName = document.querySelector("input[name='customers[0][name]']");
    if(mainNameInput && firstRowName) {
        mainNameInput.addEventListener("input", function(){
            firstRowName.value = this.value;
        });
    }

    function updateTotal(){
        let sum = 0, count = 0;
        document.querySelectorAll(".price-input").forEach(el => {
            let val = Number(el.value);
            if(!isNaN(val)) {
                sum += val;
                count++;
            }
        });
        document.getElementById("totalMoney").value = sum;
        document.getElementById("totalPax").value = count;
    }
});
</script>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>