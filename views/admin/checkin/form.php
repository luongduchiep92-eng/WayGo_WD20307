<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Check-in: <?= $booking['ten_tour'] ?></h3>
            <p class="text-muted mb-0">Ngày: <?= date('d/m/Y', strtotime($booking['ngay_khoi_hanh'])) ?> | Booking ID: #<?= $booking['id'] ?></p>
        </div>
        <div>
            <a href="index.php?action=checkin_all&id=<?= $booking['id'] ?>" class="btn btn-success me-2 fw-bold shadow-sm" onclick="return confirm('Xác nhận đánh dấu TẤT CẢ khách chưa check-in thành CÓ MẶT?')">
                <i class="fa-solid fa-check-double"></i> Tất cả có mặt
            </a>
            <a href="index.php?action=checkin_list" class="btn btn-secondary shadow-sm">Quay lại</a>
        </div>
    </div>

    <div class="row g-3 mb-4 text-center">
        <div class="col">
            <div class="p-3 border rounded bg-white shadow-sm h-100">
                <h3 class="fw-bold mb-0 text-primary" id="count-total"><?= $stats['total'] ?></h3>
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Tổng khách</small>
            </div>
        </div>
        <div class="col">
            <div class="p-3 border rounded bg-success-subtle h-100">
                <h3 class="fw-bold mb-0 text-success" id="count-present"><?= $stats['present'] ?></h3>
                <small class="text-success fw-bold text-uppercase" style="font-size: 0.7rem;">Có mặt</small>
            </div>
        </div>
        <div class="col">
            <div class="p-3 border rounded bg-warning-subtle h-100">
                <h3 class="fw-bold mb-0 text-warning" id="count-late"><?= $stats['late'] ?></h3>
                <small class="text-warning fw-bold text-uppercase" style="font-size: 0.7rem;">Đến muộn</small>
            </div>
        </div>
        <div class="col">
            <div class="p-3 border rounded bg-danger-subtle h-100">
                <h3 class="fw-bold mb-0 text-danger" id="count-absent"><?= $stats['absent'] ?></h3>
                <small class="text-danger fw-bold text-uppercase" style="font-size: 0.7rem;">Vắng mặt</small>
            </div>
        </div>
        <div class="col">
            <div class="p-3 border rounded bg-secondary-subtle h-100">
                <h3 class="fw-bold mb-0 text-secondary" id="count-pending"><?= $stats['pending'] ?></h3>
                <small class="text-secondary fw-bold text-uppercase" style="font-size: 0.7rem;">Chưa đến</small>
            </div>
        </div>
    </div>

    <div class="card card-modern shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="20%">Khách hàng</th>
                            <th width="15%">Liên hệ</th>
                            <th width="35%">Trạng thái</th>
                            <th width="25%">Ghi chú / Lý do</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($customers)): ?>
                            <?php foreach($customers as $i => $c): ?>
                            <tr id="row-<?= $c['id'] ?>" class="<?= $c['checkin_status']=='Vắng mặt' ? 'table-danger' : '' ?>">
                                <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                                
                                <td>
                                    <div class="fw-bold text-primary"><?= $c['ho_ten'] ?></div>
                                    <div class="small text-muted">
                                        <span class="badge bg-light text-dark border"><?= $c['gioi_tinh'] ?></span>
                                        <?= $c['tuoi'] ?> tuổi
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <?php if($c['so_dien_thoai']): ?>
                                        <div class="fw-bold text-dark mb-2"><?= $c['so_dien_thoai'] ?></div>
                                        <div class="btn-group btn-group-sm">
                                            <a href="tel:<?= $c['so_dien_thoai'] ?>" class="btn btn-outline-success" title="Gọi điện"><i class="fa-solid fa-phone"></i></a>
                                            <a href="https://zalo.me/<?= $c['so_dien_thoai'] ?>" target="_blank" class="btn btn-outline-primary fw-bold" title="Chat Zalo">Zalo</a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">Không có SĐT</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="py-3 bg-light">
                                    <div class="d-flex justify-content-center gap-2 mb-2">
                                        <input type="radio" class="btn-check status-radio" name="status_<?= $c['id'] ?>" id="p_<?= $c['id'] ?>" 
                                               value="Có mặt" data-id="<?= $c['id'] ?>" <?= $c['checkin_status']=='Có mặt'?'checked':'' ?>>
                                        <label class="btn btn-outline-success btn-sm fw-bold" for="p_<?= $c['id'] ?>">Có mặt</label>

                                        <input type="radio" class="btn-check status-radio" name="status_<?= $c['id'] ?>" id="l_<?= $c['id'] ?>" 
                                               value="Đến muộn" data-id="<?= $c['id'] ?>" <?= $c['checkin_status']=='Đến muộn'?'checked':'' ?>>
                                        <label class="btn btn-outline-warning btn-sm fw-bold" for="l_<?= $c['id'] ?>">Muộn</label>

                                        <input type="radio" class="btn-check status-radio" name="status_<?= $c['id'] ?>" id="a_<?= $c['id'] ?>" 
                                               value="Vắng mặt" data-id="<?= $c['id'] ?>" <?= $c['checkin_status']=='Vắng mặt'?'checked':'' ?>>
                                        <label class="btn btn-outline-danger btn-sm fw-bold" for="a_<?= $c['id'] ?>">Vắng</label>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted fst-italic time-log" style="font-size: 0.8rem;">
                                            <?= $c['checkin_time'] ? '<i class="fa-regular fa-clock"></i> '.date('H:i d/m', strtotime($c['checkin_time'])) : '' ?>
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control note-input" data-id="<?= $c['id'] ?>" 
                                               value="<?= $c['checkin_note'] ?>" placeholder="Lý do vắng/muộn...">
                                        <button class="btn btn-outline-primary btn-save-note" type="button" data-id="<?= $c['id'] ?>" title="Lưu ghi chú"><i class="fa-solid fa-floppy-disk"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-4">Chưa có dữ liệu khách hàng.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    
    // Xử lý đổi trạng thái
    const radios = document.querySelectorAll('.status-radio');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const status = this.value;
            const row = document.getElementById('row-' + id);
            
            // Đổi màu dòng nếu vắng
            if(status === 'Vắng mặt') row.classList.add('table-danger');
            else row.classList.remove('table-danger');

            updateStatus(id, status);
        });
    });

    // Xử lý lưu ghi chú
    const noteBtns = document.querySelectorAll('.btn-save-note');
    noteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const input = document.querySelector(`.note-input[data-id="${id}"]`);
            // Lấy trạng thái hiện tại (nếu chưa chọn thì mặc định 'Chưa checkin')
            const checkedRadio = document.querySelector(`input[name="status_${id}"]:checked`);
            const status = checkedRadio ? checkedRadio.value : 'Chưa checkin';
            
            updateStatus(id, status, input.value);
            alert('Đã lưu ghi chú thành công!');
        });
    });

    function updateStatus(id, status, note = null) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', status);
        if(note !== null) formData.append('note', note);

        fetch('index.php?action=checkin_ajax_update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Cập nhật giờ hiển thị ngay lập tức trên giao diện
                const now = new Date();
                const timeString = now.getHours() + ':' + (now.getMinutes()<10?'0':'') + now.getMinutes();
                const dayString = now.getDate() + '/' + (now.getMonth()+1);
                document.querySelector(`#row-${id} .time-log`).innerHTML = '<i class="fa-regular fa-clock"></i> ' + timeString + ' ' + dayString;
                location.reload(); 
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>