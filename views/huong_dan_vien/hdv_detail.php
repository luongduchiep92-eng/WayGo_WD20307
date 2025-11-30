<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-modern overflow-hidden">
                <div class="bg-primary" style="height: 150px;"></div>
                
                <div class="card-body px-5 pb-5">
                    <div class="row">
                        <div class="col-md-3 text-center" style="margin-top: -80px;">
                            <?php if ($hdv->avatar): ?>
                                <img src="<?= $hdv->avatar ?>" alt="Avatar" class="rounded-circle border border-4 border-white shadow" width="160" height="160" style="object-fit: cover; background: #fff;">
                            <?php else: ?>
                                <div class="rounded-circle border border-4 border-white shadow bg-secondary text-white d-flex align-items-center justify-content-center mx-auto" style="width:160px; height:160px; font-size: 60px;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            <?php endif; ?>
                            
                            <h4 class="mt-3 fw-bold"><?= htmlspecialchars($hdv->ho_ten) ?></h4>
                            <span class="badge bg-info text-dark"><?= $hdv->loai_hdv ?></span>
                        </div>

                        <div class="col-md-9 pt-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary fw-bold mb-0">Hồ sơ chi tiết</h5>
                                <div>
                                    <a href="index.php?action=hdv_edit&id=<?= $hdv->id ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
                                    <a href="index.php?action=hdv_list" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded h-100 border-start border-4 border-primary">
                                        <h6 class="fw-bold text-dark"><i class="fa-solid fa-address-card me-2"></i>Thông tin cá nhân</h6>
                                        <hr class="my-2">
                                        <p class="mb-1 text-muted small">Ngày sinh</p>
                                        <p class="fw-bold"><?= date('d/m/Y', strtotime($hdv->ngay_sinh)) ?></p>
                                        
                                        <p class="mb-1 text-muted small">Liên hệ</p>
                                        <p class="mb-0"><i class="fa-solid fa-phone text-success"></i> <?= $hdv->so_dien_thoai ?></p>
                                        <p><i class="fa-solid fa-envelope text-danger"></i> <?= $hdv->email ?></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded h-100 border-start border-4 border-success">
                                        <h6 class="fw-bold text-dark"><i class="fa-solid fa-briefcase me-2"></i>Kỹ năng & Kinh nghiệm</h6>
                                        <hr class="my-2">
                                        <p class="mb-1 text-muted small">Kinh nghiệm</p>
                                        <p class="fw-bold"><?= $hdv->kinh_nghiem_nam ?> năm</p>

                                        <p class="mb-1 text-muted small">Ngôn ngữ thành thạo</p>
                                        <p class="fw-bold text-primary"><?= $hdv->ngon_ngu ?></p>

                                        <p class="mb-1 text-muted small">Chứng chỉ</p>
                                        <p class="mb-0"><?= $hdv->chung_chi ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6 class="fw-bold">Đánh giá / Ghi chú:</h6>
                                <p class="fst-italic text-muted p-3 border rounded bg-white">
                                    "<?= $hdv->danh_gia ?: 'Chưa có đánh giá nào.' ?>"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>