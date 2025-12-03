<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Danh sách đánh giá</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Danh sách đánh giá</h2>

    <div class="mb-3">
        <a href="index.php?action=comment_add_form" class="btn btn-success">Thêm đánh giá</a>
    </div>

    <!-- Form lọc -->
    <form method="POST" class="row mb-3" action="index.php?action=comments_list">
    
        <div class="col-md-4 mb-2">
            <input type="text" name="supplier_name" placeholder="Nhà cung cấp" class="form-control" value="<?= $_POST['supplier_name'] ?? '' ?>">
        </div>
        <div class="col-md-2 mb-2">
            <select name="rating" class="form-select">
                <option value="">Tất cả đánh giá</option>
                <?php for($i=1;$i<=5;$i++): ?>
                    <option value="<?= $i ?>" <?= (isset($_POST['rating']) && $_POST['rating']==$i)?'selected':'' ?>><?= str_repeat('⭐',$i) ?></option>
                <?php endfor; ?>
            </select>
        </div>
         
        <div class="col-md-2 mb-2">
            <button class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Họ và tên</th>
                <th>Nhà cung cấp</th>
                <th>Nội dung</th>
                <th>Đánh giá</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($comments)): ?>
                <?php foreach($comments as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['guest_name']) ?></td>
                    <td><?= htmlspecialchars($c['supplier_name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($c['content'])) ?></td>
                    <td><?= str_repeat('⭐', $c['rating']) ?></td>
                    <td><?= $c['created_at'] ?></td>
                    <td>
                        <a href="index.php?action=comment_detail&id=<?= $c['id'] ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
                        <a href="index.php?action=comment_delete&id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa đánh giá này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">Chưa có đánh giá</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
