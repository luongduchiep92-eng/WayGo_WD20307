<?php require_once "views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Cập nhật Tài Khoản</h1>
</div>

<form method="POST" action="index.php?action=user_edit&id=<?= $user['id'] ?>" class="mb-4">
    <div class="mb-3">
        <label class="form-label fw-bold">Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" required value="<?= $user['username'] ?>" />
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" placeholder="Để trống nếu giữ nguyên mật khẩu" />
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Email</label>
        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?? '' ?>" />
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Vai trò</label>
        <select name="role" class="form-select">
            <option value="user" <?= ($user['role'] ?? '') === 'user'  ? 'selected' : '' ?>>User</option>
            <option value="hdv" <?= ($user['role'] ?? '') === 'hdv'   ? 'selected' : '' ?>>Hướng dẫn viên</option>
            <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-white">Cập nhật</button>
</form>

<?php require_once "views/layouts/footer.php"; ?>