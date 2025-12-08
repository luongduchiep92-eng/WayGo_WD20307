<?php include PATH_VIEW . 'layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800 fw-bold">Danh sách tài khoản người dùng</h1>
    <a href="index.php?action=user_add" class="btn btn-primary">
        <i class="fa-solid fa-user-plus"></i> Thêm tài khoản
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
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>#<?= $user->id ?></td>
                            <td><?= htmlspecialchars($user->username) ?></td>
                            <td><?= htmlspecialchars($user->full_name) ?></td>
                            <td><?= htmlspecialchars($user->email) ?></td>
                            <td><?= htmlspecialchars($user->role) ?></td>
                            <td>
                                <?= ($user->status == 1)
                                    ? "<span class='text-success'>Kích hoạt</span>"
                                    : "<span class='text-danger'>Khóa</span>"; ?>
                            </td>
                            <td>
                                <a href="index.php?action=user_edit&id=<?= $user->id ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="index.php?action=user_delete&id=<?= $user->id ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?');">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>