<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<div class="container-fluid">
    <div class="card card-modern mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold text-primary mb-1"><?= $tour->ten_tour ?></h2>
                    <div class="mb-2">
                        <span class="badge bg-warning text-dark me-2"><i class="fa-solid fa-star"></i> <?= $tour->loai_tour ?></span>
                        <span class="badge bg-<?= $tour->status=='Hoạt động'?'success':'danger' ?>"><?= $tour->status ?></span>
                    </div>
                    <p class="text-muted mb-0"><i class="fa-solid fa-location-dot text-danger"></i> <?= $tour->dia_diem ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <h3 class="text-success fw-bold"><?= number_format($tour->gia_tour) ?> VNĐ</h3>
                    <p class="small text-muted">/ khách</p>
                    <div>
                        <a href="index.php?action=tour_edit&id=<?= $tour->id ?>" class="btn btn-warning btn-sm fw-bold"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
                        <a href="index.php?action=tour_list" class="btn btn-secondary btn-sm fw-bold">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-modern mb-4">
                <div class="card-header bg-white fw-bold">Thư viện ảnh</div>
                <div class="card-body">
                    <?php if(!empty($tour->images)): ?>
                        <div class="row g-2">
                            <?php foreach($tour->images as $img): ?>
                                <div class="col-md-4">
                                    <div class="ratio ratio-4x3">
                                        <img src="<?= $img->image_path ?>" class="img-fluid rounded border object-fit-cover" alt="Tour Image" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">Chưa có hình ảnh nào.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card card-modern">
                <div class="card-header bg-white fw-bold"><i class="fa-solid fa-calendar-days text-primary"></i> Lịch trình chi tiết</div>
                <div class="card-body">
                    <?php if(!empty($schedule)): ?>
                        <?php foreach($schedule as $day): ?>
                            <div class="mb-4 position-relative ps-4" style="border-left: 2px dashed #ddd;">
                                <div class="position-absolute bg-primary rounded-circle" style="width: 12px; height: 12px; left: -7px; top: 5px;"></div>
                                <h5 class="fw-bold text-dark">Ngày <?= $day->ngay_thu ?>: <?= $day->tieu_de ?></h5>
                                <p class="text-muted fst-italic mb-2"><?= nl2br($day->mo_ta) ?></p>
                                
                                <?php if(!empty($day->activities)): ?>
                                    <div class="bg-light p-3 rounded">
                                        <?php foreach($day->activities as $act): ?>
                                            <div class="d-flex mb-2">
                                                <div class="me-3 text-nowrap fw-bold text-secondary" style="min-width: 100px;">
                                                    <?= substr($act->thoi_gian_bat_dau, 0, 5) ?> - <?= substr($act->thoi_gian_ket_thuc, 0, 5) ?>
                                                </div>
                                                <div>
                                                    <strong><?= $act->hoat_dong ?></strong>
                                                    <?php if($act->dia_diem): ?><br><small class="text-muted"><i class="fa-solid fa-map-pin"></i> <?= $act->dia_diem ?></small><?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">Chưa cập nhật lịch trình.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-modern mb-4">
                <div class="card-header bg-white fw-bold">Thông tin tóm tắt</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Thời gian:</span>
                        <span class="fw-bold"><?= $tour->thoi_gian ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Ngày khởi hành:</span>
                        <span class="fw-bold"><?= date('d/m/Y', strtotime($tour->ngay_khoi_hanh)) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Phương tiện:</span>
                        <span class="fw-bold"><?= $tour->phuong_tien ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Số người tối đa:</span>
                        <span class="fw-bold"><?= $tour->so_nguoi_toi_da ?> khách</span>
                    </li>
                </ul>
            </div>

            <div class="card card-modern">
                <div class="card-header bg-white fw-bold">Mô tả chung</div>
                <div class="card-body text-muted small">
                    <?= nl2br($tour->mo_ta) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>