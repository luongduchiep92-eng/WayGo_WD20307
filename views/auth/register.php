<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - WayGo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); overflow: hidden; width: 450px; }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="card-body p-4">
            <h3 class="text-center fw-bold text-primary mb-4">ĐĂNG KÝ TÀI KHOẢN</h3>
            
            <form method="POST">
                <div class="mb-3">
                    <label>Họ và tên</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="fw-bold">Bạn đăng ký với tư cách?</label>
                    <select name="role" class="form-select">
                        <option value="user">Khách hàng / Người dùng</option>
                        <option value="hdv">Hướng dẫn viên</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100 mb-3">Đăng ký</button>
            </form>
            
            <div class="text-center"><a href="index.php?action=login">Đã có tài khoản? Đăng nhập</a></div>
        </div>
    </div>
</body>
</html>