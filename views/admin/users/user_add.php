<?php include PATH_VIEW . 'layouts/header.php'; ?>

<h2 class="h4 mb-3">Thêm Tài Khoản Mới</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="post" action="index.php?action=user_add">
    <div class="mb-3">
        <label class="form-label">Tên đăng nhập:</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Họ và tên:</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mật khẩu:</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Quyền:</label>
        <select name="role" class="form-select">
            <option value="user">Khách hàng</option>
            <option value="staff">Nhân viên</option>
            <option value="admin">Quản trị</option>
            <option value="hdv">Hướng dẫn viên</option>
        </select>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="status" class="form-check-input" id="chkActive" checked>
        <label for="chkActive" class="form-check-label">Kích hoạt tài khoản</label>
    </div>
    <!-- Trường số điện thoại (tùy chọn nếu thêm HDV) -->
    <div class="mb-3">
        <label class="form-label">Số điện thoại (chỉ cho HDV):</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Lưu tài khoản</button>
    <a href="index.php?action=user_list" class="btn btn-secondary">Hủy</a>
</form>