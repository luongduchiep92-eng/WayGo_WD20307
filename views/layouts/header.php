<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị hệ thống - WayGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-plane-departure"></i> ADMIN WAYGO
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="index.php?controller=admin&action=dashboard" class="<?= (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : '' ?>">
                    <i class="fa-solid fa-gauge-high"></i> Trang chủ
                </a>
            </li>
            <li>
                <a href="index.php?action=tour_list" class="<?= (isset($_GET['action']) && strpos($_GET['action'], 'tour') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-map-location-dot"></i> Quản lý Tour
                </a>
            </li>
            <li>
                <a href="index.php?action=booking_list" class="<?= (isset($_GET['action']) && strpos($_GET['action'], 'booking') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-list-check"></i> Quản lý Booking
                </a>
            </li>
            <li>
                <a href="index.php?action=hdv_list" class="<?= (isset($_GET['action']) && strpos($_GET['action'], 'hdv') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-tie"></i> Hướng Dẫn Viên
                </a>
            </li>
            <li>
                <a href="index.php?action=listsupplier" class="<?= (isset($_GET['action']) && strpos($_GET['action'], 'supplier') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-truck-field"></i> Nhà Cung Cấp
                </a>
            </li>
            <li>
    <a href="index.php?action=comments_list" 
       class="<?= (isset($_GET['action']) && $_GET['action'] === 'comments_list') ? 'active' : '' ?>">
        <i class="fa-solid fa-star-half-stroke"></i> Đánh giá Nhà Cung Cấp
    </a>
</li>
<li>
    <a href="index.php?action=diary_list" class="<?= (isset($_GET['action']) && strpos($_GET['action'], 'diary') !== false) ? 'active' : '' ?>">
        <i class="fa-solid fa-book-journal-whills"></i> Nhật Ký Tour
    </a>
</li>

        </ul>
    </nav>

    <div id="content">
        <nav class="navbar-custom">
            <button type="button" id="sidebarCollapse" class="btn-toggle-sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark fw-bold" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['user_name'] ?? 'Admin' ?>&background=random" alt="" width="32" height="32" class="rounded-circle me-2">
                        <span><?= $_SESSION['user_name'] ?? 'Quản trị viên' ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                        <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.php?action=logout">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">