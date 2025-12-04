<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>HDV Portal - WayGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; padding-bottom: 80px; }
        
        /* Navbar Top */
        .navbar-custom { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white; padding: 15px; }
        .navbar-brand { font-weight: 800; font-size: 1.2rem; }
        
        /* Bottom Navigation Bar (Menu dưới cùng) */
        .bottom-nav {
            position: fixed; bottom: 0; width: 100%; background: #fff;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1); z-index: 1000;
            display: flex; justify-content: space-around; padding: 10px 0;
        }
        .nav-item-link {
            text-align: center; color: #adb5bd; text-decoration: none; flex: 1;
            font-size: 0.8rem; transition: 0.3s;
        }
        .nav-item-link i { display: block; font-size: 1.4rem; margin-bottom: 3px; }
        .nav-item-link.active { color: #0d6efd; font-weight: bold; }
        .nav-item-link:hover { color: #0d6efd; }

        /* Card styles */
        .tour-card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); margin-bottom: 15px; background: white; }
        .schedule-time { min-width: 60px; font-weight: bold; color: #0d6efd; }
    </style>
</head>
<body>

<div class="navbar-custom shadow-sm d-flex justify-content-between align-items-center">
    <div>
        <i class="fa-solid fa-plane-circle-check"></i> <span class="navbar-brand">WayGo HDV</span>
    </div>
    <div class="d-flex align-items-center">
        <span class="me-2 small">Xin chào, <?= $_SESSION['user_name'] ?? 'HDV' ?></span>
        <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['user_name'] ?? 'H' ?>&background=random" class="rounded-circle" width="32" height="32">
    </div>
</div>