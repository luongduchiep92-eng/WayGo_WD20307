<?php require_once "views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Thêm Tài Khoản</h1>
</div>

<form method="POST" action="index.php?action=user_add" class="mb-4">
    <div class="mb-3">
        <label class="form-label fw-bold">Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" required placeholder="Nhập tên đăng nhập..." />
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Mật khẩu</label>
        <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu..." />
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Nhập email (nếu có)..." />
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Vai trò</label>
        <select name="role" class="form-select">
            <option value="user">User</option>
            <option value="hdv">Hướng dẫn viên</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
</form>

<?php require_once "views/layouts/footer.php"; ?>