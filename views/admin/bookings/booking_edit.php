<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary">Cập nhật Booking #<?= $booking['id'] ?></h3>
        <span class="badge bg-<?= $booking['status']=='Hoàn tất'?'success':($booking['status']=='Hủy'?'danger':'warning') ?> fs-6">
            <?= $booking['status'] ?>
        </span>
    </div>

    <form method="post" id="bookingForm" class="card shadow p-4">
        
        <h5 class="section-title text-info border-bottom pb-2">1. Thông tin Tour & Thời gian</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tour hiện tại</label>
                <input type="text" class="form-control" value="<?= $booking['ten_tour'] ?>" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ngày Khởi Hành</label>
                <input type="date" name="ngay_khoi_hanh" class="form-control" value="<?= $booking['ngay_khoi_hanh'] ?>" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Phương tiện</label>
                <input type="text" name="phuong_tien" class="form-control" value="<?= $booking['phuong_tien'] ?>">
            </div>
            <div class="col-md-12">
                <label class="form-label">Hướng Dẫn Viên</label>
                <select name="hdv_id" class="form-select" required>
                    <?php foreach ($hdvs as $h): ?>
                        <option value="<?= $h['id'] ?>" <?= $h['id'] == $booking['hdv_id'] ? 'selected' : '' ?>>
                            <?= $h['ho_ten'] ?> (<?= $h['loai_hdv'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <h5 class="section-title mt-4 text-info border-bottom pb-2">2. Danh sách Khách</h5>
        <table class="table table-bordered" id="custTable">
            <thead class="table-light"><tr><th>Họ tên</th><th>SĐT</th><th>Tuổi</th><th>Giới tính</th><th>Giá vé (VND)</th><th>#</th></tr></thead>
            <tbody>
                <?php if (!empty($booking['customers'])): ?>
                    <?php foreach ($booking['customers'] as $key => $c): ?>
                    <tr>
                        <td><input type="text" name="customers[<?= $key ?>][name]" class="form-control" value="<?= $c['ho_ten'] ?>" required></td>
                        <td><input type="text" name="customers[<?= $key ?>][phone]" class="form-control" value="<?= $c['so_dien_thoai'] ?>"></td>
                        <td><input type="number" name="customers[<?= $key ?>][age]" class="form-control" value="<?= $c['tuoi'] ?>" style="width:80px"></td>
                        <td>
                            <select name="customers[<?= $key ?>][gender]" class="form-select">
                                <option value="Nam" <?= $c['gioi_tinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                                <option value="Nữ" <?= $c['gioi_tinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                            </select>
                        </td>
                        <td><input type="number" name="customers[<?= $key ?>][price]" class="form-control price-input" value="<?= $c['gia_tien'] ?>"></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm del-row">X</button>
                            <input type="hidden" name="customers[<?= $key ?>][cccd]" value="<?= $c['CCCD'] ?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addCustBtn">+ Thêm hành khách</button>

        <h5 class="section-title mt-4 text-info border-bottom pb-2">3. Thanh toán (Tự động tính toán)</h5>
        <div class="row g-3 bg-light p-3 rounded border">
            <div class="col-md-3">
                <label>Tổng tiền Tour:</label>
                <input type="text" name="tong_tien" id="totalMoney" class="form-control fw-bold" value="<?= $booking['tong_tien'] ?>" readonly>
            </div>
            
            <div class="col-md-3">
                <label>Chi phí phát sinh:</label>
                <input type="number" id="phatSinh" name="chi_phi_phat_sinh" class="form-control" value="<?= $booking['chi_phi_phat_sinh'] ?>">
            </div>

            <div class="col-md-3">
                <label>Đã thanh toán:</label>
                <input type="text" class="form-control bg-white text-success fw-bold" id="paidAmount" 
                       value="<?= number_format($booking['tien_da_coc']) ?>" readonly data-raw="<?= $booking['tien_da_coc'] ?>">
            </div>

            <div class="col-md-3">
                 <label>Cần thanh toán thêm:</label>
                 <input type="text" name="them_coc" id="payMoreInput" class="form-control border-primary fw-bold" value="0">
            </div>
            
            <div class="col-12 text-end">
                <span id="remainText" class="fw-bold text-danger fs-5">
                    CÒN LẠI PHẢI THU: <?= number_format(($booking['tong_tien'] + $booking['chi_phi_phat_sinh']) - $booking['tien_da_coc']) ?> đ
                </span>
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
            <div class="col-md-9">
                <label>Lý do phát sinh:</label>
                <input type="text" name="ly_do_phat_sinh" class="form-control" value="<?= $booking['ly_do_phat_sinh'] ?>">
            </div>
        </div>
        
        <h5 class="section-title mt-4 text-info border-bottom pb-2">4. Lịch trình chi tiết</h5>
<div id="scheduleBox" class="mb-3 border p-3 rounded bg-white" style="max-height: 400px; overflow-y: auto;">
    <?php if(!empty($booking['schedule'])): ?>
        <?php foreach($booking['schedule'] as $i => $d): ?>
            <div class="card mb-3 border-0 bg-light">
                <div class="card-body p-2">
                    <strong class="text-primary">Ngày <?= $d['ngay_thu'] ?>: <?= $d['tieu_de'] ?></strong>
                    <div class="small text-muted mb-2 fst-italic"><?= $d['mo_ta'] ?></div>
                    
                    <?php if(!empty($d['activities'])): ?>
                        <ul class="list-group list-group-flush small">
                            <?php foreach($d['activities'] as $act): ?>
                                <li class="list-group-item bg-transparent py-1 ps-0 border-0">
                                    <span class="badge bg-secondary me-2">
                                        <?= substr($act['thoi_gian_bat_dau'], 0, 5) ?>
                                    </span>
                                    <?= $act['hoat_dong'] ?> 
                                    <?php if($act['dia_diem']): ?>
                                        <span class="text-muted">(@<?= $act['dia_diem'] ?>)</span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted text-center pt-3">Chưa có dữ liệu lịch trình.</p>
    <?php endif; ?>
</div>

        <div class="row">
            <div class="col-md-6"><label>Khách sạn</label><select name="hotel_supplier_id" class="form-select"><option value="">--Chọn--</option><?php foreach($hotels as $h):?><option value="<?=$h['id']?>" <?= $booking['hotel_supplier_id']==$h['id']?'selected':'' ?>><?=$h['name']?></option><?php endforeach;?></select></div>
            <div class="col-md-6"><label>Nhà hàng</label><select name="restaurant_supplier_id" class="form-select"><option value="">--Chọn--</option><?php foreach($restaurants as $r):?><option value="<?=$r['id']?>" <?= $booking['restaurant_supplier_id']==$r['id']?'selected':'' ?>><?=$r['name']?></option><?php endforeach;?></select></div>
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
    const totalMoneyInput = document.getElementById("totalMoney");
    const phatSinhInput = document.getElementById("phatSinh");
    const paidInput = document.getElementById("paidAmount");
    const remainText = document.getElementById("remainText");

    let idx = 1000; 
    document.getElementById("addCustBtn").addEventListener("click", function(){
        const row = custTable.insertRow();
        row.innerHTML = `<td><input type="text" name="customers[${idx}][name]" class="form-control" required></td>
            <td><input type="text" name="customers[${idx}][phone]" class="form-control"></td>
            <td><input type="number" name="customers[${idx}][age]" class="form-control" required></td>
            <td><select name="customers[${idx}][gender]" class="form-select"><option>Nam</option><option>Nữ</option></select></td>
            <td><input type="number" name="customers[${idx}][price]" class="form-control price-input" value="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm del-row">X</button></td>`;
        idx++;
        updateTotal();
    });

    custTable.addEventListener("click", function(e){ if(e.target.classList.contains("del-row")){ e.target.closest("tr").remove(); updateTotal(); } });
    custTable.addEventListener("input", function(e){ if(e.target.classList.contains("price-input")) updateTotal(); });

    function updateTotal(){
        let sum = 0;
        document.querySelectorAll(".price-input").forEach(el => { let val = Number(el.value); if(!isNaN(val)) sum += val; });
        totalMoneyInput.value = sum;
        updateRemain();
    }
    
    phatSinhInput.addEventListener("input", updateRemain);

    function formatNumber(num) { return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }

    function updateRemain() {
        const total = parseFloat(totalMoneyInput.value) || 0;
        const ps = parseFloat(phatSinhInput.value) || 0;
        const paid = parseFloat(paidInput.dataset.raw) || 0;
        const remain = (total + ps) - paid;
        
        remainText.innerText = "CÒN LẠI PHẢI THU: " + formatNumber(remain) + " đ";
    }
});
</script>
<?php include PATH_VIEW . 'layouts/footer.php'; ?>