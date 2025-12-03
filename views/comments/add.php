<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Thêm đánh giá</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Thêm đánh giá mới</h2>
    <form method="POST" action="index.php?action=comment_add">
        <div class="mb-3">
            <label>Họ và tên</label>
            <input type="text" name="guest_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tên nhà cung cấp</label>
            <input type="text" name="supplier_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nội dung đánh giá</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Đánh giá</label>
            <select name="rating" class="form-select" required>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
        </div>
        <button class="btn btn-success">Thêm</button>
        <a href="index.php?action=comments_list" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>
