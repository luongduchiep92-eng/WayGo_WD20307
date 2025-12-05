<?php include PATH_VIEW . 'layouts/header.php'; 
    $active_session_id = $_GET['session_id'] ?? null;
?>

<div class="container-fluid mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Check-in: <?= $booking['ten_tour'] ?></h3>
            <p class="text-muted mb-0">
                <i class="fa-regular fa-calendar me-1"></i> <?= !empty($booking['ngay_khoi_hanh']) ? date('d/m/Y', strtotime($booking['ngay_khoi_hanh'])) : 'Chưa xác định' ?> 
                <span class="mx-2">|</span> Booking ID: #<?= $booking['id'] ?>
            </p>
        </div>
        <a href="index.php?action=checkin_list" class="btn btn-secondary shadow-sm"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card card-modern mb-3 shadow-sm h-100">
                <div class="card-header bg-light fw-bold text-dark border-bottom">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i> Lịch sử điểm danh
                </div>
                
                <div class="list-group list-group-flush flex-grow-1 overflow-auto" style="max-height: 400px;">
                    <?php if(!empty($sessions)): ?>
                        <?php foreach($sessions as $ss): 
                            $isActive = ($active_session_id == $ss['id']);
                            $bgClass = $isActive ? 'bg-primary text-white' : 'bg-white text-dark';
                            $textMuted = $isActive ? 'text-white-50' : 'text-muted';
                        ?>
                            <div class="list-group-item p-0 d-flex align-items-stretch border-bottom <?= $isActive ? 'border-primary' : '' ?>">
                                <a href="index.php?action=checkin_perform&id=<?= $booking['id'] ?>&session_id=<?= $ss['id'] ?>" 
                                   class="flex-grow-1 p-3 text-decoration-none <?= $bgClass ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <strong class="mb-1 text-truncate" style="max-width: 130px;"><?= htmlspecialchars($ss['title']) ?></strong>
                                        <?php if($isActive): ?><i class="fa-solid fa-caret-right"></i><?php endif; ?>
                                    </div>
                                    <small class="<?= $textMuted ?>"><?= date('H:i - d/m/Y', strtotime($ss['created_at'])) ?></small>
                                </a>

                                <a href="index.php?action=checkin_delete_session&session_id=<?= $ss['id'] ?>&booking_id=<?= $booking['id'] ?>" 
                                   class="btn btn-link text-danger d-flex align-items-center border-start px-3 text-decoration-none" 
                                   style="border-radius: 0;"
                                   onclick="return confirm('CẢNH BÁO: Bạn chắc chắn muốn XÓA phiên điểm danh này?\n\nDữ liệu check-in của khách trong phiên này sẽ mất hết!')"
                                   title="Xóa phiên này">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-regular fa-folder-open fa-2x mb-2 opacity-50"></i>
                            <p class="small mb-0">Chưa có dữ liệu.</p>
                            <p class="small">Hãy tạo lần điểm danh đầu tiên!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-3 border-top bg-white mt-auto">
                    <button class="btn btn-outline-primary w-100 fw-bold dashed-border" type="button" data-bs-toggle="collapse" data-bs-target="#newSessionForm">
                        <i class="fa-solid fa-plus-circle me-1"></i> THÊM MỚI
                    </button>
                    <div class="collapse mt-2" id="newSessionForm">
                        <form method="POST" action="index.php?action=checkin_create_session">
                            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                            <div class="input-group">
                                <input type="text" name="title" class="form-control form-control-sm" placeholder="VD: Sân bay..." required>
                                <button class="btn btn-primary btn-sm"><i class="fa-solid fa-save"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <?php if($active_session_id): ?>
                
                <div class="row g-2 mb-3 text-center">
                    <div class="col"><div class="p-2 border rounded bg-white"><h4 class="fw-bold text-primary mb-0"><?= $stats['total'] ?></h4><small class="text-muted">Tổng</small></div></div>
                    <div class="col"><div class="p-2 border rounded bg-success-subtle"><h4 class="fw-bold text-success mb-0" id="stat-present"><?= $stats['present'] ?></h4><small class="text-success fw-bold">Có mặt</small></div></div>
                    <div class="col"><div class="p-2 border rounded bg-warning-subtle"><h4 class="fw-bold text-warning mb-0" id="stat-late"><?= $stats['late'] ?></h4><small class="text-warning fw-bold">Muộn</small></div></div>
                    <div class="col"><div class="p-2 border rounded bg-danger-subtle"><h4 class="fw-bold text-danger mb-0" id="stat-absent"><?= $stats['absent'] ?></h4><small class="text-danger fw-bold">Vắng</small></div></div>
                    <div class="col"><div class="p-2 border rounded bg-light"><h4 class="fw-bold text-secondary mb-0" id="stat-pending"><?= $stats['pending'] ?></h4><small class="text-muted">Chưa check</small></div></div>
                </div>

                <div class="card card-modern shadow-sm">
                    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Danh sách khách hàng</span>
                        <a href="index.php?action=checkin_all&id=<?= $booking['id'] ?>&session_id=<?= $active_session_id ?>" class="btn btn-success btn-sm fw-bold shadow-sm" onclick="return confirm('Bạn có chắc chắn muốn đánh dấu TẤT CẢ là CÓ MẶT? (Sẽ ghi đè trạng thái cũ)')">
                            <i class="fa-solid fa-check-double"></i> Tất cả có mặt
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th width="5%">STT</th>
                                        <th width="25%">Khách hàng</th>
                                        <th width="40%" class="text-center">Trạng thái</th>
                                        <th width="30%">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($customers)): ?>
                                        <?php foreach($customers as $i => $c): ?>
                                        <tr id="row-<?= $c['id'] ?>" class="<?= $c['status']=='Vắng mặt' ? 'table-danger' : '' ?>">
                                            <td class="text-center fw-bold text-muted"><?= $i + 1 ?></td>
                                            <td>
                                                <div class="fw-bold text-dark"><?= $c['ho_ten'] ?></div>
                                                <div class="small text-muted">
                                                    <?= $c['gioi_tinh'] ?>, <?= $c['tuoi'] ?>t 
                                                    <?php if($c['so_dien_thoai']): ?> | <i class="fa-solid fa-phone fa-xs"></i> <?= $c['so_dien_thoai'] ?><?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <input type="radio" class="btn-check status-radio" name="status_<?= $c['id'] ?>" id="p_<?= $c['id'] ?>" value="Có mặt" data-id="<?= $c['id'] ?>" <?= $c['status']=='Có mặt'?'checked':'' ?>>
                                                    <label class="btn btn-outline-success btn-sm fw-bold" for="p_<?= $c['id'] ?>">Có mặt</label>

                                                    <input type="radio" class="btn-check status-radio" name="status_<?= $c['id'] ?>" id="l_<?= $c['id'] ?>" value="Đến muộn" data-id="<?= $c['id'] ?>" <?= $c['status']=='Đến muộn'?'checked':'' ?>>
                                                    <label class="btn btn-outline-warning btn-sm fw-bold" for="l_<?= $c['id'] ?>">Muộn</label>

                                                    <input type="radio" class="btn-check status-radio" name="status_<?= $c['id'] ?>" id="a_<?= $c['id'] ?>" value="Vắng mặt" data-id="<?= $c['id'] ?>" <?= $c['status']=='Vắng mặt'?'checked':'' ?>>
                                                    <label class="btn btn-outline-danger btn-sm fw-bold" for="a_<?= $c['id'] ?>">Vắng</label>
                                                </div>
                                                <div class="text-center mt-1">
                                                    <small class="text-muted fst-italic time-log" style="font-size: 0.75rem;">
                                                        <?= $c['checkin_time'] ? '<i class="fa-regular fa-clock"></i> '.date('H:i d/m', strtotime($c['checkin_time'])) : '' ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control note-input" data-id="<?= $c['id'] ?>" value="<?= htmlspecialchars($c['note'] ?? '') ?>" placeholder="Ghi chú...">
                                                    <button class="btn btn-outline-secondary btn-save-note" type="button" data-id="<?= $c['id'] ?>"><i class="fa-solid fa-save"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center py-4 text-muted">Chưa có khách hàng nào.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-info text-center py-5">
                    <i class="fa-solid fa-clipboard-list fa-3x mb-3"></i>
                    <h4>Chưa chọn điểm danh nào</h4>
                    <p>Vui lòng chọn một điểm check-in bên trái hoặc tạo mới.</p>
                </div>
            <?php endif; ?>
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
            const checkedRadio = document.querySelector(`input[name="status_${id}"]:checked`);
            const status = checkedRadio ? checkedRadio.value : 'Chưa checkin'; // Mặc định nếu chưa chọn
            updateStatus(id, status, input.value);
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
                // Hiệu ứng visual báo thành công
                const now = new Date();
                const timeString = now.getHours() + ':' + (now.getMinutes()<10?'0':'') + now.getMinutes() + ' ' + now.getDate() + '/' + (now.getMonth()+1);
                
                // Cập nhật giờ checkin ngay lập tức
                const timeLog = document.querySelector(`#row-${id} .time-log`);
                if(timeLog) timeLog.innerHTML = '<i class="fa-regular fa-clock"></i> ' + timeString;
                
                // Nếu là lưu ghi chú thì alert nhẹ
                if(note !== null) alert("Đã lưu ghi chú!");
            } else {
                alert("Có lỗi xảy ra, vui lòng thử lại!");
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>