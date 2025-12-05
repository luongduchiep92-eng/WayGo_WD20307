<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - WayGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            /* Màu nền Gradient xanh giống hệt ảnh Login bạn gửi */
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-card {
            background: #fff;
            border-radius: 15px; /* Bo góc card */
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 500px; /* Rộng hơn login một chút vì nhiều trường hơn */
            padding: 40px 30px;
        }
        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .brand-header i {
            color: #4e73df;
        }
        .brand-header h3 {
            color: #4e73df;
            font-weight: 800;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        
        /* Input bo tròn kiểu viên thuốc (Pill shape) */
        .form-control, .form-select {
            border-radius: 50px; 
            padding: 12px 20px;
            background-color: #f8f9fc;
            border: 1px solid #d1d3e2;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #4e73df;
            background-color: #fff;
        }
        
        /* Label nhỏ phía trên input */
        .form-label {
            margin-left: 15px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #858796;
            margin-bottom: 5px;
        }

        /* Nút đăng ký */
        .btn-register {
            border-radius: 50px;
            padding: 12px;
            font-weight: bold;
            background: #4e73df;
            border: none;
            width: 100%;
            color: white;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        .btn-register:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="brand-header">
            <i class="fa-solid fa-plane-circle-check fa-3x"></i>
            <h3>ĐĂNG KÝ TÀI KHOẢN</h3>
            <p class="text-muted small">Nhập thông tin để tham gia hệ thống</p>
        </div>

        <form method="POST" action="index.php?action=register">
            
            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tên đăng nhập (Username)</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Đăng ký với vai trò?</label>
                <select name="role" class="form-select fw-bold text-primary">
                    <option value="staff">Nhân viên (Staff)</option>
                    <option value="hdv">Hướng dẫn viên (HDV)</option>
                    <option value="admin">Quản trị viên (Admin)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-register">ĐĂNG KÝ NGAY</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="index.php?action=login" class="text-decoration-none small text-secondary fw-bold">
                <i class="fa-solid fa-arrow-left"></i> Đã có tài khoản? Đăng nhập ngay
            </a>
        </div>
    </div>
</body>
</html>