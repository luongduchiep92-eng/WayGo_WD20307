<?php include PATH_VIEW . 'layouts/header.php'; ?>

<h2 class="h4 mb-3">Chỉnh Sửa Tài Khoản</h2>

<form method="post" action="index.php?action=user_edit&id=<?= $user['id'] ?>">
    <div class="mb-3">
        <label class="form-label">Tên đăng nhập:</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Họ và tên:</label>
        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mật khẩu mới (nếu muốn đổi):</label>
        <input type="password" name="password" class="form-control" placeholder="Để trống nếu không thay đổi">
    </div>
    <div class="mb-3">
        <label class="form-label">Quyền:</label>
        <select name="role" class="form-select">
            <option value="user" <?= $user['role'] == 'user'  ? 'selected' : '' ?>>Khách hàng</option>
            <option value="staff" <?= $user['role'] == 'staff' ? 'selected' : '' ?>>Nhân viên</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Quản trị</option>
            <option value="hdv" <?= $user['role'] == 'hdv'   ? 'selected' : '' ?>>Hướng dẫn viên</option>
        </select>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="status" class="form-check-input" id="chkActive"
            <?= $user['status'] ? 'checked' : '' ?>>
        <label for "chkActive" class="form-check-label">Kích hoạt tài khoản</label>
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
    <a href="index.php?action=user_list" class="btn btn-secondary">Hủy</a>
</form>