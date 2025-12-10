<?php include PATH_VIEW . 'layouts/header.php'; ?>

<style>
    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        height: 200px;
        border-radius: 15px 15px 0 0;
        position: relative;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border: 5px solid #fff;
        border-radius: 50%;
        object-fit: cover;
        position: absolute;
        bottom: -75px;
        left: 50px;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        background-color: #fff;
    }

    .profile-info {
        padding-top: 85px;
    }

    .info-card {
        transition: all 0.3s;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .info-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.2rem;
    }
</style>

<div class="container mt-4 mb-5">

    <div class="card card-modern border-0 shadow-lg overflow-visible mb-4">
        <div class="profile-header">
            <a href="index.php?action=hdv_list" class="btn btn-light btn-sm position-absolute top-0 end-0 m-3 fw-bold text-primary shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
            </a>
        </div>

        <?php if ($hdv->avatar): ?>
            <img src="<?= $hdv->avatar ?>" alt="Avatar" class="profile-avatar">
        <?php else: ?>
            <div class="profile-avatar d-flex align-items-center justify-content-center text-secondary display-4">
                <i class="fa-solid fa-user"></i>
            </div>
        <?php endif; ?>

        <div class="card-body profile-info px-5 pb-5">
            <div class="d-flex flex-wrap justify-content-between align-items-end">
                <div>
                    <h2 class="fw-bold text-gray-800 mb-1"><?= htmlspecialchars($hdv->ho_ten) ?></h2>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            <i class="fa-solid fa-id-badge me-1"></i> HDV <?= $hdv->loai_hdv ?>
                        </span>
                        <span class="text-muted"><i class="fa-solid fa-briefcase me-1"></i> Kinh nghiệm: <strong><?= $hdv->kinh_nghiem_nam ?> năm</strong></span>
                    </div>
                </div>
                <div class="mb-2">
                    <a href="index.php?action=hdv_edit&id=<?= $hdv->id ?>" class="btn btn-warning px-4 fw-bold shadow-sm text-white">
                        <i class="fa-solid fa-user-pen"></i> Chỉnh sửa hồ sơ
                    </a>
                </div>
            </div>

            <hr class="mt-4 mb-4 text-muted opacity-25">

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card info-card">
                        <div class="card-header bg-white fw-bold text-primary border-bottom-0 pt-4 pb-0">
                            <i class="fa-solid fa-address-book me-2"></i> THÔNG TIN LIÊN HỆ
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                    <div class="info-icon bg-success-subtle text-success me-3"><i class="fa-solid fa-phone"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Số điện thoại</small>
                                        <span class="fw-bold text-dark"><?= $hdv->so_dien_thoai ?></span>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                    <div class="info-icon bg-danger-subtle text-danger me-3"><i class="fa-solid fa-envelope"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Email</small>
                                        <span class="fw-bold text-dark"><?= $hdv->email ?></span>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                    <div class="info-icon bg-info-subtle text-info me-3"><i class="fa-solid fa-cake-candles"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Ngày sinh</small>
                                        <span class="fw-bold text-dark">
                                            <?php
                                            if (!empty($hdv->ngay_sinh)) {
                                                echo date('d/m/Y', strtotime($hdv->ngay_sinh));
                                            } else {
                                                echo "Chưa cập nhật";
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 px-0 d-flex align-items-center">
                                    <div class="info-icon bg-warning-subtle text-warning me-3"><i class="fa-solid fa-heart-pulse"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Sức khỏe</small>
                                        <span class="fw-bold text-dark"><?= $hdv->suc_khoe ?></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="card info-card">
                                <div class="card-body">
                                    <h5 class="fw-bold text-gray-800 mb-3 border-bottom pb-2">
                                        <i class="fa-solid fa-star text-warning me-2"></i> Kỹ năng & Chứng chỉ
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="small text-muted fw-bold text-uppercase mb-1">Ngoại ngữ thành thạo</label>
                                            <div class="fs-5 text-dark fw-bold">
                                                <i class="fa-solid fa-language text-primary me-2"></i> <?= $hdv->ngon_ngu ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small text-muted fw-bold text-uppercase mb-1">Chứng chỉ hành nghề</label>
                                            <div class="fs-5 text-dark fw-bold">
                                                <i class="fa-solid fa-certificate text-success me-2"></i> <?= $hdv->chung_chi ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card info-card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold text-secondary mb-2"><i class="fa-solid fa-comment-dots"></i> ĐÁNH GIÁ / GHI CHÚ TỪ QUẢN LÝ</h6>
                                    <div class="p-3 bg-white rounded border shadow-sm position-relative">
                                        <i class="fa-solid fa-quote-left text-muted opacity-25 position-absolute top-0 start-0 m-2 fs-3"></i>
                                        <p class="fst-italic text-dark mb-0 ms-3">
                                            "<?= $hdv->danh_gia ?: 'Chưa có ghi chú đánh giá nào về hướng dẫn viên này.' ?>"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layouts/footer.php'; ?>