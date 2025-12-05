<?php require_once "views/layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Danh sách Tài Khoản</h1>
    <a href="index.php?action=user_add" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-user-plus fa-sm text-white-50"></i> Thêm Tài Khoản
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?? '' ?></td>
                                <td><?= $user['role'] ?? '' ?></td>
                                <td>
                                    <!-- Nút sửa tài khoản -->
                                    <a href="index.php?action=user_edit&id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <!-- Nút xóa tài khoản -->
                                    <a href="index.php?action=user_delete&id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');"
                                        title="Xóa tài khoản">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Không có tài khoản nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>