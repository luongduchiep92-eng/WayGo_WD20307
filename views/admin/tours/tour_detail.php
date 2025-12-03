<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<style>
    /* CSS Riêng cho trang chi tiết Tour */
    .tour-hero {
        position: relative;
        height: 300px;
        border-radius: 15px;
        overflow: hidden;
        background-color: #333;
        margin-bottom: 30px;
    }
    .tour-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.7;
    }
    .tour-hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 30px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
    }
    .timeline-step {
        position: relative;
        padding-left: 40px;
        margin-bottom: 30px;
    }
    .timeline-step::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: -30px;
        width: 2px;
        background: #e3e6f0;
    }
    .timeline-step:last-child::before { display: none; }
    .timeline-point {
        position: absolute;
        left: 0;
        top: 0;
        width: 22px;
        height: 22px;
        background: #4e73df;
        border: 4px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.2);
    }
    .activity-item {
        background: #f8f9fc;
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-left: 3px solid #36b9cc;
    }
    .gallery-img {
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .gallery-img:hover { transform: scale(1.05); }
</style>

<div class="container-fluid">
    
    <div class="tour-hero shadow">
        <?php 
            // Lấy ảnh đầu tiên làm ảnh nền, nếu không có dùng ảnh placeholder
            $bgImage = !empty($tour->images) ? $tour->images[0]->image_path : 'https://placehold.co/1200x400?text=No+Image';
        ?>
        <img src="<?= $bgImage ?>" alt="Tour Background">
        <div class="tour-hero-content">
            <div class="d-flex justify-content-between align-items-end">
                <div>
                    <span class="badge bg-warning text-dark mb-2"><i class="fa-solid fa-star"></i> <?= $tour->loai_tour ?></span>
                    <h1 class="fw-bold mb-1"><?= $tour->ten_tour ?></h1>
                    <p class="mb-0 text-white-50"><i class="fa-solid fa-location-dot"></i> <?= $tour->dia_diem ?></p>
                </div>
                <div class="text-end">
                    <h2 class="text-warning fw-bold mb-0"><?= number_format($tour->gia_tour) ?> VNĐ</h2>
                    <span class="text-white-50 small">/ khách</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            
            <div class="card card-modern mb-4" style="height: auto !important; min-height: 0;">
            <div class="card-header bg-white fw-bold text-primary"><i class="fa-solid fa-circle-info"></i> Giới thiệu tour</div>
                <div class="card-body text-secondary" style="line-height: 1.6;">
                    <?= nl2br($tour->mo_ta) ?>
                </div>
            </div>

            <div class="card card-modern mb-4" style="height: auto !important; min-height: 0;">
            <div class="card-header bg-white fw-bold text-primary"><i class="fa-solid fa-route"></i> Lịch trình chi tiết</div>
                <div class="card-body">
                    <?php if(!empty($schedule)): ?>
                        <?php foreach($schedule as $day): ?>
                            <div class="timeline-step">
                                <div class="timeline-point"></div>
                                <h5 class="fw-bold text-dark">Ngày <?= $day->ngay_thu ?>: <?= $day->tieu_de ?></h5>
                                <p class="text-muted fst-italic mb-3"><?= nl2br($day->mo_ta) ?></p>
                                
                                <?php if(!empty($day->activities)): ?>
                                    <div class="ms-2">
                                        <?php foreach($day->activities as $act): ?>
                                            <div class="activity-item">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bold text-info">
                                                        <i class="fa-regular fa-clock"></i> 
                                                        <?= substr($act->thoi_gian_bat_dau, 0, 5) ?> - <?= substr($act->thoi_gian_ket_thuc, 0, 5) ?>
                                                    </span>
                                                    <?php if($act->dia_diem): ?>
                                                        <span class="text-muted small"><i class="fa-solid fa-map-pin"></i> <?= $act->dia_diem ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mt-1"><?= $act->hoat_dong ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">Chưa cập nhật lịch trình.</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card card-modern mb-4" style="height: auto !important; min-height: 0;">
            <div class="card-header bg-white fw-bold text-primary"><i class="fa-solid fa-images"></i> Thư viện ảnh</div>
                <div class="card-body">
                    <?php if(!empty($tour->images)): ?>
                        <div class="row g-2">
                            <?php foreach($tour->images as $img): ?>
                                <div class="col-md-3 col-6">
                                    <img src="<?= $img->image_path ?>" class="img-fluid gallery-img w-100 border" alt="Tour Image">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">Chưa có hình ảnh nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-modern mb-4 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-primary text-white fw-bold text-center">THÔNG TIN TÓM TẮT</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="fa-regular fa-calendar"></i> Khởi hành:</span>
                            <span class="fw-bold"><?= date('d/m/Y', strtotime($tour->ngay_khoi_hanh)) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="fa-solid fa-hourglass-half"></i> Thời gian:</span>
                            <span class="fw-bold"><?= $tour->thoi_gian ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="fa-solid fa-plane"></i> Phương tiện:</span>
                            <span class="fw-bold"><?= $tour->phuong_tien ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="fa-solid fa-users"></i> Số chỗ:</span>
                            <span class="fw-bold"><?= $tour->so_nguoi_toi_da ?> khách</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Trạng thái:</span>
                            <span class="badge bg-<?= $tour->status=='Hoạt động'?'success':'danger' ?>"><?= $tour->status ?></span>
                        </li>
                    </ul>

                    <div class="d-grid gap-2">
                        <a href="index.php?action=tour_edit&id=<?= $tour->id ?>" class="btn btn-warning fw-bold"><i class="fa-solid fa-pen-to-square"></i> Cập nhật Tour</a>
                        <a href="index.php?action=tour_list" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Quay lại danh sách</a>
                        <button class="btn btn-outline-danger btn-sm mt-2" onclick="return confirm('Bạn có chắc muốn xóa tour này?') ? window.location.href='index.php?action=tour_delete&id=<?= $tour->id ?>' : false;">
                            <i class="fa-solid fa-trash"></i> Xóa Tour này
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>