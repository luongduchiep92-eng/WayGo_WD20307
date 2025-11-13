<?php include(PATH_VIEW . 'layouts/header.php'); ?>

<div class="container mt-4">
    <h2><?= $tour->ten_tour ?></h2>
    <p><strong>Địa điểm:</strong> <?= $tour->dia_diem ?></p>
    <p><strong>Thời gian:</strong> <?= $tour->thoi_gian ?></p>
    <p><strong>Ngày khởi hành:</strong> <?= $tour->ngay_khoi_hanh ?></p>
    <p><strong>Giá:</strong> <?= number_format($tour->gia_tour) ?> VNĐ</p>
    <p><strong>Phương tiện:</strong> <?= $tour->phuong_tien ?></p>
    <p><strong>Số người tối đa:</strong> <?= $tour->so_nguoi_toi_da ?></p>
    <p><strong>Mô tả:</strong> <?= nl2br($tour->mo_ta) ?></p>

    <?php if(!empty($tour->images)): ?>
        <h4>Hình ảnh tour</h4>
        <div class="row mb-4">
            <?php foreach($tour->images as $img): ?>
                <div class="col-md-3 mb-2">
                    <img src="<?= BASE_ASSETS_UPLOADS . $img->image_path ?>" class="img-fluid rounded" alt="Hình tour">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <hr>
    <h4>Lịch trình tour</h4>
    <?php if(!empty($schedule)): ?>
        <?php foreach($schedule as $day): ?>
            <div class="card mb-3">
                <div class="card-header"><strong>Ngày <?= $day->ngay_thu ?>: <?= $day->tieu_de ?></strong></div>
                <div class="card-body">
                    <p><?= nl2br($day->mo_ta) ?></p>
                    <?php if(!empty($day->activities)): ?>
                        <ul class="list-group">
                            <?php foreach($day->activities as $act): ?>
                                <li class="list-group-item">
                                    <strong><?= $act->hoat_dong ?></strong><br>
                                    <?php if($act->thoi_gian_bat_dau || $act->thoi_gian_ket_thuc): ?>
                                        Thời gian: <?= $act->thoi_gian_bat_dau ?> - <?= $act->thoi_gian_ket_thuc ?><br>
                                    <?php endif; ?>
                                    <?php if($act->dia_diem): ?>Địa điểm: <?= $act->dia_diem ?><br><?php endif; ?>
                                    <?php if($act->hinh_anh): ?>
                                        <img src="<?= BASE_ASSETS_UPLOADS . $act->hinh_anh ?>" class="img-fluid mt-1 rounded" style="max-width:150px;" alt="Hình ảnh hoạt động">
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có lịch trình</p>
    <?php endif; ?>

    <a href="index.php?action=tour_edit&id=<?= $tour->id ?>" class="btn btn-warning">Chỉnh sửa tour</a>
    <a href="index.php?action=tour_list" class="btn btn-secondary">Quay lại</a>
</div>

<?php include(PATH_VIEW . 'layouts/footer.php'); ?>
