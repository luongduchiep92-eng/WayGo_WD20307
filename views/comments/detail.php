<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Chi tiết đánh giá</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Chi tiết đánh giá</h2>
    <?php if($comment): ?>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Nhà bình luận:</strong> <?= htmlspecialchars($comment['guest_name']) ?></li>
            <li class="list-group-item"><strong>Nhà cung cấp:</strong> <?= htmlspecialchars($comment['supplier_name']) ?></li>
            <li class="list-group-item"><strong>Nội dung:</strong><br><?= nl2br(htmlspecialchars($comment['content'])) ?></li>
            <li class="list-group-item"><strong>Đánh giá:</strong> <?= str_repeat('⭐', $comment['rating']) ?></li>
            <li class="list-group-item"><strong>Thời gian:</strong> <?= $comment['created_at'] ?></li>
        </ul>
    <?php else: ?>
        <p>Không tìm thấy đánh giá.</p>
    <?php endif; ?>
    <a href="index.php?action=comments_list" class="btn btn-secondary">Quay lại</a>
</div>
</body>
</html>
