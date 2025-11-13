<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/a2e0b1c6c7.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">ADMIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminMenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=admin&action=dashboard">
            <i class="fa-solid fa-house"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=tour&action=list">
            <i class="fa-solid fa-map"></i> Quản lý Tour
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=user&action=list">
            <i class="fa-solid fa-users"></i> Người dùng
          </a>
        </li>
      </ul>

      <div class="text-white">
        <i class="fa-solid fa-user-circle me-2"></i> Xin chào, Admin
      </div>
    </div>
  </div>
</nav>
